<?php

// Start the session..

session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_ojt_adviser_section_handled']))

	{

		$adviser_id =  mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));

		$acad_year_start =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));

		$semester_ash =  mysqli_real_escape_string($dbc, trim($_POST['semester_ash']));

		$section_id =  mysqli_real_escape_string($dbc, trim($_POST['section_id']));

		$status_ash =  mysqli_real_escape_string($dbc, trim($_POST['status_ash']));

		$semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));

		$ash_id =  mysqli_real_escape_string($dbc, trim($_POST['ash_id']));



		

	if($status_ash=="Active")

	{



		$query_select_ash_status="SELECT section_id,semester,acad_year_start,program_id FROM adviser_section_handled WHERE 

		section_id = '$section_id' AND acad_year_start = '$acad_year_start' AND semester = '$semester' AND adviser_id ='$adviser_id' AND status='Active'";

		$result_select_ash_status =  mysqli_query($dbc, $query_select_ash_status); 

		   if($result_select_ash_status->num_rows > 0 )

	            {   

	              while ($row_asg_status = mysqli_fetch_array($result_select_ash_status))

	              {

	                 	$section_id_stat =  $row_asg_status[0];  

	                    $semester_stat =  $row_asg_status[1];

	                    $acad_year_start_stat =  $row_asg_status[2];

	                    $program_id =  $row_asg_status[3]; 

	                   	

	                    header("Location:update_ojt_adviser_section_handled.php?acad_year_start=$acad_year_start&semester=$semester&adviser_id=$adviser_id&section_id=$section_id&error1=1");

	                    echo "error";	        

			   	  }

	 		    }



	 		else{



			//Update query for OJT adviser section handled

			$query_OJT_adviser_section_handled = "UPDATE adviser_section_handled SET section_id = '$section_id',status = '$status_ash',semester = '$semester' WHERE adviser_id = '$adviser_id' AND acad_year_start = '$acad_year_start' AND semester = '$semester_ash' AND ash_id = '$ash_id'";	





		$result_OJT_adviser_section_handled = mysqli_query($dbc,$query_OJT_adviser_section_handled);

		if($result_OJT_adviser_section_handled)

				{

					echo "updated ojt adviser section handled success";

					header("Location:section_handled.php?adviser_id=$adviser_id&success=1");

					

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

		}



	}

	else if($status_ash=="Not Active")

	{



		$query_select_ash_status="SELECT section_id,semester,acad_year_start,program_id FROM adviser_section_handled WHERE 

		section_id = '$section_id' AND acad_year_start = '$acad_year_start' AND semester = '$semester' AND adviser_id ='$adviser_id' AND status='Not Active'";

		$result_select_ash_status =  mysqli_query($dbc, $query_select_ash_status); 

		   if($result_select_ash_status->num_rows > 0 )

	            {   

	              while ($row_asg_status = mysqli_fetch_array($result_select_ash_status))

	              {

	                 	$section_id_stat =  $row_asg_status[0];  

	                    $semester_stat =  $row_asg_status[1];

	                    $acad_year_start_stat =  $row_asg_status[2];

	                    $program_id =  $row_asg_status[3]; 

	                   	

	                    header("Location:update_ojt_adviser_section_handled.php?acad_year_start=$acad_year_start&semester=$semester&adviser_id=$adviser_id&section_id=$section_id&error2=1");	

	                    echo "error2";       

			   	  }

	 		    }

	 		else{



			//Update query for OJT adviser section handled

			$query_OJT_adviser_section_handled = "UPDATE adviser_section_handled SET section_id = '$section_id',status = '$status_ash',semester = '$semester' WHERE adviser_id = '$adviser_id' AND acad_year_start = '$acad_year_start' AND semester = '$semester_ash' AND ash_id = '$ash_id'";	



		$result_OJT_adviser_section_handled = mysqli_query($dbc,$query_OJT_adviser_section_handled);

		if($result_OJT_adviser_section_handled)

				{

					echo "updated ojt adviser section handled success";

					header("Location:section_handled.php?adviser_id=$adviser_id&success=1");



				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

		}

	  }

	}

?>

