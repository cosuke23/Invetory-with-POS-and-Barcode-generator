<?php

require 'medoo/medoo.php';
$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'e2e_private',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8'
]);
?>
