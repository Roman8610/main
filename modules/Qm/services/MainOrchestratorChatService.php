<?php

namespace app\modules\Qm\services;

use app\models\ChatForm;
use Yii;
/**
 * Главные орекстратор, отвечает за весь жизненный цикл диалога, последовательно вызывает сервисы:
 * - сохраняет запрос пользователя в БД
 * - вызывает оркестратор MCP‑агент, инкапсулирует цикл обращений к ИИ
 */
class MainOrchestratorChatService {

    public function run(ChatForm $formModel){
            // Сохранили последенее сообщение пользователя
            Yii::$app->getModule('Qm')->get('saveMessageUserService')->run($formModel);
            // Оркестратор MCP‑агент (Model Context Protocol)
            Yii::$app->getModule('Qm')->get('mcpOrchestratorService')->run();

    }

}