<?php

use yii\db\Migration;

class m261015_153331_add_action_and_params_to_ai_chat_messages_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%ai_chat_messages}}', 'action', $this->string(255));
        $this->addColumn('{{%ai_chat_messages}}', 'params', $this->string(255));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ai_chat_messages}}', 'params');
        $this->dropColumn('{{%ai_chat_messages}}', 'action');
    }
}
