<?php
ob_start("ob_gzhandler");
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
$date_today_ybgp =  date("m/d/Y");
require 'asset/connection/mysqli_dbconnection.php';
///COOKIE CODES
if(!isset($_COOKIE["sid"])) {
  header ("Location: e2e_login.php");
  exit;
  
}
$user_id = $_COOKIE["sid"];

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
                         &nbsp;
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                        <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="icons icon-user"></span> STUDENT INFO</a>
                      </li>
                      <li role="presentation">
                        <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-file-pdf-o"></span> RESUME INFO</a>
                      </li>
                      <li role="presentation">
                        <a href="#tab3" id="tabs3" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-calendar-check-o"></span> SEMINAR ATTENDED</a>
                      </li>
                      <li role="presentation">
                        <a href="#tab4" id="tabs4" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-male"></span> CHECK ATTIRE</a>
                      </li>
                        <li role="presentation">
                          <a href="#tab5" id="tabs5" role="tab" data-toggle="tab" aria-expanded="false"><span class="glyphicon glyphicon-briefcase"></span> JOB FAIR</a>
                        </li>
                         <li role="presentation">
                          <a href="#tab6" id="tabs6" role="tab" data-toggle="tab" aria-expanded="false"><span class="glyphicon fa fa-building"></span> ALUMNI RECORDS</a>
                        </li>
                      </ul>
                    </div>

                    <?php
                      if(isset($_GET['stud_no'])) {
                        $stud_no=$_GET['stud_no'];
                        $table = "student_info";
                        $columns = ["stud_no","lname","fname","mname","gender","program_id","bday",
                          "year","semester","acad_year_start","acad_year_end","email",
                          "contact_no","address","fb_link","stud_dp"];
                        $where = ["stud_no" => $stud_no];
                        $q_stud_info =$database->select($table,$columns,$where);

                        foreach($q_stud_info as $stud_data){
                          $stud_no = $stud_data['stud_no'];
                          $lname = $stud_data['lname'];
                          $fname = $stud_data['fname'];
                          $mname = $stud_data['mname'];
                          $gender = $stud_data['gender'];
                          $bday = $stud_data['bday'];
                          $stud_program_id = $stud_data['program_id'];
                          $year = $stud_data['year'];
                          $semester = $stud_data['semester'];
                          $acad_year_start = $stud_data['acad_year_start'];
                          $acad_year_end = $stud_data['acad_year_end'];
                          $email = $stud_data['email'];
                          $contact_no = $stud_data['contact_no'];
                          $address = $stud_data['address'];
                          $fb_link = $stud_data['fb_link'];
                          $stud_dp = $stud_data['stud_dp'];

                          $table2 = "program_list";
                          $columns2 = "*";
                          $where2 = ["program_id" => $stud_program_id];
                          $q_stud_info_program=$database->select($table2,$columns2,$where2);

                          foreach ($q_stud_info_program as $q_stud_info_program_data){
                              $program_code = $q_stud_info_program_data['program_code'];

                              
                          }
                        }
                               $file_name_program_code = $program_code;
                               $file_name_2 = $lname.", ".$fname." ".$mname;
                               $file_name_stud_no = $stud_no;
                      }
                      ?>
                    <div id="tabsDemo5Content" class="tab-content tab-content-v3">
                    <?php
                           if(isset($_GET['success2'])){

                             echo '<script language = javascript>
                             swal({
                                title: "Resume info was successfully updated!",
                                 html: true,
                                text: "",
                                type: "success",
                                showCancelButton: false,

                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no.'";
                                }
                              });
                          </script>';
                            }
                          elseif(isset($_GET['success_ca']) && isset($_GET['stud_no'])){

                            $stud_no = $_GET['stud_no'];
                            echo '<script language = javascript>
                             swal({
                                title: "Success!",
                                text: "Successfully updated!",
                                type: "success",
                                showCancelButton: false,

                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_jf']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_up = $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Student info was successfully updated!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_up.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['deleted']) && isset($_GET['stud_no'])){   
                              $stud_no_up = $_GET['stud_no'];                   
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Successfully Removed!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_up.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_alumni']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_up = $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Alumni student info was successfully updated!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_up.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_alumni_2']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_up = $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Alumni student info was successfully added!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_up.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_ybgp']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_grad_info= $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Yearbook/grad. picture student info was successfully updated!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_grad_info.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_grad_info.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_grad_info']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_ybgp= $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Graduation student info was successfully Updated!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_ybgp.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_ybgp.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_alumni_id']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_id= $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Alumni ID info was successfully added!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_id.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_id.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_alumni_id_2']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_id= $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Alumni ID info was successfully updated!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_id.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_id.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_alumni_id_3']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_id= $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Alumni ID info was successfully deleted!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_id.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_id.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success_add_jf']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_jf= $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Student was successfully added to the job fair list!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_jf.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_jf.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['error_add_jf'])&&  isset($_GET['stud_no'])){   
                              
                              $stud_no_jf = $_GET['stud_no'];
                             echo '<script language = javascript>
                             swal({
                                title: "Error!",
                                 html: true,
                                text: "Sorry., The selected company was not added to the active event.",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_jf.'";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['error2_add_jf']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_jf= $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Student was already added to the selected company!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_jf.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_update_student_records.php?stud_no='.$stud_no_jf.'";
                                }
                              });
                          </script>';
                            }


                          ?>
                    <!--start of tab 1-->
                    <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
                    <form id="defaultForm" method="post" action="update_Student_records_process.php" enctype="multipart/form-data">
                    <!--start of panel body 1-->
                      <div class="panel-body" style="padding-bottom:30px;">

                        <div class="row">
                           <div class="col-md-3">
                           <?php
                             echo '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:200px;width:200px;">';
                             ?>
                           </div>
                          <div class="col-md-6">
                            <h5>STUDENT PICTURE &nbsp; <i class="fa fa-camera"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="stud_dp" placeholder="Upload Image" alt="student image"/>
                               </div>
                          </div>
                        </div>

                        <div class="row">
                         <input name="stud_no" type="hidden" value ="<?php echo $stud_no; ?>"/>
                          <div class="col-md-3">
                             <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                               <div class="form-group has-feedback">
                                <input type="text" name="stud_no" id="stud_no" class="form-control" value ="<?php echo $stud_no; ?>" maxlength="12" disabled/>
                               </div>
                          </div>
                         <div class="col-md-3">
                             <h5 style="padding-left:5px;">LASTNAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="lname" id="lname" class="form-control" value ="<?php echo $lname; ?>" maxlength="32"/>
                              </div>
                          </div>
                          <div class="col-md-3">
                             <h5 style="padding-left:5px;">FIRSTNAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="fname" id="fname" class="form-control" value ="<?php echo $fname; ?>" maxlength="32"/>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">MIDDLENAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="mname" id="mname" class="form-control" value ="<?php echo $mname; ?>" maxlength="32"/>
                              </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">GENDER</h5>
                              <div class="form-group has-feedback">
                                   <?php
                                     $comstart1="";
                                     $comstart2="";
                                     $comend="-->";
                                     if($gender=="Male")
                                     {
                                    $comstart1="<!--";
                                     }
                                     else if($gender=="Female")
                                     {
                                    $comstart2="<!--";
                                     }
                                     ?>
                                  <select class="form-control" name="gender" id="gender" class="form-control" placeholder="Gender">
                                    <option><?php echo $gender; ?></option>
                                    <?php echo $comstart1;?><option value="Male">Male</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Female">Female</option><?php echo $comend;?>
                                    </select>
                              </div>
                          </div>
                           <div class="col-md-3">
                                <h5 style="padding-left:5px;">BIRTHDAY</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="bday">
                                          <input type="text" class="form-control" name="bday" value="<?php echo $bday; ?>" maxlength="10"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                            <h5 style="padding-left:5px;">Year</h5>
                              <div class="form-group has-feedback">
                                   <?php
                                     $comstart1="";
                                     $comstart2="";
                                     $comstart3="";
                                     $comstart4="";
                                     $comstart5="";
                                     $comend="-->";
                                     if($year=="1st")
                                     {
                                    $comstart1="<!--";
                                     }
                                     elseif($year=="2nd")
                                     {
                                    $comstart2="<!--";
                                     }
                                     elseif($year=="3rd")
                                     {
                                    $comstart3="<!--";
                                     }
                                     elseif($year=="4th")
                                     {
                                    $comstart4="<!--";
                                     }
                                     elseif($year=="5th")
                                     {
                                    $comstart5="<!--";
                                     }
                                     ?>
                                  <select class="form-control" name="year" id="year" class="form-control" placeholder="Year">
                                    <option><?php echo $year; ?></option>
                                    <?php echo $comstart1; ?><option value="1st">1st</option><?php echo $comend;?>
                                    <?php echo $comstart2; ?><option value="2nd">2nd</option><?php echo $comend;?>
                                    <?php echo $comstart3; ?><option value="3rd">3rd</option><?php echo $comend;?>
                                    <?php echo $comstart4; ?><option value="4th">4th</option><?php echo $comend;?>
                                    <?php echo $comstart5; ?><option value="5th">5th</option><?php echo $comend;?>
                                    </select>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">PROGRAM</h5>
                            <div class="form-group has-feedback">
                                <?php
                                $table_pl = "program_list";
                                $columns_pl = "*";
                                $where_pl = ["status" => 'Active'];
                                $q_pl =$database->select($table_pl,$columns_pl,$where_pl);

                                print'<select class="form-control"  name="program_id" class="form-control">';

                                 echo "<option value='".$stud_program_id."'>".$program_code."</option>";

                                 foreach($q_pl as $q_pl_data){

                                    $program_id2 = $q_pl_data['program_id'];
                                    $program_code2 = $q_pl_data['program_code'];
                                    $counter = 0;

                                $comstart3="";
                                if($program_code==$program_code2)
                                {
                                  $comstart3="<!--";
                                }
                                if($counter <= $stud_program_id)
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
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                            <h5 style="padding-left:5px;">SEMESTER</h5>
                              <div class="form-group has-feedback">
                                   <?php
                                     $comstart1="";
                                     $comstart2="";
                                     $comend="-->";
                                     if($semester=="1st Semester")
                                     {
                                    $comstart1="<!--";
                                     }
                                     elseif($year=="2nd Semester")
                                     {
                                       $comstart2="<!--";
                                     }
                                     elseif($year=="Summer")
                                     {
                                       $comstart3="<!--";
                                     }
                                     ?>
                                  <select  name="semester" id="semester" class="form-control" placeholder="Year">
                                    <option><?php echo $semester; ?></option>
                                    <?php echo $comstart1; ?><option value="1st Semester">1st Semester</option><?php echo $comend;?>
                                    <?php echo $comstart2; ?><option value="2nd Semester">2nd Semester</option><?php echo $comend;?>
                                    <?php echo $comstart3; ?><option value="Summer">Summer</option><?php echo $comend;?>
                                    ?>
                                    </select>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>"/>
                            <input type="hidden" name="next_year" id="next_year" value="<?php echo $next_year; ?>"/>
                                  <h5 style="padding-left:5px;">ACADEMIC YEAR START</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date">
                                          <input type="text" class="form-control" name="acad_year_start" placeholder="(e.g.YYYY)" id="acad_year_start" onchange="get_value_ays()" value="<?php echo $acad_year_start; ?>"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                             <div class="col-md-3">
                                <h5 style="padding-left:5px;">ACADEMIC YEAR END</h5>
                                  <div>
                                   <input type="hidden" id="acad_year_end_value" name="acad_year_end" value="<?php echo $acad_year_end; ?>" />
                                   <h4 id ="acad_year_start_show"><?php echo $acad_year_end; ?></h4>
                                   </div>
                             </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <h2 style="padding-left:5px;">CONTACT INFORMATION</h2>
                            </div>
                          </div>

                           <div class="row">
                            <div class="col-md-12">
                                 <h5 style="padding-left:5px;">ADDRESS</h5>
                                <div class="form-group has-feedback">
                                  <textarea rows="2" name="address" id="address" class="form-control" ><?php echo $address ; ?></textarea>
                                </div>
                            </div>
                          </div>

                          <div class="row">
                             <div class="col-md-4">
                               <h5 style="padding-left:5px;">EMAIL</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="email" id="email" class="form-control" value ="<?php echo $email; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">FACEBOOK</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="fb_link" id="fb_link" class="form-control"  value ="<?php echo $fb_link; ?>" placeholder="(Optional)"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">CONTACT NUMBER</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="contact_no" id="contact_no" class="form-control"  value ="<?php echo $contact_no; ?>" maxlength="11"/>
                                </div>
                            </div>
                          </div>

                         <br>

                          <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_update_stud_info" id="btn_update_stud_info">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                 </button>
                             </div>
                              <div class="col-md-4">
                               <a href="e2e_student_records.php"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                             </div>
                          </div>

                        </div><!--ENd of panel body 1-->
                        </form>
                       </div><!--end of tab of tab 1-->

                       <!--start of tab 2-->
                    <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">
                    <form id="defaultForm2" method="post" action="update_Student_resume_process.php" enctype="multipart/form-data">
                    <input type="hidden" name="stud_no_r" value="<?php echo $stud_no; ?>"/>
                    <!--start of panel body 2-->
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">
                            <div class="col-md-4">
                              <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                            </div>
                            <div class="col-md-6">
                              <h4 style="color:white;"><b>STUDENT NAME:  <?php echo $lname. " ".$fname.", ".$mname; ?></b></h4>
                            </div>
                          </div>
                        </div>
                        <?php
                          $tbl_res = "resume_data";
                          $columns_res = "*";
                          $where_res = ["stud_no"=>$stud_no];
                          $q_resume = $database->select($tbl_res,$columns_res,$where_res);

                          foreach($q_resume as $q_res_data){
                            $resume_id = $q_res_data["resume_id"];
                            $file_name = $q_res_data["file_name"];
                            $stud_no_res = $q_res_data["stud_no"];
                            $resume_link = $q_res_data["resume_link"];
                          }
                          ?>
                          <input type="hidden" name="resume_id" value="<?php echo $resume_id; ?>">
                           <input type="hidden" name="resume_stud_no" value="<?php echo $stud_no_res; ?>">
                           <input type="hidden" name="file_nameC" value="<?php echo $resume_link; ?>">

                          <div class="row">
                            <div class="col-md-12">
                              <h2 style="padding-left:5px;">RESUME INFO</h2>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4" style="display:none;">
                              <h5 style="padding-left:5px;">RESUME LINK</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="resume_link" id="resume_link" class="form-control"  value ="<?php echo $resume_link; ?>" placeholder="(e.g. example.jobs.street.com)"/>
                                </div>
                            </div>
                            <div class="col-md-5">
                            <h5>UPLOAD DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="resume_data" placeholder="Upload Resume" alt="resume data"/>
                               </div>
                          </div>
                          <br><br>
                          <div class="col-md-3"></div>
                          <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_update_stud_resume" id="btn_update_stud_resume">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                 </button>
                             </div>
                         <br>
                         </div>
                        </div><!--ENd of panel body 2-->
                        </form>
                        <br>
                         <div class="row">
                            <div class="col-md-12">
                                <iframe src="asset/resume_data/<?php echo $file_name; ?>" height="750px" width="100%"
                                frameborder="0"></iframe>
                           </div>
                          </div>
                       </div><!--end of tab of tab 2-->
                       <br>
                         <!--start of tab 3-->
                    <div role="tabpanel" class="tab-pane fade" id="tab3" aria-labelledby="tab3">

                      <div class="panel-body" style="padding-bottom:30px;">
                       <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">
                            <div class="col-md-4">
                              <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                            </div>
                            <div class="col-md-6">
                              <h4 style="color:white;"><b>STUDENT NAME:
                                <?php $stud_name = $lname. ", ".$fname." ".$mname;
                                  echo $lname. ", ".$fname." ".$mname; ?></b></h4>
                            </div>
                          </div>
                        </div>
                         <div class="row">
                            <div class="col-md-12">
                              <div class="col-md-4">
                                <h2 style="padding-left:5px;margin-top:40px;">SEMINAR ATTENDED</h2>
                              </div>
                              <div class="col-md-8">
                                <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v4" role="tablist">
                                  <li role="presentation" class="active">
                                    <a href="#tab_sa1" id="tabs_sa1" role="tab" data-toggle="tab" aria-expanded="true">S1</a>
                                  </li>
                                  <li role="presentation">
                                    <a href="#tab_sa2" id="tabs_sa2" role="tab" data-toggle="tab" aria-expanded="false">S2</a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>

                        <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                            <div class="col-md-2">
                            <a href="add_seminar_attended.php?stud_no=<?php echo $stud_no; ?>&stud_name=<?php echo $stud_name; ?>">
                               <button class="btn btn-success btn-outline btn-block btn-sm">
                                    <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                              </button>
                              </a>
                            </div>
                            <div class="col-md-6"></div>
                          </div>
                        </div>
                  <div id="tabsDemo4Content" class="tab-content tab-content-v4">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_sa1" aria-labelledby="tab_sa1">
                        <?php
                          $tbl_sa1 = "seminar_attended";
                          $columns_sa1 = "*";
                          $where_sa1 = ["stud_no"=>$stud_no];
                          $q_sa1 = $database->select($tbl_sa1,$columns_sa1,$where_sa1);

              print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables_sa1"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th class="text-center">EVENT NAME</th>
                          <th class="text-center">EVENT DATE</th>
                          <th class="text-center">SCHOOL YEAR</th>
                          <th class="text-center">TIME IN</th>
                          <th class="text-center">TIME OUT</th>
                          <th class="text-center">STATUS S1</th>
                        </tr>
                      </thead>
                      <tbody>';
                      foreach($q_sa1 as $seminar_attended_data){

                            $sa_id = $seminar_attended_data['sa_id'];
                            $sa_acad_year_start = $seminar_attended_data['acad_year_start'];
                            $sa_acad_year_end = $seminar_attended_data['acad_year_end'];
                            $semester = $seminar_attended_data['semester'];
                            $s1_timein =  $seminar_attended_data['s1_timein'];
                            $s1_timeout = $seminar_attended_data['s1_timeout'];
                            $s1_status = $seminar_attended_data['s1_status'];
                            $event_id = $seminar_attended_data['event_id'];

                            $event_manager = "event_manager";
                            $columns_em = "*";
                            $where_em = ["event_id"=>$event_id];
                            $q_em = $database->select($event_manager,$columns_em,$where_em);

                            foreach($q_em AS $q_em_data){
                              $event_name = $q_em_data['event_name'];
                              $event_date = $q_em_data['event_date'];
                         ?>
                      <tr>
                                <td><?php echo $event_name; ?></td>
                                <td><?php echo $event_date; ?></td>
                                <td><?php echo $acad_year_start." - ".$acad_year_end; ?></td>
                                <td>
                                  <?php
                                  if($s1_timein == "0"){
                                    echo "- - -";
                                  }else{
                                    echo date('g:i A',$s1_timein);
                                  }
                                  ?>
                                </td>
                                <td><?php
                                  if($s1_timeout == "0"){
                                    echo "- - -";
                                  }else{
                                    echo date('g:i A',$s1_timeout);
                                  }
                                  ?>
                                  </td>
                                <td><?php echo $s1_status; ?></td>
                      </tr>
                      <?php
                       }
                     }
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?>
                     </div>

                     <div role="tabpanel" class="tab-pane fade" id="tab_sa2" aria-labelledby="tab_sa2">
                        <?php
                          $tbl_sa2 = "seminar_attended_2";
                          $columns_sa2 = "*";
                          $where_sa2 = ["stud_no"=>$stud_no];
                          $q_sa2 = $database->select($tbl_sa2,$columns_sa2,$where_sa2);

              print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables_sa2" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th class="text-center">EVENT NAME</th>
                          <th class="text-center">EVENT DATE</th>
                          <th class="text-center">SCHOOL YEAR</th>
                          <th class="text-center">TIME IN</th>
                          <th class="text-center">TIME OUT</th>
                          <th class="text-center">STATUS S2</th>
                        </tr>
                      </thead>
                      <tbody>';
                      foreach($q_sa2 as $seminar_attended_data){

                            $sa_id = $seminar_attended_data['sa_id'];
                            $sa_acad_year_start = $seminar_attended_data['acad_year_start'];
                            $sa_acad_year_end = $seminar_attended_data['acad_year_end'];
                            $semester = $seminar_attended_data['semester'];
                            $s2_timein =  $seminar_attended_data['s2_timein'];
                            $s2_timeout = $seminar_attended_data['s2_timeout'];
                            $s2_status = $seminar_attended_data['s2_status'];
                            $event_id2 = $seminar_attended_data['event_id'];

                            $event_manager = "event_manager";
                            $columns_em = "*";
                            $where_em = ["event_id"=>$event_id2];
                            $q_em = $database->select($event_manager,$columns_em,$where_em);

                            foreach($q_em AS $q_em_data){
                              $event_name = $q_em_data['event_name'];
                              $event_date = $q_em_data['event_date'];
                         ?>
                      <tr>
                                <td><?php echo $event_name; ?></td>
                                <td><?php echo $event_date; ?></td>
                                <td><?php echo $acad_year_start." - ".$acad_year_end; ?></td>
                                <td>
                                  <?php
                                  if($s2_timein == "0"){
                                    echo "- - -";
                                  }else{
                                    echo date('g:i A',$s2_timein);
                                  }
                                  ?>
                                </td>
                                <td><?php
                                  if($s2_timeout == "0"){
                                    echo "- - -";
                                  }else{
                                    echo date('g:i A',$s2_timeout);
                                  }
                                  ?>
                                  </td>
                                <td><?php echo $s2_status; ?></td>
                      </tr>
                      <?php
                       }
                     }
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?>
                     </div>
                      </div>
                    </div><!--ENd of panel body 3-->
                   </div><!--end of tab of tab 3-->

                       <!--start of tab 4-->
                    <div role="tabpanel" class="tab-pane fade" id="tab4" aria-labelledby="tab4">
                        <div class="panel-body" style="padding-bottom:30px;">
                           <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">
                            <div class="col-md-4">
                              <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                            </div>
                            <div class="col-md-6">
                              <h4 style="color:white;"><b>STUDENT NAME:
                                <?php $stud_name = $lname. ", ".$fname." ".$mname;
                                  echo $lname. ", ".$fname." ".$mname; ?></b></h4>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                            <div class="col-md-2">
                            <a href="add_check_attire.php?stud_no=<?php echo $stud_no; ?>&stud_name=<?php echo $stud_name; ?>">
                               <button class="btn btn-success btn-outline btn-block btn-sm">
                                    <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                              </button>
                              </a>
                            </div>
                            <div class="col-md-2"></div>
                             <div class="col-md-8">

                               <?php

                                $table_ts = "check_attire";
                                $where_ts = [ "AND" => ["stud_no"=>$stud_no, "remarks"=>'OK'] ];
                                $count_ts = $database->count($table_ts, $where_ts);
                                echo '<h3>APPROVED # OF STICKERS: <strong>'.$count_ts.'</strong></h3>';
                                $pc = ($count_ts/8) * 100;
                                echo '<h3>PERCENT COMPLETED: <strong>'.$pc.'%</strong></h3>';
                                ?>

                            </div>
                          </div>
                        </div>
                             <?php

                      $table_ca = "check_attire";
                      $columns_ca = "*";
                      $where_ca = ["stud_no"=>$stud_no];
                      $ca=$database->select($table_ca,$columns_ca,$where_ca);

              print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables_ca"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="width:50px;"></th>
                          <th class="text-center">REMARKS</th>
                          <th class="text-center">OTHERS</th>
                          <th class="text-center">DATE CHECK</th>
                          <th class="text-center" style="width:100px;">ACTION</th>
                        </tr>
                      </thead>
                      <tbody>';
                      foreach($ca as $ca_data){

                            $attire_id = $ca_data['attire_id'];
                            $remarks = $ca_data['remarks'];
                            $others = $ca_data['others'];
                           $date_check = $ca_data['date_check'];
                        ?>
                      <tr>
                                <td>
                                  <?php
                                    if($remarks=="OK"){
                                      echo '<img src="asset/img/iconsticker.png" height="50px;" width="50px;">';
                                    } else{
                                      echo '<img src="asset/img/iconsticker_not_ok.png" height="50px;" width="50px;">';
                                    }
                                  ?>
                                </td>
                                <td><?php echo $remarks; ?></td>
                                <td><?php echo $others; ?></td>
                                <td><?php echo $date_check; ?></td>
                                <td><a href="update_check_attire.php?attire_id=<?php echo $attire_id; ?>&stud_no=<?php echo $stud_no; ?>&stud_name=<?php echo $stud_name; ?>">
                                  <button type="button" class="btn btn-outline btn-block btn-info">
                                    <span class="glyphicon glyphicon-pencil">&nbsp;</span>Update&nbsp;
                                  </button>
                                </a></td>
                      </tr>
                      <?php
                     }
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?>
                        </div><!--ENd of panel body 4-->
                       </div><!--end of tab of tab 4-->
                        <!--start of tab 5-->
                      <div role="tabpanel" class="tab-pane fade" id="tab5" aria-labelledby="tab5">
                      <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v2" role="tablist">
                        <li role="presentation" class="active">
                          <a href="#tabs-demo3-area1" id="tabs-demo3-1" role="tab" data-toggle="tab" aria-expanded="true">CURRENT JOB FAIR COMPANY VISIT</a>
                        </li>
                        <li role="presentation" class="">
                          <a href="#tabs-demo3-area2" role="tab" id="tabs-demo3-2" data-toggle="tab" aria-expanded="false">JOB FAIR COMPANY VISIT RECORDS</a>
                        </li>
                    </ul>
                    <div id="tabsDemo3Content" class="tab-content tabs-content-v2">
                      <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo3-area1" aria-labelledby="tabs-demo3-area1">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-2">
                            <a href="e2e_add_jobfair_student.php?stud_no=<?php echo $stud_no; ?>">
                               <button class="btn btn-success btn-outline btn-block btn-sm">
                                    <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                              </button>
                              </a>
                            </div>
                          </div>
                        </div>
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
                    $q_data_jf = $database->query("SELECT a.comp_id,a.comp_name,b.remarks,b.others,a.comp_address,a.contact_no,b.aljf_id,d.job_fair_id FROM company_info AS a INNER JOIN applicant_list_jf AS b INNER JOIN event_manager AS c INNER JOIN nop_job_fair AS d WHERE a.comp_id = d.comp_id AND d.comp_id = b.comp_id AND b.stud_no = '$stud_no' AND a.comp_id = b.comp_id AND b.event_id = c.event_id AND c.status = 'Active'")->fetchAll();

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
                          <th class="text-center" style="width:80px;">ACTION</th> 
                        </tr>
                      </thead>
                      <tbody>';
                      foreach($q_data_jf as $qData_jf){

                            $comp_name = $qData_jf['comp_name'];
                            $remarks = $qData_jf['remarks'];
                            $others = $qData_jf['others'];
                            $address = $qData_jf['comp_address'];
                            $contact_no = $qData_jf['contact_no'];
                            $aljf_id = $qData_jf['aljf_id'];
                            $comp_id = $qData_jf['comp_id'];
							$job_fair_id = $qData_jf['job_fair_id'];
                         ?>
                      <tr>
                                <td><?php echo $comp_name; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $contact_no; ?></td>
                                <td><?php echo $remarks; ?></td>
                                <td><?php echo $others; ?></td>
                                <td><a class="btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Update Applicant" href="e2e_admin_update_applicant_student.php?stud_no=<?php echo $stud_no; ?>&aljf_id=<?php echo $aljf_id; ?>"><span class="fa fa-pencil"></span></a>
                                <a class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Remove Applicant" href="e2e_admin_remove_applicant_student.php?aljf_id=<?php echo $aljf_id; ?>&stud_no=<?php echo $stud_no; ?>&job_fair_id=<?php echo $job_fair_id; ?>"><span class="fa fa-remove"></span></a>
                                </td>

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
                      <div role="tabpanel" class="tab-pane fade" id="tabs-demo3-area2" aria-labelledby="tabs-demo3-area2">
                        <div class="row" style="padding-top:10px;">
                                  <div class="col-md-12">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-6"></div>
                                     <div class="col-md-4">
                                     <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                                    </div>
                                  </div>
                                </div>
                        <div class="row">
                          <div class="col-md-12">
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
                      </div> <!--end of tab 5-->
                         <!--start of tab 6-->
                        <div role="tabpanel" class="tab-pane fade" id="tab6" aria-labelledby="tab6">
                        <ul id="tabs-demo3_ai" class="nav nav-tabs nav-tabs-v2" role="tablist">
                        <li role="presentation" class="active">
                          <a href="#tabs-demo3-area1_ai" id="tabs-demo3-1_ai" role="tab" data-toggle="tab" aria-expanded="true">ALUMNI INFORMATION</a>
                        </li>
                        <li role="presentation">
                          <a href="#tabs-demo3-area2_ai" role="tab" id="tabs-demo3-2_ai" data-toggle="tab" aria-expanded="false">ALUMNI RECORDS</a>
                        </li>
                        <li role="presentation">
                          <a href="#tabs-demo3-area3_ai" role="tab" id="tabs-demo3-3_ai" data-toggle="tab" aria-expanded="false">YEAR BOOK & GRADUATING PICTURE</a>
                        </li>
                        <li role="presentation">
                          <a href="#tabs-demo4-area4_ai" role="tab" id="tabs-demo4-4_ai" data-toggle="tab" aria-expanded="false">GRADUATION INFO</a>
                        </li>
                        <li role="presentation">
                        <a href="#tabs-demo5-area5_ai" role="tab" id="tabs-demo4-5_ai" data-toggle="tab" aria-expanded="false">ALUMNI ID</a>
                        </li>
                        </ul>
                         <div id="tabsDemo3Content" class="tab-content tabs-content-v2">
                           <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo3-area1_ai" aria-labelledby="tabs-demo3-area1_ai">
                            <div class="panel-body">
                              <div class="row" style="background-color:#3385ff;">
                                <div class="col-md-12">
                                  <div class="col-md-4">
                                    <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                                  </div>
                                  <div class="col-md-6">
                                    <h4 style="color:white;"><b>STUDENT NAME:
                                      <?php $stud_name = $lname. ", ".$fname." ".$mname;
                                        echo $lname. ", ".$fname." ".$mname; ?></b></h4>
                                  </div>
                                </div>
                              </div>
                               <div class="row" style="padding-top:10px;">
                                  <div class="col-md-12">
                                    <div class="col-md-2">
                                    <a href="e2e_add_alumni_records.php?stud_no=<?php echo $stud_no; ?>">
                                       <button class="btn btn-success btn-outline btn-block btn-sm">
                                            <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                      </button>
                                      </a>
                                    </div>
                                    <div class="col-md-10"></div>
                                     <div class="col-md-4">
                                    </div>
                                  </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                <?php
                                $q_data_ai=$database->query("SELECT * FROM alumni_info WHERE stud_no = '$stud_no'")->fetchAll();
                                print '<div class="panel-body">
                                  <div class="responsive-table">
                                  <table id="datatables_ai1"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th class="text-center">COMPANY NAME</th>
                                      <th class="text-center">POSITION</th>
                                      <th class="text-center">DATE CONTACTED</th>
                                      <th class="text-center">STATUS</th>
                                      <th class="text-center" style="width:50px;">ACTION</th> 
                                    </tr>
                                  </thead>
                                  <tbody>';
                                  foreach($q_data_ai as $qData_ai){

                                        $comp_name_ai = $qData_ai['comp_name'];
                                        $position_ai = $qData_ai['position'];
                                        $date_contact = $qData_ai['date_contact'];
                                        $work_status = $qData_ai['work_status'];
                                        $alumni_id = $qData_ai['alumni_id'];
                                     ?>
                                  <tr>
                                            <td><?php echo $comp_name_ai; ?></td>
                                            <td><?php echo $position_ai; ?></td>
                                            <td><?php echo $date_contact; ?></td>
                                            <td><?php echo $work_status; ?></td>
                                            <td><a href="e2e_update_alummi_info.php?alumni_id=<?php echo $alumni_id; ?>"><button type="button" class="btn btn-outline btn-info">
                                              <span class="fa fa-pencil"></span>
                                            </button></a>
                                            </td>
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
                            <div role="tabpanel" class="tab-pane fade" id="tabs-demo3-area2_ai" aria-labelledby="tabs-demo3-area2_ai">
                              <div class="panel-body">
                              <div class="row" style="background-color:#3385ff;">
                                <div class="col-md-12">
                                  <div class="col-md-4">
                                    <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                                  </div>
                                  <div class="col-md-6">
                                    <h4 style="color:white;"><b>STUDENT NAME:
                                      <?php $stud_name = $lname. ", ".$fname." ".$mname;
                                        echo $lname. ", ".$fname." ".$mname; ?></b></h4>
                                  </div>
                                </div>
                              </div>
                              <div class="row" style="padding-top:10px;">
                                  <div class="col-md-12">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-6"></div>
                                     <div class="col-md-4">
                                     <div id="buttons_ai2" class="pull-right" style="padding-top:6px;"></div>
                                    </div>
                                  </div>
                                </div>
                              <div class="row">
                                <div class="col-md-12">
                                <input type="hidden" id= "file_name_2" value="<?php echo $file_name_2; ?>"/>
                                <input type="hidden" id= "file_name_stud_no" value="<?php echo $file_name_stud_no; ?>"/>
                                 <input type="hidden" id= "file_name_program_code" value="<?php echo $file_name_program_code; ?>"/>
                                <?php
                                $q_data_ai=$database->query("SELECT * FROM alumni_info WHERE stud_no = '$stud_no'")->fetchAll();
                                print '<div class="panel-body">
                                  <div class="responsive-table">
                                  <table id="datatables_ai2"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th class="text-center">COMPANY NAME</th>
                                      <th class="text-center">COMPANY ADDRESS</th>
                                      <th class="text-center">POSITION</th>
                                      <th class="text-center">DATE HIRED</th>
                                      <th class="text-center">DATE CONTACTED</th>
                                      <th class="text-center"><label style="font-size:12px;"># OF MONTHS AFTER <br> HIRED AFTER GRAD</label></th>
                                      <th class="text-center">STATUS</th>
                                      
                                    </tr>
                                  </thead>
                                  <tbody>';
                                  foreach($q_data_ai as $qData_ai){

                                        $comp_name_ai = $qData_ai['comp_name'];
                                        $position_ai = $qData_ai['position'];
                                        $date_contact = $qData_ai['date_contact'];
                                        $work_status = $qData_ai['work_status'];
                                        $alumni_id = $qData_ai['alumni_id'];
                                        $no_month_hired_grad = $qData_ai['no_month_hired_grad'];
                                        $alumni_id = $qData_ai['alumni_id'];
                                        $date_hired = $qData_ai['date_hired'];
                                        $comp_address = $qData_ai['comp_address'];
                                     ?>
                                  <tr>
                                            <td><?php echo $comp_name_ai; ?></td>
                                            <td><?php echo $comp_address; ?></td>
                                            <td><?php echo $position_ai; ?></td>
                                            <td><?php echo $date_hired; ?></td>
                                            <td><?php echo $date_contact; ?></td>
                                            <td><?php echo $no_month_hired_grad; ?></td>
                                            <td><?php echo $work_status; ?></td>
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
                            </div><!--end of tab 2 for alumni info-->
                            <div role="tabpanel" class="tab-pane fade in" id="tabs-demo3-area3_ai" aria-labelledby="tabs-demo3-area3_ai">
                              <div class="panel-body">
                              <?php
                              $t_yb = "alumni_year_book_grad_pic";
                              $c_yb = "*";
                              $w_yb = ["stud_no"=>$stud_no];
                              $q_Data_alumni_yb_gp = $database->select($t_yb,$c_yb,$w_yb);
                              foreach($q_Data_alumni_yb_gp AS $qData_yb_gp){
                                $ybgp_id = $qData_yb_gp["ybgp_id"];
                                $year_book_status = $qData_yb_gp["year_book_status"];
                                $year_book_date = $qData_yb_gp["year_book_date"];
                                $grad_pic_status = $qData_yb_gp["grad_pic_status"];
                                $grad_pic_date = $qData_yb_gp["grad_pic_date"];

                                if($year_book_date == "none"){
                                  $show1 ="none";
                                }else{
                                   $show1 ="";
                                }

                                if($grad_pic_date == "none"){
                                  $show2 ="none";
                                }else{
                                   $show2 ="";
                                }
                              }
                              ?>
                              <div class="row" style="background-color:#3385ff;">
                                <div class="col-md-12">
                                  <div class="col-md-4">
                                    <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                                  </div>
                                  <div class="col-md-6">
                                    <h4 style="color:white;"><b>STUDENT NAME:
                                      <?php $stud_name = $lname. ", ".$fname." ".$mname;
                                        echo $lname. ", ".$fname." ".$mname; ?></b></h4>
                                  </div>
                                </div>
                              </div>
                              <form  id ="defaultform_ybgp" action="e2e_update_year_book_grad_pic_process.php" method="POST">
                                <input type="hidden" name="ybgp_id" value="<?php echo $ybgp_id; ?>" >
                                <input type="hidden" name="stud_no_ybgp" value="<?php echo $stud_no; ?>" >
                                <input type="hidden" name="stud_name_ybgp" value="<?php echo $stud_name; ?>" >
                                <div class="row">
                                  <div class="col-md-12">
                                     <div class="col-md-3">
                                      <h5 style="padding-left:5px;">YEAR BOOK STATUS</h5>
                                        <div class="form-group has-feedback">
                                            <select class="form-control" name="year_book_status" id="year_book_status_id">
                                              <option value="<?php echo $year_book_status; ?>"><?php echo $year_book_status; ?>
                                              </option>
                                              <option value="Unclaimed">Unclaimed </option>
                                              <option value="Claimed">Claimed </option>
                                            </select>
                                        </div>
                                     </div>
                                      <div class="col-md-3" style="display:<?php echo  $show1; ?>" id="year_book_date_id">
                                      <h5 style="padding-left:5px;">YEAR BOOK DATE </h5>
                                      <div class="form-group">
                                        <div class="dateContainer">
                                            <div class="input-group input-append date" id="year_book_date">
                                                <input type="text" class="form-control" name="year_book_date" value="<?php echo $year_book_date; ?>" maxlength="10"/>
                                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                      </div>
                                      </div>
                                     <div class="col-md-3">
                                      <h5 style="padding-left:5px;">GRADUATING PICTURE STATUS</h5>
                                        <div class="form-group has-feedback">
                                            <select class="form-control" name="grad_pic_status" id="grad_pic_status_id">
                                              <option value="<?php echo $grad_pic_status; ?>"><?php echo $grad_pic_status; ?>
                                              </option>
                                              <option value="Unclaimed">Unclaimed </option>
                                              <option value="Claimed">Claimed </option>
                                            </select>
                                        </div>
                                     </div>
                                      <div class="col-md-3" style="display:<?php echo  $show2; ?>" id="grad_pic_date_id">
                                        <h5 style="padding-left:5px;">GRADUATING PICTURE DATE </h5>
                                      <div class="form-group">
                                        <div class="dateContainer">
                                            <div class="input-group input-append date" id="grad_pic_date">
                                                <input type="text" class="form-control" name="grad_pic_date" value="<?php echo $grad_pic_date; ?>" maxlength="10"/>
                                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                      </div>
                                      </div>
                                  </div>
                                </div>

                                <br>
                             <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_update_alumni_ybgp" id="btn_update_alumni_ybgp">
                                  <span class="glyphicon glyphicon-pencil"></span> &nbsp;UPDATE
                                 </button>
                             </div>
                            </div>
                              </form>   
                              </div>
                            </div><!--end of tab 3 for alumni info-->
                            <div role="tabpanel" class="tab-pane fade in" id="tabs-demo4-area4_ai" aria-labelledby="tabs-demo4-area4_ai">
                              <div class="panel-body">
                              <?php
                              $t_gi = "alumni_grad_info";
                              $c_gi = "*";
                              $w_gi = ["stud_no"=>$stud_no];
                              $q_Data_alumni_gi = $database->select($t_gi,$c_gi,$w_gi);
                              foreach($q_Data_alumni_gi AS $q_Data_alumni_gi){
                                $grad_info_id = $q_Data_alumni_gi["grad_info_id"];
                                $semester_grad_info = $q_Data_alumni_gi["semester"];
                                $acad_year_start_grad_info = $q_Data_alumni_gi["acad_year_start"];
                                $acad_year_end_grad_info = $q_Data_alumni_gi["acad_year_end"];
                                $status_grad_info = $q_Data_alumni_gi["status"];
                              }
                              ?>
                              <div class="row" style="background-color:#3385ff;">
                                <div class="col-md-12">
                                  <div class="col-md-4">
                                    <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                                  </div>
                                  <div class="col-md-6">
                                    <h4 style="color:white;"><b>STUDENT NAME:
                                      <?php $stud_name = $lname. ", ".$fname." ".$mname;
                                        echo $lname. ", ".$fname." ".$mname; ?></b></h4>
                                  </div>
                                </div>
                              </div>
                              <form  id ="defaultform_grad_info" action="e2e_update_grad_info_process.php" method="POST">
                                <input type="hidden" name="grad_info_id" value="<?php echo $grad_info_id; ?>" >
                                <input type="hidden" name="stud_no_grad_info" value="<?php echo $stud_no; ?>" >
                                <input type="hidden" name="stud_name_grad_info" value="<?php echo $stud_name; ?>" >
                                 <div class="row">
                                    <div class="col-md-12">
                                    <div class="col-md-3">
                                    <h5 style="padding-left:5px;">PROGRAM</h5>
                                    <div class="form-group has-feedback">
                                        <h4 style="padding-left:7px;"><?php echo $program_code; ?></h4>
                                      </div>
                                    </div>
                                       <div class="col-md-3">
                                        <h5 style="padding-left:5px;">SEMESTER</h5>
                                          <div class="form-group has-feedback">
                                               <?php
                                                 $comstart1="";
                                                 $comstart2="";
                                                 $comend="-->";
                                                 if($semester=="1st Semester")
                                                 {
                                                $comstart1="<!--";
                                                 }
                                                 elseif($year=="2nd Semester")
                                                 {
                                                   $comstart2="<!--";
                                                 }
                                                 elseif($year=="Summer")
                                                 {
                                                   $comstart3="<!--";
                                                 }
                                                 ?>
                                              <select  name="semester_grad_info" id="semester_grad_info" class="form-control" placeholder="Year">
                                                <option><?php echo $semester_grad_info; ?></option>
                                                <?php echo $comstart1; ?><option value="1st Semester">1st Semester</option><?php echo $comend;?>
                                                <?php echo $comstart2; ?><option value="2nd Semester">2nd Semester</option><?php echo $comend;?>
                                                <?php echo $comstart3; ?><option value="Summer">Summer</option><?php echo $comend;?>
                                                ?>
                                                </select>
                                          </div>
                                      </div>                                    
                                    </div>  
                                  </div> 

                                  <div class="row">
                                    <div class="col-md-12">
                                    <div class="col-md-3">
                                            <h5 style="padding-left:5px;">ACADEMIC YEAR START</h5>
                                            <div class="form-group">
                                            <div class="dateContainer">
                                                <div class="input-group input-append date">
                                                    <input type="text" class="form-control" name="acad_year_start_grad_info" placeholder="(e.g.YYYY)" id="acad_year_start_grad_info" onchange="get_value_ays_2()" value="<?php echo $acad_year_start_grad_info; ?>"/>
                                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                      </div>

                                      <div class="col-md-3">
                                        <h5 style="padding-left:5px;">ACADEMIC YEAR END</h5>
                                       <div>
                                     <input type="hidden" id="acad_year_end_value_grad_info" name="acad_year_end_grad_info" value="<?php echo $acad_year_end_grad_info; ?>" />
                                     <h4 id ="acad_year_start_show_grad_info"><?php echo $acad_year_end_grad_info; ?></h4>
                                     </div>
                                   </div>
                                   <div class="col-md-3">
                                        <h5 style="padding-left:5px;">STATUS</h5>
                                          <div class="form-group has-feedback">
                                               <?php
                                                 $comstart1="";
                                                 $comstart2="";
                                                 $comend="-->";
                                                 if($status_grad_info=="Graduate")
                                                 {
                                                  $comstart1="<!--";
                                                 }
                                                 elseif($status_grad_info=="Not Graduate")
                                                 {
                                                   $comstart2="<!--";
                                                 }
                                                 ?>
                                              <select name="status_grad_info" id="status_grad_info" class="form-control" placeholder="status">
                                                <option><?php echo $status_grad_info; ?></option>
                                                <?php echo $comstart1; ?><option value="Graduate">Graduate</option><?php echo $comend;?>
                                                <?php echo $comstart2; ?><option value="Not Graduate">Not Graduate</option><?php echo $comend;?>
                                                </select>
                                          </div>
                                      </div>                                    
                                    </div>
                                  </div>
                                <br>
                             <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_update_alumni_grad_info" id="btn_update_alumni_grad_info">
                                  <span class="glyphicon glyphicon-pencil"></span> &nbsp;UPDATE
                                 </button>
                             </div>            
                          </div>
                              </form>
                              </div>
                            </div><!--end of tab 4 for alumni info-->
                            <div role="tabpanel" class="tab-pane fade in" id="tabs-demo5-area5_ai" aria-labelledby="tabs-demo4-area5_ai">
                              <div class="panel-body">
                              <div class="row" style="background-color:#3385ff;">
                                <div class="col-md-12">
                                  <div class="col-md-4">
                                    <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                                  </div>
                                  <div class="col-md-6">
                                    <h4 style="color:white;"><b>STUDENT NAME:
                                      <?php $stud_name = $lname. ", ".$fname." ".$mname;
                                        echo $lname. ", ".$fname." ".$mname; ?></b></h4>
                                  </div>
                                </div>
                              </div>
                               <div class="row" style="padding-top:10px;">
                                  <div class="col-md-12">
                                    <div class="col-md-2">
                                    <a href="e2e_add_alumni_id.php?stud_no=<?php echo $stud_no; ?>">
                                       <button class="btn btn-success btn-outline btn-block btn-sm">
                                            <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                      </button>
                                      </a>
                                    </div>
                                    <div class="col-md-10"></div>
                                     <div class="col-md-4">
                                    </div>
                                  </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                <?php
                                $q_data_ai=$database->query("SELECT * FROM alumni_info_id WHERE stud_no = '$stud_no'")->fetchAll();
                                $count = 1;
                                $student_name = $lname. ", ".$fname." ".$mname;
                                print '<div class="panel-body">
                                  <div class="responsive-table">
                                  <table id="datatables_ai3"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="width:50px;">#</th>
                                      <th class="text-center">DATE OF RENEWAL</th>
                                      <th class="text-center">DATE CLAIM</th>
                                      <th class="text-center">STATUS</th>
                                      <th class="text-center" style="width:80px;">ACTION</th> 
                                    </tr>
                                  </thead>
                                  <tbody>';
                                  foreach($q_data_ai as $qData_ai){

                                        $renewal_date = $qData_ai['renewal_date'];
                                        $claimed_date = $qData_ai['claimed_date'];
                                        $claimed_status = $qData_ai['claimed_status'];
                                        $alumni_id = $qData_ai['alumni_id'];
                                         $stud_no = $qData_ai['stud_no'];
                                     ?>
                                  <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $renewal_date; ?></td>
                                            <td><?php echo $claimed_date; ?></td>
                                            <td><?php echo $claimed_status; ?></td>
                                            <td><a href="e2e_update_alummi_id.php?alumni_id=<?php echo $alumni_id; ?>&stud_no=<?php echo $stud_no; ?>"><button type="button" class="btn btn-outline btn-info">
                                              <span class="fa fa-pencil"></span>
                                            </button></a>
                                            <a class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Remove Applicant" href="e2e_remove_alumni_info.php?alumni_id=<?php echo $alumni_id; ?>&stud_no=<?php echo $stud_no; ?>&student_name=<?php echo $student_name; ?>"><span class="fa fa-remove"></span></a>
                                            </td>
                                  </tr>
                                  <?php
                                  $count++;
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
                        </div> <!--end of tab 6-->
                      </div>
                      </div>
                    </div>
                   </div>
                </div>
           </div>

    <!-- end: content -->
          </div>
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
function get_value_ays(){
var selected_acad_year_start = document.getElementById("acad_year_start").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
 document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;
 }
 function get_value_ays_2(){
var selected_acad_year_start = document.getElementById("acad_year_start_grad_info").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
 document.getElementById("acad_year_start_show_grad_info").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value_grad_info").value =  acad_year_end;
 }
$(document).ready(function(){
  $('#datatables_sa1').DataTable();
  $('#datatables_sa2').DataTable();
  $('#bday')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'bday');
        });
    $('#year_book_date')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultform_ybgp').bootstrapValidator('revalidateField', 'year_book_date');
        });
        $('#grad_pic_date')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultform_ybgp').bootstrapValidator('revalidateField', 'grad_pic_date');
        });
            
 $('#acad_year_start')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'acad_year_start');
        });
