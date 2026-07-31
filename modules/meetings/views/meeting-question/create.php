<?php
/**
 * @var app\modules\meetings\models\MeetingQuestion $modelForm
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin();

echo $form->field($modelForm, 'question_text')->textInput(['maxlength' => true]);

echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']);

ActiveForm::end();
?>