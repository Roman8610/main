<?php

namespace app\modules\Qm\services;

use app\modules\Qm\models\AiChatMessages;

class GetMessagesChatService
{
    /**
     * Возвращает историю сообщений чата с ИИ для пользователя
     */
    public function run(int $user_id):array {
        $messages = AiChatMessages::find()->where(['user_id' => $user_id])->all();
        return $messages;
    }
}
