<?php

namespace app\modules\Qm\services\chat;

use app\models\ChatForm;
use Yii;

/**
 * Сервис оркестаратор.
 * Последовательно вызывает сервисы:
 * - Получение сырых данных от ИИ
 * - Экстракция данных и формирование объекта DTO
 * - Сохранение данных в БД
 */
class GetAnswerAiAndSaveService
{
    public function run(ChatForm $formModel)
    {
        $answer = Yii::$app->getModule('Qm')->get('getAnswerAiService')->run($formModel);
        $answerDto = Yii::$app->getModule('Qm')->get('extractAnswerAiService')->run($answer); 
         
        Yii::$app->getModule('Qm')->get('saveMessageAndGetStoryService')->run($answerDto);
    }
}
