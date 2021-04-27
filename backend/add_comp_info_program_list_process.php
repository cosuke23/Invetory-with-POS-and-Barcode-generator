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



if(isset($_POST['btn_add_comp_info_program_program_list']))

	{

		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));

		$comp_name = mysqli_real_escape_string($dbc, trim($_POST['comp_name']));

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



		

		$query_comp_prog = "SELECT comp_id,program_id,comp_program_id FROM company_program WHERE comp_id='$comp_id' AND program_id = '$program_id'";

		$result_comp_prog =  mysqli_query($dbc, $query_comp_prog);         

          if($result_comp_prog->num_rows > 0)

               {   

                while ($row_progr = mysqli_fetch_array($result_comp_prog))

                   {

                     $comp_prog_id = $row_progr[0];

                      $comp_program_id2 = $row_progr[1];

                       $comp_program_id3 = $row_progr[2];

                     header ("Location: add_comp_info_program_list.php?comp_id=$comp_id&error=1&comp_name=$comp_name&program_code=$program_code");  



                     echo 'error';    

                    }

              }

           else{

           	 $comp_program_id = generateId($dbc, 'comp_program_id','company_program');

			//Update query company program

			$query_add_comp_info_company_program = $query4 = "INSERT INTO company_program(comp_id,program_id,comp_program_status,comp_program_id) VALUES

			('$comp_id','$program_id','$comp_program_status','$comp_program_id')";

			$result_add_comp_info_company_program = mysqli_query($dbc,$query_add_comp_info_company_program);



		  



		if($result_add_comp_info_company_program)

				{

					echo "successfully added";			

						header ("Location: company_manage_program.php?comp_id=$comp_id&added=1&comp_name=$comp_name&program_code=$program_code");  

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

			





           }   



             

	}



?>

