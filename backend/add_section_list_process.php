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



if(isset($_POST['btn_add_section']))

	{

		$program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		$section =  mysqli_real_escape_string($dbc, trim($_POST['section']));

		$status =  mysqli_real_escape_string($dbc, trim($_POST['status']));

		$program_code =  mysqli_real_escape_string($dbc, trim($_POST['program_code']));

		

			//add query for section_list

			$section_id = generateId($dbc, 'section_id','section_list');



			$query_add_Section = "INSERT INTO section_list(section_id,program_id,section,status) VALUES

			('$section_id','$program_id','$section','$status')";

			

			$result_add_Section = mysqli_query($dbc,$query_add_Section);



		if($result_add_Section)

				{

					echo "added section list success";

					header("Location: Manage_course.php?section=$section&program_code=$program_code");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}

?>

