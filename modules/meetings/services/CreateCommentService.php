<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\CommentForm;
use app\modules\meetings\models\CommentQuestions;
use Yii;

class CreateCommentService
{
    public function run(CommentForm $formModel): CommentQuestions
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canCreateCommentToQuestion($formModel->question_id, $userId)) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
        }

        $comment = new CommentQuestions();
        $comment->question_id = $formModel->question_id;
        $comment->created_at = date('Y-m-d H:i:s');
        $comment->text = $formModel->text;

        if (!$comment->save()) {
            throw new \Exception('Не удалось сохранить вопрос: ' . json_encode($comment->getErrors()));
        }
        return $comment;        
    }
}
