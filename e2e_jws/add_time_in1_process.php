<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];
if (isset($_POST['btn_add_seminar_attended'])){

	 $stud_no = $_POST["stud_no"];
	 $s1_timein = $_POST["s1_timein"];
	 $s1_timeout = $_POST["s1_end"];
	 $event_id = $_POST["event_id"];
	 $s1_status = $_POST["s1_status"];
	 $acad_year_start_seminar = $_POST["acad_year_start_seminar"];
	 $acad_year_end = $acad_year_start_seminar+1;
	 $batch_active = $_POST["batch_active"];
	 $semester = $_POST["semester"];

	$q_check_session = $database->query("SELECT * FROM event_manager WHERE status = 'Active'");
	foreach($q_check_session AS $q_checkData){
		$no_session = $q_checkData['no_session'];
		$event_name = $q_checkData['event_name'];
	}
	if($no_session == 2){
		$s2_status = "Absent";
	}elseif($no_session == 1){
		$s2_status = "- - -";
	}

	$seminar_date =  date("Y-m-d");

	 $table_sa = "seminar_attended";
	 $column_sa = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start_seminar,"acad_year_end"=>$acad_year_end,
	 "semester"=>$semester,"s1_timein"=>$s1_timein,"s1_timeout"=>$s1_timeout,"s1_status"=>$s1_status,"event_id"=>$event_id,"batch_id"=>$batch_active,"date_attended"=>$seminar_date];
	 $q_add = $database->insert($table_sa,$column_sa);

	  $table_sa2 = "seminar_attended_2";
	 $column_sa2 = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start_seminar,"acad_year_end"=>$acad_year_end,
	 "semester"=>$semester,"s2_timein"=>0,"s2_timeout"=>0,"s2_status"=>$s2_status,"event_id"=>$event_id,"batch_id"=>$batch_active,"date_attended"=>$seminar_date];
	 $q_add2 = $database->insert($table_sa2,$column_sa2);


	 if($q_add == true AND $q_add2 == true){
	 	echo "true";
	 }else{
	 	echo "error";
	 }
}
header("location:e2e_student_records.php?stud_no=$stud_no&success_sa=1&s1_status=$s1_status&s1_timein=$s1_timein");
?>