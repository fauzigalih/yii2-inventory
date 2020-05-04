<?php
use app\models\Products;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

$this->title = $titlePage . ' - ' . Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => $page, 'url' => ['index']];
$this->params['breadcrumbs'][] = $titlePage;

$isDisabled = Yii::$app->controller->action->id == 'view';
$isActionCreate = Yii::$app->controller->action->id == 'create';
$displayFile = !$isActionCreate ? Yii::getAlias("@web/img/product/$model->imageProduct") : false;
?>

<div class="products-form">
    <div class="card">
        <p class="title-card"><?= Html::encode($titlePage) ?></p>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 3,
                'attributes' => [
                    'invoice' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $isDisabled]],
                    'nameProduct' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Name Product...', 'disabled' => $isDisabled]],
                    'typeProduct' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Type Product...', 'disabled' => $isDisabled]],
                    'unit' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Unit...', 'disabled' => $isDisabled]],
                    'price' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Price...', 'disabled' => $isDisabled]],
                    'stockFirst' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Stock...', 'disabled' => $isDisabled]],
                    '_imageProduct' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => 'kartik\file\FileInput',
                        'options' => [
                            'disabled' => $isDisabled,
                            'options' => [
                                'multiple' => false,
                                'placeholder' => 'Pilih',
                                'class' => 'form-control'
                            ],
                            'pluginOptions' => [
                                'showUpload' => false,
                                'showRemove' => false,
                                'initialPreview' => $displayFile,
                                'initialPreviewAsData' => true,
                                'initialCaption' => $model->imageProduct,
                            ],
                        ],
                    ],
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
