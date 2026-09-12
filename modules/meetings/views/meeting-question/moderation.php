<?php

/**
 * @var app\modules\meetings\forms\PublishedMeetingQuestionModerationForm $formModelPublish
 * @var app\modules\meetings\forms\RejectMeetingQuestionModerationForm $formModelReject
 * @var app\modules\meetings\models\MeetingQuestion $question
 */

use app\modules\meetings\assets\MeetingsAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;

MeetingsAsset::register($this);
?>

<h1>Модерация постановочного вопроса</h1>

<div class="question-meta-panel">
    <table class="meta-table">
        <tr>
            <td>Совещание</td>
            <td><?= $question->meeting_id ?></td>
        </tr>
        <tr>
            <td>Автор вопроса</td>
            <td><?= $question->created_by ?></td>
        </tr>
        <tr>
            <td>Название постановочного вопроса</td>
            <td><?= $question->name ?></td>
        </tr>
        <tr>
            <td>Текст постановочного вопроса</td>
            <td><?= $question->question_text ?></td>
        </tr>
        <tr>
            <td>Предлагаемое решение</td>
            <td><?= $question->decision ?></td>
        </tr>
        <tr>
            <td>Комментарий автора</td>
            <td><?= $question->comment ?></td>
        </tr>
        <tr>
            <td>Предполагаемая дата выпалнения</td>
            <td><?= $question->deadline ?></td>
        </tr>
        <tr>
            <td>Дата создания вопроса</td>
            <td><?= $question->created_at ?></td>
        </tr>
        <tr>
            <td>Дата постледенего обновления</td>
            <td><?= $question->updated_at ?></td>
        </tr>
        <tr>
            <td>Последнее изменение выполнил</td>
            <td><?= $question->updated_by ?></td>
        </tr>
    </table>
</div>


<?php $form = ActiveForm::begin([
    'id' => 'publish-form',
    'action' => ['publish', 'id' => $question->id],
]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body">
            <div class="row" id="departments-directions-container">
                <div class=" col-md-12 departments-directions-row">
                    <div class="row">
                        <div class="col-md-6 department-input">
                            <?= $form->field($formModelPublish, 'departments')->widget(Select2::class, [
                                'data' => [
                                    1 => 'Отдел 1',
                                    2 => 'Отдел 2',
                                    3 => 'Отдел 3',
                                    4 => 'Отдел 4',
                                    5 => 'Отдел 5',
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
                        <div class="col-md-6 direction-input">
                            <?= $form->field($formModelPublish, 'directions')->textInput(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $form->field($formModelPublish, 'question_id')->hiddenInput(['value' => $question->id])->label(false); ?>
<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-auto">
        <?= Html::submitButton('Опубликовать', [
            'class' => 'btn btn-success',
            'style' => 'margin-top: 10px;',
            'form' => 'publish-form',
        ]); ?>
    </div>
    <div class="col-auto">
        <?= Html::button('Отклонить', [
            'class' => 'btn btn-danger',
            'style' => 'margin-top: 10px;',
            'data-bs-toggle'  => 'modal',
            'data-bs-target' => '#rejectModal',
        ]); ?>
    </div>
</div>

<style>
    #rejectModal.show {
        display: block;
        opacity: 1;
    }

    #rejectModal.show .modal-dialog {
        transform: none;
    }
</style>
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Укажите причину отклонения</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['reject', 'id' => $question->id],
                ]); ?>
                <?= $form->field($formModelReject, 'comment_moderator')->textarea(['rows' => 6]); ?>
                <?= $form->field($formModelReject, 'question_id')->hiddenInput(['value' => $question->id])->label(false); ?>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Отклонить', [
                    'class' => 'btn btn-danger',
                ]); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>