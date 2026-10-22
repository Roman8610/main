<?php

namespace app\modules\Qm\controllers\api\v1;

use app\models\ChatForm;
use app\models\ChatFormDelete;
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

        $behaviors['access']['rules'][] = [
            'actions' => ['delete'],
            'allow' => true,
            'roles' => ['@'],
        ];

        return $behaviors;
    }

    // yc config list  
    // yc iam create-token - создание нового токена
    // curl.exe -i -H "Authorization: Bearer 101-token" "http://yiitest.loc/Qm/api/v1/ai-chat/execute"

    public function actionExecute()
    {
        $form = new ChatForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->user_id = (int)Yii::$app->user->id;
            $form->role = 'user';
            Yii::$app->getModule('Qm')->get('saveMessageUserService')->run($form);
            Yii::$app->getModule('Qm')->get('agentOrchestrator')->run();
        }

        return $this->redirect(Yii::$app->request->referrer ?: '/');
    }

    public function actionDelete()
    {
        $form = new ChatFormDelete();
        $form->user_id = Yii::$app->request->post('user_id');
        if ($form->validate()) {
            if (Yii::$app->getModule('Qm')->get('chatAccessService')->canDelete($form->user_id)) {
                Yii::$app->getModule('Qm')->get('deleteStoryChatService')->run($form);
            }
        }
        return $this->redirect(Yii::$app->request->referrer ?: '/');
    }
}
