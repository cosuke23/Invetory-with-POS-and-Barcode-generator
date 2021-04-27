<?php

 // Start the session..

session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_stud_records_Adv']))

	{

		$stud_no_records =  mysqli_real_escape_string($dbc, trim($_POST['stud_no_records']));

		$section_records =  mysqli_real_escape_string($dbc, trim($_POST['section_records']));

		$ojt_status =  mysqli_real_escape_string($dbc, trim($_POST['ojt_status']));

		$enrollment_status =  mysqli_real_escape_string($dbc, trim($_POST['enrollment_status']));



		$acad_year_start_rd =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start_rd']));

		$semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));

		

			//Update query for student_ojt_records

			$query_student_update_records = "UPDATE student_ojt_records

			SET section_id = '$section_records', ojt_status = '$ojt_status', enrollment_status = '$enrollment_status' WHERE stud_no = '$stud_no_records' and acad_year_start = '$acad_year_start_rd'";

			



			$result_update_student_records = mysqli_query($dbc,$query_student_update_records);

	

			

		if($result_update_student_records)

				{

					echo "update student records success";

					header("Location: adviser_update_student_information.php?stud_no=$stud_no_records&semester_rd=$semester&acad_year_start_rd=$acad_year_start_rd&section_id=$section_records");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}

?>

