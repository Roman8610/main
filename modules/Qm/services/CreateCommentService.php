<?php

namespace app\modules\Qm\services;

use app\modules\Qm\forms\CommentForm;
use app\modules\Qm\models\CommentQuestions;
use Yii;

class CreateCommentService
{
    public function run(CommentForm $formModel): CommentQuestions
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canCreateCommentToQuestion($formModel->question_id, $userId)) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
        }

        $comment = new CommentQuestions();
        $comment->question_id = $formModel->question_id;
        $comment->created_at = date('Y-m-d H:i:s');
        $comment->text = $formModel->text;
        $comment->parent_id = $formModel->parent_id;

        if (!$comment->save()) {
            throw new \Exception('Не удалось сохранить вопрос: ' . json_encode($comment->getErrors()));
        }
        return $comment;        
    }
}
