<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn-login']))
{
	session_start();
		$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no']));

		$check_stud_no = "SELECT * FROM admin_info WHERE admin_id ='$stud_no' ";
		$result_stud_no = mysqli_query($dbc, $check_stud_no);
		if(mysqli_num_rows($result_stud_no)>0)
		{
			$sql = $dbc->query("SELECT * FROM admin_info WHERE admin_id = '$stud_no'");
			if($sql->num_rows != 0) 
			{
				
					header ("Location: login2.php?stud_no=$stud_no");
				
				}
				
				
			
		}
		else
		{
			header("Location: mname_validator.php?stud_no=$stud_no");
			exit;
		}
}
?>