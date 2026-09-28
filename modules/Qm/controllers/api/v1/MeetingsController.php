<?php

namespace app\modules\Qm\controllers\api\v1;

use app\modules\Qm\models\Meeting;
use yii\web\NotFoundHttpException;

class MeetingsController extends ApiController
{
    public function verbs(): array
    {
        return [
            'index' => ['GET'],
        ];
    }

    /**
     * Возвращает все совещания
     * @return array
     */
    public function actionIndex(): array
    {

        $meetings = Meeting::find()->asArray()->all();

        return [
            'allMeetings' => $meetings,
        ];
    }

    /**
     * Возвращает совещание по id
     * @return array
     */
    public function actionView(int $id): array
    {
        $meeting = Meeting::find()->where(['id' => $id])->asArray()->one();

        if (!$meeting) {
            throw new NotFoundHttpException();
        }

        return [
            'meeting' => $meeting,
        ];
    }
}
