<?php
use app\models\User;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\web\View;
use app\models\Products;
use kartik\date\DatePicker;

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
                'method' => 'GET',
                'action' => ['index'],
                'type' => ActiveForm::TYPE_VERTICAL,
                'options' => [
                    'data-pjax' => false,
                    'class' => 'form-filter'
                ],
        ]);
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 4,
            'attributes' => [
                'invoice' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => 'kartik\select2\Select2',
                        'options' => [
                            'data' => Products::getListInvoice(),
                            'options' => [
                                'placeholder' => 'Select Item',
                                'required' => false,
                                'class' => 'form-control'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]
                    ],
                'nameProduct' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Name Product...']],
                'typeProduct' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Type Product...']],
                'unit' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => 'kartik\select2\Select2',
                        'options' => [
                            'data' => Products::$unitCategories,
                            'options' => [
                                'placeholder' => 'Select Item',
                                'required' => false,
                                'class' => 'form-control'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]
                    ],
                'price' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Price...']],
                'stockFirst' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Stock First...']],
                'stockIn' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Stock In...']],
                'stockOut' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Stock Out...']],
                'stockFinal' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Stock Final...']],
                'fromDate' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass' => 'kartik\date\DatePicker', 
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]
                ],
                'toDate' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass' => 'kartik\date\DatePicker', 
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]
                ],
                'active' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => 'kartik\select2\Select2',
                    'options' => [
                        'data' => Products::$activeCategories,
                        'options' => [
                            'placeholder' => 'Select Item',
                            'required' => false,
                            'class' => 'form-control'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]
                ],
            ],
        ]);
        ?>
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