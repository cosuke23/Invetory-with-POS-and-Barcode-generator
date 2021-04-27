<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';

$table = "tbl_interviewer";
$columns = "interviewer_id";
$interviewer_id = $database->max($table,$columns) + 1;

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_reg']))
{
    /*$interviewer_user  =    $_POST['interviewer_user'];*/
    $comp_name           =    $_POST['comp_name'];
    $table = "company_info";
    $columns = "*";
    $where = ["comp_name"=>$comp_name];
    $q_company = $database->select($table,$columns,$where);
    foreach ($q_company as $q_company_data) {
        $comp_id = $q_company_data["comp_id"];
    }
    $lname             =    $_POST['lname'];
    $fname             =    $_POST['fname'];
    $position          =    $_POST['position'];
    $contact_no        =    $_POST['contact_no'];
    $email             =    $_POST['email'];
    $username          =    $_POST['interviewer_user'];
    $password          =    $_POST['interviewer_user'];
  
    $data = $database->insert("tbl_interviewer",[
        "interviewer_id"    =>  $interviewer_id,
        "comp_id"           =>  $comp_id,
        "lname"             =>  $lname,
        "fname"             =>  $fname,
        "position"          =>  $position,
        "contact_no"        =>  $contact_no,
        "email"             =>  $email,
        "username"          =>  $username,
        "password"          =>  $password,      
        ]);
        header("location: e2e_company_mi_login.php?success=1");
}
?>