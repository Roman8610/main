<?php

namespace app\modules\Qm\forms;

use app\modules\Qm\models\MeetingQuestion;
use Override;

/**
 * Данные формы создания и редактирования постановочного вопроса.
 *
 * Используется для валидации ActiveForm и передачи данных в сервисы
 * сохранения черновика или отправки вопроса на модерацию.
 */

class MeetingQuestionForm extends \yii\base\Model
{
    public $id;
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

    /**
     * Заполняет форму данными существующего вопроса.
     *
     * @param MeetingQuestion $question Вопрос для редактирования.
     */
    public function loadFromQuestion(MeetingQuestion $question): void
    {
        $this->setAttributes($question->attributes);

        $this->recipients = $question->getRecipients()
            ->select(['subsidiary_id'])
            ->column();
    }
}
