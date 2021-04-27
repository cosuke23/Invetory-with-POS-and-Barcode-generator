<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }

  // echo $_GET['event_name'] . "<br>";
  // echo $_GET['event_id'] . "<br>";
  // echo $_GET['mi_sched_id'] . "<br>";
  // echo $_GET['status'] . "<br>";
  // echo $_GET['mi_sched_stud_set_id'] . "<br>";

   if(isset($_GET['mi_sched_stud_set_id']) && isset($_GET['mi_sched_id']) && isset($_GET['event_id']) && isset($_GET['event_name']) && isset($_GET['status'])){
    $event_id = $_GET['event_id'];
    $event_name = $_GET['event_name'];
    $mi_sched_id = $_GET['mi_sched_id'];
    $status = $_GET['status'];
    $mi_sched_stud_set_id = $_GET['mi_sched_stud_set_id'];
    
  //   $activateCtr = 0;
  //   if($status == "Waiting"){
      $table = "event_mi_sched_stud_set";
      $columns = ["status"=>"Available"];
      $where = ["mi_sched_stud_set_id" => $mi_sched_stud_set_id];
      $q_update_stud_mi_attendance =$database->update($table,$columns,$where);
  //   } 

    header ("Location: e2e_event_manager_add_new_mi_sched_stud_set.php?mark_attendance=success&event_name=$event_name&event_id=$event_id&mi_sched_id=$mi_sched_id");

   }
?>
