<?php

use yii\db\Migration;

/**
 * Class m200503_073805_products
 */
class m200503_073805_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'invoice' => $this->string(50)->notNull(),
            'nameProduct' => $this->string(50)->notNull(),
            'typeProduct' => $this->string(50)->notNull(),
            'unit' => $this->string(50)->notNull(),
            'price' => $this->integer(11)->notNull(),
            'price' => $this->integer(11)->notNull(),
            'stockFirst' => $this->integer(11)->notNull(),
            'stockIn' => $this->integer(11)->notNull(),
            'stockOut' => $this->integer(11)->notNull(),
            'stockFinal' => $this->integer(11)->notNull(),
            'imageProduct' => $this->string(255)->notNull(),
            'datePublished' => $this->date()->notNull(),
            'active' => $this->integer(11)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200503_073805_products cannot be reverted.\n";

        return false;
    }
    */
}
