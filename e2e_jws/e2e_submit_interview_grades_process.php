<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_submit']))
{
  $mi_interview_list_id =   $_POST['mi_interview_list_id']; 
  $mi_sched_stud_set_id =   $_POST['mi_sched_stud_set_id'];

  $comm_skill           =   $_POST['comm_skill'];
  $paper_screening      =   $_POST['paper_screening'];
  $skill_fit            =   $_POST['skill_fit'];
  $org_fit              =   $_POST['org_fit'];
  $confidence           =   $_POST['confidence'];
  $total                =   $_POST['total'];
  $remarks              =   $_POST['remark'];
  $comment              =   $_POST['comment'];
  $remarks_value        =   "";

  if($remarks == 'Yes'){
    $remarks_value = "Passed";
  }
  else{
    $remarks_value = "Failed";
  }

  $table   = "event_mi_interview_grade";
  $columns = ["comm_skill"     =>  $comm_skill,
            "paper_screening"  =>  $paper_screening,
            "skill_fit"        =>  $skill_fit,
            "org_fit"          =>  $org_fit,
            "confidence"       =>  $confidence,
            "total"            =>  $total,
            "remarks"          =>  $remarks_value,
            "comment"          =>  $comment,
            ];
  $where = ["mi_interview_list_id"  => $mi_interview_list_id];
  $q_data = $database->update($table,$columns,$where);

  $table2   = "event_mi_sched_stud_set";
  $columns2 = ["status"     =>  'Already Graded',
            ];
  $where2 = ["mi_sched_stud_set_id"  => $mi_sched_stud_set_id];
  $q_data = $database->update($table2,$columns2,$where2);
  header("Location: e2e_scheduled_interviewees.php");
}
?>