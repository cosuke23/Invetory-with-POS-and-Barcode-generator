<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
if(isset($_GET['fid']))
{
	$fid=$_GET['fid'];
	$query="DELETE FROM ojt_monitoring_report WHERE fid='$fid'";
	$result=mysqli_query($dbc, $query);
	if($result==true)
	{
		header("Location: view_report.php?dsuccess=1");
		exit;
	}
	else
	{
		echo "ERROR: query";
	}
}	

?>