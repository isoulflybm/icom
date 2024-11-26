<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m241114_213607_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
            'deleted_at' => $this->timestamp()->null()->defaultExpression('NULL'),
            'image' => $this->binary(4294967295)->notNull(),
            'post_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('posts_image_id', 'images', 'post_id', 'posts', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
