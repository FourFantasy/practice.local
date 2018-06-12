<?php

use yii\db\Migration;

/**
 * Class m180612_153920_services
 */
class m180612_153920_services extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('services', [
            'id' => $this->integer(11)->notNull(),
            'name' => $this->text()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('services');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180612_153920_services cannot be reverted.\n";

        return false;
    }
    */
}
