<?php
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_GET['aljf_id'])){
	$aljf_id = $_GET['aljf_id'];
	$job_fair_id = $_GET['job_fair_id'];
	$table = "applicant_list_jf";
	$where = ["aljf_id"=>$aljf_id];
	
		$q_update_total_attendees = $database->query("SELECT * FROM nop_job_fair WHERE job_fair_id = '$job_fair_id'")->fetchAll();
			foreach($q_update_total_attendees AS $q_data2){
				$total_attendees = $q_data2['total_attendees'];
			}

			$F_total = $total_attendees -1;

			$tbl2= "nop_job_fair";
			$col2= ["total_attendees"=>$F_total];
			$where2 = ["job_fair_id"=>$job_fair_id];
			$q_update_total_attendees = $database->update($tbl2,$col2,$where2);

	$qData = $database->delete($table,$where);
	header("location:e2e_company_applicant_list.php?deleted=1");
}

?>