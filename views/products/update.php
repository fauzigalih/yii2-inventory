<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$page = 'Products';
$titlePage = 'Update ' . $page;
?>
<div class="products-update">

    <h1><?= Html::encode('') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'page' => $page,
        'titlePage' => $titlePage,
    ]) ?>

</div>
