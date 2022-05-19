<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company}}`.
 */
class m220407_120855_create_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(500)->notNull(),
        ]);
        $this->insert('{{%company}}',  [
            'id' => '1',
            'name' => 'Test1'
        ]);
        $this->insert('{{%company}}',  [
            'id' => '2',
            'name' => 'Test2'
        ]);
        $this->insert('{{%company}}',  [
            'id' => '3',
            'name' => 'Test3'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%company}}');
    }
}
