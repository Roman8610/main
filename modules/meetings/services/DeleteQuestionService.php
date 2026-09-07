<?php

namespace app\modules\meetings\services;

use app\modules\meetings\models\MeetingQuestion;
use app\modules\meetings\models\RecipientsQuestions;
use Yii;

class DeleteQuestionService
{
    /**
     * Удаляет постановочный вопрос вместе со связанными получателями и ответами (комментариями)
     * @param int $id Идентификатор постановочного вопроса.
     * @return bool `true`, если вопрос удален, иначе `false`.
     * @throws \Throwable Если удаление не удалось.
     */
    public function run(int $id): bool
    {
        $question = MeetingQuestion::findOne($id);
        if ($question === null) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            RecipientsQuestions::deleteAll(['question_id' => $question->id]);

            if (!$question->delete()) {
                throw new \RuntimeException('Не удалось удалить постановочный вопрос');
            }

            $transaction->commit();
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

}