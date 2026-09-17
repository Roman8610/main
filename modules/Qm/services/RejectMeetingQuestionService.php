<?php

namespace app\modules\Qm\services;

use app\modules\Qm\forms\RejectMeetingQuestionModerationForm;
use app\modules\Qm\models\MeetingQuestion;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class RejectMeetingQuestionService
{
    public function run(RejectMeetingQuestionModerationForm $formModel): MeetingQuestion
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canMakeModeration($formModel->question_id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        $question = $this->findModel($formModel->question_id);
        $question->comment_moderator = $formModel->comment_moderator;
        $question->status = MeetingQuestion::STATUS_REJECTED;
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
