<?php
include('db.php');
include('session.php');
$start = $_POST['start'];
$end = $_POST['end'];
$reason = $_POST['reason'];
if (isset($_POST['Start'])){
mysql_query("INSERT into maintenance (date_start,date_end,reason) values('$start','$end','$reason')")or die(mysql_error());
header("location:club.php");
}

if (isset($_POST['stop'])){
	$num=0;
mysql_query("DELETE from maintenance where id > '$num' ")or die (mysql_error());
header("location:club.php");
}
?>