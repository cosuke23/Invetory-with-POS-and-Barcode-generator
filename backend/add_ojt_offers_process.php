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



if(isset($_POST['btn_add_ojt_offers']))

	{

		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));

		$comp_name = mysqli_real_escape_string($dbc, trim($_POST['comp_name']));

		$program_id_oo = mysqli_real_escape_string($dbc, trim($_POST['program_id_oo']));

		$ojt_offers_id = mysqli_real_escape_string($dbc, trim($_POST['ojt_offers_id']));

		$offer_status = mysqli_real_escape_string($dbc, trim($_POST['offer_status']));

	    $ojt_title = mysqli_real_escape_string($dbc, trim($_POST['ojt_title']));

	    $ojt_desc = mysqli_real_escape_string($dbc, trim($_POST['ojt_desc']));

		

		$program_id = mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		

			//Add query for ojt offers

			$ojt_offers_id = generateId($dbc, 'ojt_offers_id','ojt_offers');



			$query_add_ojt_offers = "INSERT INTO ojt_offers(ojt_offers_id,comp_id,ojt_title,ojt_desc,status,program_id) VALUES

			('$ojt_offers_id','$comp_id','$ojt_title', '$ojt_desc','$offer_status','$program_id')";

			



		$rusult_ojt_offers = mysqli_query($dbc,$query_add_ojt_offers);

		if($rusult_ojt_offers)

				{

					echo "Added ojt offers";

					header("Location:Company_info.php?comp_name3=$comp_name&offers_add=1&ojt_offers_id=$ojt_offers_id&comp_id=$comp_id");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}

?>

