<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products_categories}}`.
 */
class m240725_202411_create_products_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products_categories}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'parent' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products_categories}}');
    }
}
