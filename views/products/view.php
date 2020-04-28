<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$page = 'Products';
$titlePage = 'View ' . $page;
$this->title = $titlePage . ' - ' . Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => $page, 'url' => ['index']];
$this->params['breadcrumbs'][] = $titlePage;
?>
<div class="products-view">

    <h1><?= Html::encode('') ?></h1>
    <?=
    $this->render('_form',
        [
            'model' => $model,
            'titlePage' => $titlePage,
    ])
    ?>
</div>
