<?php

/**
 * @var app\modules\meetings\models\MeetingQuestion $modelForm
 */

use app\modules\meetings\assets\MeetingsAsset;
use kartik\icons\Icon;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;

MeetingsAsset::register($this);
?>

<h1>Создание постановочного вопроса</h1>


<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($modelForm, 'name', ['template' => "{label}\n<span class=\"required\" style=\"color: red;\">*</span>\n{input}\n{error}"])->textInput(['maxlength' => true]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($modelForm, 'question_text', ['template' => "{label}\n<span class=\"required\" style=\"color: red;\">*</span>\n{input}\n{error}"])->textarea(['rows' => 6]); ?>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card card-body">
            <div class="row" id="departments-directions-container">
                <div class=" col-md-12 departments-directions-row">
                    <div class="row">
                        <div class="col-md-3 subsidary-input">
                            <?php
                            // echo $form->field($modelForm, 'senders[]', ['template' => "{label}\n<span class=\"required\" style=\"color: red;\">*</span>\n{input}\n{error}"])
                            // ->dropDownList(
                            //     [
                            //         'data' => [
                            //             '1' => 'ГД Астрахань',
                            //             '2' => 'ГД Иркутск',
                            //             '3' => 'ГД Краснодар',
                            //         ],
                            //         'options' => [
                            //             'placeholder' => 'Выберите адресатов...',
                            //             'multiple' => true, // Включаем множественный выбор
                            //         ],
                            //         'pluginOptions' => [
                            //             'allowClear' => true // Возможность очистить выбор
                            //         ],
                            //     ],
                            //     ['class' => 'form-control']
                            // )
                            //->label('Кому'); 
                            ?>
                            <?= $form->field($modelForm, 'senders[]')->widget(Select2::class, [
                                'data' => [
                                    '1' => 'ГД Астрахань',
                                    '2' => 'ГД Иркутск',
                                    '3' => 'ГД Краснодар',
                                    // Можно подставить массив из БД:
                                    // \app\modules\meetings\models\Sender::find()->select(['id', 'name'])->indexBy('id')->column(),
                                ],
                                'options' => [
                                    'placeholder' => 'Выберите адресатов...',
                                    'multiple' => true, // Включаем множественный выбор
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true // Возможность очистить выбор
                                ],
                            ]); ?>

                        </div>
                        <div class="col-md-3 department-input">
                            <?= $form->field($modelForm, 'departments[]', ['template' => "{label}\n<span class=\"required\" style=\"color: red;\">*</span>\n{input}\n{error}"])->textInput(); ?>
                        </div>
                        <div class="col-md-3 direction-input">
                            <?= $form->field($modelForm, 'directions[]', ['template' => "{label}\n<span class=\"required\" style=\"color: red;\">*</span>\n{input}\n{error}"])->textInput(); ?>
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
<div class="row mt-3">
    <div class="col-md-12">
        <?= $form->field($modelForm, 'deadline')->input('date', ['class' => 'form-control']) ?>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="accordion" id="solutionAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSolution" aria-expanded="false" aria-controls="collapseSolution">
                        Предполагаемое решение
                    </button>
                </h2>
                <div id="collapseSolution" class="accordion-collapse collapse" data-bs-parent="#solutionAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($modelForm, 'decision')->textarea(['rows' => 6])->label(false); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="accordion" id="solutionAccordion1">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSolution1" aria-expanded="false" aria-controls="collapseSolution1">
                        Комментарий
                    </button>
                </h2>
                <div id="collapseSolution1" class="accordion-collapse collapse" data-bs-parent="#solutionAccordion1">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($modelForm, 'commet')->textarea(['rows' => 6])->label(false); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'style' => 'margin-top: 10px;']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>