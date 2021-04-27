<?php



require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);





if(isset($_GET['msg_id']))

	{

	

		$msg_id = $_GET['msg_id'];

		

			//add query for company_info

			$query_delete = "DELETE FROM messages WHERE msg_id = '$msg_id'";





		$result_post_del = mysqli_query($dbc,$query_delete);

		if($result_post_del)

				{

					echo "deleted POST";

					header("Location:admin_home.php");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

 }	

?>

