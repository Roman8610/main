<?php

namespace app\modules\Qm\controllers\api\v1;

use RuntimeException;

class AiChatController extends ApiController
{
    public function actionExecute()
    {

       
        if (!$iamToken) {
            throw new RuntimeException('IAM_TOKEN не задан');
        }

        $url = 'https://resource-manager.api.cloud.yandex.net/resource-manager/v1/clouds';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $iamToken,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($ch);

        return $response;
    }
}
