<?php  
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];

 if(isset($_GET["alumni_id"]) && isset($_GET["stud_no"]) && isset($_GET["student_name"]))  
 { 			
 	$alumni_id = $_GET["alumni_id"];
   $stud_no = $_GET["stud_no"];
   $student_name = $_GET["student_name"];
   $q_remove= $database->query("DELETE FROM alumni_info_id WHERE alumni_id = '$alumni_id'")->fetchAll();
   header("location:e2e_update_student_records.php?success_alumni_id_3=1&stud_no=$stud_no&student_name=$student_name");
   if($q_remove == true){
         echo "true";
   }else{
      echo "true";
   }
 }  
 ?>  