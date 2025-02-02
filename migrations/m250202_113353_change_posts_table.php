<?php

use yii\db\Migration;

/**
 * Class m250202_113353_change_posts_table
 */
class m250202_113353_change_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%posts}}', 'text', $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext')->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250202_113353_change_posts_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250202_113353_change_posts_table cannot be reverted.\n";

        return false;
    }
    */
}
