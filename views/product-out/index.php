<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use app\widgets\ToolbarFilterButton;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$page = 'Product Out';
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
            'codeProduct',
            'nameProduct',
            'unit',
            'qty',
            'price',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action'
            ],
        ],
    ]);
    ?>
</div>
