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
                <li ><a href="#" class="opener-right-menu"><span class="fa fa-coffee"></span></a></li>
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
                        <h1 class="animated fadeInLeft">ALUMNI INFORMATION</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;"> 
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <h3>UPDATE ALUMNI INFO</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if(isset($_GET['alumni_id'])){
                          $alumni_id = $_GET['alumni_id'];
                          $q_data = $database->query("SELECT a.*,b.*,c.program_code FROM student_info AS a INNER JOIN alumni_info AS b INNER JOIN program_list AS c WHERE c.program_id = a.program_id AND a.stud_no = b.stud_no AND b.alumni_id = '$alumni_id'" )->fetchAll();
                          foreach($q_data AS $q_Data){
                            $lname = $q_Data['lname'];
                            $fname = $q_Data['fname'];
                            $mname = $q_Data['mname'];
                            $stud_dp = $q_Data['stud_dp'];
                            $program_code = $q_Data['program_code'];
                            $contact_no = $q_Data['contact_no'];
                            $address = $q_Data['address'];
                            $email = $q_Data['email'];
                            $industry = $q_Data['industry'];
                            $subclass = $q_Data['sub_class'];
                            $industry = $q_Data['industry'];
                            $division = $q_Data['division'];
                            $remarks = $q_Data['remarks'];

                            //alumni DATA
                            $comp_name = $q_Data['comp_name'];
                            $comp_address = $q_Data['comp_address'];
                            $stud_no = $q_Data['stud_no'];
                            //$student_status = $q_Data['student_status'];
                            $position = $q_Data['position'];
                            $date_hired = $q_Data['date_hired'];
                            $work_status = $q_Data['work_status'];
                            $no_month_hired_grad = $q_Data['no_month_hired_grad'];
                            $date_contact = $q_Data['date_contact'];
                            $alumni_id = $q_Data['alumni_id'];

                            if($work_status == "Continuing Study"){
                              $display_status = "none";
                            }else{
                              $display_status = "";
                            }
                          }
                        }
                         
                        ?>
                       
                          <div class="row">
                           <div class="col-md-3"> 
                           <?php 
                             echo '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="border:1px;height:200px;width:200px;">';
                             ?>
                           </div>
                           <div class="col-md-3">
                              <h4>PROGRAM : <?php echo $program_code; ?></h4>
                           </div>
                           <div class="col-md-9">
                              <h4>CONTACT NUMBER : <?php echo $contact_no; ?></h4>
                           </div>
                           <div class="col-md-9">
                              <h4>ADDRESS : <?php echo $address; ?></h4>
                           </div>
                           <div class="col-md-9">
                              <h4>EMAIL : <?php echo $email; ?></h4>
                           </div>
                        </div>
                        <br>
                       <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">
                            <div class="col-md-6">
                               <h4 style="color:white;"><b>STUDENT NAME:  <?php echo $lname. " ".$fname.", ".$mname; ?></b></h4>
                            </div>
                            <div class="col-md-6">
                               <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                            </div>
                          </div>
                        </div>
                       
                        <form action="e2e_update_alumni_info_process.php" id="defaultForm" method="POST">
                          <input type="hidden" name="stud_no" value="<?php echo $stud_no; ?>"/>
                          <input type="hidden" name="alumni_id" value="<?php echo $alumni_id; ?>"/>
                          <input type="hidden" name="student_name" value="<?php echo $lname.", ".$fname." ".$mname; ?>">

                          <div class="row">
                            <div class="col-md-12">
                             <div class="col-md-3">
                                 <h5 style="padding-left:5px;">WORK STATUS</h5>
                                  <div class="form-group has-feedback">
                                    <SELECT name="work_status" id="work_status" class="form-control">
                                    <option value="<?php echo $work_status; ?>"><?php echo $work_status; ?></option>
                                    <option value="Employed">Employed</option>
                                    <option value="Unemployed">Unemployed</option>
                                    <option value="Continuing Study">Continuing Study</option>
                                    <option value="Abroad">Abroad</option>
                                    <option value="Self Employed">Self Employed</option>
                                    <option value="Under Graduate">Under Graduate</option>
                                  </SELECT>
                                  </div>
                                </div>
                              <div class="col-md-6">
                              <h5 style="padding-left:5px;">COMPANY NAME</h5>
                              <div class="form-group has-feedback">
                                  <input type="text" class="form-control" name="comp_name" value="<?php echo $comp_name; ?>"/>
                              </div>
                              </div>
                              
                                <div class="col-md-3">
                                  <h5 style="padding-left:5px;">DATE CONTACTED</h5>
                                <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="date_contact">
                                          <input type="text" class="form-control" name="date_contact" value="<?php echo $date_contact; ?>" maxlength="10"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                                </div>
                                </div>
                              
                              </div>
                            </div>

                           <div class="row">
                            <div class="col-md-12">
                                 <h5 style="padding-left:5px;">COMPANY ADDRESS</h5>
                                <div class="form-group has-feedback">
                                  <textarea rows="2" name="comp_address" id="comp_address" class="form-control"><?php echo $comp_address ; ?></textarea>
                                </div>
                            </div>
                          </div>

                           <div class="row" style="display:<?php echo $display_status; ?>">
                            <div class="col-md-12">
                                <div class="col-md-3" id="position">
                                <h5 style="padding-left:5px;">POSITION</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="position" class="form-control" maxlength="200" placeholder="Position"  value="<?php echo $position; ?>"/>
                                </div>
                               </div>
                                <div class="col-md-3" id ="date_hired_status">
                                <h5 style="padding-left:5px;">DATE HIRED</h5>
                                <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="date_hired">
                                          <input type="text" class="form-control" name="date_hired" value="<?php echo $date_hired; ?>" maxlength="10"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                                </div>
                                </div>
                                 <div class="col-md-3" id="no_month_hired_grad">
                                <h5 style="padding-left:5px;"># OF MONTH BEFORE HIRED</h5>
                                <div class="form-group has-feedback">
                                  <SELECT name="no_month_hired_grad"  class="form-control">
                                    <option value="<?php echo $no_month_hired_grad; ?>"><?php echo $no_month_hired_grad; ?></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                  </SELECT>
                                </div>
                               </div>
                                 <div class="col-md-12">
                                <div class="col-md-3" id="position">
                                <h5 style="padding-left:5px;">Division</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="division" class="form-control" maxlength="200" value="<?php echo $division; ?>"  />
                                </div>
                               </div>
                                   <div class="col-md-3" id="position">
                                <h5 style="padding-left:5px;">Sub Class</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="sub_class" class="form-control" maxlength="200" value="<?php echo $subclass; ?>"  />
                                </div>
                               </div>

                                 <div class="col-md-3" id="position">
                                <h5 style="padding-left:5px;">Remarks</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="remarks" class="form-control" maxlength="200" value="<?php echo $remarks; ?>"  />
                                </div>
                               </div>


                               <div class="col-md-3" id="industry" >
                                <h5 style="padding-left:5px;">Services</h5>
                                <div class="form-group has-feedback">
                                  <SELECT name="industry""  class="form-control">
                                    <option value=""><?php echo $industry; ?></option>
                                    <option value="ACCOMMODATION AND FOOD SERVICES ACTIVITIES">ACCOMMODATION AND FOOD SERVICES ACTIVITIES</option>
                                    <option value="ARTS, ENTERTAINMENT AND RECREATION">ARTS, ENTERTAINMENT AND RECREATION</option>
                                    <option value="EDUCATION">EDUCATION</option>
                                    <option value="FINANCIAL AND INSURANCE ACTIVITIES">FINANCIAL AND INSURANCE ACTIVITIES</option>
                                    <option value="HUMAN HEALTH AND SOCIAL WORK ACTIVITIES">HUMAN HEALTH AND SOCIAL WORK ACTIVITIES</option>
                                    <option value="INFORMATION AND COMMUNICATION">INFORMATION AND COMMUNICATION</option>
                                    <option value="PROFESSIONAL, SCIENTIFIC AND TECHNICAL ACTIVITIES">PROFESSIONAL, SCIENTIFIC AND TECHNICAL ACTIVITIES</option>
                                    <option value="REAL ESTATE ACTIVITIES">REAL ESTATE ACTIVITIES</option>
                                    <option value="WHOLESALE & RETAIL TRADE, REPAIR OF MOTOR VEHICLES, MOTORCYCLES & MOTORCYCLES">WHOLESALE & RETAIL TRADE, REPAIR OF MOTOR VEHICLES, MOTORCYCLES & MOTORCYCLES</option>
                                    <option value="TRANSPORT AND STORAGE">TRANSPORT AND STORAGE</option>
                                    <option value="ADMINISTRATIVE AND SUPPORT SERVICE ACTIVITIES">ADMINISTRATIVE AND SUPPORT SERVICE ACTIVITIES</option>
                                    <option value="PUBLIC ADMINISTRATION AND DEFENCE, COMPULSORY SOCIAL SECURITY">PUBLIC ADMINISTRATION AND DEFENCE, COMPULSORY SOCIAL SECURITY</option>
                                    <option value="OTHER SERVICE ACTIVITIES">OTHER SERVICE ACTIVITIES</option>
                                    <option value="ACTIVITIES OF HOUSEHOLDS AS EMPLOYERS, UNDIFFERENTIATED GOODS-AND SERVICES-PRODUCING ACTIVITIES OF HOUSEHOLDS FOR OWN USE">ACTIVITIES OF HOUSEHOLDS AS EMPLOYERS, UNDIFFERENTIATED GOODS-AND SERVICES-PRODUCING ACTIVITIES OF HOUSEHOLDS FOR OWN USE</option>
                                    <option value="ACTIVITIES OF EXTRATERRITORIAL ORGANIZATION AND BODIES">ACTIVITIES OF EXTRATERRITORIAL ORGANIZATION AND BODIES</option>
                                    <option value="CONSTRUCTION">CONSTRUCTION</option>
                                    <option value="ELECTRICITY, GAS , STEAM AND  AIR CONDITIONING SUPPLY">ELECTRICITY, GAS , STEAM AND  AIR CONDITIONING SUPPLY</option>
                                    <option value="MANUFACTURING ">MANUFACTURING </option>
                                    <option value="MINING AND QUARRYING">MINING AND QUARRYING</option>
                                    <option value="WATER SUPPLY, SEWERAGE, WASTE MANAGEMENT AND REMEDIATION ACTIVITIES">WATER SUPPLY, SEWERAGE, WASTE MANAGEMENT AND REMEDIATION ACTIVITIES</option>
                                    <option value="AGRICULTURE, FORESTRY  AND FISHING">AGRICULTURE, FORESTRY  AND FISHING</option>
                                  </SELECT>
                                </div>
                               </div>
                            </div>
                              
                            </div>
                          </div>

                            <br>
                             <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_update_alumni_info" id="btn_update_alumni_info">
                                  <span class="glyphicon glyphicon-pencil"></span> &nbsp;UPDATE
                                 </button>
                             </div>
                              <div class="col-md-4">
                               <a href="e2e_update_student_records.php?stud_no=<?php echo $stud_no; ?>"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                             </div>
                          </div>
                        </form>
                     </div>
                  </div>
                </div>
              </div>
            </div><!-- end: content -->

          <!-- start: right menu -->
            <div id="right-menu">
              <div class="tab-content">
                <div id="right-menu-user" class="tab-pane fade in active">
                  <div class="search col-md-12">
                    <input type="text" placeholder="search.."/>
                  </div>
                  <div class="user col-md-12">
                   <ul class="nav nav-list">
                    <li class="online">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="gadget">
                        <span class="fa  fa-mobile-phone fa-2x"></span> 
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="away">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="gadget">
                        <span class="fa  fa-desktop"></span> 
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="offline">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="offline">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="online">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="gadget">
                        <span class="fa  fa-mobile-phone fa-2x"></span> 
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="offline">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="online">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="gadget">
                        <span class="fa  fa-mobile-phone fa-2x"></span> 
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="offline">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="offline">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="online">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="gadget">
                        <span class="fa  fa-mobile-phone fa-2x"></span> 
                      </div>
                      <div class="dot"></div>
                    </li>
                    <li class="online">
                      <img src="asset/img/avatar.jpg" alt="user name">
                      <div class="name">
                        <h5><b>Bill Gates</b></h5>
                        <p>Hi there.?</p>
                      </div>
                      <div class="gadget">
                        <span class="fa  fa-mobile-phone fa-2x"></span> 
                      </div>
                      <div class="dot"></div>
                    </li>

                  </ul>
                </div>
                <!-- Chatbox -->
                <div class="col-md-12 chatbox">
                  <div class="col-md-12">
                    <a href="#" class="close-chat">X</a><h4>Akihiko Avaron</h4>
                  </div>
                  <div class="chat-area">
                    <div class="chat-area-content">
                      <div class="msg_container_base">
                        <div class="row msg_container send">
                          <div class="col-md-9 col-xs-9 bubble">
                            <div class="messages msg_sent">
                              <p>that mongodb thing looks good, huh?
                                tiny master db, and huge document store</p>
                                <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                              </div>
                            </div>
                            <div class="col-md-3 col-xs-3 avatar">
                              <img src="asset/img/avatar.jpg" class=" img-responsive " alt="user name">
                            </div>
                          </div>

                          <div class="row msg_container receive">
                            <div class="col-md-3 col-xs-3 avatar">
                              <img src="asset/img/avatar.jpg" class=" img-responsive " alt="user name">
                            </div>
                            <div class="col-md-9 col-xs-9 bubble">
                              <div class="messages msg_receive">
                                <p>that mongodb thing looks good, huh?
                                  tiny master db, and huge document store</p>
                                  <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                                </div>
                              </div>
                            </div>

                            <div class="row msg_container send">
                              <div class="col-md-9 col-xs-9 bubble">
                                <div class="messages msg_sent">
                                  <p>that mongodb thing looks good, huh?
                                    tiny master db, and huge document store</p>
                                    <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                                  </div>
                                </div>
                                <div class="col-md-3 col-xs-3 avatar">
                                  <img src="asset/img/avatar.jpg" class=" img-responsive " alt="user name">
                                </div>
                              </div>

                              <div class="row msg_container receive">
                                <div class="col-md-3 col-xs-3 avatar">
                                  <img src="asset/img/avatar.jpg" class=" img-responsive " alt="user name">
                                </div>
                                <div class="col-md-9 col-xs-9 bubble">
                                  <div class="messages msg_receive">
                                    <p>that mongodb thing looks good, huh?
                                      tiny master db, and huge document store</p>
                                      <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                                    </div>
                                  </div>
                                </div>

                                <div class="row msg_container send">
                                  <div class="col-md-9 col-xs-9 bubble">
                                    <div class="messages msg_sent">
                                      <p>that mongodb thing looks good, huh?
                                        tiny master db, and huge document store</p>
                                        <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                                      </div>
                                    </div>
                                    <div class="col-md-3 col-xs-3 avatar">
                                      <img src="asset/img/avatar.jpg" class=" img-responsive " alt="user name">
                                    </div>
                                  </div>

                                  <div class="row msg_container receive">
                                    <div class="col-md-3 col-xs-3 avatar">
                                      <img src="asset/img/avatar.jpg" class=" img-responsive " alt="user name">
                                    </div>
                                    <div class="col-md-9 col-xs-9 bubble">
                                      <div class="messages msg_receive">
                                        <p>that mongodb thing looks good, huh?
                                          tiny master db, and huge document store</p>
                                          <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="chat-input">
                                <textarea placeholder="type your message here.."></textarea>
                              </div>
                              <div class="user-list">
                                <ul>
                                  <li class="online">
                                    <a href=""  data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <div class="user-avatar"><img src="asset/img/avatar.jpg" alt="user name"></div>
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="offline">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="away">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="online">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="offline">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="away">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="offline">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="offline">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="away">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="online">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="away">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                  <li class="away">
                                    <a href="" data-toggle="tooltip" data-placement="left" title="Akihiko avaron">
                                      <img src="asset/img/avatar.jpg" alt="user name">
                                      <div class="dot"></div>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                         
             
            </div>  
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

