<?php

// Start the session..

//session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn-login_comp']))

	{

		

		$compname = trim($_POST['validate_compname']);

		$password = trim($_POST['validate_password']);

		//$comp_id = trim($_POST['comp_id']);

		

				$sql = $dbc->query("SELECT * FROM company_info WHERE BINARY username = '$compname' AND BINARY password = '$password'");

						

						if($sql->num_rows > 0)

						{

							$row = $sql->fetch_assoc();

							

							if($row["status"]=="Active")

							{

								setcookie("cid",$row["username"],time() + 86400);

								$comp_id = $row['comp_id'];

								header("Location: comp_company_remarks.php?comp_id=$comp_id");

								exit;

							}

							else

							{

								setcookie('error','1',time() + 86400);

								$error = "Company you tried to login is not active.";

								

								header("Location: company_login.php?error=$error");

								exit;		

							}

						}

						else

						{

							setcookie('error','1',time() + 86400);

							$error = "Username or Password incorrect.";

							header("Location: company_login.php?error=$error");

							exit;		

						}

			

	}

?>

