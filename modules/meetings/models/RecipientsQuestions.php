<?php

namespace app\modules\meetings\models;

use yii\db\ActiveRecord;

class RecipientsQuestions extends ActiveRecord
{
    public static function tableName()
    {
        return 'recipients_questions';
    }

    public function getSubsidiary()
    {
        return $this->hasOne(Subsidiary::class, ['id' => 'subsidiary_id']);
    }
}
