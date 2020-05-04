<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

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

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const DEFAULT_VALUE_NULL = 0;

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
            [['nameProduct', 'typeProduct', 'unit', 'price', 'stockFirst', 'imageProduct', '_imageProduct'], 'required'],
            [['price', 'stockFirst', 'stockIn', 'stockOut', 'stockFinal', 'active'], 'integer'],
            [['invoice', 'nameProduct', 'typeProduct', 'unit', 'imageProduct'], 'string', 'max' => 45],
            [['datePublished'], 'default', 'value' => date('Y-m-d')],
            [['stockIn', 'stockOut'], 'default', 'value' => self::DEFAULT_VALUE_NULL],
            ['active', 'default', 'value' => self::STATUS_ACTIVE]
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

    public function save($runValidation = true, $attributeNames = null) {
        $baseUrl = Yii::$app->request->baseUrl;
        $transaction = Yii::$app->db->beginTransaction();

        $uploadedFile = UploadedFile::getInstance($this, '_imageProduct');
        if ($uploadedFile) {
            $fileDir = Yii::getAlias('@webroot/img/product');
            if (!file_exists($fileDir))
                FileHelper::createDirectory($fileDir);

            if ($this->_imageProduct != $this->imageProduct)
                unlink("$fileDir/$this->imageProduct");

            date_default_timezone_set('Asia/Jakarta');
            $dateTime = date('dmYHis');
            $fileName = strtolower("$this->nameProduct" . "_$this->invoice" . "_$dateTime." . $uploadedFile->extension);
            if (!$uploadedFile->saveAs("$fileDir/$fileName")) {
                $transaction->rollBack();
                return false;
            }
            $this->imageProduct = $fileName;
            $this->stockFinal = $this->stockFirst;

            if (!parent::save($runValidation, $attributeNames)) {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
            return true;
        }
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
