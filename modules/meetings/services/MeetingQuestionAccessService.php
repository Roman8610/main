<?php

namespace app\modules\meetings\services;

use yii\web\NotFoundHttpException;

class MeetingQuestionAccessService
{
    /**
     * Проверяет может ли пользователь создать вопрос в совещании
     * @param int $meeting_id
     * @param int $user_id
     * @return bool
     */
    public function canCreate(int $meetingId, int $userId): bool
    {

        // Проверяем существует ли совещание
        $meeting = \app\modules\meetings\models\Meeting::findOne($meetingId);
        if (!$meeting) {
            throw new NotFoundHttpException('Совещание не найдено');
        }

        // Получаем роли пользователя в этом совещании
        // Проверяем является ли пользователь сотрудником дочернего общества
        // Является ли пользователь руководителем совещания
        // Является ли пользователь участником совещания
        // Является ли пользователь ответственным в филиале
        // Если ниодна из проверок не возвращает true, возвращаем false

        return true;
    }

    /**
     * Проверяет может ли пользователь отправить вопрос на модерацию
     */
    public function canSubmitForModeration(): bool
    {
        // Проверяем существует ли совещание 
        // Если совещание не найдено , 
        // то удалить вопрос а так же все связанные с ним сущности и выбросить исключение
        // Проверяем является ли пользователь владельцем вопроса
        return true;
    }

    /**
     * Возвращает массив ролей пользователя для конкретного совещания
     * @return array
     */
    public function getRoles(int $userId, int $meetingId): array
    {
        $roles = ['moderator', 'user'];
        return $roles;
    }
}
