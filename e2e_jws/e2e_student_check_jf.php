<?php
ob_start("ob_gzhandler");
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';
if(!isset($_COOKIE["stud_no"])) {
  header ("Location: e2e_student_home.php");
  exit;
}
$stud_no = $_COOKIE["stud_no"];

    $table = "student_info";
    $columns = "*";
    $where = ["stud_no" =>$stud_no];

    $q_stud_info =$database->select($table,$columns,$where);

    foreach ($q_stud_info as $q_stud_info_data)
    {
          $lname = $q_stud_info_data["lname"];
          $fname = $q_stud_info_data["fname"];
          $mname = $q_stud_info_data["mname"];
          $stud_dp = $q_stud_info_data["stud_dp"];
    }
$current_year = date("Y") - 2;
$next_year = date("Y")+1;
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="Miminium Admin Template v.1">
  <meta name="author" content="Isna Nur Azis">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E2E SYSTEM v2</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>

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
  <script src="asset/js/jquery.confirm.js"></script>
  <script src="asset/js/sweetalert-dev.js"></script>
  <link rel="shortcut icon" href="asset/img/e2elogoc.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
    ?>
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
                <a href="e2e_student_home.php" class="navbar-brand"> 
                 <b>E2E SYSTEM v2</b>
                </a>
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span>&nbsp; Hi' <?php echo $fname ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <?php 
                       echo '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
                  ?>
                  
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="student_logout.php"><span class="fa fa-power-off"></span> Log out</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">
  
          <!-- start:Left Menu -->
            <div id="left-menu">
              <div class="sub-left-menu scroll">

                    <div  style="background: linear-gradient(#ebebe0, 50%,#ebebe0);height:90px;">
                      <img src="asset/img/e2elogoc.png" style="padding-top:4px;margin-left:1px;width:230px;height:100px;" class="animated fadeInLeft">
                    </div>
                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:70px;">
                    <br>
                       <p class="animated fadeInRight" style="color:gray;margin-left:10px;margin-top:20px;">
                               <?php
                                 echo  date("l, F j, Y"); 
                               ?>
                        </p>
                    </div>
                      <div class="nav-side-menu">
                        <label>
                          <a href="e2e_student_home.php"><i class="glyphicon glyphicon-user"></i>Student Information</a>
                        </label><br>
                         <label  class="active">
                        <a href="e2e_student_check_jf.php"><i class="glyphicon glyphicon-briefcase"></i>Job Fair Company Visit</a>
                        </label><br>
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->
          <div class="container-fluid mimin-wrapper">
         <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">JOB FAIR COMPANY VISIT</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                         View company visit.&nbsp;
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#tabs-demo4-area1" id="tabs-demo4-1" role="tab" data-toggle="tab" aria-expanded="true">CURRENT JOB FAIR COMPANY VISIT</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tabs-demo4-area2" role="tab" id="tabs-demo4-2" data-toggle="tab" aria-expanded="false">JOB FAIR COMPANY VISIT RECORDS</a>
                      </li>
                    </ul>
                    </div>
                    <div id="tabsDemo3Content" class="tab-content tab-content-v3">
                      <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo4-area1" 
                       aria-labelledby="tabs-demo4-area1">
                       <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-12">
                              <?php
                                $table_em  ="event_manager";
                                $columns_em = "*";
                                $where_em = ["status"=>"Active"];
                                $q_em = $database->select($table_em,$columns_em,$where_em);
                                foreach($q_em AS $q_em_data){
                                    $event_id = $q_em_data["event_id"];
                                    $event_name = $q_em_data["event_name"];
                                    $event_date = $q_em_data["event_date"];
                                    $event_semester = $q_em_data["semester"];
                                    $acad_year_start_seminar = $q_em_data["acad_year_start_seminar"];
                                    $acad_year_end_seminar = $q_em_data["acad_year_end_seminar"];
                                    $batch_active = $q_em_data["batch_active"];
                                    $batch_no = $q_em_data["batch_no"];
                                }
                              ?>
                               <h5><b>EVENT NAME: <?php echo $event_name; ?></b></h5>
                               <h5><b>EVENT DATE: <?php echo $event_date." || Semester: ".$event_semester." || S.Y.: ".$acad_year_start_seminar." - ".$acad_year_end_seminar." || Batch Active : ".$batch_active; ?></b></h5>                         
                          </div>
                           <?php
                    $q_data_jf = $database->query("SELECT a.comp_name,b.remarks,b.others,a.comp_address,a.contact_no FROM company_info AS a INNER JOIN applicant_list_jf AS b INNER JOIN event_manager AS c WHERE b.stud_no = '$stud_no' AND a.comp_id = b.comp_id AND b.event_id = c.event_id AND c.status = 'Active'")->fetchAll();

                    print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables_jf1"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th class="text-center">COMPANY NAME</th>
                          <th class="text-center">ADDRESS</th>
                          <th class="text-center">CONTACT NO</th>
                          <th class="text-center">REMARKS</th>
                          <th class="text-center">OTHERS</th>
                        </tr>
                      </thead>
                      <tbody>';
                      foreach($q_data_jf as $qData_jf){

                            $comp_name = $qData_jf['comp_name'];
                            $remarks = $qData_jf['remarks'];
                            $others = $qData_jf['others'];
                            $address = $qData_jf['comp_address'];
                            $contact_no = $qData_jf['contact_no'];
                         ?>
                      <tr>
                                <td><?php echo $comp_name; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $contact_no; ?></td>
                                <td><?php echo $remarks; ?></td>
                                <td><?php echo $others; ?></td>

                      </tr>
                      <?php
                       }
                     
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?>
                        </div>
                      </div>
                      </div>
                       <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area2" aria-labelledby="tabs-demo4-area2">
                       <?php
                         $q_data_jf = $database->query("SELECT a.comp_name,b.remarks,b.others,a.comp_address,a.contact_no,c.event_name FROM company_info AS a INNER JOIN applicant_list_jf AS b INNER JOIN event_manager AS c WHERE b.stud_no = '$stud_no' AND a.comp_id = b.comp_id AND b.event_id = c.event_id")->fetchAll();

                    print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables_jf2"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th class="text-center">COMPANY NAME</th>
                          <th class="text-center">ADDRESS</th>
                          <th class="text-center">CONTACT NO</th>
                          <th class="text-center">REMARKS</th>
                          <th class="text-center">OTHERS</th>
                          <th class="text-center">EVENT NAME</th>
                        </tr>
                      </thead>
                      <tbody>';
                      foreach($q_data_jf as $qData_jf){

                            $comp_name = $qData_jf['comp_name'];
                            $remarks = $qData_jf['remarks'];
                            $others = $qData_jf['others'];
                            $address = $qData_jf['comp_address'];
                            $contact_no = $qData_jf['contact_no'];
                            $event_name = $qData_jf['event_name'];
                         ?>
                      <tr>
                                <td><?php echo $comp_name; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $contact_no; ?></td>
                                <td><?php echo $remarks; ?></td>
                                <td><?php echo $others; ?></td>
                                <td><?php echo $event_name; ?></td>

                      </tr>
                      <?php
                       }
                     
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?>
                       </div>
                    
                      </div>
                    </div>
                   </div>
                </div>
           </div>
     
    <!-- end: content -->       
      </div>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="e2e_student_home.php"><i class="glyphicon glyphicon-user"></i>&nbsp; Student Information</a>
                       <a href="e2e_student_check_jf.php"><i class="glyphicon glyphicon-briefcase"></i>&nbsp; Job Fair Company Visit</a>
                    </li>
                </ul>
            </div>
        </div>
      </div>
      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle" style="background-color:#0d47a1;">
        <span class="fa fa-bars" style="color:yellow;"></span>
      </button>
       <!-- end: Mobile -->

<!-- start: Javascript -->
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/jquery.ui.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>
<!-- plugins -->
<script src="asset/js/plugins/moment.min.js"></script>
<script src="asset/js/plugins/jquery.datatables.min.js"></script>
<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>

<script src="asset/js/plugins/jquery.knob.js"></script>
<script src="asset/js/plugins/ion.rangeSlider.min.js"></script>
<script src="asset/js/plugins/bootstrap-material-datetimepicker.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>
<script src="asset/js/plugins/jquery.mask.min.js"></script>
<script src="asset/js/plugins/select2.full.min.js"></script>
<script src="asset/js/plugins/nouislider.min.js"></script>
<script src="asset/js/plugins/jquery.validate.min.js"></script>

<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script src="asset/js/jquery.confirm.min.js"></script>
<script src="asset/js/jquery.confirm.js"></script>
<script src="asset/js/sweetalert-dev.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#datatables_jf1').DataTable();
  $('#datatables_jf2').DataTable();
  });
</script>
<!-- end: Javascript -->
</body>
</html>