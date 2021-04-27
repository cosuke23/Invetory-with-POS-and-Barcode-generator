<?php
ob_start("ob_gzhandler");
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';

///COOKIE CODES 
if(!isset($_COOKIE["uid"])) {
  header ("Location: e2e_login.php");
  exit;
}
$user_id = $_COOKIE["uid"];

    $table = "user_info";
    $columns = "*";
    $where = ["user_id" => $user_id];

    $q_user_info =$database->select($table,$columns,$where);

    foreach ($q_user_info as $q_user_info_data)
    {
          $lname = $q_user_info_data["lname"];
          $fname = $q_user_info_data["fname"];
          $mname = $q_user_info_data["mname"];
          $title = $q_user_info_data["title"];
          $profileData = $q_user_info_data["profileData"];
          $coverData = $q_user_info_data["coverData"];
          $usertype =  $q_user_info_data["usertype"];
		  $sender_user = $q_user_info_data["username"];

         $decoded_img_profile = base64_decode($profileData);
         $f = finfo_open(); 
         $img_type_profile = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);

         $decoded_img_cover = base64_decode($coverData);
         $f = finfo_open(); 
         $img_type_cover = finfo_buffer($f, $decoded_img_cover, FILEINFO_MIME_TYPE);

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
                 <b>E2E SYSTEM v2</b>
                </a>
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span>&nbsp; Hi' <?php echo  $title." ".$fname ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <?php 
                       echo '<img src="data:'.$img_type_profile.';base64,'.$profileData.'" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
                  ?>
                  
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="my_account.php"><span class="fa fa-user"></span> My Profile</a></li>
                     <li><a href="logout.php"><span class="fa fa-power-off"></span> Log out</a></li>
                  </ul>
                </li>
                <!-- Start of chat ekek-->
                <li><a href="#" class="opener-right-menu"><span class="fa fa-weixin"></span>
                  <?php
                  $c_unread_chat = $database->count("messenger",["AND"=>["receiver" => $sender_user,"message_status"=>'unread']]);
                  if($c_unread_chat == 0){
                    echo "";
                  }
                  else{
                    echo '<div class="badge" style="background:red;">'.$c_unread_chat.'</div>';
                  }
                  ?>
                </a></li>
				<!-- end of chat ekek-->
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
                          <a href="e2e_admin_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label class="active"><a href="e2e_student_records.php">
                          <i class="glyphicon glyphicon-tasks"></i>Student Records</a>
                        </label><br>
                        <label><a href="e2e_company_records.php">
                          <i class="glyphicon fa fa-building-o"></i>Company Records</a>
                        </label><br>
                        <label><a href="e2e_reports.php">
                          <i class="glyphicon fa fa-thumbs-o-up"></i>Reports</a>
                        </label><br>
                        <label><a href="e2e_grad_id.php">
                          <i class="glyphicon fa fa-smile-o"></i>Graduating ID Card</a>
                        </label><br>
                        <label><a href="e2e_business_card.php">
                          <i class="glyphicon icons icon-credit-card"></i>Business Card</a>
                        </label><br>
                        <label><a href="e2e_event_manager.php">
                          <i class="glyphicon glyphicon-list-alt"></i>Event Manager</a>
                        </label><br>
                        <?php
                        if($usertype == 1){
                          echo '<label><a href="e2e_user_account.php">
                          <i class="glyphicon fa fa-user"></i>User Account</a>
                        </label><br>';
                        echo '<label><a href="audit_trail.php">
                          <i class="glyphicon fa fa-folder-open"></i> Audit Trail</a>
                        </label><br>';
                        }
                        ?>   
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
                        <h1 class="animated fadeInLeft">STUDENT RECORDS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                           View and manage the students records.
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>List of all Student</h3></div>   
                    <form id="batch_certi" method="post" action="e2e_student_record.php" enctype="multipart/form-data">
                                  <div class="row">
                                    <div class="col-md-2">
                                      <h5 style="padding-left:5px;">Student Year level</h5>
                                      <div class="form-group has-feedback">
                                        <?php
                                          $table = "student_info";
                                          $columns = "*";
                                          $group = "group by year";
                                          $q_program =$database->select($table,$columns,$group);

                                          print'<select class="form-control"  name="program" class="form-control">';
                                          echo "<option value='".$program_id."' disabled selected>".$program_code."</option>";

                                          foreach($q_program as $q_program_data){
                                            $program_id2 = $q_program_data['program_id'];
                                            $program_code2 = $q_program_data['year'];
                                            $counter = 0;

                                            $comstart3="";
                                            if($program_code==$program_code2)
                                            {
                                              $comstart3="<!--";
                                            }
                                            if($counter <= $program_id)
                                            {
                                              echo $comstart3."<option value='".$program_id2."'>".$program_code2."</option>".$comend;
                                              $counter++;
                                            }
                                          }
                                        ?>
                                        <?php
                                          print '</select>';
                                        ?>
                                      </div>
                                    </div>

                                       
                                    <div class="col-md-3"><br>
                                      <button type="submit" class="btn btn-ripple btn-raised btn-primary" name="btn_prog" id="btn_update_stud_info" style="margin-top:15px;">
                                        <span class="glyphicon glyphicon-ok"></span> &nbsp;Search
                                      </button>
                                    </div>
                                     <div class="col-md-4">
                              <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                                  </div>
                                </form>
                     <br>
                    <div class="row">
                      <div class="col-md-12">

                         <?php
                         if(isset($_GET['success1']) && isset($_GET['stud_no']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['mname'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $lname_up = $_GET['lname'];
                              $fname_up = $_GET['fname'];
                              $mname_up = $_GET['mname'];
                            
                        /*    echo '<script language = javascript>
                             swal({
                                title: "Successfully Updated!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$lname_up.', '.$fname_up.' '.$mname_up.'<br> was Sucessfully Updated!</strong> ",
                                type: "success",
                                showCancelButton: false,
                                
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_student_records.php";
                                }
                              });
                          </script>'; */
                            }  
                            elseif(isset($_GET['success2']) && isset($_GET['stud_no']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['mname'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $lname_up = $_GET['lname'];
                              $fname_up = $_GET['fname'];
                              $mname_up = $_GET['mname'];
                            echo '<script language = javascript>
                             swal({
                                title: "Successfully Added!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$lname_up.', '.$fname_up.' '.$mname_up.'</strong>",
                                type: "success",
                                showCancelButton: false,
                                
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_student_records.php";
                                }
                              });
                          </script>';
                        }
                        elseif(isset($_GET['success_sa']) && isset($_GET['stud_no']) && isset($_GET['s1_timein'])
                          && isset($_GET['s1_status'])) 
                            {   
                              $stud_no_sa = $_GET['stud_no'];
                              $s1_status = $_GET['s1_status'];
                              $s1_timein = date("h:i A",$_GET['s1_timein']);
                             echo '<script language = javascript>
                             swal({
                                title: "Successfully Added to seminar!",
                                 html: true,
                                 text: " <strong>Student Number : '. $stud_no_sa.' <br>  Time in: '.$s1_timein.'<br>S1 Status : '.$s1_status.' </strong> ",
                                type: "success",
                                showCancelButton: false,
                                
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_student_records.php";
                                }
                              });
                          </script>';
                            }
                        elseif(isset($_GET['success_sa2']) && isset($_GET['stud_no']) && isset($_GET['s2_timein'])
                          && isset($_GET['s2_status'])) 
                            {   
                              $stud_no_sa = $_GET['stud_no'];
                              $s2_status = $_GET['s2_status'];
                              $s2_timein = date("h:i A",$_GET['s2_timein']);
                             echo '<script language = javascript>
                             swal({
                                title: "Successfully Added to seminar!",
                                 html: true,
                                 text: " <strong>Student Number : '. $stud_no_sa.' <br>  Time in 2: '.$s2_timein.'<br>S2 Status : '.$s2_status.' </strong> ",
                                type: "success",
                                showCancelButton: false,
                                
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_student_records.php";
                                }
                              });
                          </script>';
                            }  
                            if(isset($_GET['marked'])){
                              $marked=$_GET['marked'];
                            if($marked==1)
                            {
                              echo '<script language = javascript>
                             swal({
                                title: "Success!",
                                text: "Successfully marked data.",
                                type: "success",
                                showCancelButton: false,
                                
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              }
                              ,
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_student_records.php";
                                }
                              });

                          </script>';
                            }
                            else if($marked==0)
                            {
                              echo '<script language = javascript>
                             swal({
                                title: "Data already marked!",
                                type: "success",
                                showCancelButton: false,
                                
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              }
                              ,
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_student_records.php";
                                }
                              });

                          </script>';
                            }
                            
                            }
                            ?>
                        </div>
                      </div>

                         
                    <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                            <div class="col-md-2">
                                       <button class="btn btn-success btn-outline btn-block btn-sm" 
                                       id="check_student_number">
                                            <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                      </button>
                            </div>
                            <div class="col-md-7" style="margin-top:-10px;">
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
                               <input type="hidden"  id = "event_id" value ="<?php echo $event_id; ?>" />
                               <input type="hidden"  id = "batch_no" value ="<?php echo $batch_no; ?>" />
                            </div>
                            <div class="col-md-3" style="margin-top:-10px;">
                              <input type="button" value="Enabled" id ="enabled" class="btn btn-info pull-right" onclick="enabledFunc()">
                              <input type="button" value="Disabled" id ="disabled" class="btn btn-danger pull-right" onclick="disabledFunc()">
                            </div>
                            
                          </div>
                        </div>

                    <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                         
                          <div class="col-md-2">
                             <a href="temp_print.php"><button  class="btn btn-primary">
                               <span class="fa fa-print"></span> EXPORT ATTENDANCE </button></a>
                          </div>

                           <div class="col-md-8"><p><a href="asset/resume_data/0082A080441.pdf" download target="_blank">test pdf</a></p</div>
                            <div class="col-md-2" style="margin-top:-10px;">
                                <button type="submit" id ="marked_seminar_attended" class="btn btn-primary btn-block pull-right" disabled="disabled"><span class="fa fa-calendar"></span> Marked Data</button>
                            </div>
                          </div>
                      </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                        <th class="col-md-1"></th>
                         <th class="text-center">STUDENT NUMBER</th>
                          <th class="text-center">LASTNAME</th>
                          <th class="text-center">FIRSTNAME</th>
                          <th class="text-center">MIDDLENAME</th>
                          <th class="text-center">PROGRAM</th>
                          <th class="text-center" style="width:150px;">ACTION</th>               
                        </tr>
                      </thead>
                      <tbody></tbody>
                     </table>
                     </div>
                     </div>
                  </div>
                </div>
              </div>
            </div><!-- end: content -->

          <!-- start: right menu -->
            <?php require('chat.php') ?>
          <!-- end: right menu -->
          
      </div>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="e2e_home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                      <a href="e2e_student_records.php"><i class="glyphicon glyphicon-tasks"></i>&nbsp; Student Records</a>
                      <a href="e2e_company_records.php"><i class="glyphicon fa fa-building-o"></i>&nbsp; Company Records</a>
                      <a href="*"><i class="glyphicon fa fa-thumbs-o-up"></i>&nbsp; OJT Endorsement</a>
                      <a href="*"><i class="glyphicon fa fa-user-secret"></i>&nbsp; Check Attire</a>
                      <a href="*"><i class="glyphicon fa fa-smile-o"></i>&nbsp; Graduating ID Card</a>
                      <a href="*"><i class="glyphicon icons icon-credit-card"></i>&nbsp; Business Card</a>
                      <a href="e2e_event_manager.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Event Manager</a>
                      <a href="*"><i class="glyphicon fa fa-user"></i>&nbsp; User Account</a>
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
<script src="asset/js/plugins/nouislider.min.js"></script>
<script src="asset/js/plugins/jquery.validate.min.js"></script>

