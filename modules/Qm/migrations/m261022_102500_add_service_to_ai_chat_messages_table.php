<?php

use yii\db\Migration;

class m261022_102500_add_service_to_ai_chat_messages_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            '{{%ai_chat_messages}}',
            'service',
            $this->string(255)->null()->defaultValue(null)
        );
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ai_chat_messages}}', 'service');
    }
}
