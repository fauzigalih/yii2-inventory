<?php
use app\models\User;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model MsUser */
?>
<div class="panel panel-search">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter</h4>
    </div>
    <div class="panel-body">
        <?php
        $form = ActiveForm::begin([
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'GET',
                'action' => ['index'],
                'type' => ActiveForm::TYPE_VERTICAL,
                'options' => [
                    'data-pjax' => false,
                    'class' => 'form-filter'
                ],
        ]);
        ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'fullName') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'userName') ?>
            </div>
            <div class="col-md-4">
                <?=
                $form->field($model, 'role')->widget(Select2::classname(),
                    [
                        'data' => User::$roleCategories,
                        'options' => [
                            'placeholder' => 'Select..',
                        ],
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?=
                $form->field($model, 'active')->widget(Select2::classname(),
                    [
                        'data' => User::$activeCategories,
                        'options' => [
                            'placeholder' => 'Select...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                ]);
                ?>
            </div>
        </div>
        <div class="form-group text-right">
            <?=
            Html::submitButton('<i class="glyphicon glyphicon-search with-text"></i> Search',
                [
                    'class' => 'btn btn-primary',
            ])
            ?> 
            <?=
            Html::a('<i class="glyphicon glyphicon-remove with-text"></i> Reset',
                ['index'],
                [
                    'class' => 'btn btn-danger'
            ])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>