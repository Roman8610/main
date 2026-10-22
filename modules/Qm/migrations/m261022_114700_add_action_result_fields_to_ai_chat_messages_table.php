<?php

use yii\db\Migration;

class m261022_114700_add_action_result_fields_to_ai_chat_messages_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%ai_chat_messages}}', 'action_success', $this->boolean()->null());
        $this->addColumn('{{%ai_chat_messages}}', 'action_message', $this->text()->null());
        $this->addColumn('{{%ai_chat_messages}}', 'action_data', $this->text()->null());
        $this->addColumn('{{%ai_chat_messages}}', 'action_error_code', $this->string(255)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ai_chat_messages}}', 'action_error_code');
        $this->dropColumn('{{%ai_chat_messages}}', 'action_data');
        $this->dropColumn('{{%ai_chat_messages}}', 'action_message');
        $this->dropColumn('{{%ai_chat_messages}}', 'action_success');
    }
}
