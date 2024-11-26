<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_tags}}`.
 */
class m241124_160059_create_posts_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts_tags}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
            'deleted_at' => $this->timestamp()->null()->defaultExpression('NULL'),
            'tag_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('posts_tag_id', 'posts_tags', 'tag_id', 'tags', 'id', 'CASCADE');
        $this->addForeignKey('posts_post_id', 'posts_tags', 'post_id', 'posts', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_tags}}');
    }
}
