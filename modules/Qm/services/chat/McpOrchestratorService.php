<?php

namespace app\modules\Qm\services\chat;

use app\modules\Qm\dto\AnswerAiDTO;
use app\modules\Qm\models\AiChatMessages;
use Yii;

/**
 * MCP - оркестратор
 * Инкапсуляция логики взаимодействия с ИИ
 * Оркестратор запускает цикл обращений к ИИ:
 *   Начало цикла обращений к ИИ
 * - Получаем историю польльзователя из БД
 * - Подготавливаем историю к передаче в ИИ (приватный метод)
 * - Сервис получения сырых данных от ИИ
 * - Сервис сохранения данных ИИ в БД
 * Завершение цикла
 * - Проверка есть ли  в ответе инструкция для выполнения и не исчетпан ли лимит циклов
 * - Проверка не дублирование ответа ИИ , если ИИ дает два подряд одинаковых ответа , цикл прекращается 
 * 
 */
class McpOrchestratorService
{
    private $limit = 20;
    public function run()
    {
        $n = 0;
        do {
            $n++;
            // Получение истории чата для формиррования контекста
            $promt = [
                'role' => 'system',
                'text' => file_get_contents(\Yii::getAlias('@app/modules/Qm/doc/ai-promt-v1-test.txt')),
            ];
            $context = AiChatMessages::find()
                ->select(['role', 'text', 'created_at'])
                ->where(['user_id' => Yii::$app->user->id])
                ->limit($this->limit)
                ->asArray()
                ->orderBy(['created_at' => SORT_DESC])
                ->all();

            // Берём последние N сообщений (по убыванию даты), затем восстанавливаем хронологический порядок
            $context = array_reverse($context);

            array_unshift($context, $promt);

            // сервис обращения к ИИ, получаем сырые данные от ИИ
            $dataJson = Yii::$app->getModule('Qm')->get('getAnswerAiService')->run($context);

            // выполняем экстракцию данных
            $dataDto = $this->extractMessage($dataJson);
            // выполняем сохранение ответа ИИ
            Yii::$app->getModule('Qm')->get('saveAnswerAiServise')->run($dataDto);

            if (!$this->isAction()) {
                break;
            }

            // Запускаем сервис выполнение инструкций 


            if ($this->isDuble()) {
                // Если ии начал дублировать ответы, выполняем сохранение системных данных о том что у ИИ не получилось обработать запрос
                // попробуйте сформулировать вопрос по другому 
            }
        } while ($n < $this->limit);
    }

    private function isAction(): bool
    {
        return false;
    }

    private function isDuble(): bool
    {
        return true;
    }


    /**
     * Формирует объект DTO из JSON
     *
     * @param string $dataJson JSON‑строка с данными
     * @return AnswerAiDTO
     */
    private function extractMessage(string $dataJson): AnswerAiDTO
    {
        $dataArray = json_decode($dataJson, true);

        if (isset($dataArray['result']['alternatives'][0]['message']['text'])) {
            $cleanJsonString = preg_replace('/^\s*```(?:json)?\s*|\s*```\s*$/s', '', $dataArray['result']['alternatives'][0]['message']['text']);
            $cleanJsonString = trim($cleanJsonString);

            $answerArray = json_decode($cleanJsonString, true);

            $action = null;
            $params = [];

            if (is_array($answerArray) && json_last_error() === JSON_ERROR_NONE) {
                $message = $answerArray['message'] ?? '';
                $action = $answerArray['action'] ?? '';
                $params = $answerArray['params'] ?? [];

                return new AnswerAiDTO($message, $action, $params);
            }
        }

        return new AnswerAiDTO('Ошибка обработки ответа ассистента');
    }
}
