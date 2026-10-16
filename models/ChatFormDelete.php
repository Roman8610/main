<?php

namespace app\models;

use Override;
use yii\base\Model;

class ChatFormDelete extends Model
{
    public $user_id;

    #[Override]
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
        ];
    }
}
