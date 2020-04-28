<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Register - ' . Yii::$app->name;

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions3 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Inventory</b>System</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php if (Yii::$app->session->getFlash('error') !== NULL) { ?>
            <div class="alert alert-warning">
                <?= Yii::$app->session->getFlash('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <p class="login-box-msg">Sign up your  account.</p>

        <?php $form = ActiveForm::begin(['id' => 'register-form', 'enableClientValidation' => false]); ?>

        <?=
            $form
            ->field($model, 'fullName', $fieldOptions1)
            ->label(false)
            ->textInput(['autofocus' => true, 'placeholder' => $model->getAttributeLabel('Enter Your Full Name...')])
        ?>

        <?=
            $form
            ->field($model, 'userName', $fieldOptions2)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('Enter Username...')])
        ?>

        <?=
            $form
            ->field($model, 'password', $fieldOptions3)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('Enter Password...')])
        ?>

        <?=
            $form
            ->field($model, 'passwordConfirm', $fieldOptions3)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('Enter Confirm Password...')])
        ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?=
                Html::submitButton('Register',
                    ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button'])
                ?>
            </div>
            <!-- /.col -->
        </div>


<?php ActiveForm::end(); ?>

        <!--        <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                        using Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                        in using Google+</a>
                </div>-->
        <!-- /.social-auth-links -->

        <!--        <a href="#">I forgot my password</a><br>-->
<?= Html::a('Already Login ? ', ['login'], ['class' => 'text-center']) ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
