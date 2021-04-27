<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';

$date_today =  date("Y-m-d");

$table2 = "nop_job_fair";
$columns2 = "job_fair_id";
$job_fair_id = $database->max($table2,$columns2) + 1;

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_add_jf']))
{
	$comp_id = $_POST["comp_id"];
	$jf = $_POST["jf"];
	$contact_person_jf1 = $_POST["contact_person_jf1"];
	$position_jf1 = $_POST["position_jf1"];
	$contact_no_jf1 = $_POST["contact_no_jf1"];
	$contact_person_jf2 = $_POST["contact_person_jf2"];
	$position_jf2 = $_POST["position_jf2"];
	$contact_no_jf2 = $_POST["contact_no_jf2"];

	$table = "event_manager";
	$columns = "*";
	$where = ["event_id" => $jf];
	$q_jf =$database->select($table,$columns,$where);

	foreach ($q_jf AS $q_jf_data) {
		$acad_year_start_seminar = $q_jf_data['acad_year_start_seminar'];
		$acad_year_end_seminar = $q_jf_data['acad_year_end_seminar'];
		$semester = $q_jf_data['semester'];
	}

	$data = $database->insert("nop_job_fair",[
	"job_fair_id"     			 		=>  $job_fair_id,
	"comp_id"              			=>  $comp_id,
	"event_id"             			=>  $jf,
	"contact_person_jf1"        =>  $contact_person_jf1,
	"position_jf1"            	=>  $position_jf1,
	"contact_no_jf1"            =>  $contact_no_jf1,
	"contact_person_jf2"        =>  $contact_person_jf2,
	"position_jf2"            	=>  $position_jf2,
	"contact_no_jf2"            =>  $contact_no_jf2,
	"acad_year_start_jf"   			=>  $acad_year_start_seminar,
	"acad_year_end_jf"     			=>  $acad_year_end_seminar,
	"semester_jf"          			=>  $semester,
	"date_added"          			=>  $date_today,
	]);
	header("location: e2e_company_records.php?addjf=$comp_name");
}
?>
