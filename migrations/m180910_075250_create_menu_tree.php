<?php

use yii\db\Migration;
use \yii\db\Schema;

/**
 * Class m180910_075250_create_menu_tree
 */
class m180910_075250_create_menu_tree extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('menu',
            [
                'id' => Schema::TYPE_PK,
                'parent_id' => Schema::TYPE_INTEGER,
                'title' => Schema::TYPE_STRING . ' NOT NULL',
                'link' => Schema::TYPE_TEXT,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180910_075250_create_menu_tree cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180910_075250_create_menu_tree cannot be reverted.\n";

        return false;
    }
    */
}
