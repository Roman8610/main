<?php

use yii\db\Migration;

class m261026_091721_create_qm_role_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%qm_role}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'meeting_id' => $this->integer()->unsigned()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%qm_role}}');
    }
}
