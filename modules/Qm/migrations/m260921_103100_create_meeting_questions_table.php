<?php

use yii\db\Migration;

class m260921_103100_create_meeting_questions_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%meeting_questions}}', [
            'id' => $this->primaryKey()->unsigned(),
            'meeting_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(255)->notNull(),
            'question_text' => $this->text()->notNull(),
            'decision' => $this->text(),
            'comment' => $this->text(),
            'deadline' => $this->date(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->unsigned(),
            'comment_moderator' => $this->string(255),
            'directions' => $this->string(500),
            'status' => $this->string(255)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%meeting_questions}}');
    }
}