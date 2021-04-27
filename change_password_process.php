<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_change_pass']))
{
	$stud_no = mysqli_real_escape_string($dbc, trim($_POST['this_stud_no']));
	$cur_pass = mysqli_real_escape_string($dbc, trim($_POST['cur_pass']));
	$nw_pass = mysqli_real_escape_string($dbc, trim($_POST['nw_pass']));
	$con_pass = mysqli_real_escape_string($dbc, trim($_POST['con_pass']));
	
	$query_stud_pass = "SELECT password FROM student_info WHERE stud_no='$stud_no'";
	$result_stud_pass = mysqli_query($dbc, $query_stud_pass);
	if(mysqli_num_rows($result_stud_pass)>0)
	{
		$row = mysqli_fetch_assoc($result_stud_pass);
		$password = $row['password'];
		
	}
	if(crypt($cur_pass, '$2a$12$xyYidadDvFewdFQZFIcDDs')==$password)
	{
		if($nw_pass == $con_pass)
		{
			$nwst_pass = crypt($nw_pass, '$2a$12$xyYidadDvFewdFQZFIcDDs');
			$query_new_pass = "UPDATE student_info SET password='$nwst_pass' WHERE stud_no='$stud_no'";
			$result_new_pass = mysqli_query($dbc, $query_new_pass);
			if($result_new_pass==true)
			{
				$msg = "Password changed successfully.";
				header("Location: change_password.php?error3=$msg");
				exit;
			}
		}
		else
		{
			$msg = "Password doesn't match";
			header("Location: change_password.php?error2=$msg");
			exit;
		}
	}
	else
	{
		$msg = "Wrong password";
		header("Location: change_password.php?error1=$msg");
		exit;
	}
}
?>