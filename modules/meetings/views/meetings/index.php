<?php
/** @var \yii\data\ActiveDataProvider $dataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
?>
<h1>Совещания</h1>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout'       => "{items}{pager}",
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => '#',
        ],
        [
            'attribute'=>'name',
            'header' => 'Название',
            'value' => function ($model) {
                return Html::a($model->name, ['meetings/view', 'id' => $model->id]);
            },
            'format' => 'html',
        ],
    ]
])  ?>