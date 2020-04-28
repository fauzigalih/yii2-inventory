<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\ProductOut */
/* @var $form yii\widgets\ActiveForm */

$this->title = $titlePage . ' - ' . Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => $page, 'url' => ['index']];
$this->params['breadcrumbs'][] = $titlePage;

$isDisabled = Yii::$app->controller->action->id == 'view';

?>

<div class="product-out-form">
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
                    'invoice' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Code Product...']],
                ],
            ]);
            ?>
            <div class="right">
                <?=
                Html::resetButton('Reset', ['class' => 'btn btn-default']) . ' ' .
                Html::a('Back', Yii::$app->request->referrer,
                    ['class' => 'btn btn-danger']) . ' ' .
                Html::submitButton('Submit',
                    ['type' => 'button', 'class' => 'btn btn-primary'])
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
