<?php

// Start the session..

session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_add_stud_indv']))

	{

		$stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no_indv']));

		$lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));

		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));

		$mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));

		$program_code =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		$status =  mysqli_real_escape_string($dbc, trim($_POST['status']));



		$chk_stud ="SELECT stud_no FROM official_student_list WHERE stud_no ='$stud_no'";

			$result_chk_stud =  mysqli_query($dbc, $chk_stud);         

          if($result_chk_stud->num_rows > 0)

               {  

                while ($row_stud_no = mysqli_fetch_array($result_chk_stud))

                   {

                   	$stud_no_err= $row_stud_no[0];

                     header ("Location: add_indv_official_student_list.php?error1=1&stud_no=$stud_no_err&fname=$fname&mname=$mname&lname=$lname&program_code=$program_code");       

                    }

              }

         else{

         	$query_add_indv_student = "INSERT INTO official_student_list(	stud_no,lname,fname,mname,program_code,status)

									VALUES('".ucfirst(strtolower($stud_no))."','".ucfirst(strtolower($lname))."',

									'".ucfirst(strtolower($fname))."','".ucfirst(strtolower($mname))."','".ucfirst(strtolower($program_code))."','".ucfirst(strtolower($status))."')";

		$result_add_indv_student = mysqli_query($dbc,$query_add_indv_student);

			if($result_add_indv_student)

			{

				header ("Location: upload.php?success5=1&stud_no=$stud_no&fname=$fname&mname=$mname&lname=$lname&program_code=$program_code");

			}else{

				echo mysql_errno();

			}

         }	

	}

?>

