<?php

namespace app\modules\meetings\models;

use yii\db\ActiveRecord;

class RecipientsQuestions extends ActiveRecord
{
    public static function tableName()
    {
        return 'recipients_questions';
    }
}
