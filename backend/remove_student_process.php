<?php
	require 'asset/connection/mysqli_dbconnection.php';
	if(isset($_GET['stud_no'])){
		$stud_no=$_GET['stud_no'];
		$stud_name = $_GET['stud_name'];
		echo $stud_no;
		echo $stud_name; 
		$q_remove_student = "update student_ojt_records set section_id='1', enrollment_status='Not Enrolled' where stud_no='$stud_no' and ojt_status='Ongoing'";
		if($dbc->query($q_remove_student) == TRUE){
		header("Location:adviser_section_handled.php?remove=ok&stud_name='$stud_name'");
		
		}else{
		echo 'error bes';
		}
	}



?>