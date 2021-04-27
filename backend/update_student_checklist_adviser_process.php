<?php
// Start the session..
session_start();
//header("Location: update_student_records.php");
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_stud_chklist_adv']))
	{
		$stud_no_chklist =  mysqli_real_escape_string($dbc, trim($_POST['stud_no_chklist']));
		$deliverable_id =  mysqli_real_escape_string($dbc, trim($_POST['deliverable_id']));
		$date_submitted =  mysqli_real_escape_string($dbc, trim($_POST['date_submitted']));
		$remarks =  mysqli_real_escape_string($dbc, trim($_POST['remarks']));
		$deliverable_name =  mysqli_real_escape_string($dbc, trim($_POST['deliverable_name']));
		
		$acad_year_start =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));
		$semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));
		$date_submitted2 = date('Y-m-d', strtotime(str_replace('-', '/', $date_submitted)));
		//get ongoing category_id
		$q_ongoing_category = "SELECT category_id from student_ojt_records WHERE stud_no='$stud_no_chklist' AND ojt_status='Ongoing'";
		$q_ongoing_category_res = $dbc->query($q_ongoing_category);
		$row = $q_ongoing_category_res->fetch_assoc();
		$category_id = $row['category_id'];
		//
			//Update query for student_ojt_records
			$query_student_update_chklist = "UPDATE student_checklist SET date_submitted = '$date_submitted2', remarks = '$remarks'  WHERE stud_no = '$stud_no_chklist' AND deliverable_id = '$deliverable_id' and acad_year_start = '$acad_year_start' and semester = '$semester' and category_id='$category_id'";
			
			$result_update_student_checklist = mysqli_query($dbc,$query_student_update_chklist);
	
			
		if($result_update_student_checklist)
				{
					echo "update student checklist success";
					header("Location: adviser_OJT_student_checklist.php?acad_year_start_rd=$acad_year_start&semester_rd=$semester&stud_no_records=$stud_no_chklist&success=1&deliverable_name=$deliverable_name");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
			
	}
?>