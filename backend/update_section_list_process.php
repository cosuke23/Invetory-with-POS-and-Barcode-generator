<?php

// Start the session..

session_start();

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_section']))

	{

		$program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		$section_id =  mysqli_real_escape_string($dbc, trim($_POST['section_id']));

		$section =  mysqli_real_escape_string($dbc, trim($_POST['section']));

		$status =  mysqli_real_escape_string($dbc, trim($_POST['status']));

		

		

			$query_section_list = "UPDATE section_list SET section = '$section',status = '$status' WHERE program_id = '$program_id' and section_id = '$section_id'";



		$result_section_list = mysqli_query($dbc,$query_section_list);	

		if($result_section_list)

				{

					echo "updated section list success";

					header("Location:manage_section_list.php?program_id=$program_id");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}

?>

