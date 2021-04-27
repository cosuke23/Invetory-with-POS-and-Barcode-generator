<?php
include('dbcon.php');
if (isset($_POST['delete_moderator'])){
$id=$_POST['selector'];
$N = count($id);

for($i=0; $i < $N; $i++)
{
$user_query = mysql_query("SELECT * from admin_info where admin_id = '$id[$i]'")or die(mysql_error());
$row=mysql_fetch_array($user_query);

$results = mysql_query("DELETE FROM admin_info where admin_id='$id[$i]'")or die(mysql_error());
	//$result = mysql_query("DELETE FROM ".$clubs." where student_id='$id[$i]'");
}
header("location: admin_user.php");
}
?>