<?php


namespace app\models;

use Override;
use yii\base\Model;

class ChatForm extends Model{

    public string $text;
    public int $user_id;
    public string $role;

    #[Override]
    public function rules()
    {
        return [
            [['text'], 'required'],
        ];
    }

}