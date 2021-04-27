<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }


  if( isset($_POST['btn-update'])){    
    
    $mi_sched_id = $_POST['mi_sched_id'];
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];

    $event_mi_batch_no  =   $_POST['batch_no'];
    $batch_date       =   date("Y-m-d", strtotime($_POST['batch_date']));    
    $time_start   =   date("H:i:s", strtotime($_POST['time_start']));
    $time_end     =   date("H:i:s", strtotime($_POST['time_end']));  
    $venue  =   $_POST['venue'];

    //Testing Values
    // echo $event_mi_batch_no . "<br>";    
    // echo $batch_date . "<br>";    
    // echo $time_start . "<br>";
    // echo $time_end . "<br>";
    // echo $venue . "<br>";
    
    $table = "event_mi_sched";
        $columns = [
                    "event_mi_batch_no"=>$event_mi_batch_no,
                    "event_mi_batch_date"=>$batch_date,
                    "time_start"=>$time_start,
                    "venue"=>$venue,
                    "time_end"=>$time_end
                   ];
        $where = ["mi_sched_id" => $mi_sched_id];
        $q_update_mi_sched =$database->update($table,$columns,$where);

        header("location: e2e_event_manager_add_new_mi_sched.php?event_id=$event_id&event_name=$event_name&success_update=1");

  }
    


?>
