<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m220407_120952_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(10)->notNull(),
            'title' => $this->string(500)->notNull(),
            'body' => $this->string(5000)->notNull(),
            'company' => $this->integer(10)->notNull(),
            'project' => $this->string(500)->notNull(),
            'link' => $this->string(500)->notNull(),
            'status' => $this->integer(10)->notNull(),
            'work_time' => $this->integer()->null(),
            'pay_per_hour' => $this->integer(10)->notNull(),
            'base_price' => $this->integer()->null(),
            'price' => $this->integer()->null(),
            'dop_price' => $this->integer()->null(),
            'created_at' => $this->date()->null(),
            'completed_at' => $this->date()->null(),
            'updated_at' => $this->date()->null(),
        ]);
        $this->createIndex(
            'idx-task-status',
            'task',
            'status'
        );
        $this->createIndex(
            'idx-task-user_id',
            'task',
            'user_id'
        );
        $this->createIndex(
            'idx-task-company',
            'task',
            'company'
        );
        $this->createIndex(
            'idx-task-created_at',
            'task',
            'created_at'
        );
        $this->createIndex(
            'idx-task-multiple_filter',
            'task',
            'company, status, created_at, user_id'
        );
        $this->addForeignKey(
            'user_id',
            'task',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'status',
            'task',
            'status',
            'status_task',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'company',
            'task',
            'company',
            'company',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'user_id',
            'task'
        );
        $this->dropForeignKey(
            'status',
            'task'
        );
        $this->dropForeignKey(
            'company',
            'task'
        );
        $this->dropIndex(
            'idx-task-created_at',
            'task'
        );
        $this->dropIndex(
            'idx-task-user_id',
            'task'
        );
        $this->dropIndex(
            'idx-task-company',
            'task'
        );
        $this->dropIndex(
            'idx-task-status',
            'task'
        );
        $this->dropIndex(
            'idx-task-multiple_filter',
            'task'
        );
        $this->dropTable('{{%task}}');
    }
}
