<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_logos}}`.
 */
class m241106_201008_create_users_logos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_logos}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
            'deleted_at' => $this->timestamp()->null()->defaultExpression('NULL'),
            'user_id' => $this->integer()->notNull(),
            'logo' => $this->binary(4294967295),
        ]);
        $this->addForeignKey('user_id', 'users_logos', 'user_id', 'users', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_logos}}');
    }
}
