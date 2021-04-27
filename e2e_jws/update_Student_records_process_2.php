<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
ini_set('max_execution_time', 100000);
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_stud_info']))
	{
		$stud_no =  $_POST['stud_no'];
		$lname = $_POST['lname'];
		$fname =  $_POST['fname'];
		$mname =  $_POST['mname'];
		$gender =  $_POST['gender'];
		$bday =  $_POST['bday'];
		$program_id =  $_POST['program_id'];
		$semester =  $_POST['semester'];
		$acad_year_start =  $_POST['acad_year_start'];
		$acad_year_end =  $_POST['acad_year_end'];
		$year =  $_POST['year'];

		$email =  $_POST['email'];
		$contact_no =  $_POST['contact_no'];
		$address =  $_POST['address'];
		$fb_link =  $_POST['fb_link'];
		//$resume_link =  $_POST['resume_link'];

		//$bday2 = date('Y-m-d', strtotime(str_replace('-', '/', $bday)));

		$target_dir_dp = "grad_id/grad_data/student_image/";
		$target_file_dp = $target_dir_dp . basename($_FILES["stud_dp"]["name"]);
		$file_name_dp=basename( $_FILES["stud_dp"]["name"]);

		echo $file_name_dp;
		if(!empty($file_name_dp))
		{
			$table_del = "student_info";
			$columns_del = ["stud_dp"];
			$where_del = ["stud_no"=>$stud_no];

			$q_dp=$database->select($table_del,$columns_del,$where_del);
				foreach($q_dp AS $q_dData){
					$file_name_get = $q_dData["stud_dp"];

				}
					if(unlink($target_dir_dp.$file_name_get) === true){
						echo "file has been deleted"."<br>";
						//header("Location: e2e_update_student_records.php?stud_no=$stud_no&success2=2");
						
					} else{
						echo "error in deleting file..."."<br>";
					}
			//------------update file name
			$table_up = "student_info";
			$columns_up = ["stud_dp"=>$file_name_dp];
			$where_up = ["stud_no"=>$stud_no];

			$q_resume_data=$database->update($table_up,$columns_up,$where_up);

			if (move_uploaded_file($_FILES["stud_dp"]["tmp_name"], $target_file_dp)) {
					echo "file has been updated"."<br>";
				}

			$table = "student_info";
			$columns = ["lname"=>$lname,"fname"=>$fname,"mname"=>$mname,"gender"=>$gender,"bday"=>$bday,
						"program_id"=>$program_id,"semester"=>$semester,
						"acad_year_start"=>$acad_year_start,"acad_year_end"=>$acad_year_end,
						"email"=>$email,"contact_no"=>$contact_no,"address"=>$address,"fb_link"=>$fb_link,
						"fb_link"=>$fb_link,"stud_dp"=>$file_name_dp,"year"=>$year];
			$where = ["stud_no" => $stud_no];
			$q_data = $database->update($table,$columns,$where);

			$table2 = "alumni_grad_info";
			$columns2 = ["program_id"=>$program_id];
			$where2 = ["stud_no" => $stud_no];
			$q_data2 = $database->update($table2,$columns2,$where2);

			header("Location: e2e_student_home.php?success1=1&stud_no=$stud_no&lname=$lname&fname=$fname&mname=$mname");

		}else{

			$table = "student_info";
			$columns = ["lname"=>$lname,"fname"=>$fname,"mname"=>$mname,"gender"=>$gender,"bday"=>$bday,
						"program_id"=>$program_id,"semester"=>$semester,
						"acad_year_start"=>$acad_year_start,"acad_year_end"=>$acad_year_end,
						"email"=>$email,"contact_no"=>$contact_no,"address"=>$address,"fb_link"=>$fb_link,
						"fb_link"=>$fb_link,"year"=>$year];
			$where = ["stud_no" => $stud_no];
			$q_data = $database->update($table,$columns,$where);

			$table2 = "alumni_grad_info";
			$columns2 = ["program_id"=>$program_id];
			$where2 = ["stud_no" => $stud_no];
			$q_data2 = $database->update($table2,$columns2,$where2);
			
		   	header("Location: e2e_student_home.php?success1=1&stud_no=$stud_no&lname=$lname&fname=$fname&mname=$mname");
		}			
	}
?>
