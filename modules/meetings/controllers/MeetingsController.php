<?php

namespace app\modules\meetings\controllers;

use app\modules\meetings\models\Meeting;
use app\modules\meetings\models\MeetingQuestionSearch;
use app\modules\meetings\models\MeetingSearch;
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

        $modelSearch = new MeetingQuestionSearch();
        $dataProvider = $modelSearch->searchID($id);

        return $this->render('view', [
            'meeting' => $meeting,
            'dataProviderQuestion' => $dataProvider,
        ]);
    }
}
