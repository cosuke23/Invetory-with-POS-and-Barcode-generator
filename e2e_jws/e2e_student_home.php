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
                        <label  class="active">
                          <a href="e2e_student_home.php"><i class="glyphicon glyphicon-user"></i>Student Information</a>
                        </label><br>
                          <label>
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
                        <h1 class="animated fadeInLeft">STUDENT INFORMATION</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                         View and update your student information.&nbsp;
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <ul id="tabs-demo5" class="nav nav-tabs nav-tabs-v4" role="tablist">
                        <li role="presentation" class="active">
                          <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="icons icon-user"></span></a>
                        </li>
                        <li role="presentation">
                          <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="false"><span class="fa fa-file-pdf-o"></span></a>
                        </li>
                        <li role="presentation">
                          <a href="#tab3" id="tabs3" role="tab" data-toggle="tab" aria-expanded="false"><span class="fa fa-calendar-check-o"></span></a>
                        </li>
                        <li role="presentation">
                          <a href="#tab4" id="tabs4" role="tab" data-toggle="tab" aria-expanded="false"><span class="fa fa-male"></span></a>
                        </li>
                      </ul>
                    </div>
                     
                    <?php
                    
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
                      ?>
                    <div id="tabsDemo5Content" class="tab-content tab-content-v4">
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
                                  window.location.href="e2e_student_home.php";
                                }
                              });
                          </script>';
                            }
                          else if(isset($_GET['success_ca']) && isset($_GET['stud_no'])){
                            
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
                                  window.location.href="e2e_student_home.php";
                                }
                              });
                          </script>';
                            }elseif(isset($_GET['success1']) && isset($_GET['stud_no']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['mname'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $lname_up = $_GET['lname'];
                              $fname_up = $_GET['fname'];
                              $mname_up = $_GET['mname'];
                            
                             echo '<script language = javascript>
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
                                  window.location.href="e2e_student_home.php";
                                }
                              });
                          </script>';
                            } 
                          ?>
                    <!--start of tab 1-->
                    <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
                    <form id="defaultForm" method="post" action="update_Student_records_process_2.php" enctype="multipart/form-data">
                    <!--start of panel body 1-->
                      <div class="panel-body" style="padding-bottom:30px;">
                         
                        <div class="row">
                           <div class="col-md-3"> 
                           <?php 
                             echo '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:200px;width:200px;">';
                             ?>
                           </div>
                          <div class="col-md-6" style="display:none;">
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
                                    <h4><?php echo $semester; ?></h4>
                                    <input type="hidden" name="semester" value="<?php echo $semester; ?>" />
                              </div>
                          </div>
                          <div class="col-md-3">
                             <input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>"/>
                            <input type="hidden" name="next_year" id="next_year" value="<?php echo $next_year; ?>"/>
                                  <h5 style="padding-left:5px;">ACADEMIC YEAR START</h5>
                                  <div class="form-group">
                                  <h4><?php echo $acad_year_start; ?></h5>
                                  <input type="hidden" name="acad_year_start" value="<?php echo $acad_year_start; ?>" />
                              </div>
                            </div>
                             <div class="col-md-3">
                                <h5 style="padding-left:5px;">ACADEMIC YEAR END</h5>
                                  <div>
                                   <h4 ><?php echo $acad_year_end; ?></h4>
                                    <input type="hidden" name="acad_year_end" value="<?php echo $acad_year_end; ?>" />
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
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_update_stud_info" id="btn_update_stud_info">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                 </button>
                             </div>
                             
                          </div>
                         
                        </div><!--ENd of panel body 1-->
                        </form>
                       </div><!--end of tab of tab 1-->

                       <!--start of tab 2-->
                    <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">
                    <form id="defaultForm2" method="post" action="update_Student_resume_process_2.php" enctype="multipart/form-data">
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
                            <div class="col-md-4">
                            <h5>UPLOAD DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="resume_data" placeholder="Upload Resume" alt="resume data"/> 
                               </div>
                          </div>
                          <div class="col-md-4">
                          
                           <h5>RESUME DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                            <a target="_blank" href="asset/resume_data/<?php echo $file_name; ?>" style="font-size:20px;">
                              <span class="fa fa-street-view"></span> &nbsp;VIEW RESUME &nbsp;
                            </a>
                          </div>

                          </div>
                         <br>

                             <div class="row">
                            <div class="col-md-8"></div>
                             
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_update_stud_resume" id="btn_update_stud_resume">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                 </button>
                             </div>
                          </div>                         
                        </div><!--ENd of panel body 2-->
                        </form>
                       </div><!--end of tab of tab 2-->

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
                            <div class="col-md-10"></div>
                             <div class="col-md-4">
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
                         <!-- <th class="text-center" style="width:100px;">ACTION</th>     -->            
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
                                <td><img src="asset/img/iconsticker.png" height="50px;" width="50px;"></td>
                                <td><?php echo $remarks; ?></td>
                                <td><?php echo $others; ?></td>
                                <td><?php echo $date_check; ?></td>
                             <!--   <td><a href="update_check_attire.php?attire_id=<?php echo $attire_id; ?>&stud_no=<?php echo $stud_no; ?>&stud_name=<?php echo $stud_name; ?>">
                                  <button type="button" class="btn btn-outline btn-block btn-info">
                                    <span class="glyphicon glyphicon-pencil">&nbsp;</span>Update&nbsp;
                                  </button>
                                </a></td>        --> 
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
function get_value_ays(){
var selected_acad_year_start = document.getElementById("acad_year_start").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
 document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;
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
                            regexp: /^[a-zA-Z\- ]+$/,
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
                            regexp: /^[a-zA-Z\ ]+$/,
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
                            regexp: /^[a-zA-Z\ .]+$/,
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
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
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
  });
var table = $('#datatables_ca').DataTable();

</script>
<!-- end: Javascript -->
</body>
</html>