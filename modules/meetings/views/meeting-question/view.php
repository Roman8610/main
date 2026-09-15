<?php

/**
 * @var app\modules\meetings\models\MeetingQuestion $question
 */

use app\modules\meetings\assets\MeetingsAsset;
use app\modules\meetings\models\MeetingQuestion;
use app\modules\meetings\widgets\CommentsWidget;
use yii\helpers\Html;

$this->title = 'Просмотр вопроса';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/**
 * Пример данных — замените на реальные из модели
 */
$metaData = [
    'created_at'  => '25.07.2025, 14:30',
    'department'  => 'Отдел разработки',
    'author'      => 'Иванов И.И.',
    'manager'     => 'Петров П.П.',
];

MeetingsAsset::register($this);
?>

<!-- Контент вопроса -->
<div class="question-content">
    <?php
    $labels = MeetingQuestion::getStatusLabels();
    $classMap = [
        MeetingQuestion::STATUS_DRAFT    => 'text-secondary',
        MeetingQuestion::STATUS_PENDING  => 'text-warning',
        MeetingQuestion::STATUS_PUBLISHED => 'text-success',
        MeetingQuestion::STATUS_REJECTED  => 'badge text-bg-danger',
        MeetingQuestion::STATUS_REMOVED   => 'text-muted',
    ];
    $label = isset($labels[$question->status]) && isset($classMap[$question->status]) ? $labels[$question->status] : 'Ошибка статуса!!!';
    $css = isset($labels[$question->status]) && isset($classMap[$question->status])  ? $classMap[$question->status] : 'badge bg-danger';
    //  echo Html::tag('span', $label, ['class' => $css]);
    ?>
    <div class="question-meta-panel">
        <div class="panel-header">
            <h1><?= $question->name ?></h1>
            <div>
                <a href="<?= \yii\helpers\Url::to(['update', 'id' => $question->id]) ?>" class="btn btn-edit">Редактировать</a>
                <a href="<?= \yii\helpers\Url::to(['delete', 'id' => $question->id]) ?>"
                    class="btn btn-delete"
                    onclick="return confirm('Вы уверены, что хотите удалить этот вопрос?')">Удалить</a>
            </div>
        </div>
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
                <td>Статус</td>
                <td><?= Html::tag('span', $label, ['class' => $css]) ?></td>
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
    <?php if($question->status == MeetingQuestion::STATUS_REJECTED):?>
    <div class="alert alert-danger" role="alert">
        <?=$question->comment_moderator?>
    </div>
    <?php endif?>
    <?= CommentsWidget::widget([
        'question_id' => $question->id,
    ]) ?>