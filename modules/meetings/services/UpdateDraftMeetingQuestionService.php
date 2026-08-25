<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\MeetingQuestionForm;
use app\modules\meetings\models\MeetingQuestion;
use app\modules\meetings\models\RecipientsQuestions;
use Yii;
use yii\web\ForbiddenHttpException;

class UpdateDraftMeetingQuestionService
{
    public function run(MeetingQuestion $question, MeetingQuestionForm $formModel): MeetingQuestion
    {
        // Права уже проверены в контроллере; если хочешь дублирующую защиту — делай её корректно:
        $accessService = Yii::$app->getModule('meetings')->get('meetingQuestionAccessService');
        if (!$accessService->canUpdate($question->id, $formModel->user_id)) {
            throw new ForbiddenHttpException('Доступ запрещён');
        }

        // Копируем только нужные поля из формы в AR
        $question->name = $formModel->name;
        $question->question_text = $formModel->question_text;
        $question->decision = $formModel->decision;
        $question->comment = $formModel->comment;
        $question->deadline = $formModel->deadline;
        $question->updated_at = date('Y-m-d H:i:s');
        $question->updated_by = $formModel->user_id;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$question->save()) {
                throw new \Exception('Не удалось сохранить вопрос: ' . json_encode($question->getErrors()));
            }

            RecipientsQuestions::deleteAll(['question_id' => $question->id]);

            $recipientsArray = array_map(fn($item) => [$question->id, $item], $formModel->recipients);
            if (!empty($recipientsArray)) {
                Yii::$app->db->createCommand()->batchInsert(
                    RecipientsQuestions::tableName(),
                    ['question_id', 'subsidiary_id'],
                    $recipientsArray
                )->execute();
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $question;
    }
}
