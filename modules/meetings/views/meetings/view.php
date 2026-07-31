<?php

/**
 * @var app\modules\meetings\models\Meeting $meeting 
 * @var yii\data\ActiveDataProvider $dataProviderQuestion 
 */

use kartik\icons\Icon;
use yii\grid\GridView;
use yii\helpers\Html;
?>

<h1><?= $meeting->name ?></h1>
<h2>Постановочные вопросы</h2>
<?= GridView::widget([
    'dataProvider' => $dataProviderQuestion,
    'layout'       => "{items}{pager}",
    'emptyText'    => 'Постановочных вопросов нет',
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => '#',
        ],
        [
            'attribute' => 'question_text',
            'header' => 'Постановочный вопрос',
            'value' => function ($model) {
                return Html::a($model->question_text, ['meeting-question/view', 'id' => $model->id]);
            },
            'format' => 'html',
        ],
        [
            'label' => Icon::show('comment') . 'Комментарии',
            'value' => function ($model) {
                return '3 / 10';
            },
            'encodeLabel' => false,
            'format' => 'html',
        ],
        [
            'label' => 'Статус',
        ],
    ],
]) ?>
<?= Html::a('Добавить вопрос', ['meeting-question/create', 'id' => $meeting->id], ['class' => 'btn btn-success']) ?>