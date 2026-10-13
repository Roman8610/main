<?php

namespace app\modules\Qm\services;

use app\modules\Qm\dto\ChatMessageResult;

class GetAnswerAiService
{
    /**
     * Возвращает ответ от ИИ
     */
    public function run(array $story):ChatMessageResult {
        return new ChatMessageResult( 'Тестовое сообщение');
    }
}
