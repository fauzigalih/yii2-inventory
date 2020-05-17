<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string|null $invoice
 * @property int|null $userId
 * @property string|null $codeTrx
 * @property int|null $stockFirst
 * @property int|null $qtyTrx
 * @property int|null $stockFinal
 * @property date $datePublished
 */
class Transaction extends ActiveRecord
{
    public $fullName;
    public $fromDate;
    public $toDate;
    public $active;
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
            [['userId', 'stockFirst', 'qtyTrx', 'stockFinal'], 'integer'],
            [['invoice', 'codeTrx'], 'string', 'max' => 50],
            [['datePublished', 'fullName', 'fromDate', 'toDate', 'active'], 'safe'],
            [['datePublished'], 'default', 'value' => date('Y-m-d')],
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
    
    public function getProducts(){
        return $this->hasOne(Products::className(), ['id' => 'productId']);
    }
    
    public function getProductIn(){
        return $this->hasOne(ProductIn::className(), ['invoice' => 'codeTrx']);
    }
    
    public function getProductOut(){
        return $this->hasOne(ProductOut::className(), ['invoice' => 'codeTrx']);
    }
    
    public function search() {
        $fromDate = $this->fromDate;
        $toDate = $this->toDate;
        if($fromDate == '') {
            $fromDate = '';
            $toDate = '';
        }else if($toDate == ''){
            $toDate = $this->fromDate;
        }
        $query = self::find()
            ->joinWith('user')
            ->joinWith('productIn.products AS a')
            ->joinWith('productOut.products AS b')
            ->andFilterWhere(['like', 'transaction.invoice', $this->invoice])
            ->andFilterWhere(['like', 'user.fullName', $this->fullName])
            ->andFilterWhere(['like', 'transaction.codeTrx', $this->codeTrx])
            ->andFilterWhere(['=', 'transaction.stockFirst', $this->stockFirst])
            ->andFilterWhere(['=', 'transaction.qtyTrx', $this->qtyTrx])
            ->andFilterWhere(['=', 'transaction.stockFinal', $this->stockFinal])
            ->andFilterWhere(['between', 'transaction.datePublished', $fromDate, $toDate])
            ->andFilterWhere(['or', ['a.active' => $this->active], ['b.active' => $this->active]]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8
            ],
            'sort' => [
                'attributes' => [
                    'invoice' => 'invoice',
                    'user.fullName' => 'user.fullName',
                    'codeTrx' => 'codeTrx',
                    'imageProduct' => 'imageProduct',
                    'stockFirst' => 'stockFirst',
                    'qtyTrx' => 'qtyTrx',
                    'stockFinal' => 'stockFinal',
                    'datePublished' => 'datePublished',
                    'products.active' => 'products.active'
                ]
            ]
        ]);

        return $dataProvider;
    }
    
    public static function getInvoiceData() {
        $query = self::find()->max('invoice');
        $noInvoice = (int) substr($query, 3, 3);
        $noInvoice++;
        $charInvoice = "TRX";
        $newInvoice = $charInvoice . sprintf("%03s", $noInvoice);

        return $newInvoice;
    }
    
    public static function getListInvoice() {
        return ArrayHelper::map(self::find()->all(), 'id', 'invoice');
    }
    
}
