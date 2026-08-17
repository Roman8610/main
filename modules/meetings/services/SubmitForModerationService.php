<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\SubmitMeetingQuestionModerationForm;
use app\modules\meetings\models\MeetingQuestion;
use yii\web\NotFoundHttpException;

class SubmitForModerationService
{
    public function run(SubmitMeetingQuestionModerationForm | MeetingQuestion $formModel)
    {
        if ($formModel instanceof  SubmitMeetingQuestionModerationForm) {
            $formModel = $this->findModel($formModel->question_id);
        }

        $formModel->status = MeetingQuestion::STATUS_PENDING;
        $formModel->save();

        return $formModel;
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
