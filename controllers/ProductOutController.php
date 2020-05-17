<?php

namespace app\controllers;

use Yii;
use app\models\ProductOut;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProductOutController implements the CRUD actions for ProductOut model.
 */
class ProductOutController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'create', 'view', 'update'],
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
     * Lists all ProductOut models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new ProductOut();

        $model->load(Yii::$app->request->get());

        return $this->render('index', [
                'model' => $model,
        ]);
    }

    /**
     * Displays a single ProductOut model.
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
     * Creates a new ProductOut model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductOut();

        if ($model->load(Yii::$app->request->post())) {
            $model->userId = Yii::$app->user->identity->id;
            $dataQty = $model->qtyOut;
            $dataProduct = $model->productId;
            if (!($model->sumProduct($dataQty, $dataProduct) && $model->createTransaction() && $model->save())) {
                return $this->render('create', ['model' => $model]);
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing ProductOut model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $dataQty = $model->qtyOut;
        $dataProduct = $model->productId;
        $dataInvoice = $model->invoice;

        if ($model->load(Yii::$app->request->post())) {
            if ($dataProduct != $model->productId) {
                $model->sumProduct($model->qtyOut, $model->productId);
                $dataQty = 0 - $dataQty;
            } else {
                if ($dataQty != $model->qtyOut) {
                    $dataQty = $model->qtyOut - $dataQty;
                } else {
                    $dataQty = 0;
                }
            }
            if (!($model->sumProduct($dataQty, $dataProduct) && $model->createTransaction(true, $dataInvoice) && $model->save())) {
                return $this->render('update', ['model' => $model]);
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing ProductOut model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductOut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductOut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductOut::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
