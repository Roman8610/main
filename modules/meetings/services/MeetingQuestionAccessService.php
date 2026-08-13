<?php
namespace app\modules\meetings\services;

use yii\web\NotFoundHttpException;

class MeetingQuestionAccessService
{
    public function canCreate(int $meeting_id, int $user_id): bool
    {

        // Проверяем существует ли совещание
        $meeting = \app\modules\meetings\models\Meeting::findOne($meeting_id);
        if (!$meeting) {
            throw new NotFoundHttpException('Совещание не найдено');
        }

        // Получаем роли пользователя в этом совещании
        // Проверяем является ли пользователь сотрудником дочернего общества
        // Является ли пользователь руководителем совещания
        // Является ли пользователь участником совещания
        // Является ли пользователь ответственным в филиале
        // Если ниодна из проверок не возвращает true, возвращаем folse

        // if (!$role) {
        //     return false; // Пользователь вообще не участвует в совещании
        // }
    
        return true;
    }
}
