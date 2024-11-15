<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_entities}}`.
 */
class m241114_213646_create_posts_entities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts_entities}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
            'deleted_at' => $this->timestamp()->null()->defaultExpression('NULL'),
            'title' => $this->string()->notNull(),
            'description' => $this->text(4294967295),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_entities}}');
    }
}
