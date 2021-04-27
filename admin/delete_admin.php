<?php
include('dbcon.php');
if (isset($_POST['admin_delete'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{

	$result = mysql_query("DELETE FROM admin where id='$id[$i]'")or die (mysql_error());
	//$result = mysql_query("DELETE FROM ".$clubs." where student_id='$id[$i]'");
}
header("location: system.php");
}
?>