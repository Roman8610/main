<?php

namespace app\modules\Qm\services;

use app\modules\Qm\models\CommentQuestions;

/**
 * Сервис удаления комментария.
 */
class DeleteCommentService
{
    /**
     * Удаляет комментарий и возвращает идентификатор его вопроса.
     *
     * @param int $id Идентификатор комментария.
     * @return int Идентификатор постановочного вопроса.
     * @throws \RuntimeException Если удаление не удалось.
     * @throws \TypeError Если комментарий отсутствует и текущая реализация
     *     возвращает значение, не соответствующее объявленному типу.
     */
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
