<?php
use app\models\Products;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\widgets\ToolbarFilterButton;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$page = 'Product In';
$this->title = $page . ' - ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $page;
?>
<div class="products-index">

    <h1><?= Html::encode('') ?></h1>
    <div id="search-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class='modal-body no-padding'>
                    <?= $this->render('_search',
                        ['model' => $model])
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
                'attribute' => 'user.fullName',
                'value' => function($model) {
                    return $model->user->fullName ?? null;
                }
            ],
            [
                'attribute' => 'products.nameProduct',
                'value' => function($model) {
                    return $model->products->nameProduct ?? null;
                }
            ],
            [
                'attribute' => 'products.typeProduct',
                'value' => function($model) {
                    return $model->products->typeProduct ?? null;
                }
            ],
            [
                'attribute' => 'products.unit',
                'value' => function($model) {
                    return $model->products->unit ?? null;
                }
            ],
            'qtyIn',
            [
                'attribute' => 'products.price',
                'value' => function($model) {
                    return 'Rp. ' . number_format($model->products->price, 0,
                            ',', '.');
                }
            ],
            [
                'attribute' => 'products.imageProduct',
                'format' => 'html',
                'value' => function($model) {
                    return Html::img(Yii::getAlias('@web/img/product/' . $model->products->imageProduct),
                            ['width' => '80px', 'height' => '50px']);
                }
            ],
            [
                'attribute' => 'datePublished',
                'format' => ['date', 'dd-MM-Y']
            ],
            [
                'attribute' => 'products.active',
                'value' => function($model) {
                    return $model->products->active == Products::STATUS_ACTIVE ? 'Yes' : 'No';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action'
            ],
        ],
    ]);
    ?>
</div>
