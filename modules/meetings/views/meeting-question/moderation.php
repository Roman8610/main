<?php

/**
 * @var app\modules\meetings\models\MeetingQuestion $formModel
 */

use app\modules\meetings\assets\MeetingsAsset;
use kartik\icons\Icon;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;

MeetingsAsset::register($this);
?>

<h1>Модерация постановочного вопроса</h1>


<?php $form = ActiveForm::begin(); ?>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card card-body">
            <div class="row" id="departments-directions-container">
                <div class=" col-md-12 departments-directions-row">
                    <div class="row">
                        <div class="col-md-5 department-input">
                            <?= $form->field($formModel, 'departments[]', ['template' => "{label}\n<span class=\"required\" style=\"color: red;\">*</span>\n{input}\n{error}"])->textInput(); ?>
                        </div>
                        <div class="col-md-5 direction-input">
                            <?= $form->field($formModel, 'directions[]', ['template' => "{label}\n<span class=\"required\" style=\"color: red;\">*</span>\n{input}\n{error}"])->textInput(); ?>
                        </div>
                        <div class="col-md-2" style="padding-top: 25px;">
                            <?= Html::a(Icon::show('minus'), '#', ['class' => 'btn btn-danger remove-row-btn', 'style' => 'display:none;']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <?= Html::a('Добавить', '#', ['class' => 'btn btn-outline-secondary btn-sm', 'id' => 'add-row-btn']); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>