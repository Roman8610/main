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

    public function getDepartment(){
        $this->hasOne(Departments::class, ['id' => 'departments_id']);
    }
}