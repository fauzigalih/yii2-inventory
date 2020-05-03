<?php

use yii\db\Migration;

/**
 * Class m200503_073946_product_out
 */
class m200503_073946_product_out extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_out', [
            'id' => $this->primaryKey(),
            'invoice' => $this->string(50)->notNull(),
            'userId' => $this->integer(11)->notNull(),
            'productId' => $this->integer(11)->notNull(),
            'qtyOut' => $this->integer(11)->notNull(),
            'datePublished' => $this->date()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_out');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200503_073946_product_out cannot be reverted.\n";

        return false;
    }
    */
}
