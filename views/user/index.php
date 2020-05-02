<?php

use app\models\User;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\widgets\ToolbarFilterButton;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$page = 'User';
$this->params['breadcrumbs'][] = $page;
$this->title = $page . '- ' . Yii::$app->name;
?>
<div class="user-index">

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
    <?php Pjax::begin(['id' => $page]) ?>
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
            'fullName',
            'userName',
            [
                'label' => 'Role',
                'attribute' => 'role',
                'value' => function($model) {
                    return ($model->role == 1) ? 'Admin' : 'User';
                }
            ],
            [
                'label' => 'Active',
                'attribute' => 'active',
                'value' => function($model) {
                    return ($model->active == User::STATUS_ACTIVE) ? 'Yes' : 'No';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action'
            ],
        ],
    ]);
    ?>
<?php Pjax::end() ?>

</div>