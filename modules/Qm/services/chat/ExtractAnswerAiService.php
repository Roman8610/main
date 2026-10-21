<?php

namespace app\modules\Qm\services\chat;

use app\modules\Qm\dto\AnswerAiDTO;

class ExtractAnswerAiService
{
    public function run(string $dataJson): AnswerAiDTO
    {
        $dataArray = json_decode($dataJson, true);

        if (isset($dataArray['result']['alternatives'][0]['message']['text'])) {
            $cleanJsonString = preg_replace('/^\s*```(?:json)?\s*|\s*```\s*$/s', '', $dataArray['result']['alternatives'][0]['message']['text']);
            $cleanJsonString = trim($cleanJsonString);

            $answerArray = json_decode($cleanJsonString, true);

            if (is_array($answerArray) && json_last_error() === JSON_ERROR_NONE) {
                $message = $answerArray['message'] ?? '';
                $service = $answerArray['service'] ?? '';
                $action = $answerArray['action'] ?? '';
                $params = $answerArray['params'] ?? [];

                return new AnswerAiDTO($message, $service, $action, $params);
            }
        }

        return new AnswerAiDTO('Ошибка экстракции');
    }
}
