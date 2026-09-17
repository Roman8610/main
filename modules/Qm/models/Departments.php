<?php
namespace app\modules\Qm\models;

use yii\db\ActiveRecord;

class Departments extends ActiveRecord
{
    public static function tableName(){
        return 'departments';
    }
}