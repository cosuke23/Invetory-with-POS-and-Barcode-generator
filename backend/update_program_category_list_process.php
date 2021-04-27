<?php

// Start the session..

session_start();

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_program_category_list']))

	{

		$category_id =  mysqli_real_escape_string($dbc, trim($_POST['category_id']));

		$program_id_pcl =  mysqli_real_escape_string($dbc, trim($_POST['program_id_pcl']));

		$category_description =  mysqli_real_escape_string($dbc, trim($_POST['category_description']));

		$ojt_hours =  mysqli_real_escape_string($dbc, trim($_POST['ojt_hours']));

		$status =  mysqli_real_escape_string($dbc, trim($_POST['status']));

			//Update query for section_list

			$query_update_program_category_list2 = "UPDATE program_category_list SET category_description = '$category_description',ojt_hours = '$ojt_hours',status='$status' WHERE program_id = '$program_id_pcl' and category_id = '$category_id'";

			

		$result_update_program_category_list2 = mysqli_query($dbc,$query_update_program_category_list2);	

		

		 $select_program_code = "SELECT program_code FROM program_list WHERE program_id = '$program_id_pcl'";

     	 $sresult_program_code = mysqli_query($dbc,$select_program_code);

        if($sresult_program_code->num_rows > 0)

               {   

                while ($row_name = mysqli_fetch_array($sresult_program_code))

                   {

                     $program_code = $row_name[0];      

                    }

              }



		if($result_update_program_category_list2)

				{

					echo "updated program category list success";

					header("Location: program_category_list.php?updated=1&category_description=$category_description&program_code=$program_code");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			

	}

?>

