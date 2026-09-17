<?php

namespace app\modules\Qm\services;

use app\modules\Qm\forms\MeetingQuestionForm;
use app\modules\Qm\models\MeetingQuestion;
use Yii;

class CreateAndSubmitForModerationService
{

    public function run(MeetingQuestionForm $formModel): MeetingQuestion
    {
        $createDraft = Yii::$app->getModule('Qm')->get('createDraftMeetingQuestionService');
        $question = $createDraft->run($formModel);

        if ($formModel->scenario == 'submit_pending') {
            $submitPending = Yii::$app->getModule('Qm')->get('submitForModerationService');
            $question = $submitPending->run($question);
        }

        return $question;
    }
}
