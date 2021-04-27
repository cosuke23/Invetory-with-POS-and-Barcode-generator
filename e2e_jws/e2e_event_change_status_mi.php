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
    if($status == "On Going"){
      $table = "event_mi_sched";
      $columns = ["status"=>"Waiting"];
      $where = ["mi_sched_id" => $mi_sched_id];
      $q_update_event_status =$database->update($table,$columns,$where);
    } else{
      $activateCtr = 1;
      $table = "event_mi_sched";
      // $columns = ["status"=>"Waiting"];
      $where = ["mi_sched_id" => $mi_sched_id];
      // $q_update_event_status =$database->update($table,$columns);
      $columns = ["status"=>"On Going"];
      $q_update_event_status =$database->update($table,$columns,$where);

    }
    $remarks = "";
    if($activateCtr!=0){
      $remarks = "Activated";
    } else{
      $remarks = "Deactivated";
    }

    header ("Location: e2e_event_manager_add_new_mi_sched.php?change_status=success&event_name=$event_name&event_id=$event_id&remarks=$remarks");

  }
?>
