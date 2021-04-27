<?php

// Start the session..

session_start();

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);



// Set the auto increment..

function generateId($con, $id, $table_name) {

    $query = "SELECT $id FROM $table_name";

    $result = mysqli_query($con, $query);

    $num = mysqli_num_rows($result);

    if($num <= 0) {

        $id = 1;

        return $id;

    } else {

        $query1 = "SELECT MAX($id) FROM $table_name";

        $result1 = mysqli_query($con, $query1);

        $row1 = mysqli_fetch_array($result1, MYSQLI_NUM);

        $id = $row1[0] + 1;

        return $id;

    }

}

if(isset($_POST['btn_add_course']))

	{

		$program_code =  mysqli_real_escape_string($dbc, trim($_POST['program_code']));

		$program_name = mysqli_real_escape_string($dbc, trim($_POST['program_name']));

		$status = mysqli_real_escape_string($dbc, trim($_POST['status']));

		$section = mysqli_real_escape_string($dbc, trim($_POST['section']));



		

			//Update query for company_info



			$program_id = generateId($dbc, 'program_id','program_list');

			$section_id = generateId($dbc, 'section_id','section_list');



			$add_new_program = "INSERT INTO program_list(program_id,program_code,program_name,status) VALUES

			('$program_id','$program_code','$program_name','$status')";



			$add_new_section = "INSERT INTO section_list(section_id,program_id,section,status) VALUES

			('$section_id','$program_id','$section','$status')";

			

		$result_new_program = mysqli_query($dbc,$add_new_program);

		$result_new_section = mysqli_query($dbc,$add_new_section);	

		

		if($result_new_program && $result_new_section )

				{

					echo "updated program list success";

					header("Location: Manage_course.php?added=1&program_code=$program_code");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}

?>

