<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }
  if(isset($_GET['mi_sched_id']) && isset($_GET['status'])){
    $event_id = $_GET['event_id'];
    $event_name = $_GET['event_name'];
    $status = $_GET['status'];
    $status = $_GET['status'];
    $mi_sched_id = $_GET['mi_sched_id'];
    $activateCtr = 0;
    if($status == "Waiting"){
      $table = "event_mi_sched";
      $columns = ["status"=>"Finished"];
      $where = ["mi_sched_id" => $mi_sched_id];
      $q_update_event_status =$database->update($table,$columns,$where);

      $table = "event_mi_sched_stud_set";
      $columns = ["status"=>"Did Not Attend"];
      $where = ["AND" => ["mi_sched_id" => $mi_sched_id, "status" => "Set"]];
      $q_update_event_mi_stud_attendance =$database->update($table,$columns,$where);

    } 



    $remarks = "Finished";    

    header ("Location: e2e_event_manager_add_new_mi_sched.php?change_status_fin=success&event_name=$event_name&event_id=$event_id&remarks=$remarks");

  }
?>
