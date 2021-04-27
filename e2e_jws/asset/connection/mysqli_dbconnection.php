<?php

require 'medoo/medoo.php';
$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'e2e_jws',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8'
]);
DEFINE('DB_HOST','localhost');
DEFINE('DB_USER','root');
DEFINE('DB_PASS','');
DEFINE('DB_BASE','e2e_private');
// Create a variable to connect to the SQL..
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_BASE);


if (!$dbc) {
	print '<h1>There was an error in your code .</h1>';
}
mysql_select_db('e2e_private',mysql_connect('localhost','root',''))or die(mysql_error());

?>
