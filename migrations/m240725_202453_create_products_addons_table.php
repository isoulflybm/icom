<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products_addons}}`.
 */
class m240725_202453_create_products_addons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products_addons}}', [
            'id' => $this->primaryKey(),
            'product' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'value' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products_addons}}');
    }
}
