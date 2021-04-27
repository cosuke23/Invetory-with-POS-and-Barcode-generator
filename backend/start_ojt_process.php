<?php
// Start the session..
session_start();
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);



if(isset($_POST['btn_add_start_ojt']))
	{
		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id-hidden']));
		$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no_records']));
	    $ojt_start_date = mysqli_real_escape_string($dbc, trim($_POST['ojt_start_date']));

	    
	    $ojt_start_date2 = date('Y-m-d', strtotime(str_replace('-', '/', $ojt_start_date)));

	    $acad_year_start_rd = mysqli_real_escape_string($dbc, trim($_POST['acad_year_start_rd']));
	    $acad_year_end_rd = mysqli_real_escape_string($dbc, trim($_POST['acad_year_end_rd']));
	   	$semester_rd = mysqli_real_escape_string($dbc, trim($_POST['semester_rd']));
	    $comp_ojt_stud_id =  mysqli_real_escape_string($dbc, trim($_POST['comp_ojt_stud_id']));

		$query_comp_name_start = "SELECT comp_name FROM company_info WHERE comp_id = '$comp_id'";
    	 $result_comp_name_start =  mysqli_query($dbc, $query_comp_name_start);         
          if($result_comp_name_start->num_rows > 0)
               {   
                while ($row4 = mysqli_fetch_array($result_comp_name_start))
                   {
                     $comp_name_start = $row4[0];      
                    }
              }

			$query_company_ojt_student_update = "UPDATE company_ojt_student SET comp_id = '$comp_id',ojt_start_date = '$ojt_start_date2', status = 'Ongoing' WHERE acad_year_start = '$acad_year_start_rd' AND semester = '$semester_rd' AND comp_ojt_stud_id = '$comp_ojt_stud_id' AND stud_no = '$stud_no'";

		$result_company_ojt_student = mysqli_query($dbc,$query_company_ojt_student_update);
		if($result_company_ojt_student)
				{
					echo "Added to company_program";
					header("Location: adviser_update_student_records.php?acad_year_start_rd=$acad_year_start_rd&semester_rd=$semester_rd&stud_no_records=$stud_no&added=1&comp_name_start=$comp_name_start&ojt_start_date=$ojt_start_date");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
			
	}
?>
