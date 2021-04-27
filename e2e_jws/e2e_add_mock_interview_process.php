<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';
$date_today =  date("Y-m-d");

$table3 = "nop_mock_interview";
$columns3 = "mi_id";
$mi_id = $database->max($table3,$columns3) + 1;

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_add_mi']))
{
	$comp_id = $_POST['comp_id'];
	$em    =    $_POST['em'];
	$table = "event_manager";
	$columns = "*";
	$where = ["event_id" => $em];
	$q_em =$database->select($table,$columns,$where);

	foreach ($q_em AS $q_em_data) {
		$acad_year_start_seminar = $q_em_data['acad_year_start_seminar'];
		$acad_year_end_seminar = $q_em_data['acad_year_end_seminar'];
		$semester = $q_em_data['semester'];
	}

	$data = $database->insert("nop_mock_interview",[
	"mi_id"                =>  $mi_id,
	"comp_id"              =>  $comp_id,
	"acad_year_start_mi"   =>  $acad_year_start_seminar,
	"acad_year_end_mi"     =>  $acad_year_end_seminar,
	"semester_mi"          =>  $semester,
	"event_id"          	 =>  $em,
	"date_added"          =>   $date_today,
	]);
	header("location: e2e_company_records.php?addmi=$comp_name");
}
?>
