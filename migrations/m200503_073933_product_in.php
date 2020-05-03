<?php

use yii\db\Migration;

/**
 * Class m200503_073933_product_in
 */
class m200503_073933_product_in extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_in', [
            'id' => $this->primaryKey(),
            'invoice' => $this->string(50)->notNull(),
            'userId' => $this->integer(11)->notNull(),
            'productId' => $this->integer(11)->notNull(),
            'qtyIn' => $this->integer(11)->notNull(),
            'datePublished' => $this->date()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_in');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200503_073933_product_in cannot be reverted.\n";

        return false;
    }
    */
}
