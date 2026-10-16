<?php

namespace app\modules\Qm\services\chat;

use app\models\ChatFormDelete;
use app\modules\Qm\models\AiChatMessages;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Сервис удаляет все сообщения чата для конкретного пользователя
 * @param ChatFormDelete $formModel Валидные данные пользователя.
 * @return bool `true`, если вопрос удален, иначе выбрасывается исключение.
 * @throws \Throwable Если удаление не удалось.
 */
class DeleteStoryChatService
{
    public function run(ChatFormDelete $formModel): bool
    {

        if (!Yii::$app->getModule('Qm')->get('chatAccessService')->canDelete($formModel->user_id)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            AiChatMessages::deleteAll(['user_id' => $formModel->user_id]);
            $transaction->commit();
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
