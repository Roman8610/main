<?php

namespace app\modules\Qm\forms;

use yii\base\Model;
use Override;

/**
 * Данные модерации для отклонения постановочного вопроса.
 */
class RejectMeetingQuestionModerationForm extends Model
{
    public $comment_moderator;
    public $question_id;

    #[Override]
    public function rules()
    {
        return [
            [['comment_moderator', 'question_id'], 'required'],
            [['comment_moderator'], 'string'],
        ];
    }

    #[Override]
    public function attributeLabels()
    {
        return [
            'comment_moderator' => 'Причина отклонения',
        ];
    }
}
