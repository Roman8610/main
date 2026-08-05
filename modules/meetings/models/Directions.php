<?php

namespace app\modules\meetings\models;

use yii\db\ActiveRecord;

class Directions extends ActiveRecord{
    public static function tableName(){
        return 'directions';
    }
}