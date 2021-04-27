<?php
require 'asset/connection/mysqli_dbconnection.php';


if(isset($_POST['btn_add_applicant']))
	{
		$stud_no = $_POST['stud_no'];
		$remarks = $_POST['remarks'];
		$others = $_POST['others'];
		$job_fair_id = $_POST['job_fair_id'];
		$comp_id = $_POST['comp_id'];
		$student_name = $_POST['student_name'];
		$event_id = $_POST['event_id'];

		if($others == ""){
			$F_others = "none";
		}else{
			$F_others = $others;
		}
			$table = "applicant_list_jf";
			$columns = ["stud_no"=>$stud_no,"job_fair_id"=>$job_fair_id,"remarks"=>$remarks,"others"=>$F_others,"comp_id"=>$comp_id,"event_id"=>$event_id];
			$q_data = $database->insert($table,$columns);

			$q_update_total_attendees = $database->query("SELECT * FROM nop_job_fair WHERE job_fair_id = '$job_fair_id'")->fetchAll();
			foreach($q_update_total_attendees AS $q_data2){
				$total_attendees = $q_data2['total_attendees'];
			}

			$F_total = $total_attendees +1;

			$tbl2= "nop_job_fair";
			$col2= ["total_attendees"=>$F_total];
			$where2 = ["job_fair_id"=>$job_fair_id];
			$q_update_total_attendees = $database->update($tbl2,$col2,$where2);

			header("Location: e2e_company_add_applicant.php?success=1&stud_no=$stud_no&student_name=$student_name");

			if($q_data == true){
				echo "true";
			}else{
				echo "false";
			}
	}
?>