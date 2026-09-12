<?php

namespace app\modules\meetings\forms;

use yii\base\Model;
use Override;

/**
 * Принимает ID постановочного вопроса который необходимо отклонить и комментарий модератора
 * Валедирует данные
 * Используется для создания формы ActiveForm
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
