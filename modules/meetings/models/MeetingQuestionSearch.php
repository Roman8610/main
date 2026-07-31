<?php
namespace app\modules\meetings\models;

use app\modules\meetings\models\MeetingQuestion;
use yii\data\ActiveDataProvider;

class MeetingQuestionSearch extends MeetingQuestion
{
    public function searchId(int $meetingId): ActiveDataProvider
    {
        $query = MeetingQuestion::find();
        $query->where(['meeting_id' => $meetingId]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
