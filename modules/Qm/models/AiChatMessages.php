<?php
namespace app\modules\Qm\models;

use Override;
use yii\db\ActiveRecord;

class AiChatMessages extends ActiveRecord{

    #[Override]
    public static function tableName()
    {
        return 'ai_chat_messages';
    }

}