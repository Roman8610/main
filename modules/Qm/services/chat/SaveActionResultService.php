<?php

namespace app\modules\Qm\services\chat;

use app\modules\Qm\dto\ActionResultDTO;
use app\modules\Qm\models\AiChatMessages;

class SaveActionResultService
{
    public function run(ActionResultDTO $ansverDto, int $id): AiChatMessages
    {
        $model = $this->findModel($id);

        $model->action_success = $ansverDto->success;
        $model->action_message = $ansverDto->message;
        $model->action_data = json_encode($ansverDto->data, JSON_UNESCAPED_UNICODE );
        $model->action_error_code = $ansverDto->errorCode;

        if (!$model->save()) {
            throw new \Exception('Не удалось сохранить сообщение: ' . json_encode($model->getErrors()));
        }
        return $model;
    }

    private function findModel(int $id): AiChatMessages
    {
        if (($model = AiChatMessages::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('Инструкция не найдена');
    }
}
