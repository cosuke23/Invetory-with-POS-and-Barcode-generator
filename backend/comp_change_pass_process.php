<?php

// Start the session..

session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_changepass']))

	{

		$comp_id =  mysqli_real_escape_string($dbc, trim($_POST['comp_id']));

		$username =  mysqli_real_escape_string($dbc, trim($_POST['username']));

		$new_pass =  mysqli_real_escape_string($dbc, trim($_POST['new_pass']));



		if(!empty($new_pass))

		{

			

			//query_password

			$query_pass = "UPDATE company_info SET password = '$new_pass' WHERE username = '$username'";

			$result_pass = mysqli_query($dbc,$query_pass);



			if($result_pass)

			{

				echo "updated";

				header("Location: comp_company_remarks.php?comp_id=$comp_id&pass=1");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}

		}

	}

?>

