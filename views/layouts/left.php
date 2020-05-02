<?php

use app\models\User;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->fullName ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <?=
        dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Menu Inventory', 'options' => ['class' => 'header']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => ['/']],
                    ['label' => 'Products', 'icon' => 'newspaper-o', 'url' => ['/products']],
                    [
                        'label' => 'Product In / Out', 'icon' => 'exchange', 'url' => '#',
                        'items' => [
                            ['label' => 'Product In', 'icon' => 'mail-reply', 'url' => ['/product-in'],],
                            ['label' => 'Product Out', 'icon' => 'mail-forward', 'url' => ['/product-out'],],
                        ]
                    ],
                    ['label' => 'Transaction', 'icon' => 'bar-chart', 'url' => ['/transaction']],
                    ['label' => 'Users', 'icon' => 'user', 'url' => ['/user'], 'visible' => Yii::$app->user->identity->role === User::ROLE_ADMIN],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        )
        ?>

    </section>

</aside>
