<?php

namespace app\modules\meetings\services;

use app\modules\meetings\forms\CreateMeetingQuestionForm;
use app\modules\meetings\models\MeetingQuestion;
use app\modules\meetings\models\RecipientsQuestions;
use Yii;

class CreateDraftMeetingQuestionService
{

    public function run(CreateMeetingQuestionForm $formModel): MeetingQuestion
    {
        // Проверки прав и контекста
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canCreate($formModel->meeting_id, $formModel->user_id)) {
            throw new \yii\web\ForbiddenHttpException('У вас нет прав для создания постановочного вопроса');
        }

        // Создаём модель вопроса
        $question = new MeetingQuestion();

        $question->meeting_id = $formModel->meeting_id; // ID совещания
        $question->name; // Название вопроса
        $question->question_text = $formModel->question_text; // Текст вопроса
        $question->decision; // Предлагаемое решение вопроса
        $question->commet; // Комментарий 
        $question->deadline; // Срок выполнения
        $question->created_at; // Дата создания
        $question->updated_at; // Дата последнего обновления
        $question->created_by = $formModel->user_id; // Создатель
        $question->updated_by = $formModel->user_id; // кто внес последние изменения
        $question->status; // статус

        // Сохраняем получателей вопроса 
        
        $recipients = new RecipientsQuestions();


        // $question->status = MeetingQuestion::STATUS_DRAFT;

        // if (!$question->validate('create_draft')) {
        //     throw new ValidationException($question->getErrors());
        // }

        // return $question->save(false) ? $question : throw new RuntimeException('Ошибка сохранения');



        return new MeetingQuestion();
    }
    /**
     * Сохранение вопроса
     */
    private function saveQuestion() {}
    /**
     * Сохранение получателей вопроса
     */
    private function saveRecipient() {}
     /**
     * Сохранение отделов
     */
    private function saveDepartment(){}
    /**
     * Сохранение направлений
     */
    private function saveDirection(){}
}