$('#acad_year_start_grad_info')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm_grad_info').bootstrapValidator('revalidateField', 'acad_year_start_grad_info');
        });

  $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                stud_program_id: {
                    message: 'Program is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Program is required and can\'t be empty'
                        },
                    }
                },
                semester: {
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        },
                    },
                },
                acad_year_start: {
                    validators: {
                        notEmpty: {
                            message: 'Academic year start is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Invalid characters'
                        },
                        callback: {
                        message: 'Date is not in the range',
                        callback: function(value, validator) {
                            var m = new moment(value, 'YYYY', true);
                            var cy = document.getElementById("current_year").value;
                             var ny = document.getElementById("next_year").value;
                            if (!m.isValid()) {
                                return false;
                            }
                            return m.isAfter(cy) && m.isBefore(ny);
                        }
                       },
                    }
                },
                lname: {
                    message: 'Lastname name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Lastname is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Lastname must be more than 1 and less than 32 letters'
                        },
                 regexp: {
                            regexp: /^[a-zA-Z\-ñÑ ]+$/,
                            message: 'Lastname can only consist of letters'
                        }
                    }
                },
                fname: {
                    message: 'Firstname name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Firstname is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Firstname must be more than 1 and less than 32 letters'
                        },
                    regexp: {
                            regexp: /^[a-zA-Z\ñÑ ]+$/,
                            message: 'Firstname can only consist of letters'
                        }
                    }
                },
            mname: {
                    message: 'Middlename name is not valid.',
                    validators: {
                        notEmpty: {
                            message: 'Middlename is required and can\'t be empty. If the student does not have middlename please input. "."(period)'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Middlename must be more than 1 and less than 32 letters'
                        },
                regexp: {
                            regexp: /^[a-zA-Z\ñÑ .]+$/,
                            message: 'Middlename can only consist of letters'
                        },
                    }
                },
                gender: {
                    validators: {
                        notEmpty: {
                            message: 'Gender is required and can\'t be empty'
                        }
                    }
                },
                bday: {
                    validators: {
                        notEmpty: {
                            message: 'Birthday is required and can\'t be empty'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of birthday(e.g. MM/DD/YYYY)'
                        },
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Email is required and can\'t be empty'
                        },
              emailAddress: {
                            message: 'Invalid email address'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        },
                        stringLength: {
                            min: 10,
                            max: 64,
                            message: 'Email must be more than 10 and less than 64 characters long'
                        },
                    }
                },
        address: {
                    validators: {
                        notEmpty: {
                            message: 'Address is required and can\'t be empty'
                        },

                    }
                },
        contact_no: {
                    validators: {
                        notEmpty: {
                            message: 'Contact number is required and can\'t be empty'
                        },
            regexp: {
                            regexp: /[0-9]+$/,
                            message: 'Contact number can only consist of numbers'
                        },
            stringLength: {
                            min: 11,
                            max: 11,
                            message: 'Contact number must be 11 numbers'
                        }
                    }
                },
                fb_link: {
                    validators: {
                          regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    },
                },

                stud_dp: {
                  validators: {
                      file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 5242880,   // 100kb
                        message: 'The selected file is not valid,it should be (jpeg,jpg,png) and 5MB at maximum size'
                      }
                    }
                }
            }
        });
        $('#defaultForm2')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {

                resume_data: {
                    validators: {

                          file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: 5242880,   // 5mb
                            message: 'The selected file is not valid,it should be (pdf) and 5MB at maximum size'
                          }
                    }
                },
                resume_link: {
                    validators: {
                          regexp: {
                            regexp: /^['~a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    },
                }
            }
        })
        $('#defaultform_ybgp')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                year_book_date: {
                    validators: {
                        notEmpty: {
                            message: 'year book date is required and can\'t be empty'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format(e.g. MM/DD/YYYY)'
                        },
                    }
                },
                grad_pic_date: {
                    validators: {
                        notEmpty: {
                            message: 'graduating picture date is required and can\'t be empty'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format(e.g. MM/DD/YYYY)'
                        },
                    }
                },
            }
        })

