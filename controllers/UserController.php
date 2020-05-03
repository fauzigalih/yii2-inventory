<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        if (!(Yii::$app->user->identity->role === User::ROLE_ADMIN)) {
            Yii::$app->session->setFlash('error',
                'Sorry, you\'re not permission on this session.');
            return $this->goHome();
        }

        $model = new User();

        $model->load(Yii::$app->request->get());

        return $this->render('index',
                [
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (!(Yii::$app->user->identity->role === User::ROLE_ADMIN)) {
            Yii::$app->session->setFlash('error',
                'Sorry, you\'re not permission on this session.');
            return $this->goHome();
        }
        
        $model = $this->findModel($id);

        return $this->render('view',
                [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (!(Yii::$app->user->identity->role === User::ROLE_ADMIN)) {
            Yii::$app->session->setFlash('error',
                'Sorry, you\'re not permission on this session.');
            return $this->goHome();
        }

        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validateUsername() && $model->newUser()) {
            return $this->redirect(['index']);
        }

        return $this->render('create',
                [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (!(Yii::$app->user->identity->role === User::ROLE_ADMIN)) {
            Yii::$app->session->setFlash('error',
                'Sorry, you\'re not permission on this session.');
            return $this->goHome();
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->newPassword == $model->newPasswordConfirm) {
                if ($model->validatePassword($model->oldPassword)) {
                    $model->setPassword($model->newPassword);
                    $model->generateAuthKey();
                    $model->save();

                    return $this->redirect(['index']);
                } else {
                    $model->addError('oldPassword', 'You\'re password must same to proccess update, try again.');
                }
            } else {
                $model->addError('newPasswordConfirm', 'New Password Confirm must same, try again.');
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (!(Yii::$app->user->identity->role === User::ROLE_ADMIN)) {
            Yii::$app->session->setFlash('error',
                'Sorry, you\'re not permission on this session.');
            return $this->goHome();
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionProfile($id) {
        
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
