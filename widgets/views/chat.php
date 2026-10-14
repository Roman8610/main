<?php
/** @var app\models\ChatForm $modelForm */
/** @var array $messages */
?>
<?php use kartik\form\ActiveForm;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="sidebar-chat-dialog<?= $messages ? ' sidebar-chat-dialog-messages' : ' sidebar-chat-dialog-empty' ?>" aria-label="Пример диалога">
    <?php if($messages):?>
    <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Привет! Подскажите, во сколько начинается встреча?') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-outgoing">
        <strong>Иван</strong>
        <div><?= Html::encode('Здравствуйте! Начало в 15:00.') ?></div>
    </div>
    <?php else:?>
    <div class="sidebar-chat-empty-state">
        Здравствуйте, я ИИ-ассистент портала.<br>
        Чем могу вам помочь?
    </div>
    <?php endif;?>
</div>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'sidebar-chat-form'],
    'action' => Url::to(['/Qm/api/v1/ai-chat/execute'])
    ]);?>
<?= $form->field($modelForm, 'text')->textarea(['rows' => 6])->label(false) ?>
<?= Html::submitButton(Icon::show('arrow-up'), ['class' => 'btn btn-primary', 'name' => 'contact-button'])?>
<?php ActiveForm::end(); ?>