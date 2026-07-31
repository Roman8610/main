<?php

namespace app\modules\meetings\models;

use Override;

class CommentQuestions extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'comment_questions';
    }

    #[Override]
    public function attributeLabels()
    {
        return [
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
            'text' => 'Комментарий',
        ];
    }
}
