<?php

use yii\db\Migration;

/**
 * Class m180612_153843_orders
 */
class m180612_153843_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()

    {
        $this->createTable('orders', [
            'id' => $this->integer(11)->notNull(),
            'user' => $this->text()->notNull(),
            'link' => $this->text()->notNull(),
            'quantity' => $this->string(11)->notNull(),
            'service_id' => $this->integer(11)->notNull(),
            'status' => $this->integer(1)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'mode' => $this->integer(1)->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('orders');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180612_153843_orders cannot be reverted.\n";

        return false;
    }
    */
}
