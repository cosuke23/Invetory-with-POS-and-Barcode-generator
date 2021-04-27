<?php  
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];

 if(isset($_POST["btn_update_alumni_info_id"]))  
 { 			
 	$claimed_status = $_POST["claimed_status"];
   $renewal_date = $_POST["renewal_date"];
   $claimed_date = $_POST["claimed_date"];
   $stud_no = $_POST["stud_no"];
   $student_name = $_POST["student_name"];
   $alumni_id = $_POST["alumni_id"];

   $q_add = $database->update("alumni_info_id",
      		["stud_no"=>$stud_no,"renewal_date"=>$renewal_date,"claimed_date"=>$claimed_date,"claimed_status"=>$claimed_status],["alumni_id"=>$alumni_id]);
   header("location:e2e_update_student_records.php?success_alumni_id_2=1&stud_no=$stud_no&student_name=$student_name");
   if($q_add == true){
         echo "true";
   }else{
      echo "true";
   }
 }  
 ?>  