<?php

use yii\db\Migration;

class m261012_133032_create_ai_chat_messages_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%ai_chat_messages}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'role' => $this->string(20)->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('{{%ai_chat_messages}}');
    }
}
