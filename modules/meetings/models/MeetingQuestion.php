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

    #[Override]
    public function rules()
    {
        return [
            [['question_text'], 'required'],
        ];
    }

    #[Override]
    public function attributeLabels()
    {
        return [
            'question_text' => 'Постановочный вопрос',
        ];
    }

    public function getCommentQuestions(){
        return $this->hasMany(CommentQuestions::class, ['question_id' => 'id']);
    }
}