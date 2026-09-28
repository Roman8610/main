<?php

namespace app\modules\Qm\controllers\api\v1;

use yii\rest\Controller;

class MeetingsController extends Controller
{
    public function actionIndex(): array
    {

        return [
            'countMeetings' => 38,
        ];
    }
}
