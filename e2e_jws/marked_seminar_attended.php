<?php
require 'asset/connection/mysqli_dbconnection.php';
ini_set('max_execution_time', 1000000);
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];

if(isset($_GET['event_id']) && $_GET['batch_active'])
{
	$event_id = $_GET['event_id'];
	$batch_active = $_GET['batch_active'];
	$table_ev = "event_manager";
	$columns_ev = "*";
	$where_ev = ["event_id"=>$event_id];
	$s1_timein = "- - -";
	$s1_timeout = "- - -";
	//$s1_timein = '1484614800';
	//$s1_timeout = "1484625600";
	$s2_timein = "- - -";
	$s2_timeout = "- - -";
	$s1_status = "- - -";
    $s2_status = "- - -";

	$q_check_session = $database->query("SELECT * FROM event_manager WHERE event_id = '$event_id'");
	foreach($q_check_session AS $q_checkData){
		$no_session = $q_checkData['no_session'];
		$event_name = $q_checkData['event_name'];
	}
	

	$q_ev = $database->select($table_ev,$columns_ev,$where_ev);
	foreach($q_ev AS $q_ev_data){
		$acad_year_start_seminar = $q_ev_data["acad_year_start_seminar"];
		$semester = $q_ev_data["semester"];
		$acad_year_end = $acad_year_start_seminar +1;
		$event_id;
	}
		$table_si = "student_info";
		$columns_si ="*";
		$where_si = ["AND"=>["acad_year_start"=>$acad_year_start_seminar,"semester"=>$semester]];
		$q_si = $database->select($table_si,$columns_si,$where_si);

		foreach($q_si  as $q_si_data){
			$stud_no =  $q_si_data["stud_no"];
			$table_sa2 = "seminar_attended_2";
			$columns_sa2 = "*";
			$where_sa2 = ["AND"=>["event_id"=>$event_id,"stud_no"=>$stud_no,"semester"=>$semester]]; 
			$q_sa2 = $database->count($table_sa2,$columns_sa2,$where_sa2);
			 if($q_sa2 == ""){
				 $table_sa2 = "seminar_attended_2";
				 $column_sa2 = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start_seminar,"acad_year_end"=>$acad_year_end,
				 "semester"=>$semester,"s2_timein"=>$s2_timein,"s2_timeout"=>$s2_timeout,"s2_status"=>$s2_status,"event_id"=>$event_id,"batch_id"=>$batch_active];
				 $q_add = $database->insert($table_sa2,$column_sa2);
				 
              }

            $table_sa1 = "seminar_attended";
			$columns_sa1 = "*";
			$where_sa1 = ["AND"=>["event_id"=>$event_id,"stud_no"=>$stud_no,"semester"=>$semester]]; 
			$q_sa1 = $database->count($table_sa1,$columns_sa1,$where_sa1);
			 if($q_sa1 == ""){
				 $table_sa1 = "seminar_attended";
				 $column_sa1 = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start_seminar,"acad_year_end"=>$acad_year_end,
				 "semester"=>$semester,"s1_timein"=>$s1_timein,"s1_timeout"=>$s1_timeout,"s1_status"=>$s1_status,"event_id"=>$event_id,"batch_id"=>$batch_active];
				 $q_add = $database->insert($table_sa1,$column_sa1);
				 echo "pasok na!";
              }
		}
	$tbl = "audit_trail";
	$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Marked Data : Batch - ".$batch_active." from event ".$event_name."","module"=>"Marked Data Module"];
	$q_data = $database->insert($tbl,$columns);
		header("Location: e2e_student_records.php?marked=1");
		//header("Location: e2e_student_records.php?marked=0");	
}

?>