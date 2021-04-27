<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }
  if(isset($_GET['event_id']) && isset($_GET['status'])){

    $status = $_GET['status'];
    $event_id = $_GET['event_id'];
    $activateCtr = 0;
    if($status == "Active"){
      $table = "event_manager";
      $columns = ["status"=>"Not Active"];
      $where = ["event_id" => $event_id];
      $q_update_event_status =$database->update($table,$columns,$where);
    } else{
      $activateCtr = 1;
      $table = "event_manager";
      $columns = ["status"=>"Not Active"];
      $where = ["event_id" => $event_id];
      $q_update_event_status =$database->update($table,$columns);
      $columns = ["status"=>"Active"];
      $q_update_event_status =$database->update($table,$columns,$where);

    }
    $remarks = "";
    if($activateCtr!=0){
      $remarks = "Activated";
    } else{
      $remarks = "Deactivated";
    }

    header ("Location: e2e_event_manager.php?change_status=success&&event_id=".$event_id."&&remarks=".$remarks."");

  }
?>
