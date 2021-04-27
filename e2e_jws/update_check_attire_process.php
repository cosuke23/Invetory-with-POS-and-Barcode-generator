<?php
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];

if(isset($_POST["remarks_id"]))
 {
  $attire_id = $_GET["attire_id"];
   $remarks = $_GET["remarks"];
   $others = $_GET["others"];
   $stud_no = $_GET["stud_no"];
   $date_check = $_GET["date_check"];   
  if($others == ""){
    $F_others  ="none";
  }else{
    $F_others = $others;
  }
  $total_remarks ="";

  $intCtr = 1;
  foreach($_POST["remarks_id"] as $remarks_id_data)
  {
    $table = "check_attire_remarks";
    $columns = "*";
    $where = ["remarks_id"=>$remarks_id_data];
    $q_aca = $database->select($table,$columns,$where);

    foreach($q_aca as $q_aca_data){
      if ($intCtr < count($_POST["remarks_id"])){
        $total_remarks .= $q_aca_data["remarks"].", ";
      } else{
        $total_remarks .= $q_aca_data["remarks"];
      }
    }
    $intCtr++;
  }

   $table = "check_attire";
   $columns = ["remarks"=>$total_remarks,"others"=>$F_others,"date_check"=>$date_check];
   $where = ["attire_id"=>$attire_id];
   $q_caUpdate = $database->update($table,$columns,$where);
}
  $tbl = "audit_trail";
  $columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Update Check Attire Remarks : ".$stud_no."","module"=>"Check Attire Module"];
      $q_data = $database->insert($tbl,$columns); 
header("location:e2e_update_student_records.php?success_ca=1&stud_no=$stud_no");
?>