<?php

require 'medoo/medoo.php';
$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'e2e_gemventory',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8'
]);
?>
