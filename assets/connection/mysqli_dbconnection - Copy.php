<?php 
// Assign the connection to the constant variable..
DEFINE('DB_HOST','127.0.0.1');
DEFINE('DB_USER','sticaloo_e2e2');
DEFINE('DB_PASS','e2eadmin');
DEFINE('DB_BASE','sticaloo_ojtassisti');
// Create a variable to connect to the SQL..
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_BASE);


if (!$dbc) {
	print '<h1>There was an error in your code .</h1>';
}
?>