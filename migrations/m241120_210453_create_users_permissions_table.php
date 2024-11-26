<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_permissions}}`.
 */
class m241120_210453_create_users_permissions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_permissions}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
            'deleted_at' => $this->timestamp()->null()->defaultExpression('NULL'),
            'permission_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('parmissions_user_id', 'users_permissions', 'user_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('permissions_permission_id', 'users_permissions', 'permission_id', 'permissions', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_permissions}}');
    }
}
