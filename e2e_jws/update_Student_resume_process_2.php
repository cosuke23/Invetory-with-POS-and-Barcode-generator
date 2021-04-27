<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
if (isset($_POST['btn_update_stud_resume'])){

	//$file_nameC =  $_POST['file_nameC'];
	$target_dir = "asset/resume_data/";
	$target_file = $target_dir . basename($_FILES["resume_data"]["name"]);
	$file_name=basename( $_FILES["resume_data"]["name"]);
	$resume_stud_no = $_POST['resume_stud_no'];
	$resume_link = $_POST['resume_link'];
	$resume_id = $_POST['resume_id'];


	if(empty($file_name) AND !empty($resume_link)){

		$table = "resume_data";
		$columns = ["resume_link"=>$resume_link];
		$where = ["resume_id"=>$resume_id];

		$q_resume_data=$database->update($table,$columns,$where);

		if($q_resume_data){
				echo "updated the resume link without resume data"."<br>";
				header("Location: e2e_student_home.php?success2=2");
				
		}else{
			echo "error in updating the resume link without resume data"."<br>";
		}
	}

	else if(!empty($file_name) AND empty($resume_link)){
		
		$table_del = "resume_data";
		$columns_del = ["file_name"];
		$where_del = ["resume_id"=>$resume_id];

		$q_resume=$database->select($table_del,$columns_del,$where_del);
			foreach($q_resume AS $q_resume_data){
				$file_name_get = $q_resume_data["file_name"];
			}
				if(unlink($target_dir.$file_name_get) === true){
					echo "file has been deleted"."<br>";
					header("Location: e2e_student_home.php?success2=2");
					
				} else{
					echo "error in deleting file..."."<br>";
				}

		//------------update file name
		$table_up = "resume_data";
		$columns_up = ["file_name"=>$file_name];
		$where_up = ["resume_id"=>$resume_id];

		$q_resume_data=$database->update($table_up,$columns_up,$where_up);

		if (move_uploaded_file($_FILES["resume_data"]["tmp_name"], $target_file)) {
				echo "file has been updated"."<br>";
			}
			if($q_resume_data){
					echo "updated file name"."<br>";
			}else{
				echo "error";
			}
			header("Location: e2e_student_home.php?success2=2");
		}
	
	else if(!empty($file_name) AND !empty($resume_link)){
		$table = "resume_data";
		$columns = ["resume_link"=>$resume_link];
		$where = ["resume_id"=>$resume_id];

		$q_resume_data=$database->update($table,$columns,$where);

		if($q_resume_data){
				echo "updated resume link"."<br>";
		}else{
			echo "error"."<br>";
		}
		//------------delete old file
		$table_del = "resume_data";
		$columns_del = ["file_name"];
		$where_del = ["resume_id"=>$resume_id];

		$q_resume=$database->select($table_del,$columns_del,$where_del);
			foreach($q_resume AS $q_resume_data){
				$file_name_get = $q_resume_data["file_name"];
			}
				if(unlink($target_dir.$file_name_get) === true){
					echo "file has been deleted"."<br>";
					
				} else{
					echo "error in deleting file..."."<br>";
				}
		//------------update file name
		$table_up = "resume_data";
		$columns_up = ["file_name"=>$file_name];
		$where_up = ["resume_id"=>$resume_id];

		$q_resume_data=$database->update($table_up,$columns_up,$where_up);

		if (move_uploaded_file($_FILES["resume_data"]["tmp_name"], $target_file)) {
				echo "file has been updated"."<br>";
			}
			if($q_resume_data){
					echo "updated file name"."<br>";
			}else{
				echo "error";
			}
			
			header("Location: e2e_student_home.php?success2=2");
		
	}
	else if(!empty($file_name)){
		
		$table_del = "resume_data";
		$columns_del = ["file_name"];
		$where_del = ["resume_id"=>$resume_id];

		$q_resume=$database->select($table_del,$columns_del,$where_del);
			foreach($q_resume AS $q_resume_data){
				$file_name_get = $q_resume_data["file_name"];
			}
				if(unlink($target_dir.$file_name_get) === true){
					echo "file has been deleted"."<br>";
				} else{
					echo "error in deleting file..."."<br>";
				}

		//------------update file name
		$table_up = "resume_data";
		$columns_up = ["file_name"=>$file_name];
		$where_up = ["resume_id"=>$resume_id];

		$q_resume_data=$database->update($table_up,$columns_up,$where_up);

		if (move_uploaded_file($_FILES["resume_data"]["tmp_name"], $target_file)) {
				echo "file has been updated";
			}
			if($q_resume_data){
					echo "updated file name"."<br>";
			}else{
				echo "error"."<br>";
			}
		}
		
			header("Location: e2e_student_home.php?success2=2");	
}
?>