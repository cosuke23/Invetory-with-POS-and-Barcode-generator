<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_update_applicant']))
	{
		$aljf_id = $_POST['aljf_id'];
		$remarks = $_POST['remarks'];
		$others = $_POST['others'];
		$stud_no = $_POST['stud_no'];
		$student_name = $_POST['student_name'];

		$table = "applicant_list_jf";
		$columns = ["remarks"=>$remarks,"others"=>$others];
		$where = ["aljf_id"=>$aljf_id];
		$qData = $database->update($table,$columns,$where);
		header("location: e2e_company_applicant_list.php?success1=1&stud_no=$stud_no&student_name=$student_name");
	}
?>