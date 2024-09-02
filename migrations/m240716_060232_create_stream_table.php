<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stream}}`.
 */
class m240716_060232_create_stream_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stream}}', [
            'id' => $this->primaryKey()->notNull(),
            'user' => $this->integer()->notNull(),
            'streamname' => $this->string()->notNull(),
            'streamurl' => $this->string()->notNull(),
            'streamrtmp' => $this->string()->notNull(),
            'poster' => $this->string()->notNull(),
            'accessToken' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stream}}');
    }
}
