<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\MeetingQuestionForm;
use app\modules\meetings\models\MeetingQuestion;
use Yii;

class UpdateAndSubmitForModerationService
{

    public function run(MeetingQuestion $question, MeetingQuestionForm $formModel): MeetingQuestion
    {
        $updateService = Yii::$app->getModule('meetings')->get('updateDraftMeetingQuestionService');
        $question = $updateService->run($question, $formModel);

        if ($formModel->scenario === 'submit_pending') {
            $submitService = Yii::$app->getModule('meetings')->get('submitForModerationService');
            $question = $submitService->run($question);
        }

        return $question;
    }
}