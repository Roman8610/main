<?php

namespace app\modules\Qm\services;

use app\modules\Qm\forms\MeetingQuestionForm;
use app\modules\Qm\models\MeetingQuestion;
use Yii;

/**
 * Сервис обновления вопроса с возможной последующей отправкой на модерацию.
 */
class UpdateAndSubmitForModerationService
{

    /**
     * Обновляет вопрос и при сценарии submit_pending переводит его на модерацию.
     *
     * @param MeetingQuestion $question Вопрос для изменения.
     * @param MeetingQuestionForm $formModel Валидированные данные формы.
     * @return MeetingQuestion Обновленный вопрос.
     */
    public function run(MeetingQuestion $question, MeetingQuestionForm $formModel): MeetingQuestion
    {
        $updateService = Yii::$app->getModule('Qm')->get('updateDraftMeetingQuestionService');
        $question = $updateService->run($question, $formModel);

        if ($formModel->scenario === 'submit_pending') {
            $submitService = Yii::$app->getModule('Qm')->get('submitForModerationService');
            $question = $submitService->run($question);
        }

        return $question;
    }
}