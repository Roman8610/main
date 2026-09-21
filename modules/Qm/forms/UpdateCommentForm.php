<?php

namespace app\modules\Qm\forms;

use Override;
use yii\base\Model;

/**
 * Данные формы редактирования комментария.
 */
class UpdateCommentForm extends Model {
    public $comment_id;
    public $question_id;
    public $text;

    #[Override]
    public function rules()
    {
        return [
            [['comment_id', 'text', 'question_id'], 'required'],
            [['comment_id', 'question_id'], 'integer'],
            ['text', 'string'],
        ];
    }

    #[Override]
    public function attributeLabels()
    {
        return [
            'text' => 'Добавить ответ',
        ];
    }
}
