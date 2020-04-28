<?php
use app\models\User;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = $titlePage . ' - ' . Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => $page, 'url' => ['index']];
$this->params['breadcrumbs'][] = $titlePage;

$isDisabled = Yii::$app->controller->action->id == 'view';
$updateId = Yii::$app->controller->action->id == 'update';
?>

<div class="user-form">
    <div class="card">
        <p class="title-card"><?= Html::encode($titlePage) ?></p>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL,]);
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 3,
                'attributes' => [
                    'fullName' => ['type' => Form::INPUT_TEXT, 'label' => 'Full Name', 'options' => ['autofocus' => true, 'placeholder' => 'Enter Your Name...', 'disabled' => $isDisabled]],
                    'userName' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Username...', 'disabled' => $isDisabled]],
                    'password' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => 'Enter Password...', 'disabled' => $isDisabled], 'visible' => !$updateId],
                    'oldPassword' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => 'Enter Old Password...'], 'visible' => $updateId],
                    'newPassword' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => 'Enter New Password...'], 'visible' => $updateId],
                    'newPasswordConfirm' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => 'Enter New Password Confirm...'], 'visible' => $updateId],
                    'role' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => 'kartik\select2\Select2',
                        'options' => [
                            'data' => app\models\User::$roleCategories,
                            'disabled' => $isDisabled,
                            'options' => [
                                'placeholder' => 'Pilih',
                                'required' => false,
                                'class' => 'form-control'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ],
                    ],
                    'active' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => 'kartik\select2\Select2',
                        'options' => [
                            'data' => User::$activeCategories,
                            'disabled' => $isDisabled,
                            'options' => [
                                'placeholder' => 'Pilih',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]
                    ],
                //'passwordHashConfirm' => ['type' => Form::INPUT_PASSWORD, 'maxlength' => true, 'options' => ['placeholder' => 'Enter Password...']],
                ],
            ]);
            ?>
            <div class="right">
                <?=
                Html::resetButton('Reset', ['class' => 'btn btn-default']) . ' ' .
                Html::a('Back', Yii::$app->request->referrer,
                    ['class' => 'btn btn-danger']) . ' '
                ?>
                <?php
                if (!$isDisabled) {
                    echo Html::submitButton('Submit',
                        ['type' => 'button', 'class' => 'btn btn-primary']);
                }
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
