<?php

namespace app\modules\Qm\services\chat;

use Yii;

/**
 * Проверяет права пользователей на работу с чатом.
 */
class ChatAccessService
{
    /**
     * Проверяет может ли пользователь удалять сообщения чата
     * @param int $userId
     * @return bool
     */
    public function canDelete(int $userId): bool
    {
        if ($this->isOwnedByUser($userId)) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет идентификатор пользльзователя
     * @param int $userId
     * @return bool
     */
    private function isOwnedByUser($userId)
    {
        if ($userId == Yii::$app->user->id) {
            return true;
        }
        return false;
    }
}
