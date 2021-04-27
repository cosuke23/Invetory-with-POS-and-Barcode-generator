<?php



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



if(isset($_GET['rb']))

{

	$rb=$_GET['rb'];

}

else

{

	$rb=0;

}

$error=" ";

	if(isset($_POST['btn_email']))

	{

		$stud_no = mysqli_real_escape_string($dbc, $_POST['stud_no']);

									

		$email = mysqli_real_escape_string($dbc, $_POST['email']);

												   

		$q_email = $dbc->query("SELECT email FROM student_info WHERE BINARY email='$email'");

		if($q_email->num_rows != 0)

		{

			$r_email= $q_email->fetch_assoc();

				

			if($r_email['email'] == $email)

			{

				$error = "Email address exists.";

				header("Location: email_validator.php?stud_no=$stud_no&error=$error&rb=$rb");

			}

		}

		else

		{

			echo "ok";

			header("Location: student_registration.php?stud_no=$stud_no&email=$email&rb=$rb");

			exit;

		}

	}

?>