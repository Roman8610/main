<?php

namespace app\modules\meetings\widgets;

use app\modules\meetings\models\CommentQuestions;
use Override;

class CommentsWidget extends \yii\base\Widget
{
    public int $question_id;

    #[Override]
    public function run()
    {

        $tree = $this->getTree();

        return $this->render('comments', [
            'tree' => $tree,
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
            // TODO: убрать после подключения связи с файлами
            $flat[$comment['id']]['files'] = [
                [
                    'name' => 'document.pdf',
                    'size' => '245 KB',
                    'url'  => '/uploads/document.pdf',
                ],
                                [
                    'name' => 'document.pdf',
                    'size' => '245 KB',
                    'url'  => '/uploads/document.pdf',
                ],
                                [
                    'name' => 'document.pdf',
                    'size' => '245 KB',
                    'url'  => '/uploads/document.pdf',
                ],
            ];
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
