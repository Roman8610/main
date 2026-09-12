<?php

namespace app\modules\meetings\forms;

use Override;

class OffPublishedMeetingQuestionForm extends \yii\base\Model
{
    public $question_id;

    #[Override]
    public function rules()
    {
        return [
            [['question_id'], 'required'],
            ['question_id', 'integer'],
        ];
    }
}