<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#date_contact')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'date_contact');
        });
  $('#date_hired')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'date_hired');
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
                remarks: {
                    message: 'Remarks is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Remarks is required and can\'t be empty'
                        },
                    }
                },
                comp_name: {
                    message: 'Company Name is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Company Name is required and can\'t be empty'
                        },
                    }
                },
                comp_address: {
                    message: 'Company Address is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Company Address is required and can\'t be empty'
                        },
                    }
                },
                
                position: {
                    message: 'Position is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Position is required and can\'t be empty'
                        },
                    }
                },
                date_contact: {
                    validators: {
                        notEmpty: {
                            message: 'Date Contact is required and can\'t be empty'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of Date(e.g. MM/DD/YYYY)'
                        },
                    }
                },
                date_hired: {
                    validators: {
                        notEmpty: {
                            message: 'Date hired is required and can\'t be empty'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of Date(e.g. MM/DD/YYYY)'
                        },
                    }
                },
              }
        }) 
});
 $('#work_status').change(function(){
  selection = $(this).val();
  if(selection == 'Continuing Study'){
     $('#date_hired_status').hide();
     $('#no_month_hired_grad').hide();
    $('#position').hide();
  }
  else{
    $('#date_hired_status').show();
    $('#no_month_hired_grad').show();
     $('#position').show();
  }
});
</script>
<!-- end: Javascript -->
</body>
</html>