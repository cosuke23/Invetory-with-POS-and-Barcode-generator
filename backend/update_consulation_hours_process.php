<?php



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_consulation_hours']))

	{

		$adviser_id =  mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));

		

		$ach_id =  mysqli_real_escape_string($dbc, trim($_POST['ach_id']));

		$hour_start =  mysqli_real_escape_string($dbc, trim($_POST['hour_start']));

		$hour_end =  mysqli_real_escape_string($dbc, trim($_POST['hour_end']));

		$day =  mysqli_real_escape_string($dbc, trim($_POST['day']));



		$query_consultation_hour_update = "UPDATE adviser_consultation_hours  SET day = '$day',hour_start = '$hour_start', hour_end = '$hour_end' WHERE adviser_id = '$adviser_id' AND ach_id = '$ach_id'";	

			

			$result_consultation_hour_update = mysqli_query($dbc,$query_consultation_hour_update);

			

		if($result_consultation_hour_update)

				{

					echo "update CH";

					header("Location:adviser_account.php?username=$adviser_id");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}

    }

?>

