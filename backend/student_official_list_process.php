<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
	if(isset($_POST['btn_mname']))
		{
		$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
		$mname_val = mysqli_real_escape_string($dbc, trim($_POST['mname_val']));
		$rb = $_GET['rb'];
		$q_mname = $dbc->query("SELECT mname FROM official_student_list WHERE stud_no ='$stud_no' AND mname='$mname_val'");
		if($q_mname->num_rows != 0)
		{
			header("Location:email_validator.php?stud_no=$stud_no&rb=$rb");
			exit;
		}
		else
		{
			header("Location: student_official_list.php?stud_no=$stud_no&rb=$rb&error=1");
			exit;
		}
	}
?>