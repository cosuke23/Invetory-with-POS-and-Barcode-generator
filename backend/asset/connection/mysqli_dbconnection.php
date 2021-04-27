<?php 
// Assign the connection to the contant variable..
DEFINE('DB_HOST','localhost');
DEFINE('DB_USER','root');
DEFINE('DB_PASS','');
DEFINE('DB_BASE','e2e_private');
// Create a variable to connect to the SQL..
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_BASE);


if (!$dbc) {
	print '<h1>There was an error in your code .</h1>';
}
?>