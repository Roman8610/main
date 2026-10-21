<?php

namespace app\modules\Qm\services\chat;

use app\models\ChatForm;
use RuntimeException;
use Yii;

class GetAnswerAiService
{
    /**
     * Получает ответ от ИИ
     */
    public function run(array $context):string
    {
        $iamToken = Yii::$app->params['iamToken'];
        $folderId = Yii::$app->params['folderId'];

        if (!$iamToken) {
            throw new RuntimeException('IAM_TOKEN не задан');
        }

        $payload = [
            'modelUri' => 'gpt://' . $folderId . '/yandexgpt/latest',
            'completionOptions' => [
                'temperature' => 0.7,
                'maxTokens' => 150,
            ],
            'messages' => $context,

        ];

        $url = 'https://llm.api.cloud.yandex.net/foundationModels/v1/completion';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $iamToken,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($ch);

        return $response;
    }

}
