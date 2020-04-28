<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$page = 'User';
$titlePage = 'Create ' . $page;
?>
<div class="user-create">

    <h1><?= Html::encode('') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'page' => $page,
        'titlePage' => $titlePage,
    ]) ?>

</div>
