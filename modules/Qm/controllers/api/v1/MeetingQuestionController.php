<?php

namespace app\modules\Qm\controllers\api\v1;

use app\modules\Qm\models\MeetingQuestion;
use Yii;
use yii\web\ForbiddenHttpException;

class MeetingQuestionController extends ApiController
{
    /**
     * Получение вопросов по ID совещания
     */
    public function actionGetQuestionByMeeting(int $id): array
    {
        $userId = Yii::$app->user->id;
        // if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canView($id, $userId)) {
        //     throw new ForbiddenHttpException('Доступ запрещен');
        // }

        $questions = MeetingQuestion::find()->where(['meeting_id' => $id])->asArray()->all();

        return ['questions' => $questions];
    }

    /**
     * Получение вопросов по статусу
     */
    public function actionGetQuestionByStatus(string $status) {}

    /**
     * Получение вопросов по ID пользователя
     */
    public function actionGetQuestionByUser(int $user_id) {}
}
