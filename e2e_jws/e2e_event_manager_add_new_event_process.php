<?php
  require 'asset/connection/mysqli_dbconnection.php';
  date_default_timezone_set("Asia/Manila");

  if( isset($_POST['btn-add'])){
    $event_code         =   $_POST['event_code'];
    $event_name         =   $_POST['event_name'];
    $event_start_date   =   $_POST['start_date'];
    $event_end_date     =   $_POST['end_date'];
    $event_date         =   $event_start_date;     //Event Active Date
    $no_of_session      =   $_POST['no_of_session'];
    $acad_year_start    =   date('Y', strtotime('+0 years',strtotime($_POST['current_year'])));
    $acad_year_end      =   date('Y', strtotime('+1 years',strtotime($_POST['current_year'])));
    $venue              =   $_POST['venue'];
    $semester           =   $_POST['semester'];

    if($_POST['time_in_1'] != ""){
      $date_test          =   date("Y-m-d", strtotime($_POST['start_date']));
      $time_in_1          =   strtotime($_POST['time_in_1']);
      $ti1                =   date("h:i A", $time_in_1);
      $dt_ti1             =   $date_test . " " . $ti1;
      $uts_dt_ti1         =   strtotime($dt_ti1);
      // echo $uts_dt_ti1 . "<br>";
      // $date_time_text = date("Y-m-d h:i A", $uts_dt_ti1);
      // echo $date_time_text . "<br>";
    }
    else{
      // echo "TI 1 None<br>";
      $uts_dt_ti1 = 0;
    }

    if($_POST['time_out_1'] != ""){
      $date_test          =   date("Y-m-d", strtotime($_POST['start_date']));
      $time_out_1         =   strtotime($_POST['time_out_1']);
      $to1                =   date("h:i A", $time_out_1);
      $dt_to1             =   $date_test . " " . $to1;
      $uts_dt_to1         =   strtotime($dt_to1);
      // echo $uts_dt_to1 . "<br>";
      // $date_time_text = date("Y-m-d h:i A", $uts_dt_to1);
      // echo $date_time_text . "<br>";
    }
    else{
      // echo "TO 1 None<br>";
      $uts_dt_to1 = 0;
    }

    if($_POST['time_in_2'] != ""){
      $date_test          =   date("Y-m-d", strtotime($_POST['start_date']));
      $time_in_2          =   strtotime($_POST['time_in_2']);
      $ti2                =   date("h:i A", $time_in_2);
      $dt_ti2             =   $date_test . " " . $ti2;
      $uts_dt_ti2         =   strtotime($dt_ti2);
      // echo $uts_dt_ti2 . "<br>";
      // $date_time_text = date("Y-m-d h:i A", $uts_dt_ti2);
      // echo $date_time_text . "<br>";
    }
    else{
      // echo "TI 2 None<br>";
      $uts_dt_ti2 = 0;
    }

    if($_POST['time_out_2'] != ""){
      $date_test          =   date("Y-m-d", strtotime($_POST['start_date']));
      $time_out_2         =   strtotime($_POST['time_out_2']);
      $to2                =   date("h:i A", $time_out_2);
      $dt_to2             =   $date_test . " " . $to2;
      $uts_dt_to2         =   strtotime($dt_to2);
      // echo $uts_dt_to2 . "<br>";
      // $date_time_text = date("Y-m-d h:i A", $uts_dt_to2);
      // echo $date_time_text . "<br>";
    }
    else{
      // echo "TO 2 None<br>";
      $uts_dt_to2 = 0;
    }

    $event_type         =   $_POST['event_type'];

    $status             =   $_POST['status'];
    if($status=="Active"){
      $table = "event_manager";
      $columns = ["status"=>"Not Active"];
      $q_update_event_status =$database->update($table,$columns);
    }

    $batch_no           =   $_POST['batch_no'];

    //Testing Values
    // echo $_POST['event_code'] . "<br>";
    // echo $_POST['event_name'] . "<br>";
    // echo $_POST['start_date'] . "<br>";

    // $date_test = date("y-m-d", strtotime($_POST['start_date']));
    // echo $date_test . "<br>";

    // echo $_POST['end_date'] . "<br>";
    // echo $_POST['no_of_session'] . "<br>";
    // echo $_POST['acad_year_start'] . "<br>";
    // echo $_POST['acad_year_end'] . "<br>";
    // echo $_POST['semester'] . "<br>";
    // echo $_POST['time_in_1'] . "<br>";

    // $time_test = date("H:i A", strtotime($_POST['time_in_1']));
    // echo $time_test. "<br>";
    // $date_time_test = $date_test . " " . $time_test;
    // echo $date_time_test . "<br>";
    // echo strtotime($date_time_test) . "<br>";
    // $date_time_text = date("Y-m-d H:i A", strtotime($date_time_test));
    // echo $date_time_text . "<br>";

    // echo $_POST['time_out_1'] . "<br>";
    // echo $_POST['time_in_2'] . "<br>";
    // echo $_POST['time_out_2'] . "<br>";
    // echo $_POST['event_type'] . "<br>";
    // echo $_POST['status'] . "<br>";
    // echo $_POST['batch_no'] . "<br>";
    // echo $_POST['venue'] . "<br>";

    $database->insert("event_manager",array([
        "event_code"                =>  $event_code,
        "event_name"                =>  $event_name,
        "event_start_date"          =>  $event_start_date,
        "event_end_date"            =>  $event_end_date,
        "event_date"                =>  $event_date,
        "no_session"                =>  $no_of_session,
        "acad_year_start_seminar"   =>  $_POST['acad_year_start'],
        "acad_year_end_seminar"     =>  $_POST['acad_year_end'],
        "semester"                  =>  $semester,
        "s1_start"                  =>  $uts_dt_ti1,
        "s1_end"                    =>  $uts_dt_to1,
        "s2_start"                  =>  $uts_dt_ti2,
        "s2_end"                    =>  $uts_dt_to2,
        "type"                      =>  $event_type,
        "status"                    =>  $status,
        "batch_active"              =>  1,
        "batch_no"                  =>  $batch_no,
        "venue"                     =>  $venue
    ]));

   header("location: e2e_event_manager.php?add_event=success&&event_name=".$event_name."");





   /*function get_time_string($seconds){
        echo date('F j, Y, g:i A', $seconds);
    }*/

    //$uts_time_in_1 = strtotime($time_in_1); //strtotime func, converts string time format to unix time
    /*echo $uts_time_in_1."<br>";           //unix_timestamp format long int value
    echo get_time_string($uts_time_in_1);*/ //formats unix_timestamp back to string


    //get_time_string(strtotime($time_in_1));
  }





?>
