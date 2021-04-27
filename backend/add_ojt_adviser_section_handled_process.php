<?php

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';

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



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_add_ojt_adviser_section_handled']))

	{

		$adviser_id =  mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));

		$acad_year_start =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));

    	$acad_year_end =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_end']));

		$semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));

		$section_id =  mysqli_real_escape_string($dbc, trim($_POST['section_id']));

		$program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		$status_ash =  mysqli_real_escape_string($dbc, trim($_POST['status_ash']));

			//add query for OJT adviser section handled



		$query_select_ash_status="SELECT section_id,semester,acad_year_start,program_id FROM adviser_section_handled WHERE 

		section_id = '$section_id' AND acad_year_start = '$acad_year_start' AND semester = '$semester' AND adviser_id ='$adviser_id'";

		$result_select_ash_status =  mysqli_query($dbc, $query_select_ash_status); 

		   if($result_select_ash_status->num_rows > 0 )

	            {   

	              while ($row_asg_status = mysqli_fetch_array($result_select_ash_status))

	              {

	                 	$section_id_stat =  $row_asg_status[0];  

	                    $semester_stat =  $row_asg_status[1];

	                    $acad_year_start_stat =  $row_asg_status[2];

	                    $program_id =  $row_asg_status[3]; 

	                   	

	                    header("Location:add_OJT_adviser_section_handled.php?adviser_id=$adviser_id&error=1");	        

			   	  }

	 		    }

	 		    else

	 		    {

	 		    	$ash_id = generateId($dbc, 'ash_id','adviser_section_handled');



						$add_OJT_adviser_section_handled = "INSERT INTO adviser_section_handled(adviser_id,section_id,semester,acad_year_start,acad_year_end,program_id,status,ash_id) VALUES

						('$adviser_id','$section_id','$semester','$acad_year_start','$acad_year_end','$program_id','$status_ash','$ash_id')";



					$result_OJT_adviser_section_handled = mysqli_query($dbc,$add_OJT_adviser_section_handled);		

					

					if($result_OJT_adviser_section_handled)

							{

								echo "add ojt adviser section handled success";

								header("Location:section_handled.php?adviser_id=$adviser_id&success2=1");

							}

						else	

						{

							

						}	



	 		    }



			

			

	}

?>

