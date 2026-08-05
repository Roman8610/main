<?php
namespace app\modules\meetings\models;

use yii\db\ActiveRecord;

class Departments extends ActiveRecord
{
    public static function tableName(){
        return 'departments';
    }
}