<?php

/**
 * @var array $comment
 * @var int $depth
 * @var app\modules\meetings\forms\DeleteCommentForm $formModelCommentDelete
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\icons\Icon;
?>

<div class="comment mb-3 <?= $depth > 0 ? 'ms-3' : '' ?>" data-id="<?= $comment['id'] ?>">
    <div class="card">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="text-dark">
                    <?= Html::encode($comment['author_name'] ?? 'Аноним') ?>
                </strong>
                <small class="text-muted opacity-50" style="font-size: 0.75rem">
                    Создан: <?= Yii::$app->formatter->asDatetime($comment['created_at'], 'dd.MM.yyyy HH:mm') ?>
                    <?php if (!empty($comment['updated_at'])): ?>
                        &nbsp;&nbsp;|&nbsp;&nbsp;Изменен: <?= Yii::$app->formatter->asDatetime($comment['updated_at'], 'dd.MM.yyyy HH:mm') ?>
                    <?php endif; ?>
                </small>
                <div class="d-flex gap-2">
                    <a href="#"
                       class="text-muted opacity-50"
                       style="font-size: 0.8rem"
                       data-bs-toggle="modal"
                       data-bs-target="#editCommentModal"
                       data-comment-id="<?= (int)$comment['id'] ?>"
                       data-comment-text="<?= Html::encode($comment['text']) ?>"
                       title="Редактировать">
                        <?= Icon::show('pencil') ?>
                    </a>
                    <a href="#"
                       class="text-muted opacity-50"
                       style="font-size: 0.8rem"
                       data-bs-toggle="modal"
                       data-bs-target="#replyCommentModal"
                       data-parent-comment-id="<?= (int)$comment['id'] ?>"
                       title="Ответить">
                        <?= Icon::show('reply') ?>
                    </a>
                    <!-- <a href="#" class="text-muted opacity-50" style="font-size: 0.8rem"><?= Icon::show('trash') ?></a> -->
                    <?php $form = ActiveForm::begin([
                        'action' => ['/meetings/question-comments/delete'],
                        'options' => ['style' => 'display: inline'],
                        'fieldConfig' => ['template' => "{input}"],
                    ]); ?>
                    <?= $form->field($formModelCommentDelete, 'comment_id')->hiddenInput([
                        'value' => $comment['id'],
                    ]) ?>
                    <?= Html::submitButton(Icon::show('trash'), [
                            'class' => 'btn p-0 border-0 bg-transparent text-muted opacity-50',
                            'style' => 'font-size: 0.8rem',
                            'title' => 'Удаление',
                            'encode' => false,
                            'onclick' => "return confirm('Вы уверены, что хотите удалить эту запись?')",
                    ]) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="comment-text text-secondary">
                <?= nl2br(Html::encode($comment['text'])) ?>
            </div>
        </div>
    </div>

    <?php if (!empty($comment['children'])): ?>
        <div class="comment-children mt-2">
            <?php foreach ($comment['children'] as $child): ?>
                <?= $this->render('_comment', [
                    'comment' => $child,
                    'depth'   => $depth + 1,
                    'formModelCommentDelete' => $formModelCommentDelete,
                ]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>