<?php
include('dbcon.php');
if (isset($_POST['strand'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{

	$result = mysql_query("DELETE FROM strands where id='$id[$i]'");
	//$result = mysql_query("DELETE FROM ".$clubs." where student_id='$id[$i]'");
}
header("location: strand.php");
}


if (isset($_POST['section'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{

	$result = mysql_query("DELETE FROM section where id='$id[$i]'");
	//$result = mysql_query("DELETE FROM ".$clubs." where student_id='$id[$i]'");
}
header("location: section.php");
}
?>