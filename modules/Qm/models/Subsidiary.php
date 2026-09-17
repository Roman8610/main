<?php
namespace app\modules\Qm\models;

use yii\db\ActiveRecord;

class Subsidiary extends ActiveRecord
{
    public static function tableName()
    {
        return 'subsidiary';
    }
}