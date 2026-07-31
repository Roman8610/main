<?php

/**
 * @var app\modules\meetings\models\MeetingQuestion $question
 */

use app\modules\meetings\widgets\CommentsWidget;
use yii\web\View;

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
?>

<style>
    /* Панель мета-данных */
    .question-meta-panel {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 24px;
        position: relative;
    }
    .question-meta-panel .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }
    .question-meta-panel .panel-header h3 {
        margin: 0;
        font-size: 16px;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .meta-table {
        width: 100%;
        border-collapse: collapse;
    }
    .meta-table td {
        padding: 8px 12px;
        border: 1px solid #e0e0e0;
        vertical-align: top;
    }
    .meta-table td:first-child {
        width: 200px;
        background: #f1f3f5;
        font-weight: 600;
        color: #495057;
    }

    /* Контент вопроса */
    .question-content {
        margin-bottom: 30px;
        line-height: 1.7;
    }
    .question-content h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #212529;
    }
    .question-content h2 {
        font-size: 20px;
        margin-top: 24px;
        margin-bottom: 12px;
        color: #343a40;
    }
    .question-content p {
        margin-bottom: 14px;
        color: #495057;
    }
    .question-content ul {
        margin-bottom: 16px;
        padding-left: 24px;
    }
    .question-content li {
        margin-bottom: 6px;
        color: #495057;
    }

    /* Таблица с данными */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 14px;
    }
    .data-table thead th {
        background: #e9ecef;
        color: #343a40;
        font-weight: 600;
        padding: 10px 14px;
        text-align: left;
        border: 1px solid #dee2e6;
    }
    .data-table tbody td {
        padding: 10px 14px;
        border: 1px solid #dee2e6;
        color: #495057;
    }
    .data-table tbody tr:nth-child(even) {
        background: #f8f9fa;
    }
    .data-table tbody tr:hover {
        background: #e9ecef;
    }

    /* Разделитель между вопросом и комментариями */
    .comments-section {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid #dee2e6;
    }

    /* Кнопки управления */
    .btn {
        display: inline-block;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 4px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: background-color 0.2s, border-color 0.2s;
    }
    .btn-edit {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
    }
    .btn-edit:hover {
        background: #0056b3;
        border-color: #0056b3;
    }
    .btn-delete {
        background: #dc3545;
        color: #fff;
        border-color: #dc3545;
    }
    .btn-delete:hover {
        background: #a71d2a;
        border-color: #a71d2a;
    }
</style>



<!-- Контент вопроса -->
<div class="question-content">
    <div class="question-meta-panel">
        <div class="panel-header">
            <h1><?= $question->question_text ?></h1>
            <div>
                <a href="<?= \yii\helpers\Url::to(['update', 'id' => $question->id]) ?>" class="btn btn-edit">Редактировать</a>
                <a href="<?= \yii\helpers\Url::to(['delete', 'id' => $question->id]) ?>" 
                   class="btn btn-delete" 
                   onclick="return confirm('Вы уверены, что хотите удалить этот вопрос?')">Удалить</a>
            </div>
        </div>
    <table class="meta-table">
        <tr>
            <td>Дата создания</td>
            <td><?= htmlspecialchars($metaData['created_at']) ?></td>
        </tr>
        <tr>
            <td>Подразделение</td>
            <td><?= htmlspecialchars($metaData['department']) ?></td>
        </tr>
        <tr>
            <td>Автор</td>
            <td><?= htmlspecialchars($metaData['author']) ?></td>
        </tr>
        <tr>
            <td>Руководитель</td>
            <td><?= htmlspecialchars($metaData['manager']) ?></td>
        </tr>
    </table>
</div>

    <h2>Подзаголовок</h2>

    <p>
        Коллеги, прошу внимательно ознакомиться с <strong>ключевыми показателями</strong>
        за третий квартал и подготовиться к обсуждению стратегических целей на четвёртый.
        Основные направления работы включают:
    </p>

    <ul>
        <li>Анализ выполнения KPI по отделам продаж и маркетинга</li>
        <li>Обзор продуктовой линейки и приоритетные задачи разработки</li>
        <li>Бюджетирование и распределение ресурсов на следующий квартал</li>
        <li>Кадровые вопросы: планирование найма и обучение персонала</li>
    </ul>

    <p>
        Ниже представлены <em>сводные данные</em> по основным направлениям:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th>Направление</th>
                <th>План</th>
                <th>Факт</th>
                <th>Выполнение</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Продажи</td>
                <td>12 000 000 ₽</td>
                <td>11 400 000 ₽</td>
                <td>95%</td>
            </tr>
            <tr>
                <td>Маркетинг</td>
                <td>850 лидов</td>
                <td>920 лидов</td>
                <td>108%</td>
            </tr>
            <tr>
                <td>Разработка</td>
                <td>12 спринтов</td>
                <td>11 спринтов</td>
                <td>92%</td>
            </tr>
        </tbody>
    </table>

    <p>
        Прошу каждого <strong>подготовить краткий отчёт</strong> по своему направлению
        <em>за 3 дня до встречи</em>. Вопросы, требующие отдельного обсуждения,
        можно оставить в комментариях к этому вопросу.
    </p>
</div>

<?= CommentsWidget::widget([
    'question_id' => $question->id,
]) ?>