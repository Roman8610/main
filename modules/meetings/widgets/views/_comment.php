<?php
/**
 * @var array $comment
 * @var int $depth
 */
use yii\helpers\Html;
use kartik\icons\Icon;
?>

<?php
// TODO: Заменить на реальную связь с файлами
// $files = $comment['model']->files;
$files = $comment['files'] ?? [];
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
                    <a href="#" class="text-muted opacity-50" style="font-size: 0.8rem"><?= Icon::show('pencil') ?></a>
                    <a href="#" class="text-muted opacity-50" style="font-size: 0.8rem"><?= Icon::show('reply') ?></a>
                    <a href="#" class="text-muted opacity-50" style="font-size: 0.8rem"><?= Icon::show('trash') ?></a>
                </div>
            </div>
            <div class="comment-text text-secondary">
                <?= nl2br(Html::encode($comment['text'])) ?>
            </div>

            <?php if (!empty($files)): ?>
                <div class="border-top pt-2 mt-2">
                    <div class="attachments d-flex align-items-center gap-3">
                        <?php foreach ($files as $file): ?>
                            <div class="d-flex align-items-center gap-2">
                                <?= Icon::show('file', ['class' => 'text-muted opacity-50']) ?>
                                <span class="text-muted opacity-50" style="font-size: 0.75rem"><?= Html::encode($file['name']) ?></span>
                                <span class="text-muted opacity-50" style="font-size: 0.75rem">(<?= $file['size'] ?>)</span>
                                <a href="<?= $file['url'] ?>" class="text-muted opacity-50" style="font-size: 0.75rem">скачать</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($comment['children'])): ?>
        <div class="comment-children mt-2">
            <?php foreach ($comment['children'] as $child): ?>
                <?= $this->render('_comment', [
                    'comment' => $child,
                    'depth'   => $depth + 1,
                ]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
