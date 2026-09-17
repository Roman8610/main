<?php

/**
 * @var array $tree
 * @var int $question_id
 * @var app\modules\Qm\forms\CommentForm $formModelCommentCreate
 * @var app\modules\Qm\forms\UpdateCommentForm $formModelCommentUpdate
 * @var app\modules\Qm\forms\DeleteCommentForm $formModelCommentDelete
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="comments-section">
    <h4 class="mb-3">Ответ</h4>

    <?php if (!empty($tree)): ?>
        <div class="comments-tree">
            <?php foreach ($tree as $comment): ?>
                <?= $this->render('_comment', [
                    'comment' => $comment,
                    'depth'   => 0,
                    'formModelCommentDelete' => $formModelCommentDelete,
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
                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['/Qm/question-comments/update', 'id' => 0]),
                    'id' => 'editCommentForm',
                    'options' => [
                        'data-action-template' => Url::to([
                            '/Qm/question-comments/update',
                            'id' => '__COMMENT_ID__',
                        ]),
                    ],
                ]); ?>
                <?= $form->field($formModelCommentUpdate, 'text')->textarea([
                    'rows' => 6,
                    'id' => 'editCommentText',
                ]) ?>
                <?= $form->field($formModelCommentUpdate, 'question_id')->hiddenInput([
                    'value' => $question_id,
                    'id' => 'editCommentQuestionId',
                ])->label(false) ?>
                <div class="mt-3 text-end">
                    <?= Html::submitButton('Сохранить', [
                        'class' => 'btn btn-primary',
                       // 'disabled' => true,
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>
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
                <?php $form = ActiveForm::begin([
                    'action' => ['/Qm/question-comments/create', 'id' => $question_id],
                    'id' => 'replyCommentForm',
                ]); ?>
                <?= $form->field($formModelCommentCreate, 'text')->textarea([
                    'rows' => 6,
                    'placeholder' => 'Введите ответ',
                    'id' => 'replyCommentText',
                ]) ?>
                <?= $form->field($formModelCommentCreate, 'parent_id')->hiddenInput([
                    'id' => 'replyParentCommentId',
                ])->label(false) ?>
                <div class="mt-3 text-end">
                    <?= Html::submitButton('Ответить', [
                        'class' => 'btn btn-primary',
                      //  'disabled' => true,
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>
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
        const editForm = document.getElementById('editCommentForm');
        editForm.action = editForm.dataset.actionTemplate.replace('__COMMENT_ID__', editLink.dataset.commentId);
    }

    if (replyLink) {
        document.getElementById('replyCommentText').value = '';
        document.getElementById('replyParentCommentId').value = replyLink.dataset.parentCommentId;
    }
});
JS
);
?>