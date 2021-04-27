<?php

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_student_number_login']))

	{

		//$user_id = $_POST['user_id'];

		$username = trim($_POST['validate_student_number']);

		$password = trim($_POST['validate_student_password']);	

		$sql = $dbc->query("SELECT * FROM student_info WHERE BINARY stud_no = '$username' AND BINARY password = '$password'");

						

						if($sql->num_rows != 0) {

							$row = $sql->fetch_assoc();

							if($row['stud_no']==$username)

							{	setcookie('uid',$row["stud_no"],time() + 86400);

								setcookie('ut',3,time() + 86400);

								//header ("Location: admin_home.php");

								echo "ok";

								exit;

							}

						}

						else {

							setcookie('error','1',time() + 86400);

							//header ("Location: login.php");

							echo "Username or Password incorrect.";

							exit;		

						}

			

	}

?>

