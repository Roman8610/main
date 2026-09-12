<?php
namespace app\modules\meetings\models;

use Override;
use yii\db\ActiveRecord;

class DepartmentsQuestions extends ActiveRecord
{
    #[Override]
    public static function tableName()
    {
        return 'departments_questions';
    }
}