<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>

<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
var event_id = document.getElementById('event_id').value;
var batch_no = document.getElementById('batch_no').value;
function disabledFunc(){
  document.getElementById("marked_seminar_attended").disabled = true;
}
function enabledFunc(){
  document.getElementById("marked_seminar_attended").disabled = false;
}
  $(document).ready(function(){

  $.fn.dataTable.ext.errMode = function(settings,helpPage,message){
    pending_table.ajax.reload(null, false);
  }

 $('#datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "e2e_student_records_processing.php",
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },
  }); 

$('#check_student_number').click(function(){
    swal({
  title: "CHECK STUDENT NUMBER",
  text: "Type Student Number:",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  inputPlaceholder: "Type Student Number here..",
  showLoaderOnConfirm: true,
},
  function(inputValue){
    var regex = /^[0-9]+$/;
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("You need to write something!");
      return false;
    }
    if (!inputValue.match(regex)) {
      swal.showInputError("Student Number only consist of numbers!");
      return false;
    }
    if (inputValue.length !== 11) {
    swal.showInputError("Student Number must be 11 numbers!");
    return false;
    }
    else{
        $.ajax({
          method:'GET',
          url: 'check_student_number.php?inputValue='+inputValue,
          success : function(response){
            if(response=="ok"){
              swal.showInputError("Student Number already exist!");
            }else{
              setTimeout(function(){
                 window.location.href="student_registration.php?stud_no="+inputValue;  
                //swal("Ajax request finished!");
              }, 1200);      
            }
          }
        });
        return false;
     //end of function student number   
      }  
    });
  }); 
//
 $('#marked_seminar_attended').click(function(){
    swal({
  title: "MARKED DATA",
  text: "Type batch number:",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  inputPlaceholder: "Type batch number here..",
  showLoaderOnConfirm: true,
},
  function(inputValue){
    var regex = /^[0-9]+$/;
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("You need to write something!");
      return false;
    }
    if (!inputValue.match(regex)) {
      swal.showInputError("Batch Number only consist of numbers!");
      return false;
    }
    if (inputValue.length !== 1) {
    swal.showInputError("Batch Number must only consist of 1 character!");
    return false;
    }
    if (inputValue > batch_no) {
    swal.showInputError("Invalid Value!");
    return false;
    }
    else{
        window.location.href="marked_seminar_attended.php?event_id="+event_id+"&batch_active="+inputValue;  
      }  
    });
  }); 
 });
</script>
<!-- end: Javascript -->
</body>
</html>