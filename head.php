<?php
error_reporting(0);
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'assets/connection/mysqli_dbconnection.php';
require 'db.php';
include('session.php');
//include('db1.php');
//get student info
$q_studinfo ="select * from student_info where stud_no='$stud_no'";
$q_studinfo_res = $dbc->query($q_studinfo);
$studinfo = $q_studinfo_res->fetch_assoc();
$studname= $studinfo['fname']. ' ' .$studinfo['lname'];
//get student course
$stud_program_id = $studinfo['course'];
if($stud_program_id==1){

  $stud_course='BSIT';
}else if($stud_program_id==2){

  $stud_course='BSHRM';
}else if($stud_program_id==3){

  $stud_course='BSHRM';
}else if($stud_program_id==4){

  $stud_course='BSHRM';
}else if($stud_program_id==5){

  $stud_course='BSAT';
}else if($stud_program_id==6){

  $stud_course='BSTM';
}else if($stud_program_id==7){

  $stud_course='BSTM';
}else if($stud_program_id==8){

  $stud_course='BSIT';
}else if($stud_program_id==9){

  $stud_course='BSIT';
}else if($stud_program_id==10){

  $stud_course='BSIT';
}else if($stud_program_id==11){

  $stud_course='BSIT';
}else if($stud_program_id==12){

  $stud_course='BSIT';
}else{
  $stud_course='NONE';
}


    
    
///end of COOKIE CODES
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="Miminium Admin Template v.1">
  <meta name="author" content="Isna Nur Azis">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JMTC</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

<!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker.css"/>
  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/animate.notify.css" />


  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/red.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>
  <link href="asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->

  <link rel="stylesheet" type="text/css" href="asset/css/sweetalert.css"/>
  <script src="asset/js/jquery.confirm.min.js"></script>
  <script src="asset/js/sweetalert-dev.js"></script>
  <link rel="shortcut icon" href="asset/img/e2elogoc.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="mimin" class="dashboard">
      <!-- start: Header -->
        <nav class="navbar navbar-custom header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
              <div class="opener-left-menu is-open">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
              </div>
                <a href="e2e_home.php" class="navbar-brand">
                 <b>JMTC-INVENTORY</b>
                </a>
        
        <ul class="nav navbar-nav navbar-right user-nav">
        
                <li class="animated fadeInRight" style="color:white;margin-left:10px;margin-top:20px;">
        <span>                        
            <?php 
              echo  date("l, F j, Y -|-  h:i:sa"); 
                        ?> &nbsp; &nbsp; &nbsp; &nbsp;
        </span>
        </li>
        
              </ul>
            </div>
          </div>
        </nav>