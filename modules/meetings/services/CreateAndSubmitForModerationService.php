<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\MeetingQuestionForm;
use app\modules\meetings\models\MeetingQuestion;
use Yii;

class CreateAndSubmitForModerationService
{

    public function run(MeetingQuestionForm $formModel): MeetingQuestion
    {
        $createDraft = Yii::$app->getModule('meetings')->get('createDraftMeetingQuestionService');
        $question = $createDraft->run($formModel);

        if ($formModel->scenario == 'submit_pending') {
            $submitPending = Yii::$app->getModule('meetings')->get('submitForModerationService');
            $question = $submitPending->run($question);
        }

        return $question;
    }
}
