
<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }
  if(isset($_GET['event_id'])){
    $event_id = $_GET['event_id'];
    $table = "event_manager";
    $where = ["event_id" => $event_id];
    $q_delete_event =$database->delete($table,$where);

    header ("Location: e2e_event_manager.php?delete_event=success&&event_id=".$event_id."");

  }
?>
