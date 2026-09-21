<?php

namespace app\modules\Qm\services;

use app\modules\Qm\forms\SubmitMeetingQuestionModerationForm;
use app\modules\Qm\models\MeetingQuestion;
use yii\web\NotFoundHttpException;

/**
 * Сервис перевода постановочного вопроса в статус pending.
 */
class SubmitForModerationService
{
    /**
     * Отправляет вопрос на модерацию.
     *
     * @param SubmitMeetingQuestionModerationForm|MeetingQuestion $formModel
     *     Форма с идентификатором вопроса или модель вопроса.
     * @return MeetingQuestion Вопрос в статусе pending.
     * @throws NotFoundHttpException Если вопрос не найден.
     */
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
