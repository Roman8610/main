<?php
namespace app\modules\meetings\services;

use app\modules\meetings\forms\CreateMeetingQuestionForm;
use app\modules\meetings\forms\SubmitMeetingQuestionModerationForm;
use app\modules\meetings\models\MeetingQuestion;
use Yii;

class CreateAndSubmitForModerationService{

    public function run(CreateMeetingQuestionForm $formModel):MeetingQuestion{

        $createDraft = Yii::$app->getModule('meetings')->get('createDraftMeetingQuestionService');
        $question = $createDraft->run($formModel);

        if($formModel->scenario == 'submit_pending'){
            $formPending = new SubmitMeetingQuestionModerationForm();
            $formPending->question_id = $question->id;
            $formPending->scenario = $formModel->scenario;

            $submitPending = Yii::$app->getModule('meetings')->get('submitForModerationService');
            $question = $submitPending->run($formPending);
        }

        return $question;
    }

}