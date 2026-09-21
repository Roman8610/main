<?php

namespace app\modules\Qm\services;

use app\modules\Qm\forms\RejectMeetingQuestionModerationForm;
use app\modules\Qm\models\MeetingQuestion;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Сервис отклонения постановочного вопроса модератором.
 */
class RejectMeetingQuestionService
{
    /**
     * Переводит вопрос в статус rejected и сохраняет причину отклонения.
     *
     * @param RejectMeetingQuestionModerationForm $formModel
     *     Валидированные данные модерации.
     * @return MeetingQuestion Отклоненный вопрос.
     * @throws ForbiddenHttpException Если пользователь не может модерировать вопрос.
     * @throws NotFoundHttpException Если вопрос не найден.
     * @throws \Throwable Если сохранение не удалось.
     */
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
