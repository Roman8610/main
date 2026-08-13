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
    const STATUS_REJECTED = 'rejected'; // Отклонен модератором
    const STATUS_REMOVED = 'removed'; // Снят с публикаци

    
    public static function tableName()
    {
        return 'meeting_questions';
    }

    public function getCommentQuestions(){
        return $this->hasMany(CommentQuestions::class, ['question_id' => 'id']);
    }
}