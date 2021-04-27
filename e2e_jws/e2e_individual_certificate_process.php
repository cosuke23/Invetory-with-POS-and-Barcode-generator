<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_indiv']))
{
 $studno =  $_POST['studno'];
 $table = "student_info";
 $columns = "*";
 $where = ["stud_no"=>$studno];
 $q_stud = $database->select($table,$columns,$where);

 foreach ($q_stud AS $q_stud_data) {
   $stud_no = $q_stud_data["stud_no"];
   $full_name = $q_stud_data["fname"].' '.$q_stud_data["lname"];
 }
 header("Location: e2e_reports.php?stud_no=$stud_no&&full_name=$full_name");
}
?>
