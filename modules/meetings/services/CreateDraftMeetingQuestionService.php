<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\MeetingQuestionForm;
use app\modules\meetings\models\MeetingQuestion;
use app\modules\meetings\models\RecipientsQuestions;
use Yii;

class CreateDraftMeetingQuestionService
{

    public function run(MeetingQuestionForm $formModel): MeetingQuestion
    {
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canCreate($formModel->meeting_id, $formModel->user_id)) {
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

        if ($question->save(false)) {
            $question_id = $question->id;
        } else {
            $errors = $question->getErrors();
            Yii::$app->session->setFlash('error', 'Не удалось сохранить вопрос: ' . json_encode($errors));
        }

        $recipients_array = array_map(function ($item) use ($question_id) {
            return [$question_id, $item];
        }, $formModel->recipients);

        // Сохраняем получателей вопроса 
        Yii::$app->db->createCommand()->batchInsert(
            RecipientsQuestions::tableName(),
            ['question_id', 'subsidiary_id'],
            $recipients_array
        )->execute();

        return $question;
    }
    /**
     * Сохранение вопроса
     */
    private function saveQuestion() {}
    /**
     * Сохранение получателей вопроса
     */
    private function saveRecipient() {}
    /**
     * Сохранение отделов
     */
    private function saveDepartment() {}
    /**
     * Сохранение направлений
     */
    private function saveDirection() {}
}
