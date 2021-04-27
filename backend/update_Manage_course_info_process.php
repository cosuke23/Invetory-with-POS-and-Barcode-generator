<?php

// Start the session..

session_start();

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_course']))

	{

		$program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		$program_code = mysqli_real_escape_string($dbc, trim($_POST['program_code']));

		$program_desc = mysqli_real_escape_string($dbc, trim($_POST['program_desc']));

		$status = mysqli_real_escape_string($dbc, trim($_POST['status']));



		

			//Update query for company_info

			$query_program_list = "UPDATE program_list

			SET program_code = '$program_code',program_name = '$program_desc',status = '$status' WHERE program_id = '$program_id'";

			

			$query_section_list = "UPDATE section_list

			SET status = '$status' WHERE program_id = '$program_id'";



		$result_program_list = mysqli_query($dbc,$query_program_list);

		$result_section_list = mysqli_query($dbc,$query_section_list);		

		

		if($result_program_list && $result_section_list)

				{

					echo "updated program list success";

					header("Location: Manage_course.php?success=1&program_code=$program_code");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}

?>

