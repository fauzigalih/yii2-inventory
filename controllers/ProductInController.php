<?php

namespace app\controllers;

use Yii;
use app\models\ProductIn;
use app\models\Products;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * ProductInController implements the CRUD actions for ProductIn model.
 */
class ProductInController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductIn models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new ProductIn();

        $model->load(Yii::$app->request->get());

        return $this->render('index',
                [
                'model' => $model,
        ]);
    }

    /**
     * Displays a single ProductIn model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view',
                [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductIn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductIn();

        if ($model->load(Yii::$app->request->post())) {
            $model->userId = Yii::$app->user->identity->id;
            $dataQty = $model->qtyIn;
            $dataProduct = $model->productId;
            if (!($model->sumProduct($dataQty, $dataProduct) && $model->save())) {
                return $this->render('create', ['model' => $model]);
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing ProductIn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $dataQty = $model->qtyIn;
        $dataProduct = $model->productId;

        if ($model->load(Yii::$app->request->post())) {
            if($dataProduct != $model->productId){
                $model->sumProduct($model->qtyIn, $model->productId);
                $dataQty = 0 - $dataQty;
            }else{
                if ($dataQty != $model->qtyIn){
                    $dataQty = $model->qtyIn - $dataQty;
                } else {
                    $dataQty = 0;
                }
            }
            if(!($model->sumProduct($dataQty, $dataProduct) && $model->save())){
                return $this->render('update', ['model' => $model]);
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing ProductIn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionList($id) {
        $countInvoice = Products::find()->where(['id' => $id])->count();
        $invoices = Products::find()->where(['id' => $id])->all();

        if ($countInvoice > 0) {
            foreach ($invoices as $invoice) {
                echo '<input type="text" value="' . $invoice->invoice . '">';
            }
        } else {
            echo '<input type="text" placeholder="Enter Name Product...">';
        }
    }

    /**
     * Finds the ProductIn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductIn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductIn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
