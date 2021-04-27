<?php
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_resume_status']))
	{
		$stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
		$lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));
		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
		$mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));
		$resume_status =  mysqli_real_escape_string($dbc, trim($_POST['resume_status']));
		$resume_remarks = mysqli_real_escape_string($dbc, trim($_POST['resume_remarks']));
		echo $stud_no;
			//Update query for student_info
			if($resume_status!=3)
			{
					$query_resume_status_update = "UPDATE student_resume_data SET resume_status = '$resume_status', resume_remarks ='' WHERE stud_no = '$stud_no'";
					

					$result_update_resume_status = mysqli_query($dbc,$query_resume_status_update);
					
					if($resume_status==2){
						$query_resume_status_update2 = "UPDATE student_checklist AS a INNER JOIN student_ojt_records AS b ON a.stud_no = b.stud_no SET a.date_submitted = '$date_today', a.remarks = 'Completed' WHERE b.ojt_status = 'Ongoing' AND a.stud_no ='$stud_no' AND a.deliverable_id = '2' AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester";
					

								$result_update_resume_status2 = mysqli_query($dbc,$query_resume_status_update2);
						
								
							if($result_update_resume_status2 && $result_update_resume_status)
									{
										echo "update the checklist of the resume ok";
										
										header("Location: student_resume_data.php?aprroved=1&stud_no=$stud_no&lname=$lname&fname=$fname&mname=$mname");
										
									}
								else	
								{
									echo "query error failed please try again.."; 
								}	

					}

		
			}
			if($resume_status==3)
			{
					if($resume_remarks!="")
					{
						$query_resume_status_update = "UPDATE student_resume_data SET resume_status = '$resume_status', resume_remarks = '$resume_remarks' WHERE stud_no = '$stud_no'";
						
						$result_update_resume_status = mysqli_query($dbc,$query_resume_status_update);
					
							
						if($result_update_resume_status)
						{
							echo "ok";
									
							header("Location: student_resume_data.php?rejected=1&stud_no=$stud_no&lname=$lname&fname=$fname&mname=$mname");

									
						}
						else	
						{
							echo "query error failed please try again.."; 
						}	
					}else{
						//header("Location: update_student_resume_status.php?stud_no=$stud_no&comstart= &comend2= &resume_status=3");
					}
			}
	}
?>
