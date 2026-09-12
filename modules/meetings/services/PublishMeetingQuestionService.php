<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\PublishedMeetingQuestionModerationForm;
use app\modules\meetings\models\DepartmentsQuestions;
use app\modules\meetings\models\MeetingQuestion;
use Exception;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class PublishMeetingQuestionService
{
    public function run(PublishedMeetingQuestionModerationForm $formModel): MeetingQuestion
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canMakeModeration($formModel->question_id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $question = $this->findModel($formModel->question_id);
        $question->directions = $formModel->directions;
        $question->status = MeetingQuestion::STATUS_PUBLISHED;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$question->save(false)) {
                throw new \Exception('Не удалось сохранить вопрос: ' . json_encode($question->getErrors()));
            }
            $question_id = $question->id;
            $departments_array = array_map(function ($item) use ($question_id) {
                return [$question_id, $item];
            }, $formModel->departments);
            // Сохраняем отделы
            Yii::$app->db->createCommand()->batchInsert(
                DepartmentsQuestions::tableName(),
                ['question_id', 'departments_id'],
                 $departments_array
            )->execute();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $question;
    }

    /**
     * Возвращает модель MeetingQuestion по ID.
     * Если модель не найдена — выбрасывает NotFoundHttpException.
     */
    private function findModel(int $id)
    {
        if (($model = MeetingQuestion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Вопрос не найден');
    }
}
