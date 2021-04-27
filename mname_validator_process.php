<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';

	if(isset($_POST['btn_mname']))
	{
		$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
		$mname = mysqli_real_escape_string($dbc, trim($_POST['mname']));

		$q_mname = $dbc->query("SELECT mname FROM official_student_list WHERE stud_no ='$stud_no' AND mname='$mname'");
		if($q_mname->num_rows != 0)
		{
			header("Location:email_validator.php?stud_no=$stud_no");
			exit;
		}
		else
		{
			header("Location: mname_validator.php?stud_no=$stud_no&error=1");
			exit;
		}
	}
?>