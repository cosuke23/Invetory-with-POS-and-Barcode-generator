<?php
require 'asset/connection/mysqli_dbconnection.php';

date_default_timezone_set("Asia/Manila");

if(isset($_POST['btn_post']))
	{
		$date_today = mysqli_real_escape_string($dbc, trim($_POST['date_today']));
		$announcement =  mysqli_real_escape_string($dbc, trim($_POST['announcement']));
		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
		$lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));
		$mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));
		$title =  mysqli_real_escape_string($dbc, trim($_POST['title']));
		$section_id =  $_POST['section_id'];
		$adviser_id =  $_POST['adviser_id'];
		$name = $title." ".$fname." ".$lname; 
		$date_today2 = date('Y-m-d', strtotime(str_replace('-', '/',$date_today)));
		$time = date('g:i:s A', time());
		foreach($_POST["section_id"] as $section_id)  
			{  
		$query_AYS = "SELECT semester,acad_year_start FROM adviser_section_handled where adviser_id='$adviser_id' AND status='Active' AND section_id='$section_id'";
		$result_query_AYS =  mysqli_query($dbc, $query_AYS);         
          if($result_query_AYS->num_rows > 0)
               {  
				
                while ($row_active_ASY = mysqli_fetch_array($result_query_AYS))
                   {
                     $active_semester = $row_active_ASY[0]; 
					 $active_acad_year_start = $row_active_ASY[1]; 	
					
						   $query_post = "INSERT INTO messages(name,message,date_posted,section_id,academic_year,semester,time_posted) VALUES
							('$name','$announcement','$date_today2','$section_id','$active_acad_year_start','$active_semester','$time')";
								$result_post = mysqli_query($dbc,$query_post);
					  }
					 
                 }
            }
			
		
		
		if($result_post)
				{
					echo "Added";
					header("Location: adviser_home.php?posted=1");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}
 }	
?>