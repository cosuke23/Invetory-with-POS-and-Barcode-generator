<?php
date_default_timezone_set('Asia/Manila');
	require 'assets/connection/mysqli_dbconnection.php';
	
		if(isset($_POST['btn_submit_resume']))
		{
			$stud_no = $_POST['stud_no'];
			
			$resume_file = (file_get_contents($_FILES['resume_file']['tmp_name']));
			$file_typex= basename($_FILES["resume_file"]["name"]);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);
			$filename = "files/resume/".$stud_no.".docx";
				
			
			if(!empty($resume_file)){
				if($type != "docx"){
					header("Location:upload_resume.php?error_invalid=Invalid File Selected!");
					
				}else{
				$status=2;
				$q_insert_resume = "INSERT INTO student_resume_data (resume_status,resume_remarks,stud_no)values('Approved','$status','$stud_no')";
				$q_insert_resume_res = $dbc->query($q_insert_resume);
					if($q_insert_resume_res == true)
					file_put_contents($filename, $resume_file);
					chmod($filename, 0666);
					clearstatcache();
					header("Location:upload_resume.php");
				}
			}else{
				header("Location:upload_resume.php?error_no_file=No File Selected!");
				
			}
		}
		if(isset($_POST['btn_update_resume']))
		{
			$stud_no = $_POST['stud_no'];
			$resume_file = (file_get_contents($_FILES['resume_file']['tmp_name']));
			$file_typex= basename($_FILES["resume_file"]["name"]);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);
			$filename = "files/resume/".$stud_no.".docx";
			
			if(!empty($resume_file)){
				if($type != "docx"){
					header("Location:upload_resume.php?error_invalid=Invalid File Selected!");
					
				}else{
				
				$q_insert_resume = "update student_resume_data set resume_status='1',resume_remarks='' where stud_no='$stud_no'";
				$q_insert_resume_res = $dbc->query($q_insert_resume);
					if($q_insert_resume_res == true)
					file_put_contents($filename, $resume_file);
					chmod($filename, 0666);
					clearstatcache();
					header("Location:upload_resume.php");
				}
			}else{
				header("Location:upload_resume.php?error_no_file=No File Selected!");
				
			}
		}
?>