<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">
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
                    'codeTrx' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Code Trx...']],
                    'userId' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter User ID...']],
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
