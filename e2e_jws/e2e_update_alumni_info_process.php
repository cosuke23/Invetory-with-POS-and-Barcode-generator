<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_update_alumni_info']))
	{
		$stud_no = $_POST['stud_no'];
		$industry = $_POST['industry'];
		$remarks = $_POST['remarks'];
		$sub_class = $_POST['sub_class'];
		$student_name = $_POST['student_name'];
		$comp_name = $_POST['comp_name'];
		$work_status = $_POST['work_status'];
		$division = $_POST['division'];
		$alumni_id=$_POST['alumni_id'];
		$comp_address = $_POST['comp_address'];	
		$date_contact = $_POST['date_contact'];
		$industry = $_POST['industry'];
		$_POST['date_hired'];
		$no_month_hired_grad = $_POST['no_month_hired_grad'];
		$position = $_POST['position'];
		$date_hired = $_POST['date_hired'];

		if($work_status == "Continuing Study"){
			$F_date_hired = "none";
			$F_no_month_hired_grad = "none";
			$F_position = "Student";
		}else{
			$F_date_hired = $date_hired;
			$F_no_month_hired_grad = $no_month_hired_grad;
			$F_position = $position;
		}

		$table = "alumni_info";
			$columns = ["comp_name"=>$comp_name,"comp_address"=>$comp_address,"industry"=>$industry,"sub_class"=>$sub_class,"remarks"=>$remarks,"division"=>$division,"position"=>$F_position,"date_hired"=>$F_date_hired,"work_status"=>$work_status,"no_month_hired_grad"=>$F_no_month_hired_grad,"date_contact"=>$date_contact,"stud_no"=>$stud_no];
		$where = ["alumni_id"=>$alumni_id];
		$qData = $database->update($table,$columns,$where)or die (mysql_error());

		if($qData==true){
			echo "okay";
		}
		header("location: e2e_update_student_records.php?success_alumni=1&stud_no=$stud_no&student_name=$student_name");
	}
?>