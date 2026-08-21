<?php
namespace app\modules\meetings\models;

use yii\db\ActiveRecord;

class Subsidiary extends ActiveRecord
{
    public static function tableName()
    {
        return 'subsidiary';
    }
}