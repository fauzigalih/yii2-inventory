<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string|null $invoice
 * @property string|null $nameProduct
 * @property string|null $typeProduct
 * @property string|null $unit
 * @property int|null $price
 * @property int|null $stockFirst
 * @property int|null $qtyIn
 * @property int|null $qtyOut
 * @property int|null $stockFinal
 * @property string|null $imageProduct
 * @property date $datePublished
 * @property int|null $active
 */
class Products extends ActiveRecord {
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static $activeCategories = [
        self::STATUS_ACTIVE => "ACTIVE",
        self::STATUS_INACTIVE => "NOT ACTIVE"
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['nameProduct', 'typeProduct', 'unit', 'price', 'stockFirst', 'imageProduct'], 'required'],
            [['price', 'stockFirst', 'qtyIn', 'qtyOut', 'stockFinal', 'active'], 'integer'],
            [['invoice', 'nameProduct', 'typeProduct', 'unit', 'imageProduct'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'invoice' => 'Invoice',
            'nameProduct' => 'Name Product',
            'typeProduct' => 'Type Product',
            'unit' => 'Unit',
            'price' => 'Price',
            'stockFirst' => 'Stock First',
            'qtyIn' => 'Qty In',
            'qtyOut' => 'Qty Out',
            'stockFinal' => 'Stock Final',
            'imageProduct' => 'Image Product',
            'datePublished' => 'Date Published',
            'active' => 'Active',
        ];
    }

    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'nameProduct', $this->nameProduct])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['=', 'active', $this->active]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8
            ]
        ]);

        return $dataProvider;
    }

}
