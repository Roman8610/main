<?php

/**
 * @var app\modules\meetings\models\Meeting $meeting 
 * @var yii\data\ActiveDataProvider $dataProviderQuestion 
 */

use app\modules\meetings\models\MeetingQuestion;
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
            'attribute' => 'name',
            'header' => 'Название',
            'value' => function ($model) {
                return Html::a($model->name, ['meeting-question/view', 'id' => $model->id]);
            },
            'format' => 'html',
        ],
        [
            'label' => Icon::show('comment') . 'Ответ',
            'value' => function ($model) {
                return 'Есть';
            },
            'encodeLabel' => false,
            'format' => 'html',
        ],
        [
            'label' => 'Отправитель вопроса',
        ],
        [
            'label' => 'Получатель вопроса',
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                $labels = MeetingQuestion::getStatusLabels();
                $classMap = [
                    MeetingQuestion::STATUS_DRAFT    => 'text-secondary',
                    MeetingQuestion::STATUS_PENDING  => 'text-warning',
                    MeetingQuestion::STATUS_PUBLISHED => 'text-success',
                    MeetingQuestion::STATUS_REJECTED  => 'text-danger',
                    MeetingQuestion::STATUS_REMOVED   => 'text-muted',
                ];
                $label = isset($labels[$model->status]) && isset($classMap[$model->status]) ? $labels[$model->status] : 'Ошибка статуса!!!';
                $css = isset($labels[$model->status]) && isset($classMap[$model->status])  ? $classMap[$model->status] : 'badge bg-danger';
                return Html::tag('span', $label, ['class' => $css]);
            },
            'format' => 'html',
        ],
        [
            'class'      => 'yii\grid\ActionColumn',
            'template'   => '{view}{update}{delete}{moderate}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    if (Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canView($model->id, 1)) {
                        return Html::a(Icon::show('eye'), ['meeting-question/view', 'id' => $model->id], [
                            'class' => '',
                            'title' => 'Просмотр',
                        ]);
                    }
                    return '<span class="text-muted">' . Icon::show('eye') . '</span>';
                },
                'update' =>  function ($url, $model, $key) {
                    if (Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canUpdate($model->id, 1)) {
                        return Html::a(Icon::show('pencil'), ['meeting-question/update', 'id' => $model->id], [
                            'class' => '',
                            'title' => 'Редактирование',
                        ]);
                    }
                    return '<span class="text-muted">' . Icon::show('pencil') . '</span>';
                },
                'delete' =>  function ($url, $model, $key) {
                    if (Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canDelete($model->id, 1)) {
                        return Html::a(Icon::show('trash'), ['meeting-question/delete', 'id' => $model->id], [
                            'class' => '',
                            'title' => 'Удаление',
                            'data-confirm' => 'Вы уверены, что хотите удалить эту запись?',
                            'data-method' => 'post',
                        ]);
                    }
                    return '<span class="text-muted">' . Icon::show('trash') . '</span>';
                },
                'moderate' =>  function ($url, $model, $key) {
                    if (Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canMakeModeration($model->id, 1)) {
                        return Html::a(Icon::show('triangle-exclamation'), ['meeting-question/moderation', 'id' => $model->id], [
                            'class' => 'text-danger',
                            'title' => 'Вопрос ожидает Вашей модерации',
                        ]);
                    }
                },
            ],
        ],
    ],
]) ?>
<?= Html::a('Добавить вопрос', ['meeting-question/create', 'id' => $meeting->id], ['class' => 'btn btn-success']) ?>