<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use app\models\Products;

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
    public $_invoice;
    public $nameProduct;
    public $unit;
    public $imageProduct;
    
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
            [['invoice', 'userId', 'productId', 'qtyIn', '_invoice'], 'required'],
            [['userId', 'productId', 'qtyIn'], 'integer'],
            [['invoice'], 'string', 'max' => 45],
            [['datePublished'], 'default', 'value' => date('Y-m-d')],
            [['nameProduct', 'unit', 'imageProduct'], 'safe'],
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
            '_invoice' => 'Invoice Product',
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
    
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
    
    public function getProducts(){
        return $this->hasOne(Products::className(), ['id' => 'productId']);
    }

    public function getProductsId(){
        $query = Products::find()->where(['invoice' => $this->_invoice])->one();
        return $query;
    }
    
    public function getInvoiceData() {
        $query = self::find()->max('invoice');
        $noInvoice = (int) substr($query, 3, 3);
        $noInvoice++;
        $charInvoice = "PIN";
        $newInvoice = $charInvoice . sprintf("%03s", $noInvoice);
        
        return $newInvoice;
    }
    
    public function save($runValidation = true, $attributeNames = null) {
        $transaction = Yii::$app->db->beginTransaction();
        
        $this->userId = Yii::$app->user->identity->id;
        $this->productId = $this->productsId->id;
        
        if(!parent::save($runValidation, $attributeNames)){
            $transaction->rollBack();
            return false;
        }
        
        $transaction->commit();
        return true;
    }
}
