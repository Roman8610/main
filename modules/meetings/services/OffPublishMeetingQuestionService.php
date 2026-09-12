<?php
namespace app\modules\meetings\services;

use app\modules\meetings\forms\OffPublishedMeetingQuestionForm;
use app\modules\meetings\models\MeetingQuestion;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class OffPublishMeetingQuestionService
{
    public function run(OffPublishedMeetingQuestionForm $formModel): MeetingQuestion
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canMakeOff($formModel->question_id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $question = $this->findModel($formModel->question_id);
        $question->status = MeetingQuestion::STATUS_REMOVED;

        if (!$question->save(false)) {
            throw new \Exception('Не удалось сохранить вопрос: ' . json_encode($question->getErrors()));
        }
        return $question;
    }
    /**
     * Возвращает модель MeetingQuestion по ID.
     * Если модель не найдена — выбрасывает NotFoundHttpException.
     */
    private function findModel(int $id)
    {
        if (($model = MeetingQuestion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Вопрос не найден');
    }
}
