<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
ini_set('max_execution_time', 100000);
$date_today = date("m/d/Y");
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_add_stud_info_2']))
	{
		$stud_no =  $_POST['stud_no'];
		$lname = ucwords(strtolower($_POST['lname']));
		$fname = ucwords(strtolower($_POST['fname']));
		$mname = ucwords(strtolower($_POST['mname']));
		$gender =  $_POST['gender'];
		$bday =  $_POST['bday'];
		$program_id =  $_POST['program_id'];
		$semester =  $_POST['semester'];
		$acad_year_start =  $_POST['acad_year_start'];
		$acad_year_end =  $_POST['acad_year_end'];
		$year =  $_POST['year'];

		$email =  $_POST['email'];
		$contact_no =  $_POST['contact_no'];
		$address =  ucwords(strtolower($_POST['address']));
		$fb_link =  $_POST['fb_link'];
		$resume_link =  $_POST['resume_link'];
		

		//$target_dir = "asset/resume_data/";
		//$target_file = $target_dir . basename($_FILES["resume_data"]["name"]);
		//$file_name=basename( $_FILES["resume_data"]["name"]);

		//$target_dir_dp = "grad_id/grad_data/student_image/";
		//$target_file_dp = $target_dir_dp . basename($_FILES["stud_dp"]["name"]);
		//$file_name_dp=basename( $_FILES["stud_dp"]["name"]);

		$bday2 = strtotime($bday);
		$valid = "968774400";
    		if($bday2 > $valid){
    			header("Location: student_registration_2.php?error=1&stud_no=$stud_no");
    		exit;

   			 }

			$q_data = $database->insert("student_info",[
										"lname" => $lname,
										"fname" => $fname,
										"mname" => $mname,
										"gender" => $gender,
										"bday" => $bday,
										"program_id" => $program_id,
										"semester" => $semester,
										"acad_year_start" => $acad_year_start,
										"acad_year_end" => $acad_year_end,
										"email" => $email,
										"contact_no" => $contact_no,
										"address" => $address,
										"fb_link" => $fb_link,
										"address" => $address,
										"stud_no" => $stud_no,
										"year" => $year,
										"stud_dp" => 'DEFAULT.jpg',
										"count_id" => "0",
										"claim_status" => "0",
										"password" => $mname,
										"date_added" => $date_today
									]);


				//if (move_uploaded_file($_FILES["resume_data"]["tmp_name"], $target_file)) 
				//{
					$q_data_resume = $database->insert("resume_data",[
										"file_name" =>'NO_RESUME.pdf',
										"stud_no" => $stud_no,
										"resume_link" => $resume_link
									]);
									if($q_data_resume){
										echo "added";
									}else{
										echo "error";
									}
				//} 
				//if (move_uploaded_file($_FILES["stud_dp"]["tmp_name"], $target_file_dp)) 
				//{
					//echo "MOVED";
				//}
			$tbl_yb_gp = "alumni_year_book_grad_pic";
			$columns_yb_gp = ["stud_no"=>$stud_no];
			$q_data_yb_gp = $database->insert($tbl_yb_gp,$columns_yb_gp);

			$tbl_grad_info = "alumni_grad_info";
			$columns_grad_info = ["stud_no"=>$stud_no,"semester"=>$semester,"acad_year_start"$acad_year_start,"acad_year_end"=>$acad_year_end,"program_id"=>$program_id];
			$q_data_grad_info = $database->insert($tbl_grad_info,$columns_grad_info);
			
			header("Location: student_registration_2.php?success=1&stud_no=$stud_no&lname=$lname&fname=$fname&mname=$mname");		
	}
?>
