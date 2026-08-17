<?php

namespace app\modules\meetings\services;

use app\modules\meetings\models\MeetingQuestion;
use Yii;
use yii\db\ActiveQuery;

/**
 * Сервис фильтрации видимости постановочных вопросов с учётом ролей пользователя.
 *
 * Правила видимости:
 * - Модератор: видит все вопросы, кроме черновиков других пользователей.
 * - Пользователь: видит все свои вопросы (независимо от статуса) и все опубликованные вопросы других пользователей.
 *
 * Приоритет ролей:
 * Роли проверяются в порядке убывания полномочий (moderator → user).
 * Если у пользователя несколько ролей, применяется правило для роли с наибольшими правами.
 * Это гарантирует, что более широкие права не будут случайно ограничены логикой менее привилегированных ролей.
 */

class MeetingQuestionVisibilityFilterService
{
    /**
     * Применяет условия видимости к базовому запросу в зависимости от ролей пользователя.
     *
     * @param ActiveQuery $baseQuery Базовый запрос ActiveRecord.
     * @param int $userId Идентификатор текущего пользователя.
     * @param int $meetingId Идентификатор совещания.
     * @return ActiveQuery Запрос с применёнными условиями видимости.
     */
    public function applyVisibilityConditions(ActiveQuery $baseQuery, int $userId, int $meetingId): ActiveQuery
    {
        $query = clone $baseQuery;
        $rolesArray = Yii::$app
            ->getModule('meetings')
            ->get('meetingQuestionAccessService')
            ->getRoles($userId, $meetingId);

        if (empty($rolesArray)) {
            $query->where(['and', '1=0']);
            return $query;
        }

        if (in_array('moderator', $rolesArray)) {
            $query->andWhere([
                'or',
                ['<>', 'status', MeetingQuestion::STATUS_DRAFT],
                [
                    'and',
                    ['=', 'status', MeetingQuestion::STATUS_DRAFT],
                    ['=', 'created_by', $userId], // разрешаем только свои черновики
                ],
            ]);
        } elseif (in_array('user', $rolesArray)) {
            $query->andWhere([
                'or',
                ['=', 'created_by', $userId],
                ['=', 'status', MeetingQuestion::STATUS_PUBLISHED],
            ]);
        }


        return $query;
    }
}
