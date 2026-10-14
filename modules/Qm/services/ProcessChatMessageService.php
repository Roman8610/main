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
            // Этот сервис внутри должен вызвать последовательно сервисы получения ответа от ИИ и преобразования ответа в объект DTO
            $DtoAi = Yii::$app->getModule('Qm')->get('getAnswerAiAndTransformToDTOService')->run($story);

            // Перезаписываем данные в $formModel, станавливаем роль ассистента и текст ответа ИИ
            // Валедируем данные в $formModel
            // Вызваем сервис сохранения сообщения

            // проверяем есть ли в DtoAi указание на дейтвие которое необходимо выполнить
            // если есть, то проверяем разрешено ли это действие. 
            // Вызываем соответствующий сервис
            // Отправлем результат работы сервиса в ИИ для генерации итогового ответа
            // Сохраняем результат в БД
            // 


           
            return new ChatMessageResult('сообщение', $type = null, $data = []);
    }

}