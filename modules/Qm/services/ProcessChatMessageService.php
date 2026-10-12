<?php

namespace app\modules\Qm\services;

use app\models\ChatForm;
use app\modules\Qm\dto\ChatMessageResult;

class ProcessChatMessageService {

    public function run(ChatForm $formModel): ChatMessageResult{

            // вызываем сервис который сохраняет историю сообщений чата
            // вызываем сервис который делает запрос к ИИ и возвращает ответ
            // вызываем сервис который разбирает ответ ИИ (в зависимости от результата, вызывает нужные сервисы), возвращает сообщение от ИИ
            return new ChatMessageResult('сообщение', $type = null, $data = []);
    }

}