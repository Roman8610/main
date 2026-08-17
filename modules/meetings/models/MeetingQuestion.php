<?php

namespace app\modules\meetings\models;

use yii\db\ActiveRecord;
use Override;
use yii\db\ActiveQuery;

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

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_DRAFT    => 'Черновик',
            self::STATUS_PENDING  => 'На модерации',
            self::STATUS_PUBLISHED => 'Опубликован',
            self::STATUS_REJECTED  => 'Отклонен модератором',
            self::STATUS_REMOVED   => 'Снят с публикации',
        ];
    }

    public static function findByQuestions(int $meetingId): ActiveQuery
    {
        return self::find()->where(['meeting_id' => $meetingId]);
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'status' => 'Статус',
        ];
    }

    public function getCommentQuestions()
    {
        return $this->hasMany(CommentQuestions::class, ['question_id' => 'id']);
    }
}
