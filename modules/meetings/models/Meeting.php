<?php
namespace app\modules\meetings\models;

use Override;
use yii\db\ActiveRecord;

class Meeting extends ActiveRecord
{   
    public static function tableName()
    {
        return 'meetings';
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'name' => 'Тема совещания'
        ];
    }
}