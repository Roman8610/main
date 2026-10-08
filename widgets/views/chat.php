<?php
/** @var app\models\ChatForm $modelForm */
?>
<?php use kartik\form\ActiveForm;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="sidebar-chat-dialog" aria-label="Пример диалога">
    <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Привет! Подскажите, во сколько начинается встреча?') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-outgoing">
        <strong>Иван</strong>
        <div><?= Html::encode('Здравствуйте! Начало в 15:00.') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Спасибо, буду вовремя!') ?></div>
    </div>
        <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Привет! Подскажите, во сколько начинается встреча?') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-outgoing">
        <strong>Иван</strong>
        <div><?= Html::encode('Здравствуйте! Начало в 15:00.') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Спасибо, буду вовремя!') ?></div>
    </div>
        <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Привет! Подскажите, во сколько начинается встреча?') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-outgoing">
        <strong>Иван</strong>
        <div><?= Html::encode('Здравствуйте! Начало в 15:00.') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Спасибо, буду вовремя!') ?></div>
    </div>
        <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Привет! Подскажите, во сколько начинается встреча?') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-outgoing">
        <strong>Иван</strong>
        <div><?= Html::encode('Здравствуйте! Начало в 15:00.') ?></div>
    </div>
    <div class="sidebar-chat-message sidebar-chat-message-incoming">
        <strong>Портал</strong>
        <div><?= Html::encode('Спасибо, буду вовремя!') ?></div>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'sidebar-chat-form'],
    'action' => Url::to(['/Qm/api/v1/ai-chat/execute'])
    ]);?>
<?= $form->field($modelForm, 'text')->textarea(['rows' => 6])->label(false) ?>
<?= Html::submitButton(Icon::show('arrow-up'), ['class' => 'btn btn-primary', 'name' => 'contact-button'])?>
<?php ActiveForm::end(); ?>