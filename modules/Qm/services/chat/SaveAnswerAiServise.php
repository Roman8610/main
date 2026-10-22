<?php

namespace app\modules\Qm\services\chat;

use app\modules\Qm\dto\AnswerAiDTO;
use app\modules\Qm\models\AiChatMessages;
use Yii;

class SaveAnswerAiServise
{
    public function run(AnswerAiDTO $ansverDto): AiChatMessages
    {
        $model = new AiChatMessages();
        $model->user_id = Yii::$app->user->id;
        $model->role = 'assistant';
        $model->text = $ansverDto->message;
        $model->action = $ansverDto->action;
        $model->service = $ansverDto->service;
        $model->params = json_encode($ansverDto->param);
        $model->created_at = date('Y-m-d H:i:s');

        if (!$model->save()) {
            throw new \Exception('Не удалось сохранить сообщение: ' . json_encode($model->getErrors()));
        }
        return $model;
    }
}
