<?php
namespace app\modules\meetings\models;

use yii\db\ActiveRecord;

class DepQuestions extends ActiveRecord
{
    public static function tableName(){
        return 'dep_questions';
    }
}