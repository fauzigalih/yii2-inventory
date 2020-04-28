<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$page = 'Transaction';
$titlePage = 'Create ' . $page;
$this->title = $titlePage . ' - ' . Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => $page, 'url' => ['index']];
$this->params['breadcrumbs'][] = $titlePage;
?>
<div class="transaction-create">

    <h1><?= Html::encode('') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'titlePage' => $titlePage,
    ]) ?>

</div>
