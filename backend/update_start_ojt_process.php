<?php
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

if(isset($_POST['btn_update_start_ojt']))
	{
		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id-hidden']));
		$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no_records']));
	    $ojt_start_date = mysqli_real_escape_string($dbc, trim($_POST['ojt_start_date']));
	    $acad_year_start_rd = mysqli_real_escape_string($dbc, trim($_POST['acad_year_start_rd']));
	   	$semester_rd = mysqli_real_escape_string($dbc, trim($_POST['semester_rd']));

	    $comp_ojt_stud_id = mysqli_real_escape_string($dbc, trim($_POST['c_ojt_stud_comp_id']));

		$ojt_start_date2 = date('Y-m-d', strtotime(str_replace('-', '/', $ojt_start_date)));

		$query_comp_name_start = "SELECT comp_name FROM company_info WHERE comp_id = '$comp_id'";
    	 $result_comp_name_start =  mysqli_query($dbc, $query_comp_name_start);         
          if($result_comp_name_start->num_rows > 0)
               {   
                while ($row4 = mysqli_fetch_array($result_comp_name_start))
                   {
                     $comp_name_start = $row4[0];      
                    }
              }
            
			$query_company_ojt_student_update = "UPDATE company_ojt_student SET comp_id = '$comp_id' , ojt_start_date = '$ojt_start_date2' WHERE comp_ojt_stud_id = '$comp_ojt_stud_id' AND acad_year_start = '$acad_year_start_rd' AND semester = '$semester_rd' AND stud_no ='$stud_no'";

		$result_company_ojt_student_update = mysqli_query($dbc,$query_company_ojt_student_update);
		if($result_company_ojt_student_update)
				{
					$success = "update to company_program";
					header("Location: adviser_update_student_records.php?acad_year_start_rd=$acad_year_start_rd&semester_rd=$semester_rd&stud_no_records=$stud_no&success=1&comp_name_start=$comp_name_start");
					echo "success";
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
			
	}
?>
