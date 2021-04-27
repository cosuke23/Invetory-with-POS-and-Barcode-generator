<?php

// Start the session..

session_start();

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_student_deliverables']))

	{

		$deliverable_id =  mysqli_real_escape_string($dbc, trim($_POST['deliverable_id']));

		$deliverable_name =  mysqli_real_escape_string($dbc, trim($_POST['deliverable_name']));

		$authorize_by =  mysqli_real_escape_string($dbc, trim($_POST['authorize_by']));



			//Update query for section_list

			$query_update_program_category_list2 = "UPDATE student_deliverables SET deliverable_name = '$deliverable_name', authorize_by = '$authorize_by' WHERE deliverable_id = '$deliverable_id'";

			

		$result_update_program_category_list2 = mysqli_query($dbc,$query_update_program_category_list2);	

		

		if($result_update_program_category_list2)

				{

					echo "updated student deliverables success";

					header("Location: student_deliverables.php?updated=1&authorize_by=$authorize_by&deliverable_name=$deliverable_name");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}

?>

