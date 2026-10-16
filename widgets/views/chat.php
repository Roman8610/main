<?php

/** @var app\models\ChatForm $modelForm */
/** @var array $messages */
?>
<?php

use kartik\form\ActiveForm;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="sidebar-chat-dialog<?= $messages ? ' sidebar-chat-dialog-messages' : ' sidebar-chat-dialog-empty' ?>" aria-label="Пример диалога">
    <?php if ($messages): ?>
        <?php foreach ($messages as $message): ?>
            <?php if ($message->role == 'user'): ?>
                <div class="sidebar-chat-message sidebar-chat-message-outgoing">
                    <strong>Иван</strong>
                    <div><?= Html::encode($message->text) ?></div>
                </div>
            <?php endif; ?>
            <?php if ($message->role == 'assistant'): ?>
                <div class="sidebar-chat-message sidebar-chat-message-incoming">
                    <strong>ИИ-ассистент</strong>
                    <div><?= Html::encode($message->text) ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="sidebar-chat-empty-state">
            Здравствуйте, я ИИ-ассистент портала.<br>
            Чем могу вам помочь?
        </div>
    <?php endif; ?>
</div>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'sidebar-chat-form', 'id' => 'sidebar-chat-form'],
    'action' => Url::to(['/Qm/api/v1/ai-chat/execute'])
]); ?>
<?= $form->field($modelForm, 'text')->textarea(['rows' => 6])->label(false) ?>
<?php ActiveForm::end(); ?>
<div class="d-flex justify-content-between align-items-center gap-2 mt-2">
    <?= Html::submitButton(Icon::show('arrow-up'), ['class' => 'btn btn-primary', 'name' => 'contact-button', 'form' => 'sidebar-chat-form']) ?>
    <?php
    echo Html::beginForm(['/Qm/api/v1/ai-chat/delete'], 'post', ['style' => 'display: inline'])
        . Html::hiddenInput('user_id', 200)
        . Html::submitButton(Icon::show('trash'), [
            'class' => 'btn btn-secondary',
            'title' => Icon::show('trash') . 'Очистить чат',
            'encode' => false,
            'onclick' => "return confirm('Вы уверены, что хотите удалить эту запись?')",
        ])
        . Html::endForm();
    ?>
</div>