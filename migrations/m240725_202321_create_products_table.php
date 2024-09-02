<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m240725_202321_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),
            'parent' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'price' => $this->real()->notNull(),
            'weight' => $this->real()->notNull(),
            'number' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
