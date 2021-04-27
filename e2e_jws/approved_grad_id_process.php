<?php
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");

if(isset($_GET["stud_no"])){
   $stud_no = $_GET["stud_no"];
   $stud_no = $database->query("UPDATE student_info SET claim_status = 1 WHERE stud_no = $stud_no");
}
header("location:e2e_grad_id.php?claimed=1");
?>