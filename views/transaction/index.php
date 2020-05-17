<?php
use app\models\Products;
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
                'attribute' => 'user.fullName',
                'value' => function($model) {
                    return $model->user->fullName ?? '';
                }
            ],
            'codeTrx',
            [
                'attribute' => 'imageProduct',
                'format' => 'html',
                'value' => function($model) {
                    return Html::img(Yii::getAlias('@web/img/product/' . ($model->productIn->products->imageProduct ?? $model->productOut->products->imageProduct)),
                            ['width' => '80px', 'height' => '50px']);
                }
            ],
            'stockFirst',
            'qtyTrx',
            'stockFinal',
            [
                'attribute' => 'datePublished',
                'format' => ['date', 'dd-MM-Y']
            ],
            [
                'attribute' => 'products.active',
                'value' => function($model){
                    return $model->productIn->products->active ?? $model->productOut->products->active == Products::STATUS_ACTIVE ? 'Yes' : 'No';
                }
            ],
//                'active',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'template' => '{delete}'
            ],
        ],
    ]);
    ?>
</div>
