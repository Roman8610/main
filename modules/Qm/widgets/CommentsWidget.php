<?php

namespace app\modules\Qm\widgets;

use app\modules\Qm\forms\CommentForm;
use app\modules\Qm\forms\DeleteCommentForm;
use app\modules\Qm\forms\UpdateCommentForm;
use app\modules\Qm\models\CommentQuestions;
use Override;

class CommentsWidget extends \yii\base\Widget
{
    public int $question_id;
    public CommentForm $formModelCommentCreate;
    public UpdateCommentForm $formModelCommentUpdate;
    public DeleteCommentForm $formModelCommentDelete;

    #[Override]
    public function run()
    {
        $tree = $this->getTree();
        return $this->render('comments', [
            'tree' => $tree,
            'question_id' => $this->question_id,
            'formModelCommentCreate' => $this->formModelCommentCreate,
            'formModelCommentUpdate' => $this->formModelCommentUpdate,
            'formModelCommentDelete' => $this->formModelCommentDelete,
        ]);
    }

    private function getTree(): array
    {
        $comments = CommentQuestions::find()
            ->where(['question_id' => $this->question_id])
            ->orderBy(['created_at' => SORT_ASC])
            ->asArray()
            ->all();


        $flat = [];
        foreach ($comments as $comment) {
            $flat[$comment['id']] = $comment;
            $flat[$comment['id']]['children'] = [];
        }

        $tree = [];
        foreach ($flat as $id => $comment) {
            $parentId = $comment['parent_id'] ?? null;
            if ($parentId === null || !isset($flat[$parentId])) {
                $tree[] = &$flat[$id];
            } else {
                $flat[$parentId]['children'][] = &$flat[$id];
            }
        }

        return $tree;
    }
}
