<?php
namespace app\modules\Qm\services;

use app\modules\Qm\forms\OffPublishedMeetingQuestionForm;
use app\modules\Qm\models\MeetingQuestion;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Сервис снятия опубликованного вопроса с публикации.
 */
class OffPublishMeetingQuestionService
{
    /**
     * Переводит опубликованный вопрос в статус removed.
     *
     * @param OffPublishedMeetingQuestionForm $formModel
     *     Валидированные данные операции.
     * @return MeetingQuestion Снятый с публикации вопрос.
     * @throws ForbiddenHttpException Если пользователь не может снять вопрос.
     * @throws NotFoundHttpException Если вопрос не найден.
     * @throws \Throwable Если сохранение не удалось.
     */
    public function run(OffPublishedMeetingQuestionForm $formModel): MeetingQuestion
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canMakeOff($formModel->question_id, $userId)) {
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
