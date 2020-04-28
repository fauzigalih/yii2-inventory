<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "product_in".
 *
 * @property int $id
 * @property string|null $invoice
 * @property int|null $userId
 * @property int|null $productId
 * @property int|null $qtyIn
 * @property date $datePublished
 */
class ProductIn extends ActiveRecord {
    public static $unitCategories = [
        'Pcs' => 'Pcs',
        'Pack' => 'Pack',
        'Kg' => 'Kg',
        'Dus' => 'Dus',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'product_in';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['invoice', 'userId', 'productId', 'qtyIn'], 'required'],
            [['userId', 'productId', 'qtyIn'], 'integer'],
            [['invoice'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'invoice' => 'Invoice',
            'userId' => 'User',
            'productId' => 'Product',
            'qtyIn' => 'Qty',
            'datePublished' => 'Date Published',
        ];
    }

    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'userId', $this->userId])
            ->andFilterWhere(['like', 'productId', $this->productId])
            ->andFilterWhere(['like', 'qtyIn', $this->qtyIn]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8
            ]
        ]);

        return $dataProvider;
    }

}
