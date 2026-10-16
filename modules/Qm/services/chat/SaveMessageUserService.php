<?php

namespace app\modules\Qm\services\chat;

use app\models\ChatForm;
use app\modules\Qm\models\AiChatMessages;

class SaveMessageUserService
{
    /**
     * Сохраняет новое сообщение пользователя
     */
    public function run(ChatForm $formModel): AiChatMessages
    {
        $model = new AiChatMessages();
        $model->user_id = $formModel->user_id;
        $model->role = $formModel->role;
        $model->text = $formModel->text;
        $model->created_at = date('Y-m-d H:i:s');

        if (!$model->save()) {
            throw new \Exception('Не удалось сохранить сообщение: ' . json_encode($model->getErrors()));
        }
        return $model;
    }
}
