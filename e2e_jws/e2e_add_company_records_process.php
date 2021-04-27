<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';
require 'default_comp_img.php';

    $date_today =  date("Y-m-d");

    $table = "company_info";
    $columns = "comp_id";
    $comp_id =$database->max($table,$columns) + 1;

    $table2 = "nop_job_fair";
    $columns2 = "job_fair_id";
    $job_fair_id = $database->max($table2,$columns2) + 1;

    $table3 = "nop_mock_interview";
    $columns3 = "mi_id";
    $mi_id = $database->max($table3,$columns3) + 1;

    $table5 = "nop_seminar";
    $columns5 = "seminar_id";
    $seminar_id = $database->max($table5,$columns5) + 1;

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_add_company']))
{
  $comp_name 			       = 	$_POST['comp_name'];
  $comp_dept             =  $_POST['comp_dept'];
  $comp_desc 			       = 	$_POST['comp_desc'];
  $comp_address 		     = 	$_POST['comp_address'];
  $comp_city 			       = 	$_POST['comp_city'];
  $contact_person 	     = 	$_POST['contact_person'];
  $position 			       = 	$_POST['position'];
  $contact_no 		       = 	$_POST['contact_no'];
  $email 				         = 	$_POST['email'];
  $status_company 	     = 	$_POST['status_company'];
  $comp_user             =  $_POST['comp_user'];
  $nop 				           = 	$_POST['nop'];
  $type_industry         =  $_POST['type_industry'];
  $other_industry        =  $_POST['other_industry'];

  $jf                    =    $_POST['jf'];
  $tbl = "event_manager";
  $col = "*";
  $wh = ["event_id"=>$jf];
  $q_event = $database->select($tbl,$col,$wh);
  foreach($q_event AS $q_event_data){
    $acad_year_start_seminar =  $q_event_data["acad_year_start_seminar"];
    $acad_year_end_seminar   =  $q_event_data["acad_year_end_seminar"];
    $semester                =  $q_event_data["semester"];
  }
  $contact_person_jf1    =    $_POST["contact_person_jf1"];
  $position_jf1          =    $_POST["position_jf1"];
  $contact_no_jf1        =    $_POST["contact_no_jf1"];
  $contact_person_jf2    =    $_POST["contact_person_jf2"];
  $position_jf2          =    $_POST["position_jf2"];
  $contact_no_jf2        =    $_POST["contact_no_jf2"];

  $type = $_FILES['comp_logo']['type'];

  if(!empty($jf) && empty($type)){
    $data = $database->insert("company_info",[
    "comp_id"              =>   $comp_id,
    "comp_name"            =>   $comp_name,
    "comp_desc"            =>   $comp_desc,
    "comp_address"         =>   $comp_address,
    "comp_city"            =>   $comp_city,
    "contact_person"       =>   $contact_person,
    "position"             =>   $position,
    "contact_no"           =>   $contact_no,
    "email"                =>   $email,
    "status"               =>   $status_company,
    "username"             =>   $comp_user,
    "password"             =>   $comp_user,
    "nop"                  =>   $nop,
    "date_added"           =>   $date_today,
    "comp_logo"            =>   $default_comp_image,
    "comp_dept"            =>   $comp_dept,
    "type_industry"        =>   $type_industry,
    "other_industry"       =>   $other_industry,
    ]);

    $data2 = $database->insert("nop_job_fair",[
        "job_fair_id"         =>   $job_fair_id,
        "event_id"            =>   $jf,
        "comp_id"             =>   $comp_id,
        "contact_person_jf1"  =>   $contact_person_jf1,
        "position_jf1"        =>   $position_jf1,
        "contact_no_jf1"      =>   $contact_no_jf1,
        "contact_person_jf2"  =>   $contact_person_jf2,
        "position_jf2"        =>   $position_jf2,
        "contact_no_jf2"      =>   $contact_no_jf2,
        "date_added"          =>   $date_today,
        "acad_year_start_jf"  =>   $acad_year_start_seminar,
        "acad_year_end_jf"    =>   $acad_year_end_seminar,
        "semester_jf"         =>   $semester,
    ]);
   header("location: e2e_company_records.php?comp_name=$comp_name&&username=$comp_user");
  }

  if(!empty($jf) && !empty($type))
  {
      $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
      $base64  = base64_encode($content);

      $data = $database->insert("company_info",[
      "comp_id"              =>   $comp_id,
      "comp_name"            =>   $comp_name,
      "comp_desc"            =>   $comp_desc,
      "comp_address"         =>   $comp_address,
      "comp_city"            =>   $comp_city,
      "contact_person"       =>   $contact_person,
      "position"             =>   $position,
      "contact_no"           =>   $contact_no,
      "email"                =>   $email,
      "status"               =>   $status_company,
      "username"             =>   $comp_user,
      "password"             =>   $comp_user,
      "comp_logo"            =>   $base64,
      "nop"                  =>   $nop,
      "date_added"           =>   $date_today,
      "comp_dept"            =>   $comp_dept,
      "type_industry"        =>   $type_industry,
      "other_industry"       =>   $other_industry,
      ]);

      $data2 = $database->insert("nop_job_fair",[
        "job_fair_id"         =>   $job_fair_id,
        "event_id"            =>   $jf,
        "comp_id"             =>   $comp_id,
        "contact_person_jf1"  =>   $contact_person_jf1,
        "position_jf1"        =>   $position_jf1,
        "contact_no_jf1"      =>   $contact_no_jf1,
        "contact_person_jf2"  =>   $contact_person_jf2,
        "position_jf2"        =>   $position_jf2,
        "contact_no_jf2"      =>   $contact_no_jf2,
        "date_added"          =>   $date_today,
        "acad_year_start_jf"  =>   $acad_year_start_seminar,
        "acad_year_end_jf"    =>   $acad_year_end_seminar,
        "semester_jf"         =>   $semester,
      ]);
      header("location: e2e_company_records.php?comp_name=$comp_name&&username=$comp_user");
  }
}
?>
