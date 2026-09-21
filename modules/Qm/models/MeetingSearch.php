<?php

namespace app\modules\Qm\models;

use yii\data\ActiveDataProvider;

/**
 * Поисковая модель списка совещаний.
 */
class MeetingSearch extends Meeting
{
    /**
     * Создает провайдер данных для списка совещаний.
     *
     * @return ActiveDataProvider Провайдер данных совещаний.
     */
    public function search(): ActiveDataProvider
    {
        $query = Meeting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
