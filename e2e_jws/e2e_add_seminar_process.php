<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';
	$date_today =  date("Y-m-d");

	$table = "nop_seminar";
	$columns = "seminar_id";
	$seminar_id = $database->max($table,$columns) + 1;

	error_reporting(E_ALL | E_STRICT);
	if(isset($_POST['btn_add_seminar'])){
		$comp_id = $_POST["comp_id"];
		$sem = $_POST["sem"];
		$speaker1 = $_POST["speaker1"];
		$topic1 = $_POST["topic1"];
		$speaker2 = $_POST["speaker2"];
		$topic2 = $_POST["topic2"];
		$speaker3 = $_POST["speaker3"];
		$topic3 = $_POST["topic3"];

		$table = "event_manager";
		$columns = "*";
		$where = ["event_id" => $sem];
		$q_sem =$database->select($table,$columns,$where);

		foreach ($q_sem AS $q_sem_data) {
			$acad_year_start_seminar = $q_sem_data['acad_year_start_seminar'];
			$acad_year_end_seminar = $q_sem_data['acad_year_end_seminar'];
			$semester = $q_sem_data['semester'];
		}

		$data = $database->insert("nop_seminar",[
		"seminar_id"     			 			=>  $seminar_id,
		"comp_id"              			=>  $comp_id,
		"event_id"             			=>  $sem,
		"speaker1"             			=>  $speaker1,
		"topic1"            	 			=>  $topic1,
		"topic2"            	 			=>  $topic2,
		"speaker2"             			=>  $speaker2,
		"topic3"            	 			=>  $topic3,
		"speaker3"             			=>  $speaker3,
		"acad_year_start_seminar"   =>  $acad_year_start_seminar,
		"acad_year_end_seminar"     =>  $acad_year_end_seminar,
		"semester"          			  =>  $semester,
		"date_added"								=>	$date_today,
		]);
		header("location: e2e_company_records.php?addsem=$comp_name");
	}
?>
