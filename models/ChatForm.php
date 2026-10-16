<?php

namespace app\models;

use Override;
use yii\base\Model;

class ChatForm extends Model
{

    public $text;
    public $user_id;
    public $role;
    public $action = [];

    #[Override]
    public function rules()
    {
        return [
            [['text'], 'required'],
        ];
    }
}
