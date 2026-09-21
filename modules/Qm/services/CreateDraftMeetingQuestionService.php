<?php

namespace app\modules\Qm\services;

use app\modules\Qm\forms\MeetingQuestionForm;
use app\modules\Qm\models\MeetingQuestion;
use app\modules\Qm\models\RecipientsQuestions;
use Exception;
use Yii;

/**
 * Сервис создания постановочного вопроса в статусе черновика.
 */
class CreateDraftMeetingQuestionService
{

    /**
     * Создает вопрос и сохраняет его адресатов в рамках транзакции.
     *
     * @param MeetingQuestionForm $formModel Валидированные данные вопроса.
     * @return MeetingQuestion Созданный вопрос в статусе draft.
     * @throws \yii\web\ForbiddenHttpException Если пользователь не может
     *     создать вопрос в совещании.
     * @throws \Throwable Если сохранение вопроса или адресатов не удалось.
     */
    public function run(MeetingQuestionForm $formModel): MeetingQuestion
    {
        if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canCreate($formModel->meeting_id, $formModel->user_id)) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
        }

        // Создаём модель вопроса
        $question = new MeetingQuestion();

        $question->meeting_id = $formModel->meeting_id; // ID совещания
        $question->name = $formModel->name; // Название вопроса
        $question->question_text = $formModel->question_text; // Текст вопроса
        $question->decision = $formModel->decision; // Предлагаемое решение вопроса
        $question->comment = $formModel->comment; // Комментарий 
        $question->deadline = $formModel->deadline; // Срок выполнения
        $question->created_at = date('Y-m-d H:i:s'); // Дата создания
        $question->updated_at = null; // Дата последнего обновления
        $question->created_by = $formModel->user_id; // Создатель
        $question->updated_by = null; // кто внес последние изменения
        $question->status = MeetingQuestion::STATUS_DRAFT; // статус

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$question->save(false)) {
                throw new \Exception('Не удалось сохранить вопрос: ' . json_encode($question->getErrors()));
            }
            $question_id = $question->id;
            $recipients_array = array_map(function ($item) use ($question_id) {
                return [$question_id, $item];
            }, $formModel->recipients);
            // Сохраняем получателей вопроса 
            Yii::$app->db->createCommand()->batchInsert(
                RecipientsQuestions::tableName(),
                ['question_id', 'subsidiary_id'],
                $recipients_array
            )->execute();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return $question;
    }
}
