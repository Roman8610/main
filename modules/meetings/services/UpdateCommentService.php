<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\UpdateCommentForm;
use app\modules\meetings\models\CommentQuestions;
use Yii;
use yii\web\NotFoundHttpException;

class UpdateCommentService
{
    public function run(UpdateCommentForm $formModel): CommentQuestions
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canCreateCommentToQuestion($formModel->question_id, $userId)) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
        }

        $comment = $this->findModel($formModel->comment_id);
        $comment->text = $formModel->text;

        if (!$comment->save()) {
            throw new \Exception('Не удалось сохранить вопрос: ' . json_encode($comment->getErrors()));
        }
        return $comment;
    }

    /**
     * Возвращает модель CommentQuestions по ID.
     * Если модель не найдена — выбрасывает NotFoundHttpException.
     */
    private function findModel(int $id)
    {
        if (($model = CommentQuestions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Комментарий не найден');
    }
}
