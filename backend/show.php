<?php
// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';

$query = "SELECT password FROM user WHERE username='00820070011'";
$result = mysqli_query($dbc, $query);
if(mysqli_num_rows($result)>0)
{
	$row = mysqli_fetch_assoc($result);
	$show_pass = $row['password'];
}
else
{
 echo "ERROR: query";
}
echo $show_pass;
?>