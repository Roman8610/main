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

<style>
    #editCommentModal.show {
        display: block;
        opacity: 1;
    }

    #editCommentModal.show .modal-dialog {
        transform: none;
    }
</style>
<div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCommentModalLabel">Редактирование комментария</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <?= Html::beginForm('', 'post', ['id' => 'editCommentForm']) ?>
                <?= Html::textarea('text', '', [
                    'class' => 'form-control',
                    'rows' => 6,
                    'id' => 'editCommentText',
                ]) ?>
                <?= Html::hiddenInput('comment_id', '', ['id' => 'editCommentId']) ?>
                <div class="mt-3 text-end">
                    <?= Html::submitButton('Сохранить', [
                        'class' => 'btn btn-primary',
                        'disabled' => true,
                    ]) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>

<style>
    #replyCommentModal.show {
        display: block;
        opacity: 1;
    }

    #replyCommentModal.show .modal-dialog {
        transform: none;
    }
</style>
<div class="modal fade" id="replyCommentModal" tabindex="-1" aria-labelledby="replyCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyCommentModalLabel">Ответ на комментарий</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <?= Html::beginForm('', 'post', ['id' => 'replyCommentForm']) ?>
                <?= Html::textarea('text', '', [
                    'class' => 'form-control',
                    'rows' => 6,
                    'placeholder' => 'Введите ответ',
                    'id' => 'replyCommentText',
                ]) ?>
                <?= Html::hiddenInput('parent_comment_id', '', ['id' => 'replyParentCommentId']) ?>
                <div class="mt-3 text-end">
                    <?= Html::submitButton('Ответить', [
                        'class' => 'btn btn-primary',
                        'disabled' => true,
                    ]) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs(
    <<<'JS'
document.addEventListener('click', function (event) {
    const editLink = event.target.closest('[data-bs-target="#editCommentModal"]');
    const replyLink = event.target.closest('[data-bs-target="#replyCommentModal"]');

    if (editLink) {
        document.getElementById('editCommentText').value = editLink.dataset.commentText;
        document.getElementById('editCommentId').value = editLink.dataset.commentId;
    }

    if (replyLink) {
        document.getElementById('replyCommentText').value = '';
        document.getElementById('replyParentCommentId').value = replyLink.dataset.parentCommentId;
    }
});
JS
);
?>