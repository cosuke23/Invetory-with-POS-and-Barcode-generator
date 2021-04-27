
<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }
  if(isset($_GET['mi_sched_id'])&&isset($_GET['event_id'])&&isset($_GET['event_name'])){
    $mi_sched_id = $_GET['mi_sched_id'];
    $event_id = $_GET['event_id'];
    $event_name = $_GET['event_name'];
    $table = "event_mi_sched";
    $where = ["mi_sched_id" => $mi_sched_id];
    $q_delete_event_mi_sched =$database->delete($table,$where);

    header("location: e2e_event_manager_add_new_mi_sched.php?event_id=$event_id&event_name=$event_name&success_delete=1");

  }
?>
