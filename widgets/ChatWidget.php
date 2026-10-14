<?php

namespace app\widgets;

use app\models\ChatForm;
use app\modules\Qm\models\AiChatMessages;
use Yii;
use yii\base\Widget;

class ChatWidget extends Widget
{
    public function run(){
        $modelForm = new ChatForm();
        $messages = AiChatMessages::find()->where(['user_id' => Yii::$app->user->id])->all();
        return $this->render('chat',[
            'modelForm' => $modelForm,
            'messages' => $messages,
        ]);
    }
}