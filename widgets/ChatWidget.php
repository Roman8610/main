<?php

namespace app\widgets;

use app\models\ChatForm;
use yii\base\Widget;

class ChatWidget extends Widget
{
    public function run(){
        $modelForm = new ChatForm();
        return $this->render('chat',[
            'modelForm' => $modelForm,
        ]);
    }
}