<?php
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_add_applicant_admin'])){

	$event_id = $_POST['event_id'];
	$comp_id = $_POST['comp_id-hidden'];
	$stud_no = $_POST['stud_no'];
	$student_name = $_POST['student_name'];
	$remarks = $_POST['remarks'];
	$others = $_POST['others'];
	$job_fair_id = $_POST['job_fair_id'];
	
	if($others == ""){
		$F_others = "none";
	}else{
		$F_others = $others;
	}

	$nop = $database->query("SELECT count(a.comp_id) As count FROM nop_job_fair As a INNER JOIN event_manager As b where a.event_id = b.event_id AND b.status = 'Active' AND a.comp_id = '$comp_id'")->fetchAll();
	foreach($nop As $nop_data){
		$count = $nop_data['count'];
	}

	$applicant_list_jf = $database->query("SELECT count(stud_no) AS count_app_jf FROM applicant_list_jf WHERE stud_no = '$stud_no' AND event_id = '$event_id' AND comp_id = '$comp_id'")->fetchAll();
	foreach($applicant_list_jf As $applicant_list_jf_data){
		$count2 = $applicant_list_jf_data['count_app_jf'];
	}
	
	$q_update_total_attendees = $database->query("SELECT * FROM nop_job_fair WHERE job_fair_id = '$job_fair_id'")->fetchAll();
			foreach($q_update_total_attendees AS $q_data2){
				$total_attendees = $q_data2['total_attendees'];
			}

			$F_total = $total_attendees +1;

			$tbl2= "nop_job_fair";
			$col2= ["total_attendees"=>$F_total];
			$where2 = ["job_fair_id"=>$job_fair_id];
			$q_update_total_attendees = $database->update($tbl2,$col2,$where2);
			
	echo $count2;

	if($count2 >= 1){
			
		header("location: e2e_update_student_records.php?error2_add_jf=1&stud_no=$stud_no&student_name=$student_name");
		exit;
		}

	if($count == 1){
			$q_nop_jf = $database->query("SELECT a.* FROM nop_job_fair AS a INNER JOIN event_manager AS b WHERE b.status = 'Active' AND a.comp_id = '$comp_id' AND b.event_id = '$event_id' AND a.event_id = b.event_id")->fetchAll();
                       foreach($q_nop_jf AS $Data_jf){
                         $job_fair_id = $Data_jf['job_fair_id'];
                       }
             $q_Data = $database->insert("applicant_list_jf",
      		["stud_no"=>$stud_no,"event_id"=>$event_id,"comp_id"=>$comp_id,"remarks"=>$remarks,"others"=>$F_others,"job_fair_id"=>$job_fair_id]);

			header("location: e2e_update_student_records.php?success_add_jf=1&stud_no=$stud_no&student_name=$student_name");
			exit;
     }
		else{
		header("location: e2e_update_student_records.php?error_add_jf=1&stud_no=$stud_no");
	}

	
}
?>