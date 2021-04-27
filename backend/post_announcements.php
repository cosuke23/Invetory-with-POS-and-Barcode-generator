<?php

// Start the session..
session_start();
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);

date_default_timezone_set("Asia/Manila");

if(isset($_POST['btn_post']))
	{
	
		$date_today = mysqli_real_escape_string($dbc, trim($_POST['date_today']));
		$announcement =  mysqli_real_escape_string($dbc, trim($_POST['announcement']));
		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
		$lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));
		$mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));
		$title =  mysqli_real_escape_string($dbc, trim($_POST['title']));
		$name = $title." ".$fname." ".$lname; 
		$date_today2 = date('Y-m-d', strtotime(str_replace('-', '/',$date_today)));
		$time = date('g:i:s A', time());	
		
		
		//$query_AYS = "SELECT active_semester,active_acad_year_start FROM active_semester_acad_year";
	//	$result_query_AYS =  mysqli_query($dbc, $query_AYS);         
      //    if($result_query_AYS->num_rows > 0)
      //         {   
//while ($row_active_ASY = mysqli_fetch_array($result_query_AYS))
     //              {
      //               $active_semester = $row_active_ASY[0]; 
	//				 $active_acad_year_start = $row_active_ASY[1]; 	
		//				$query_post = "INSERT INTO messages(name,message,date_posted,section_id,academic_year,semester,time_posted) VALUES
		//				('$name','$announcement','$date_today2','1','$active_acad_year_start','$active_semester','$time')";					 
       //             }
        //      }
		$q_post_announcement_active = "select * from active_semester_acad_year where status='Active'";
		$q_post_announcement_active_res = $dbc->query($q_post_announcement_active);
			if($q_post_announcement_active_res->num_rows > 0){
				$row=$q_post_announcement_active_res->fetch_assoc();
				$sem = $row['active_semester'];
				$acad_year = $row['active_acad_year_start'];
				$query_post = "INSERT INTO messages(name,message,date_posted,section_id,academic_year,semester,time_posted) VALUES
						('$name','$announcement','$date_today2','1','$acad_year','$sem','$time')";	
				
			}
		$q_post_announcement_ongoing = "select * from active_semester_acad_year where status='Ongoing'";
		$q_post_announcement_ongoing_res = $dbc->query($q_post_announcement_ongoing);
			if($q_post_announcement_ongoing_res->num_rows > 0){
				$row2=$q_post_announcement_ongoing_res->fetch_assoc();
				$sem2 = $row2['active_semester'];
				$acad_year2 = $row2['active_acad_year_start'];
				$query_post2 = "INSERT INTO messages(name,message,date_posted,section_id,academic_year,semester,time_posted) VALUES
						('$name','$announcement','$date_today2','1','$acad_year2','$sem2','$time')";	
				
			}
			
			
			//add query for company_info
			//$query_post = "INSERT INTO messages(name,message,date_posted,section_id,academic_year,semester,time_posted) VALUES
		//	('$name','$announcement','$date_today2','1','$active_acad_year_start','$active_semester','$time')";
		


		$result_post = mysqli_query($dbc,$query_post);
		$result_post2 = mysqli_query($dbc,$query_post2);
		if($result_post == true AND $result_post2 == true)
				{
					echo "Added";
					header("Location: admin_home.php?posted=1");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
 }	
?>