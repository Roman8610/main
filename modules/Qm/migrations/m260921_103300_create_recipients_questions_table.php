<?php

use yii\db\Migration;

class m260921_103300_create_recipients_questions_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%recipients_questions}}', [
            'id' => $this->primaryKey()->unsigned(),
            'question_id' => $this->integer()->unsigned()->notNull(),
            'subsidiary_id' => $this->integer()->unsigned()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%recipients_questions}}');
    }
}