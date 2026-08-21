<?php

namespace app\modules\meetings\controllers;

use app\modules\meetings\models\Meeting;
use app\modules\meetings\models\MeetingQuestion;
use app\modules\meetings\models\MeetingSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MeetingsController extends Controller
{
    public function actionIndex()
    {
        $modelSearch = new MeetingSearch();
        $dataProvider = $modelSearch->search();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id)
    {
        $meeting = Meeting::findOne($id);
        if ($meeting === null) {
            throw new NotFoundHttpException('Совещание не найдено.');
        }

        $userId = 1; // Yii::$app->user->id
        $baseQuery = MeetingQuestion::findByQuestions($id);

        $query = Yii::$app
            ->getModule('meetings')
            ->get('meetingQuestionVisibilityFilterService')
            ->applyVisibilityConditions($baseQuery, $userId, $id);

        $dataProvider = new ActiveDataProvider(['query' => $query]);

        return $this->render('view', [
            'meeting' => $meeting,
            'dataProviderQuestion' => $dataProvider,
        ]);
    }
}
