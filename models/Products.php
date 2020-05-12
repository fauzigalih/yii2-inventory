<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

//use function sanitizeFileName;

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
 * @property int|null $stockIn
 * @property int|null $stockOut
 * @property int|null $stockFinal
 * @property string|null $imageProduct
 * @property date $datePublished
 * @property int|null $active
 */
class Products extends ActiveRecord {
    public $_imageProduct;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;
    const DEFAULT_VALUE_NULL = 0;

    public static $activeCategories = [
        self::STATUS_ACTIVE => "ACTIVE",
        self::STATUS_INACTIVE => "NOT ACTIVE"
    ];
    public static $unitCategories = [
        'Unit' => 'Unit',
        'Pcs' => 'Pcs',
        'Dus' => 'Dus',
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
            [['invoice', 'nameProduct', 'typeProduct', 'unit', 'price', 'stockFirst', 'imageProduct'], 'required'],
            [['price', 'stockFirst', 'stockIn', 'stockOut', 'stockFinal', 'active'], 'integer'],
            [['invoice', 'nameProduct', 'typeProduct', 'unit', 'imageProduct'], 'string', 'max' => 45],
            [['datePublished'], 'default', 'value' => date('Y-m-d')],
            [['stockIn', 'stockOut'], 'default', 'value' => self::DEFAULT_VALUE_NULL],
            ['active', 'default', 'value' => self::STATUS_ACTIVE],
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
            'stockIn' => 'Stock In',
            'stockOut' => 'Stock Out',
            'stockFinal' => 'Stock Final',
            'imageProduct' => 'Image Product',
            'datePublished' => 'Date Published',
            'active' => 'Active',
        ];
    }

    public function uploadImage() {
        $uploadedFile = UploadedFile::getInstance($this, '_imageProduct');
        $update = Yii::$app->controller->action->id == 'update';
        if ($uploadedFile) {
            $fileDir = Yii::getAlias('@webroot/img/product');
            if (!file_exists($fileDir))
                FileHelper::createDirectory($fileDir);

            if ($update && ($this->_imageProduct != $this->imageProduct)){
                $this->stockFinal = $this->stockFirst + $this->stockIn - $this->stockOut;
                unlink(Yii::getAlias("@webroot/img/product/$this->imageProduct"));
            }
            date_default_timezone_set('Asia/Jakarta');
            $dateTime = date('dmYHis');
            $fileName = strtolower("$this->nameProduct" . "_$this->invoice" . "_$dateTime." . $uploadedFile->extension);
            if (!$uploadedFile->saveAs("$fileDir/$fileName")) {
                return false;
            }
            $this->imageProduct = $fileName;

            return true;
        } else if ($update) {
            $this->stockFinal = $this->stockFirst + $this->stockIn - $this->stockOut;
            return true;
        }
    }

    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'nameProduct', $this->nameProduct])
            ->andFilterWhere(['like', 'typeProduct', $this->typeProduct])
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

    public function getInvoiceData() {
        $query = self::find()->max('invoice');
        $noInvoice = (int) substr($query, 3, 3);
        $noInvoice++;
        $charInvoice = "INV";
        $newInvoice = $charInvoice . sprintf("%03s", $noInvoice);

        return $newInvoice;
    }

    public static function getListName() {
        return ArrayHelper::map(self::find()->all(), 'id', 'nameProduct');
    }

    public static function getListInvoice() {
        return ArrayHelper::map(self::find()->all(), 'id', 'invoice');
    }

}
