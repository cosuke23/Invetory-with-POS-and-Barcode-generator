<?php  
require 'asset/connection/mysqli_dbconnection.php';
$interviewer_id = $_COOKIE["miid"];

error_reporting(E_ALL | E_STRICT);
if(isset($_GET['mi_interview_list_id'])&&isset($_GET['mi_interview_grade_id'])&&isset($_GET['mi_sched_stud_set_id'])){
  $mi_interview_list_id = $_GET['mi_interview_list_id'];
  $mi_interview_grade_id = $_GET['mi_interview_grade_id'];
  $mi_sched_stud_set_id = $_GET['mi_sched_stud_set_id'];

  $table = "event_mi_interview_list";
  $where = ["mi_interview_list_id" => $mi_interview_list_id];
  $q_delete_list =$database->delete($table,$where);

  $table2 = "event_mi_interview_grade";
  $where2 = ["mi_interview_grade_id" => $mi_interview_grade_id];
  $q_delete_grade =$database->delete($table2,$where2);

  $table3 = "event_mi_sched_stud_set";
  $columns = ["status" => 'Available'];
  $where3 = ["mi_sched_stud_set_id" => $mi_sched_stud_set_id];
  $q_update =$database->update($table3,$columns,$where3);
  header ("Location: e2e_scheduled_interviewees.php");
}
?>