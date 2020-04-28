<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "product_out".
 *
 * @property int $id
 * @property string|null $invoice
 * @property int|null $userId
 * @property int|null $productId
 * @property int|null $qtyOut
 * @property date $datePublished
 */
class ProductOut extends ActiveRecord
{
    public static $unitCategories = [
        'Pcs' => 'Pcs',
        'Pack' => 'Pack',
        'Kg' => 'Kg',
        'Dus' => 'Dus',
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_out';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice', 'userId', 'productId', 'qtyOut'], 'required'],
            [['userId', 'productId', 'qtyOut'], 'integer'],
            [['invoice'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice' => 'Invoice',
            'userId' => 'User',
            'productId' => 'Product',
            'qtyOut' => 'Qty',
            'datePublished' => 'Date Published',
        ];
    }
    
    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'userId', $this->userId])
            ->andFilterWhere(['like', 'productId', $this->productId])
            ->andFilterWhere(['like', 'qtyOut', $this->qtyOut]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8
            ]
        ]);

        return $dataProvider;
    }
}
