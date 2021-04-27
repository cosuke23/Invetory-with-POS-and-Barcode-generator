<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';

	if(isset($_POST['btn_email']))
	{
		$stud_no = mysqli_real_escape_string($dbc, $_POST['stud_no']);
		$email = mysqli_real_escape_string($dbc, $_POST['email']);
		$q_email = $dbc->query("SELECT email FROM student_info WHERE BINARY email='$email'");
		if($q_email->num_rows != 0)
		{
			$r_email= $q_email->fetch_assoc();
			if($r_email['email'] == $email)
			{
				header("Location: email_validator.php?stud_no=$stud_no&error=1");
				exit;
			}
		}
		else
		{
			header("Location: web_registration.php?stud_no=$stud_no&email=$email");
			exit;
		}
	}
?>