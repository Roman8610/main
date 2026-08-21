<?php

/**
 * @var app\modules\meetings\models\MeetingQuestion $formModel
 * @var array $subsidiary
 */

use app\modules\meetings\assets\MeetingsAsset;
use kartik\icons\Icon;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;

MeetingsAsset::register($this);
?>

<h1>Создание постановочного вопроса</h1>

<?= $this->render('_form', [
    'formModel' => $formModel,
    'subsidiary' => $subsidiary,
]); ?>
