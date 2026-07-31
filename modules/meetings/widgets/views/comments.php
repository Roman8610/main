<?php
/**
 * @var array $tree
 */
use yii\helpers\Html;
?>

<div class="comments-section">
    <h4 class="mb-3">Ответ</h4>

    <?php if (!empty($tree)): ?>
        <div class="comments-tree">
            <?php foreach ($tree as $comment): ?>
                <?= $this->render('_comment', [
                    'comment' => $comment,
                    'depth'   => 0,
                ]) ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">Ответа пока нет</p>
    <?php endif; ?>
</div>