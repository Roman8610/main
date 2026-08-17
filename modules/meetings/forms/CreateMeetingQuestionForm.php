<?php
namespace app\modules\meetings\forms;

use Override;

/**
 * Принимает данные для создания черновика постновочного вопроса
 * Валедирует данные
 * Используется для создания формы ActiveForm
 */

class CreateMeetingQuestionForm extends \yii\base\Model
{
    public $meeting_id;
    public $user_id;
    public $name;
    public $question_text;
    public $recipients = []; // список ДО, кому адресован вопрос

    // Опциональные поля
    public $comment;
    public $deadline;
    public $decision;

    // флаг: сохранить как черновик или сразу на модерацию
    public $scenario;


    #[Override]
    public function rules()
    {
        return [
            [['question_text', 'name', 'recipients'], 'required'],
            [['question_text', 'name', 'decision', 'comment'], 'string'],
            [['deadline'], 'date', 'format' => 'yyyy-MM-dd'],
            [['scenario'], 'string'],
            [['recipients'], 'each', 'rule' => ['integer']],
        ];
    }

    #[Override]
    public function attributeLabels()
    {
        return [
            'recipients' => 'Выберите адресатов вопроса', // Кому адресован постановочный вопрос
            'name' => 'Название постановочного вопроса',
            'question_text' => 'Постановочный вопрос',
            'decision' => 'Предполагаемое решение', 
            'comment' => 'Комментарий',
            'deadline' => 'Предлагаемый cрок выполнения',
        ];
    }

}