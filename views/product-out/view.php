<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProductOut */

$page = 'Product Out';
$titlePage = 'View ' . $page;
?>
<div class="product-out-view">

    <h1><?= Html::encode('') ?></h1>
    <?=
    $this->render('_form',
        [
            'model' => $model,
            'page' => $page,
            'titlePage' => $titlePage,
    ])
    ?>

</div>
