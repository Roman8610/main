<?php

use yii\db\Migration;

class m260921_102100_create_departments_questions_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%departments_questions}}', [
            'id' => $this->primaryKey()->unsigned(),
            'question_id' => $this->integer()->unsigned()->notNull(),
            'departments_id' => $this->integer()->unsigned()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%departments_questions}}');
    }
}