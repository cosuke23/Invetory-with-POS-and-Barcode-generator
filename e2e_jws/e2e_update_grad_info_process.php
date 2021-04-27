<?php
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_update_alumni_grad_info'])){
  $grad_info_id = $_POST['grad_info_id'];
  $stud_no_grad_info = $_POST['stud_no_grad_info'];
  $stud_name_grad_info = $_POST['stud_name_grad_info'];
  $semester_grad_info = $_POST['semester_grad_info'];
  $acad_year_start_grad_info = $_POST['acad_year_start_grad_info'];
  $acad_year_end_grad_info = $_POST['acad_year_end_grad_info'];
  $status_grad_info = $_POST['status_grad_info'];

  $tbl = "alumni_grad_info";
  $col = ["semester"=>$semester_grad_info,"acad_year_start"=>$acad_year_start_grad_info,"acad_year_end"=>$acad_year_end_grad_info,"status"=>$status_grad_info];
  $where = ["grad_info_id"=>$grad_info_id];

  $q_data = $database->update($tbl,$col,$where);
  if($q_data == true){
      echo "true";
  }else{
      echo "false";
  }
  header("location: e2e_update_student_records.php?success_grad_info=1&stud_no=$stud_no_grad_info&student_name=$stud_name_grad_info");
}

?>