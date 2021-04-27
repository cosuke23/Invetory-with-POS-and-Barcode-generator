<?php
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }


  if( isset($_POST['btn-update'])){
    //Testing Values
    // echo $_POST['event_id'] . "<br>";
    // echo $_POST['event_code'] . "<br>";
    // echo $_POST['event_name'] . "<br>";
    // echo $_POST['event_start_date'] . "<br>";
    // echo $_POST['event_end_date'] . "<br>";
    // echo $_POST['event_date'] . "<br>";
    // echo $_POST['semester'] . "<br>";
    // echo $_POST['acad_year_start'] . "<br>";
    // echo $_POST['acad_year_start'] + 1 . "<br>";
    // echo $_POST['no_of_session'] . "<br>";
    // echo $_POST['event_type'] . "<br>";
    // echo $_POST['event_status'] . "<br>";
    // echo $_POST['batch_no'] . "<br>";
    // echo $_POST['batch_active'] . "<br>";
    
    // echo $_POST['ti1_hour'] . ":";
    // echo $_POST['ti1_minute'] . " ";
    // echo $_POST['ti1_period'] . "<br>";
    
    // echo $_POST['to1_hour'] . ":";
    // echo $_POST['to1_minute'] . " ";
    // echo $_POST['to1_period'] . "<br>";
    
    // echo $_POST['ti2_hour'] . ":";
    // echo $_POST['ti2_minute'] . " ";
    // echo $_POST['ti2_period'] . "<br>";
    
    // echo $_POST['to2_hour'] . ":";
    // echo $_POST['to2_minute'] . " ";
    // echo $_POST['to2_period'] . "<br>";

    $event_id = $_POST['event_id'];
    $event_code = $_POST['event_code'];
    $event_name = $_POST['event_name'];
    $event_start_date = $_POST['event_start_date'];
    $event_end_date = $_POST['event_end_date'];
    $event_date = $_POST['event_date'];
    $semester = $_POST['semester'];
    $acad_year_start = $_POST['acad_year_start'];
    $acad_year_end = $acad_year_start + 1;
    $no_of_session = $_POST['no_of_session'];
    $event_type = $_POST['event_type'];
    $event_status = $_POST['event_status'];
    $batch_no = $_POST['batch_no'];
    $batch_active = $_POST['batch_active'];
    $venue = $_POST['venue'];

    $intErr = 0;

    if($_POST['ti1_hour'] !="---" && $_POST['ti1_minute'] !="---" && $_POST['ti1_period'] !="---"){
        $formatted_date = date("Y-m-d", strtotime($event_date));
        $formatted_ti1_hour = sprintf("%02d", $_POST['ti1_hour']);
        $formatted_ti1_minute = sprintf("%02d", $_POST['ti1_minute']);
        $formatted_ti1_period = $_POST['ti1_period'];
        $unformatted_ti1_time = $formatted_ti1_hour.":".$formatted_ti1_minute." ".$formatted_ti1_period;
        $formatted_ti1_time = date("H:i:s", strtotime($unformatted_ti1_time));
        $ti1_datetime_text = $formatted_date." ".$formatted_ti1_time;
        $ti1_datetime_unix = strtotime($ti1_datetime_text);        
    } else{
        $ti1_datetime_unix = "0";
        $intErr+=1;                      
    }
    
    if($_POST['to1_hour'] !="---" && $_POST['to1_minute'] !="---" && $_POST['to1_period'] !="---"){
        $formatted_date = date("Y-m-d", strtotime($event_date));
        $formatted_to1_hour = sprintf("%02d", $_POST['to1_hour']);
        $formatted_to1_minute = sprintf("%02d", $_POST['to1_minute']);
        $formatted_to1_period = $_POST['to1_period'];
        $unformatted_to1_time = $formatted_to1_hour.":".$formatted_to1_minute." ".$formatted_to1_period;
        $formatted_to1_time = date("H:i:s", strtotime($unformatted_to1_time));
        $to1_datetime_text = $formatted_date." ".$formatted_to1_time;
        $to1_datetime_unix = strtotime($to1_datetime_text);        
    } else{
        $to1_datetime_unix = "0";
        $intErr+=1;        
    }

    $intErr2=0;

    if($_POST['ti2_hour'] !="---" && $_POST['ti2_minute'] !="---" && $_POST['ti2_period'] !="---"){
        $formatted_date = date("Y-m-d", strtotime($event_date));
        $formatted_ti2_hour = sprintf("%02d", $_POST['ti2_hour']);
        $formatted_ti2_minute = sprintf("%02d", $_POST['ti2_minute']);
        $formatted_ti2_period = $_POST['ti2_period'];
        $unformatted_ti2_time = $formatted_ti2_hour.":".$formatted_ti2_minute." ".$formatted_ti2_period;
        $formatted_ti2_time = date("H:i:s", strtotime($unformatted_ti2_time));
        $ti2_datetime_text = $formatted_date." ".$formatted_ti2_time;
        $ti2_datetime_unix = strtotime($ti2_datetime_text);        
    } else{
        $ti2_datetime_unix = "0";
        $intErr2+=1;
        // $intErr2+=1;
        // if($batch_no=="1" && ($_POST['ti2_hour'] =="---" && $_POST['ti2_minute'] =="---" && $_POST['ti2_period'] =="---")){            
        //     $intErr=0; 
        //     $intErr2=0;
        // }
    }        
    
    if($_POST['to2_hour'] !="---" && $_POST['to2_minute'] !="---" && $_POST['to2_period'] !="---"){
        $formatted_date = date("Y-m-d", strtotime($event_date));
        $formatted_to2_hour = sprintf("%02d", $_POST['to2_hour']);
        $formatted_to2_minute = sprintf("%02d", $_POST['to2_minute']);
        $formatted_to2_period = $_POST['to2_period'];
        $unformatted_to2_time = $formatted_to2_hour.":".$formatted_to2_minute." ".$formatted_to2_period;
        $formatted_to2_time = date("H:i:s", strtotime($unformatted_to2_time));
        $to2_datetime_text = $formatted_date." ".$formatted_to2_time;
        $to2_datetime_unix = strtotime($to2_datetime_text);        
    } else{
        $to2_datetime_unix = "0";        
        $intErr2+=1;  
        // if($batch_no=="1" && ($_POST['to2_hour'] =="---" && $_POST['to2_minute'] =="---" && $_POST['to2_period'] =="---") && $intErr2==0){
        //     $intErr=0;       
        // }
    }
    if($no_of_session=="1"){
        $ti2_datetime_unix = "0";
        $to2_datetime_unix = "0"; 
        $intErr2=0;       
    }
      
    if($intErr==0 && $intErr2==0){
        if($event_status=="Active"){
          $table = "event_manager";
          $columns = ["status"=>"Not Active"];
          $q_update_event_status =$database->update($table,$columns);
        }

        $table = "event_manager";
        $columns = ["event_code"=>$event_code,
                    "event_name"=>$event_name,
                    "event_start_date"=>$event_start_date,
                    "event_end_date"=>$event_end_date,
                    "event_date"=>$event_date,
                    "no_session"=>$no_of_session,
                    "acad_year_start_seminar"=>$acad_year_start,
                    "acad_year_end_seminar"=>$acad_year_end,
                    "semester"=>$semester,
                    "s1_start"=>$ti1_datetime_unix,
                    "s1_end"=>$to1_datetime_unix,
                    "s2_start"=>$ti2_datetime_unix,
                    "s2_end"=>$to2_datetime_unix,
                    "type"=>$event_type,
                    "status"=>$event_status,
                    "batch_active"=>$batch_active,
                    "batch_no"=>$batch_no,
                    "venue"=>$venue
                   ];
        $where = ["event_id" => $event_id];
        $q_update_event =$database->update($table,$columns,$where);

        header("location: e2e_event_manager_update_event.php?event_id=".$event_id."&update_event_success=success");
    }
    else{        
        header("location: e2e_event_manager_update_event.php?event_id=".$event_id."&update_event_failed=failed");            
    }

  }
    


?>