$('#defaultform_grad_info')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
               semester_grad_info: {
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        },
                    },
                },
                program_id_grad_info: {
                    validators: {
                        notEmpty: {
                            message: 'Program code is required and can\'t be empty'
                        },
                    },
                },

                status_grad_info: {
                    validators: {
                        notEmpty: {
                            message: 'Status is required and can\'t be empty'
                        },
                    }
                },
            
                acad_year_start_grad_info: {
                    validators: {
                        notEmpty: {
                            message: 'Academic year start is required and can\'t be empty'
                        },
                         regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
              }
      })

  });
var table = $('#datatables_ca').DataTable();
$('#datatables_jf1').DataTable();
$('#datatables_jf2').DataTable();
$('#datatables_ai1').DataTable();
$('#datatables_ai3').DataTable();

var file_name_2 = document.getElementById('file_name_2').value;
var file_name_stud_no = document.getElementById('file_name_stud_no').value;
var file_name_program_code = document.getElementById('file_name_program_code').value;
 var table = $('#datatables_ai2').DataTable();
 var buttons = new $.fn.dataTable.Buttons(table, {
     buttons: [
            {
                extend: 'excelHtml5',
                title: 'Alumni Records - '+file_name_stud_no,  
                message: 'Student Name : '+file_name_2+' || Student Number : '+file_name_stud_no+' || Program: '+file_name_program_code,       
                 text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                 className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            },
            {
                extend: 'print',
                title: 'Alumni Records - '+file_name_stud_no,  
                 message: 'Student Name : '+file_name_2+' <br> Student Number : '+file_name_stud_no+' <br> Program : '+file_name_program_code,         
                text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            },
            {
                extend: 'pdf',
                title: 'Alumni Records - '+file_name_stud_no,  
                 message: 'Student Name : '+file_name_2+' || Student Number : '+file_name_stud_no+' || Program : '+file_name_program_code,         
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            },
            
        ]
    }).container().appendTo($('#buttons_ai2')); 
 $('#year_book_status_id').change(function(){
  selection = $(this).val();
  if(selection == 'Unclaimed'){
     $('#year_book_date_id').hide();
  }
  else{
    $('#year_book_date_id').show();
  }
});
  $('#grad_pic_status_id').change(function(){
  selection = $(this).val();
  if(selection == 'Unclaimed'){
     $('#grad_pic_date_id').hide();
  }
  else{
    $('#grad_pic_date_id').show();
  }
});

</script>
<!-- end: Javascript -->
</body>
</html>
