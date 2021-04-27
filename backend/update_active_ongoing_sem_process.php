<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
if(isset($_POST['btnUpdateSem']))
{
	$semester = mysqli_real_escape_string($dbc, $_POST['sem']);
	$acad_year_start = mysqli_real_escape_string($dbc,$_POST['acad_year_start']);
	$status = mysqli_real_escape_string($dbc, $_POST['status']);
	$acad_year_end = $acad_year_start + 1;
	
	$query_say = "UPDATE active_semester_acad_year SET active_semester='$semester' , active_acad_year_start='$acad_year_start' , active_acad_year_end='$acad_year_end' WHERE status='$status'";
	$result_say = mysqli_query($dbc, $query_say);
	if($result_say==true)
	{
		header("Location: update_semester_ay.php?sem_update=1");
		exit;
	}
	else
	{
		echo "ERROR: query_say";
		exit;
	}
}
?>