<?php

/**
 * @var array $comment
 * @var int $depth
 * @var app\modules\Qm\forms\DeleteCommentForm $formModelCommentDelete
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\icons\Icon;
?>

<div class="comment mb-3 <?= $depth > 0 ? 'ms-5' : '' ?>" data-id="<?= $comment['id'] ?>">
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
                <div class="d-flex align-items-center gap-2">
                    <?php if (Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canUpdateComment($comment['id'], Yii::$app->user->id)): ?>
                        <a href="#"
                            class="text-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#editCommentModal"
                            data-comment-id="<?= (int)$comment['id'] ?>"
                            data-comment-text="<?= Html::encode($comment['text']) ?>"
                            title="Редактировать">
                            <?= Icon::show('pencil') ?>
                        </a>
                    <?php else: ?>
                        <?= Icon::show('pencil') ?>
                    <?php endif; ?>
                    <?php if (Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canCreateCommentToComment($comment['id'], Yii::$app->user->id)): ?>
                        <a href="#"
                            class="text-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#replyCommentModal"
                            data-parent-comment-id="<?= (int)$comment['id'] ?>"
                            title="Ответить">
                            <?= Icon::show('reply') ?>
                        </a>
                    <?php else: ?>
                        <?= Icon::show('reply') ?>
                    <?php endif; ?>
                    <?php if (Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canCreateCommentToComment($comment['id'], Yii::$app->user->id)): ?>
                        <?php $form = ActiveForm::begin([
                            'action' => ['/Qm/question-comments/delete'],
                            'options' => ['class' => 'd-inline-flex align-items-center m-0 p-0'],
                            'fieldConfig' => ['template' => "{input}"],
                        ]); ?>
                        <?= $form->field($formModelCommentDelete, 'comment_id')->hiddenInput([
                            'value' => $comment['id'],
                        ]) ?>
                        <?= Html::submitButton(Icon::show('trash'), [
                            'class' => 'border-0 bg-transparent p-0 text-primary d-flex align-items-center',
                            'title' => 'Удаление',
                            'encode' => false,
                            'onclick' => "return confirm('ВАЖНО!!! Вложенные элементы также будут удалены. Вы уверены, что хотите удалить эту запись?')",
                        ]) ?>
                        <?php ActiveForm::end(); ?>
                    <?php else: ?>
                        <?=Icon::show('trash')?>
                    <?php endif; ?>
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