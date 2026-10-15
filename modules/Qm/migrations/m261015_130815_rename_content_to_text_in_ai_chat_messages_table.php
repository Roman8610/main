<?php

use yii\db\Migration;

class m261015_130815_rename_content_to_text_in_ai_chat_messages_table extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('{{%ai_chat_messages}}', 'content', 'text');
    }

    public function safeDown()
    {
        $this->renameColumn('{{%ai_chat_messages}}', 'text', 'content');
    }
}
