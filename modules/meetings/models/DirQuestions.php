<?php

namespace app\modules\meetings\models;

use yii\db\ActiveRecord;

class DirQuestions extends ActiveRecord
{
    public static function tableName()
    {
        return 'dir_questions';
    }
}
