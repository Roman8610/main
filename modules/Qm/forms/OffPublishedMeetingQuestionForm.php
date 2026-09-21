<?php

namespace app\modules\Qm\forms;

use Override;

/**
 * Данные формы снятия вопроса с публикации.
 */
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
