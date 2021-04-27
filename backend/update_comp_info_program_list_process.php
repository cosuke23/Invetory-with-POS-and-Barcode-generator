<?php

// Start the session..

session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_comp_info_program_program_list']))

	{

		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));

		$comp_program_id = mysqli_real_escape_string($dbc, trim($_POST['comp_program_id']));

		$comp_name = mysqli_real_escape_string($dbc, trim($_POST['comp_name']));

		$program_id_cp = mysqli_real_escape_string($dbc, trim($_POST['program_id_cp']));

		$program_id = mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		$comp_program_status = mysqli_real_escape_string($dbc, trim($_POST['comp_program_status']));

		

		



		$sel_prog ="SELECT program_code FROM program_list WHERE program_id ='$program_id'";

		$ressel_prog =  mysqli_query($dbc, $sel_prog);         

          if($ressel_prog->num_rows > 0)

               {   

                while ($row_pending = mysqli_fetch_array($ressel_prog))

                   {

                     $program_code = $row_pending[0];      

                    }

              }   



        if($comp_program_status == "Not Active"){



        	 $query_comp_prog = "SELECT comp_id,program_id FROM company_program WHERE comp_id='$comp_id' AND program_id = '$program_id' AND comp_program_status ='Not Active'";

			$result_comp_prog =  mysqli_query($dbc, $query_comp_prog);         

          if($result_comp_prog->num_rows > 0)

               {   

                while ($row_progr = mysqli_fetch_array($result_comp_prog))

                   {

                     $comp_progr_id = $row_progr[0];

                      $comp_program_id2 = $row_progr[1];



                     header ("Location: update_comp_info_program_list.php?comp_id=$comp_id&program_id=$program_id_cp&comp_program_id=$comp_program_id&error=1&comp_name=$comp_name&program_code=$program_code"); 



                      echo "already exist"; 



                   

                    }

              }

          else{

          			//Update query company program

			$query_comp_info_company_program = "UPDATE company_program SET program_id = '$program_id',comp_program_status = '$comp_program_status' WHERE program_id = '$program_id_cp' AND comp_id = '$comp_id' AND comp_program_id = '$comp_program_id'";

			

		if($comp_program_status =="Not Active")

			{

				$query_ojt_offers_status_2 = "UPDATE ojt_offers

				SET status = 'Not Available' WHERE comp_id = '$comp_id' AND program_id = '$program_id_cp'";

			}else

			{

				$query_ojt_offers_status_2 = "UPDATE ojt_offers

				SET status = 'Available' WHERE comp_id = '$comp_id' AND program_id = '$program_id_cp'";

			}		



		$result_comp_info_company_program = mysqli_query($dbc,$query_comp_info_company_program);

		$result_ojt_offers_status2 = mysqli_query($dbc,$query_ojt_offers_status_2);

      



		if($result_comp_info_company_program && $result_ojt_offers_status2)

				{

					echo "updated program list";			

					header ("Location: company_manage_program.php?comp_id=$comp_id&updated=1&comp_name=$comp_name&program_code=$program_code"); 

					   

			

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

          }  



        }



        else if($comp_program_status == "Active"){



        	 $query_comp_prog = "SELECT comp_id,program_id FROM company_program WHERE comp_id='$comp_id' AND program_id = '$program_id' AND comp_program_status ='Active'";

			$result_comp_prog =  mysqli_query($dbc, $query_comp_prog);         

          if($result_comp_prog->num_rows > 0)

               {   

                while ($row_progr = mysqli_fetch_array($result_comp_prog))

                   {

                     $comp_progr_id = $row_progr[0];

                      $comp_program_id2 = $row_progr[1];



                     header ("Location: update_comp_info_program_list.php?comp_id=$comp_id&program_id=$program_id_cp&comp_program_id=$comp_program_id&error=1&comp_name=$comp_name&program_code=$program_code"); 



                      echo "already exist"; 



                   

                    }

              }

          else{

          			//Update query company program

			$query_comp_info_company_program = "UPDATE company_program SET program_id = '$program_id',comp_program_status = '$comp_program_status' WHERE program_id = '$program_id_cp' AND comp_id = '$comp_id' AND comp_program_id = '$comp_program_id'";

			

		if($comp_program_status =="Not Active")

			{

				$query_ojt_offers_status_2 = "UPDATE ojt_offers

				SET status = 'Not Available' WHERE comp_id = '$comp_id' AND program_id = '$program_id_cp'";

			}else

			{

				$query_ojt_offers_status_2 = "UPDATE ojt_offers

				SET status = 'Available' WHERE comp_id = '$comp_id' AND program_id = '$program_id_cp'";

			}		



		$result_comp_info_company_program = mysqli_query($dbc,$query_comp_info_company_program);

		$result_ojt_offers_status2 = mysqli_query($dbc,$query_ojt_offers_status_2);

      



		if($result_comp_info_company_program && $result_ojt_offers_status2)

				{

					echo "updated program list";			

					header ("Location: company_manage_program.php?comp_id=$comp_id&updated=1&comp_name=$comp_name&program_code=$program_code"); 

					   

			

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

          }  



        }



          

	}



?>

