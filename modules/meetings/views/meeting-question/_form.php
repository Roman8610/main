<?php

/**
 * @var app\modules\meetings\models\MeetingQuestion $formModel
 * @var array $subsidiary
 */

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

$form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($formModel, 'name')->textInput(['maxlength' => true]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($formModel, 'question_text')->textarea(['rows' => 6]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 subsidary-input">
        <?= $form->field($formModel, 'recipients')->widget(Select2::class, [
            'data' => $subsidiary,
            'options' => [
                'placeholder' => 'Выберите адресатов...',
                'multiple' => true, // Включаем множественный выбор
            ],
            'pluginOptions' => [
                'allowClear' => true // Возможность очистить выбор
            ],
        ]); ?>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <?= $form->field($formModel, 'deadline')->input('date', ['class' => 'form-control']) ?>
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
                                <?= $form->field($formModel, 'decision')->textarea(['rows' => 6])->label(false); ?>
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
                                <?= $form->field($formModel, 'comment')->textarea(['rows' => 6])->label(false); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-1">
        <?= Html::submitButton('Сохранить черновик', [
            'class' => 'btn btn-primary',
            'style' => 'margin-top: 10px;',
            'name'  => 'scenario',
            'value' => 'save_draft',
        ]); ?>
    </div>
    <div class="col-md-1">
        <?= Html::submitButton('Отправить на модерацию', [
            'class' => 'btn btn-primary',
            'style' => 'margin-top: 10px; margin-left: 10px;',
            'name'  => 'scenario',
            'value' => 'submit_pending',
        ]); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>