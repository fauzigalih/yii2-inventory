<?php
//This is Default setting from Yii2
return array_merge([
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=your_database',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
    ], require 'db_local.php');
