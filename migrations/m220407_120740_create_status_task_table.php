<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status_task}}`.
 */
class m220407_120740_create_status_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status_task}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(500)->notNull(),
        ]);
        $this->insert('{{%status_task}}', [
            'id' => '1',
            'name' => 'В работе'
        ]);
        $this->insert('{{%status_task}}', [
            'id' => '2',
            'name' => 'Тестирование'
        ]);
        $this->insert('{{%status_task}}', [
            'id' => '3',
            'name' => 'Выполнено'
        ]);
        $this->insert('{{%status_task}}', [
            'id' => '4',
            'name' => 'Оплачено'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status_task}}');
    }
}
