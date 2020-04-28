<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string|null $codeTrx
 * @property int|null $userId
 * @property string|null $productId
 * @property int|null $stockFirst
 * @property int|null $qtyTrx
 * @property int|null $stockFinal
 * @property date $datePublished
 */
class Transaction extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'productId', 'stockFirst', 'qtyTrx', 'stockFinal'], 'integer'],
            [['codeTrx'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codeTrx' => 'Code Trx',
            'userId' => 'User',
            'productId' => 'Product',
            'stockFirst' => 'Stock First',
            'qtyTrx' => 'Qty Trx',
            'stockFinal' => 'Stock Final'
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
    
    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'codeTrx', $this->codeTrx])
            ->andFilterWhere(['like', 'userId', $this->userId])
            ->andFilterWhere(['like', 'productId', $this->productId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8
            ]
        ]);

        return $dataProvider;
    }
}
