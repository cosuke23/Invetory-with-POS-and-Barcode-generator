<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }

  if( isset($_POST['btn_change_event_batch'])){
    $event_id = $_POST['event_id'];
    $new_active_date = $_POST['event_dates'];
    $new_active_batch = $_POST['event_batches'];

    //Update Active event date
    $table = "event_manager";
    $columns = ["event_date"=>$new_active_date];
    $where = ["event_id" => $event_id];
    $q_update_event_date =$database->update($table,$columns,$where);

    //Get Time session values for update
    $table = "event_manager";
    $columns = ["s1_start","s1_end","s2_start","s2_end"];
    $where = ["event_id" => $event_id];
    $time_sessions = $database->get($table,$columns,$where);

    // print_r($time_sessions);
    // echo "<br><br>".$time_sessions['s1_start']."&nbsp;&nbsp;&nbsp;";
    // echo date("H:i A", $time_sessions['s1_start'])."<br>";
    if($time_sessions['s1_start']=="0"){
      $uts_dti1 = 0;
    } else{
      $ti1 = date("H:i:s", $time_sessions['s1_start']);
      $dti1 = $new_active_date . " " . $ti1;
      $uts_dti1 = strtotime($dti1);
    }

    if($time_sessions['s1_end']=="0"){
      $uts_dto1 = 0;
    } else{
      $to1 = date("H:i:s", $time_sessions['s1_end']);
      $dto1 = $new_active_date . " " . $to1;
      $uts_dto1 = strtotime($dto1);
    }

    if($time_sessions['s2_start']=="0"){
      $uts_dti2 = 0;
    } else{
      $ti2 = date("H:i:s", $time_sessions['s2_start']);
      $dti2 = $new_active_date . " " . $ti2;
      $uts_dti2 = strtotime($dti2);
    }

    if($time_sessions['s2_end']=="0"){
      $uts_dto2 = 0;
    } else{
      $to2 = date("H:i:s", $time_sessions['s2_end']);
      $dto2 = $new_active_date . " " . $to2;
      $uts_dto2 = strtotime($dto2);
    }

    //Update Time Sessions
    $table = "event_manager";
    $columns = ["s1_start"=>$uts_dti1,
                "s1_end"=>$uts_dto1,
                "s2_start"=>$uts_dti2,
                "s2_end"=>$uts_dto2
               ];
    $where = ["event_id" => $event_id];
    $q_update_event_time_sessions =$database->update($table,$columns,$where);

    $table = "event_manager";
    $columns = ["batch_active"=>$new_active_batch];
    $where = ["event_id" => $event_id];
    $q_update_event_batch =$database->update($table,$columns,$where);

    header ("Location: e2e_event_manager.php?change_batch=success&&active_date=".$new_active_date."&&active_batch=".$new_active_batch."");
  }

?>
