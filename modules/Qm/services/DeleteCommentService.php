<?php

namespace app\modules\Qm\services;

use app\modules\Qm\models\CommentQuestions;

class DeleteCommentService
{
    public function run(int $id):int
    {
        $comment = CommentQuestions::findOne($id);
        if ($comment === null) {
            return false;
        }

        if (!$comment->delete()) {
            throw new \RuntimeException('Не удалось удалить постановочный вопрос');
        }

        return $comment->question->id;

    }
}
