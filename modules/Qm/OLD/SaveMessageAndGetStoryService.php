<?php

namespace app\modules\Qm\services\chat;

use app\models\ChatForm;
use app\modules\Qm\models\AiChatMessages;
use Yii;

/**
 * Сервис сохраняет новое сообщение чата и возвращает всю историю включая последнее сообщение для конкретного пользователя
 */
class SaveMessageAndGetStoryService
{
    /**
     * @param ChatForm $formModel
     * @return array<AiChatMessages>
     */
    public function run(ChatForm $formModel): array
    {
        Yii::$app->getModule('Qm')->get('saveMessageService')->run($formModel);
        $messages = Yii::$app->getModule('Qm')->get('getMessagesChatService')->run($formModel->user_id);
        return $messages;
    }
}
