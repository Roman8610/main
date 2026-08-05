<?php
namespace app\modules\meetings\models;

use Override;
use yii\db\ActiveRecord;

class MeetingQuestion extends ActiveRecord
{
    // Статусы постановочных вопросов
    const STATUS_DRAFT = 'draft'; // черновик
    const STATUS_PENDING = 'pending'; // На модерации
    const STATUS_PUBLISHED = 'published'; // Опубликован
    const STATUS_REJECTED = 'rejected'; // Отклонен 
    // Константы для сценариев
    const SCENARIO_CREATE = 'create';
    const SCENARIO_SUBMIT_FOR_REVIEW = 'submit_for_review';
    
    
    public static function tableName()
    {
        return 'meeting_questions';
    }

    public $departments;
    public $directions;
    public $senders;

    #[Override]
    public function rules()
    {
        return [
            [['question_text', 'name'], 'required'],
            [['question_text', 'name', 'decision', 'commet'], 'string'],
            [['deadline'], 'date'],
            [['departments', 'directions'], 'safe'],
        ];
    }

    #[Override]
    public function attributeLabels()
    {
        return [
            'recipient_id' => 'Выберите адресатов вопроса', // Кому адресован постановочный вопрос
            'sender_id' => 'Кто создал постановочный вопрос',
            'name' => 'Название постановочного вопроса',
            'question_text' => 'Постановочный вопрос',
            'departments' => 'Отдел',
            'directions' => 'Направление',
            'decision' => 'Предполагаемое решение', 
            'commet' => 'Комментарий',
            'deadline' => 'Предлагаемый cрок выполнения',
        ];
    }

    public function getCommentQuestions(){
        return $this->hasMany(CommentQuestions::class, ['question_id' => 'id']);
    }
}