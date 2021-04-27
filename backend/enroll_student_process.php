<?php
// Start the session..
session_start();
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_enrolled_stud']))
	{
		$stud_no_records =  mysqli_real_escape_string($dbc, trim($_POST['stud_no_records']));
		$section_records =  mysqli_real_escape_string($dbc, trim($_POST['section_records']));
		$enrollment_status =  mysqli_real_escape_string($dbc, trim($_POST['enrollment_status']));
		$acad_year_start_rd =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start_rd']));
		$semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));
		$category_id = mysqli_real_escape_string($dbc, trim($_POST['category_id']));
	
			$query_student_update_enrolled = "UPDATE student_ojt_records
			SET section_id = '$section_records', enrollment_status = '$enrollment_status' WHERE stud_no = '$stud_no_records' and acad_year_start = '$acad_year_start_rd' AND semester = '$semester' AND category_id='$category_id'";
			$result_student_update_enrolled = mysqli_query($dbc,$query_student_update_enrolled);
			
		if($result_student_update_enrolled)
				{
					echo "update student records success & company_ojt_status";
					header("Location: pending_student_list.php?success=1");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
		
	}
?>