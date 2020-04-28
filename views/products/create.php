<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$page = 'Products';
$titlePage = 'Create ' . $page;
?>
<div class="products-create">

    <h1><?= Html::encode('') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'page' => $page,
        'titlePage' => $titlePage,
    ]) ?>

</div>
