<?php

namespace app\modules\Qm\controllers\api\v1;

use app\models\ChatForm;
use app\modules\Qm\models\AiChatMessages;
use Yii;
use yii\filters\AccessControl;
use yii\web\UnauthorizedHttpException;

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
            $form->user_id = (int)Yii::$app->user->id;
            Yii::$app->getModule('Qm')->get('processChatMessageService')->run($form);
        }

        return $this->redirect(Yii::$app->request->referrer ?: '/');
    }

}
