<?php  
require 'asset/connection/mysqli_dbconnection.php';
$interviewer_id = $_COOKIE["miid"];

$table = "event_mi_interview_list";
$columns = "mi_interview_list_id";
$mi_interview_list_id = $database->max($table,$columns) + 1;

$table2 = "event_mi_interview_grade";
$columns2 = "mi_interview_grade_id";
$mi_interview_grade_id = $database->max($table2,$columns2) + 1;

error_reporting(E_ALL | E_STRICT);
if(isset($_GET['mi_sched_stud_set_id'])){
	$mi_sched_stud_set_id = $_GET['mi_sched_stud_set_id'];

	$data = $database->insert("event_mi_interview_list",[
		"mi_interview_list_id"		=>   $mi_interview_list_id,
		"interviewer_id"			=>   $interviewer_id,
		"mi_sched_stud_set_id"		=>   $mi_sched_stud_set_id,
   	]);

   	$data2 = $database->insert("event_mi_interview_grade",[
		"mi_interview_grade_id"		=>   $mi_interview_grade_id,
		"mi_interview_list_id"		=>   $mi_interview_list_id,
   	]);

	$table = "event_mi_sched_stud_set";
    $columns = ["status" => 'On Process'];
    $where = ["mi_sched_stud_set_id" => $mi_sched_stud_set_id];
    $q_update =$database->update($table,$columns,$where);
    header ("Location: e2e_interviewee_grading.php?mi_interview_list_id=".$mi_interview_list_id."");

}
?>