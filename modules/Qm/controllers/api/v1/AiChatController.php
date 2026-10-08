<?php

namespace app\modules\Qm\controllers\api\v1;

use app\models\ChatForm;
use RuntimeException;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

// yc config list  
// yc iam create-token - создание нового токена
// curl.exe -i -H "Authorization: Bearer 101-token" "http://yiitest.loc/Qm/api/v1/ai-chat/execute"


class AiChatController extends ApiController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        // 1. Убираем HttpBearerAuth — он блокирует запросы без токена
        unset($behaviors['authenticator']);

        // 2. Убедимся, что AccessControl есть
        if (!isset($behaviors['access'])) {
            $behaviors['access'] = [
                'class' => AccessControl::class,
                'rules' => [],
                'denyCallback' => static function () {
                    throw new UnauthorizedHttpException('Необходима авторизация.');
                },
            ];
        }

        // 3. Разрешаем actionExecute только авторизованным пользователям (через сессию)
        $behaviors['access']['rules'][] = [
            'actions' => ['execute'],
            'allow' => true,
            'roles' => ['@'],
        ];

        return $behaviors;
    }

    public function actionExecute()
    {
        $form = new ChatForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
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
                        'text' => file_get_contents(\Yii::getAlias('@app/modules/Qm/doc/ai-promt-v1-test.txt')),
                    ],
                    [
                        'role' => 'user',
                        'text' => $form->text,
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

            $data = json_decode($response, true);

            if (isset($data['result']['alternatives'][0]['message']['text'])) {

                $cleanJsonString = preg_replace('/^\s*```(?:json)?\s*|\s*```\s*$/s', '', $data['result']['alternatives'][0]['message']['text']);
                $cleanJsonString = trim($cleanJsonString);

                $intent = json_decode($cleanJsonString, true);

                $action = null;
                $params = [];

                if (is_array($intent) && json_last_error() === JSON_ERROR_NONE) {
                    $action = $intent['action'] ?? null;
                    $params = $intent['params'] ?? [];
                }

                return $action;
            }

            return $data;
        }
    }
}
