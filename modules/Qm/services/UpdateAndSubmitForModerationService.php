<?php

namespace app\modules\Qm\services;

use app\modules\Qm\forms\MeetingQuestionForm;
use app\modules\Qm\models\MeetingQuestion;
use Yii;

class UpdateAndSubmitForModerationService
{

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