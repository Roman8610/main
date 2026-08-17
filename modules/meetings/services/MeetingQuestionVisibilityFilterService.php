<?php

namespace app\modules\meetings\services;

use Yii;
use yii\db\ActiveQuery;

/**
 * Отвечает за фильтрацию списков постановочных вопросов с учетом ролей пользователя и их принадлежности
 */

class MeetingQuestionVisibilityFilterService
{
    public function applyVisibilityConditions(ActiveQuery $baseQuery, int $userId, int $meetingId): ActiveQuery
    {
        $query = clone $baseQuery;
        $rolesArray = Yii::$app
            ->getModule('meetings')
            ->get('meetingQuestionAccessService')
            ->getRoles($userId, $meetingId);

        dump($rolesArray); die;
            
        return $query;
    }
}
