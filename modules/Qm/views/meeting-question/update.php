<?php

/**
 * @var app\modules\Qm\models\MeetingQuestion $formModel
 * @var array $subsidiary
 */

use app\modules\Qm\assets\MeetingsAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;

MeetingsAsset::register($this);
?>

<h1>Редактирование постановочного вопроса</h1>

<?= $this->render('_form', [
    'formModel' => $formModel,
    'subsidiary' => $subsidiary,
]); ?>