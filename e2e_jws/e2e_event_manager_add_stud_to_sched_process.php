
<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }
  if(isset($_GET['mi_sched_id'])&&isset($_GET['event_id'])&&isset($_GET['event_name'])&&isset($_GET['stud_no'])){  
        
    $mi_sched_id = $_GET['mi_sched_id'];
    $event_id = $_GET['event_id'];
    $event_name = $_GET['event_name'];
    $stud_no = $_GET['stud_no'];
    $nop_comp = $_GET['nop_comp'];

    $status_index = 0;
    // [status index] if 0 no sched - available
    // [status index] if 1 already in this sched - not available
    // [status index] if 2 have another sched - not available
    
    // Test Values
    // echo $mi_sched_id . "<br>";
    // echo $event_id . "<br>";
    // echo $event_name . "<br>";
    // echo $stud_no . "<br>";
    
    $table = "event_mi_sched_stud_set";
    $column = "*";
    $where = ["AND" => [
                        "mi_sched_id" => $mi_sched_id,
                        "stud_no" => $stud_no
                       ]];
    $q_check_stud_in_this_sched =$database->count($table,$column,$where);

    
    if($q_check_stud_in_this_sched!=0){
      $status_index = 1;
    }
    else{
      $status_index = 0;      
    }

    $table = "event_mi_sched_stud_set";
    $column = "*";
    $where = ["stud_no" => $stud_no];
    $q_availability_status =$database->count($table,$column,$where);    

    if($q_availability_status!=0&&$status_index!=1){
      $status_index = 2;
    } 

    if($status_index==0){
      $database->insert("event_mi_sched_stud_set",array([
        "mi_sched_id"                =>  $mi_sched_id,
        "company_assigned_id"          =>      $nop_comp,
        "stud_no"              =>  $stud_no,
        "status"                =>  "Set"        
      ]));
      header("location: e2e_event_manager_add_new_mi_sched_stud_set.php?mi_sched_id=$mi_sched_id&event_id=$event_id&event_name=$event_name&stud_inserted_onsched=1&nop_comp=$nop_comp");             
    } elseif($status_index==1){
      header("location: e2e_event_manager_add_new_mi_sched_stud_set.php?mi_sched_id=$mi_sched_id&event_id=$event_id&event_name=$event_name&stud_already_onsched=1");  
    } elseif($status_index==2){
      header("location: e2e_event_manager_add_new_mi_sched_stud_set.php?mi_sched_id=$mi_sched_id&event_id=$event_id&event_name=$event_name&stud_already_havesched=1"); 

    }


  }
?>
