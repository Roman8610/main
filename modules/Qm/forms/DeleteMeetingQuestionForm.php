<?php

namespace app\modules\Qm\forms;

use Override;

/**
 * Данные формы удаления постановочного вопроса.
 */
class DeleteMeetingQuestionForm extends \yii\base\Model
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