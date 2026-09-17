<?php

namespace app\modules\meetings\forms;

use Override;
use yii\base\Model;

class UpdateCommentForm extends Model {
    public $question_id;
    public $parent_id;
    public $user_id;
    public $text;

    #[Override]
    public function rules()
    {
        return [
            [['question_id', 'text'], 'required'],
            ['question_id', 'integer'],
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
