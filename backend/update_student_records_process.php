<?php
// Start the session..
session_start();
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_stud_records']))
	{
		$stud_no_records =  mysqli_real_escape_string($dbc, trim($_POST['stud_no_records']));
		$section_records =  mysqli_real_escape_string($dbc, trim($_POST['section_records']));
		$ojt_status =  mysqli_real_escape_string($dbc, trim($_POST['ojt_status']));
		$enrollment_status =  mysqli_real_escape_string($dbc, trim($_POST['enrollment_status']));
		$category_description =  mysqli_real_escape_string($dbc, trim($_POST['category_description']));
		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
		$mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));
		$lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));
		$acad_year_start_rd =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start_rd']));
		$semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));
		$category_id = mysqli_real_escape_string($dbc, trim($_POST['category_id']));
		
			//Update query for student_ojt_records
		if($ojt_status=="Finished")
		{
			$query_student_update_records = "UPDATE student_ojt_records
			SET section_id = '$section_records', ojt_status = '$ojt_status', enrollment_status = '$enrollment_status' WHERE stud_no = '$stud_no_records' and acad_year_start = '$acad_year_start_rd' AND semester = '$semester' AND category_id = '$category_id'";
			$query_status_comp_ojt_stud = "UPDATE company_ojt_student
			SET status = '$ojt_status' WHERE stud_no = '$stud_no_records' and acad_year_start = '$acad_year_start_rd' AND semester = '$semester' AND status='Ongoing'";
			$result_update_student_records = mysqli_query($dbc,$query_student_update_records);
			$result_status_comp_ojt_stud = mysqli_query($dbc,$query_status_comp_ojt_stud);
			
		if($result_update_student_records)
				{
					echo "update student records success & company_ojt_status";
					header("Location: student_ojt_details.php?success2=1&stud_no=$stud_no_records&lname=$lname&fname=$fname&mname=$mname&category_description=$category_description");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
		}
		else
		{
			$query_select = "SELECT * FROM company_ojt_student WHERE stud_no='$stud_no_records'";
			$nwrow = $dbc->query($query_select)->fetch_assoc();
			
			$comp_os_id = $nwrow["comp_ojt_stud_id"];
			$comp_status = $nwrow["status"];
			
			
			$query_student_update_records = "UPDATE student_ojt_records
			SET section_id = '$section_records', ojt_status = '$ojt_status', enrollment_status = '$enrollment_status' WHERE stud_no = '$stud_no_records' and acad_year_start = '$acad_year_start_rd' AND semester = '$semester' AND category_id = '$category_id'";
			$query_status_comp_ojt_stud = "UPDATE company_ojt_student
			SET status = '$ojt_status' WHERE stud_no = '$stud_no_records' and acad_year_start = '$acad_year_start_rd' AND semester = '$semester' AND comp_ojt_stud_id = '$comp_os_id'AND status='Ongoing'";
			$result_update_student_records = mysqli_query($dbc,$query_student_update_records);
			$result_status_comp_ojt_stud = mysqli_query($dbc,$query_status_comp_ojt_stud);
			
		if($result_update_student_records)
				{
					echo "update student records success & company_ojt_status";
					header("Location: student_ojt_details.php?success=1&stud_no=$stud_no_records&lname=$lname&fname=$fname&mname=$mname");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
		}
	}
?>