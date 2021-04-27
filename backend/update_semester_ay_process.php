<?php



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



if(isset($_POST['btn-say']))

{

	$semester = mysqli_real_escape_string($dbc, trim($_POST['semester']));

	$acad_year_start = mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));

	$acad_year_end = mysqli_real_escape_string($dbc, trim($_POST['acad_year_end']));

	

	$query_say = "UPDATE active_semester_acad_year SET active_semester='$semester' , active_acad_year_start='$acad_year_start' , active_acad_year_end='$acad_year_end' WHERE say_id='1'";

	$result_say = mysqli_query($dbc, $query_say);

	if($result_say==true)

	{

		header("Location: update_semester_ay.php?success=1");

		exit;

	}

	else

	{

		echo "ERROR: query_say";

		exit;

	}

}

?>