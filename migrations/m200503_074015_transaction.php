<?php

use yii\db\Migration;

/**
 * Class m200503_074015_transaction
 */
class m200503_074015_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'codeTrx' => $this->string(50)->notNull(),
            'userId' => $this->integer(11)->notNull(),
            'productId' => $this->integer(11)->notNull(),
            'stockFirst' => $this->integer(11)->notNull(),
            'qtyTrx' => $this->integer(11)->notNull(),
            'stockFinal' => $this->integer(11)->notNull(),
            'datePublished' => $this->date()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transaction');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200503_074015_transaction cannot be reverted.\n";

        return false;
    }
    */
}
