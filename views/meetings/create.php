<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Meetings $model */

$this->title = 'Create Meetings';
$this->params['breadcrumbs'][] = ['label' => 'Meetings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meetings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
