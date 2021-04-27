<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];
$seminar_date =  date("Y-m-d");

if (isset($_POST['btn_add_seminar_attended2'])){
	$based_value = $_POST["based_value"];
	$stud_no = $_POST["stud_no"];
	$event_id = $_POST["event_id"];
	$acad_year_start_seminar = $_POST["acad_year_start_seminar"];
	$acad_year_end = $acad_year_start_seminar+1;
	$semester = $_POST["semester"];
	$sa_id = $_POST["sa_id"];
	$batch_active = $_POST["batch_active"];
	 $s2_timein = $_POST["s2_timein"];
	 $s2_timeout = $_POST["s2_timeout"];	 
	 $s2_status = $_POST["s2_status"];

	 $q_check_session = $database->query("SELECT * FROM event_manager WHERE status = 'Active'");
	foreach($q_check_session AS $q_checkData){
		$no_session = $q_checkData['no_session'];
		$event_name = $q_checkData['event_name'];
	}

if($based_value == 1){	 
	 $table_sa = "seminar_attended_2";
	$column_sa = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start_seminar,"acad_year_end"=>$acad_year_end,
	 "semester"=>$semester,"s2_timein"=>$s2_timein,"s2_timeout"=>$s2_timeout,"s2_status"=>$s2_status,"event_id"=>$event_id,"batch_id"=>$batch_active,"date_attended"=>$seminar_date];
	 $where = ["sa_id"=>$sa_id];
	 $q_add = $database->update($table_sa,$column_sa,$where);
	

	echo "success 1";
	header("location:e2e_student_records.php?stud_no=$stud_no&success_sa2=1&s2_status=$s2_status&s2_timein=$s2_timein");
	 exit;
  }else{
  	$q_check_session = $database->query("SELECT * FROM event_manager WHERE status = 'Active'");
	foreach($q_check_session AS $q_checkData){
		$no_session = $q_checkData['no_session'];
		$batch_active = $q_checkData['batch_active'];
	}
	if($no_session == 2){
		$s1_status = "Absent";
	}elseif($no_session == 1){
		$s1_status = "- - -";
	}

  	 $table_sa = "seminar_attended";
	 $column_sa = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start_seminar,"acad_year_end"=>$acad_year_end,
	 "semester"=>$semester,"s1_timein"=>0,"s1_timeout"=>0,"s1_status"=>$s1_status,"event_id"=>$event_id,"batch_id"=>$batch_active,"date_attended"=>$seminar_date];
	 $q_add = $database->insert($table_sa,$column_sa);

	  $table_sa2 = "seminar_attended_2";
	 $column_sa2 = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start_seminar,"acad_year_end"=>$acad_year_end,
	 "semester"=>$semester,"s2_timein"=>$s2_timein,"s2_timeout"=>$s2_timein,"s2_status"=>$s2_status,"event_id"=>$event_id,"batch_id"=>$batch_active,"date_attended"=>$seminar_date];
	 $q_add2 = $database->insert($table_sa2,$column_sa2);

	 echo "success 0";
	 header("location:e2e_student_records.php?stud_no=$stud_no&success_sa2=1&s2_status=$s2_status&s2_timein=$s2_timein");
	 exit;
  }
}

//header("location:e2e_student_records.php?stud_no=$stud_no&success_sa2=1&s2_status=$s2_status&s2_timein=$s2_timein");
?>