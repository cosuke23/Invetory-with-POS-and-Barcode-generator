<?php

// Start the session..

session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_ojt_offers']))

	{

		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));

		$program_id_oo = mysqli_real_escape_string($dbc, trim($_POST['program_id_oo']));

		$ojt_offers_id = mysqli_real_escape_string($dbc, trim($_POST['ojt_offers_id']));

		$offer_status = mysqli_real_escape_string($dbc, trim($_POST['offer_status']));

	    $ojt_title = mysqli_real_escape_string($dbc, trim($_POST['ojt_title']));

	    $ojt_desc = mysqli_real_escape_string($dbc, trim($_POST['ojt_desc']));

		

		$program_id = mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		

			//Update query company program

			$query_update_ojt_offers = "UPDATE ojt_offers SET ojt_title = '$ojt_title', ojt_desc = '$ojt_desc', status = '$offer_status', program_id = '$program_id' WHERE ojt_offers_id = '$ojt_offers_id' AND comp_id = '$comp_id'";

			

			

			$result_update_ojt_offers = mysqli_query($dbc,$query_update_ojt_offers);



		if($result_update_ojt_offers)

				{

					echo "updated ojt_offers";			

					header ("Location:ojt_offers_masterlist.php?success=1");  

			

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}



?>

