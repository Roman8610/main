<?php

use yii\db\Migration;

class m260921_095100_create_comment_questions_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%comment_questions}}', [
            'id' => $this->primaryKey()->unsigned(),
            'parent_id' => $this->integer()->unsigned(),
            'question_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'text' => $this->text()->notNull(),
        ]);

        $this->createIndex(
            'idx-comment_questions-parent_id',
            '{{%comment_questions}}',
            'parent_id'
        );

        $this->addForeignKey(
            'fk-comment_questions-parent_id',
            '{{%comment_questions}}',
            'parent_id',
            '{{%comment_questions}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%comment_questions}}');
    }
}