<?php

namespace app\modules\Qm\services;

use app\modules\Qm\models\MeetingSearch;

class MeetingService
{

    public function getList()
    {
        $modelSearch = new MeetingSearch();
        $query = $modelSearch->search();
        $meetings = $query->asArray()->all();
        $json = json_encode($meetings, JSON_UNESCAPED_UNICODE);

        return $json;
    }
}
