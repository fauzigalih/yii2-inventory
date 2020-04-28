<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductOut */

$page = 'Product Out';
$titlePage = 'Update ' . $page;
?>
<div class="product-out-update">

    <h1><?= Html::encode('') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'page' => $page,
        'titlePage' => $titlePage,
    ]) ?>

</div>
