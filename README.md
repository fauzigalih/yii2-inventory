# yii2-inventory
Project build with framework yii2 template basic.

Status: <b>Release Version 1.0</b>

# Required Project
1. Composer
2. PHP version 7 or above
3. Git

# Technology
1. PHP Language
2. Yii2 framework
3. Migration database
<h3>Instalation migration</h3>
<ul>
  <li>Create database in (MySQL, SQL Server, or etc), example: inventory.</li>
  <li>Setting connection database in <code>config/db_local.php</code></li>
  <li>Run CLI or Command Prompt in your root aplication (make sure you have installed the composer).</li>
  <li>Run <code>php yii migrate</code></li>
  <li>Refresh your database, and get 5 new tables in it.</li>
  <li>Finish.</li>
</ul>

# Installation project
1. Clone this project with new repository, and place to folder <code>/htdocs/..</code> . and rename folder become `inventory`
2. Open CLI/Terminal and select <code>cd inventory</code> and run composer update :
```
composer update -vvv
```
3. Setting database in <code>config/db_local.php</code>
~~~
<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;port=3306;dbname=inventory',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
~~~
4. Use migration for instalation database.
5. Run <code>php yii serve</code> on CLI, this automatic create url access for aplication ex: localhost:8080. 
Copy paste access url in your browser. (if you can't run `php yii serve` , you can access url `localhost/inventory/web/` on browser)
6. Finish.

<b>You can login with username: admin, and password: admin</b> 

<br><br><br>Created by: <a href="https://www.instagram.com/fauzigalihajisaputro/">@fauzigalihajisaputro</a>
