<?php

namespace app\modules\Qm\models;

use yii\db\ActiveQuery;

/**
 * Поисковая модель списка совещаний.
 */
class MeetingSearch extends Meeting
{
    /**
     * Создает провайдер данных для списка совещаний.
     *
     * @return ActiveQuery Провайдер данных совещаний.
     */
    public function search(): ActiveQuery
    {
        $query = Meeting::find();

        return $query;
    }
}
