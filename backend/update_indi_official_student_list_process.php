<?php
// Start the session..
session_start();
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_stud_indv']))
	{
		$sol_id =  mysqli_real_escape_string($dbc, $_POST['sol_id']);
		$stud_no =  $_POST['stud_no_indv'];
		$lname =  mysqli_real_escape_string($dbc, $_POST['lname']);
		$fname =  mysqli_real_escape_string($dbc, $_POST['fname']);
		$mname =  mysqli_real_escape_string($dbc, $_POST['mname']);
		$program_id =  mysqli_real_escape_string($dbc, $_POST['program_id']);
		$status =  mysqli_real_escape_string($dbc, $_POST['status']);
        
     	
     	$query_sol_update = "UPDATE official_student_list 
				SET lname = '$lname',fname = '$fname', mname = '$mname', program_code = '$program_id',
				 status = '$status' WHERE sol_id = '$sol_id'";
			$result_query_sol_update = mysqli_query($dbc,$query_sol_update);	
		if($result_query_sol_update){
          header ("Location: upload.php?success_up=6&stud_no=$stud_no&fname=$fname&mname=$mname&lname=$lname");  
		}else{
			echo "error";
		}
	}
?>