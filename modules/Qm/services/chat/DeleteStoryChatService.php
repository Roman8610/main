<?php

namespace app\modules\Qm\services\chat;

use app\modules\Qm\models\AiChatMessages;
use Yii;

/**
 * Сервис удаляет все сообщения чата для конкретного пользователя
 * @param int $user_id Идентификатор пользователя.
 * @return bool `true`, если вопрос удален, иначе выбрасывается исключение.
 * @throws \Throwable Если удаление не удалось.
 */
class DeleteStoryChatService
{
    public function run(int $user_id):bool {

        $transaction = Yii::$app->db->beginTransaction();
        try {
            AiChatMessages::deleteAll(['user_id' => $user_id]);
            $transaction->commit();
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
  
}
