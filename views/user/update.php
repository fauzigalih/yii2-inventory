<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$page = 'User';
$titlePage = 'Update ' . $page;
//$this->params['breadcrumbs'][] = ['label' => $model->id, /*'url' => ['view', 'id' => $model->id ] */];
?>
<div class="user-update">

    <h1><?= Html::encode('') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'page' => $page,
        'titlePage' => $titlePage,
    ]) ?>

</div>
