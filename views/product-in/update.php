<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductIn */

$page = 'Product In';
$titlePage = 'Update ' . $page;
?>
<div class="product-in-update">

    <h1><?= Html::encode('') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'page' => $page,
        'titlePage' => $titlePage,
    ]) ?>

</div>
