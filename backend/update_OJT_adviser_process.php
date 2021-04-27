<?php



require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn-adviser-update']))

	{	

		$adviser_id =  mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));

		$title =  mysqli_real_escape_string($dbc, trim($_POST['title']));		

		$lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));	

		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));

		$mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));

		$email =  mysqli_real_escape_string($dbc, trim($_POST['email']));		

		$program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));	

		$status =  mysqli_real_escape_string($dbc, trim($_POST['status']));	

		$mobile_no =  mysqli_real_escape_string($dbc, trim($_POST['mobile_no']));



		$result = mysqli_query($dbc,"UPDATE  adviser_info SET  title = '$title', lname ='$lname', fname ='$fname', mname = '$mname', email = '$email',program_id = '$program_id',status = '$status',mobile_no = '$mobile_no'  WHERE adviser_id = '$adviser_id'");



		if($status == "Not Active"){



				$result_shs = mysqli_query($dbc,"UPDATE  adviser_section_handled SET  status = 'Not Active'  WHERE adviser_id = '$adviser_id'");



				if($result_shs == true){

			echo "success update the shs not active";

			header("Location: OJT_adviser.php?updated=1&title=$title&lname=$lname&fname=$fname&mname=$mname");

		} else{



			echo "error";

		}



		}else{



			$result_shs2 = mysqli_query($dbc,"UPDATE  adviser_section_handled SET  status = 'Active'  WHERE adviser_id = '$adviser_id'");



				if($result_shs2 == true){

					echo "success update the shs active";

						header("Location: OJT_adviser.php?updated=1&title=$title&lname=$lname&fname=$fname&mname=$mname");

				}else{

					echo "error";

					}

		}



		if($result == true){

			echo "success";

				header("Location: OJT_adviser.php?updated=1&title=$title&lname=$lname&fname=$fname&mname=$mname");

		} else{



			echo "error";

		}

			

	}

?>

