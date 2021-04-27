
 <?php
 session_start();
require 'asset/connection/mysqli_dbconnection.php';

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_prog']))
{
  $program_id2    =  $_POST['program'];
  $table = "student_info";
  $columns = "*";
  $where = ["year"=>$program_id2];
  $q_prog = $database->select($table,$columns,$where);

  foreach ($q_prog AS $q_prog_data) {
    $program_id = $q_prog_data["year"];
  }
  header("Location:e2e_student_records.php?program_id=$program_id");
}
?>