<?php

namespace app\modules\meetings\models;

use yii\data\ActiveDataProvider;

class MeetingSearch extends Meeting
{
    public function search(): ActiveDataProvider
    {
        $query = Meeting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
