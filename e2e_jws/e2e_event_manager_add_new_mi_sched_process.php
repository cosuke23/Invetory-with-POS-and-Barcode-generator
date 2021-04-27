<?php
  require 'asset/connection/mysqli_dbconnection.php';
  date_default_timezone_set("Asia/Manila");

  if( isset($_POST['btn-add'])){
    $event_name         =   $_POST['event_name'];
    $event_id           =   $_POST['event_id'];
    
    $event_mi_batch_no  =   $_POST['batch_no'];
    $batch_date       =   date("Y-m-d", strtotime($_POST['batch_date']));    
    $time_start         =   date("H:i:s", strtotime($_POST['time_start']));
    $time_end           =   date("H:i:s", strtotime($_POST['time_end']));    
    $venue              =   $_POST['venue'];
    $status             =   "Waiting";    

    
    //Testing Values
    // echo $event_mi_batch_no . "<br>";    
    // echo $batch_date . "<br>";    
    // echo $time_start . "<br>";
    // echo $time_end . "<br>";
    // echo $venue . "<br>";
    
    $database->insert("event_mi_sched",array([
        "event_id"                =>  $event_id,
        "event_mi_batch_no"       =>  $event_mi_batch_no,
        "event_mi_batch_date"     =>  $batch_date,
        "time_start"              =>  $time_start,
        "time_end"                =>  $time_end,
        "venue"                   =>  $venue,
        "status"                  =>  $status
    ]));

   header("location: e2e_event_manager_add_new_mi_sched.php?event_id=$event_id&event_name=$event_name&success=1");





   /*function get_time_string($seconds){
        echo date('F j, Y, g:i A', $seconds);
    }*/

    //$uts_time_in_1 = strtotime($time_in_1); //strtotime func, converts string time format to unix time
    /*echo $uts_time_in_1."<br>";           //unix_timestamp format long int value
    echo get_time_string($uts_time_in_1);*/ //formats unix_timestamp back to string


    //get_time_string(strtotime($time_in_1));
  }





?>
