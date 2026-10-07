<?php

namespace app\modules\Qm\controllers\api\v1;

use RuntimeException;
use Yii;

// yc config list  
// yc iam create-token - создание нового токена
// curl.exe -i -H "Authorization: Bearer 101-token" "http://yiitest.loc/Qm/api/v1/ai-chat/execute"


class AiChatController extends ApiController
{

    public function actionExecute()
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
            'messages' => [
                [
                    'role' => 'system',
                    'text' => file_get_contents( \Yii::getAlias('@app/modules/Qm/doc/ai-promt-v1-test.txt')),
                ],
                [
                    'role' => 'user',
                    'text' => 'Сколько звезд на небе ?',
                ],
            ],
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
