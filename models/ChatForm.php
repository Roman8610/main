<?php


namespace app\models;

use Override;
use yii\base\Model;

class ChatForm extends Model{

    public $text;

    #[Override]
    public function rules()
    {
        return [
            [['text'], 'required'],
        ];
    }

}