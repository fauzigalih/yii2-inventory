<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use app\widgets\ToolbarFilterButton;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$page = 'Transaction';
$this->params['breadcrumbs'][] = $page;
$this->title = $page . ' - ' . Yii::$app->name;
?>
<div class="transaction-index">

    <h1><?= Html::encode('') ?></h1>
    <div id="search-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class='modal-body no-padding'>
                    <?=
                    $this->render('_search', ['model' => $model])
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?=
    GridView::widget([
        'dataProvider' => $model->search(),
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create ' . $page,
                ['create'], ['class' => 'btn btn-primary']),
            'heading' => $page,
            'headingOptions' => ['class' => 'panel-heading'],
        ],
        'toolbar' => [
            ToolbarFilterButton::widget(['model' => $model]),
            '{toggleData}',
            '{export}'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'No.'
            ],
            'invoice',
            [
                'attribute' => 'userId',
                'value' => function($model) {
                    return $model->user->fullName ?? '';
                }
            ],
            'codeTrx',
            [
                'attribute' => 'imageProduct',
                'format' => 'html',
                'value' => function($model) {
                    return Html::img(Yii::getAlias('@web/img/product/' . $model->productIn->products->imageProduct),
                            ['width' => '80px', 'height' => '50px']);
                }
            ],
            [
                'attribute' => 'stockFirst',
            ],
            'qtyTrx',
            'stockFinal',
            [
                'attribute' => 'datePublished',
                'format' => ['date', 'dd-MM-Y']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'template' => '{delete}'
            ],
        ],
    ]);
    ?>
</div>
