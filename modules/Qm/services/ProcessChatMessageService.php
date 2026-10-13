<?php

namespace app\modules\Qm\services;

use app\models\ChatForm;
use app\modules\Qm\dto\ChatMessageResult;
use Yii;

class ProcessChatMessageService {

    public function run(ChatForm $formModel): ChatMessageResult{
            // Сохранили последенее сообщение пользователя и получили историю его сообщений
            $story = Yii::$app->getModule('Qm')->get('saveMessageAndGetStoryService')->run($formModel);
            // вызываем сервис который делает запрос к ИИ и возвращает ответ
            // Этот сервис внутри должен вызвать последовательно сервисы получения ответа от ИИ и извлечения сообщения из ответа
            $messageAi = Yii::$app->getModule('Qm')->get('getAnswerAiAndExtractsMessageService')->run($story);

            // Перезаписываем данные в $formModel
            // Валедируем данные в $formModel
            // Вызваем сервис сохранения сообщения


           
            return new ChatMessageResult('сообщение', $type = null, $data = []);
    }

}