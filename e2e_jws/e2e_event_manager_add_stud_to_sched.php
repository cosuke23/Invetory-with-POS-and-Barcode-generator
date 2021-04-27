<?php
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

$rnd_ai = (mt_rand(1000,10000));
$year = date('Y');
$comp_user = 'CMP'.$year.$rnd_ai ;

$current_year = date("Y") - 1;
$next_year = date("Y") + 1;
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
                <li class="user-name"><span>&nbsp; Hi' <?php echo  $title." ".$fname; ?>&nbsp;</span></li>
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
                      <label><a href="e2e_student_records.php">
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
                      <label class="active"><a href="e2e_event_manager.php">
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
                        <h1 class="animated fadeInLeft">EVENT MANAGER</h1>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Add New Event (Mock Interview)</h3></div>
                    <br>
                    <form id="defaultForm" method="post" action="e2e_event_manager_add_new_event_process.php"  enctype="multipart/form-data">
                    <?php
                      if(isset($_GET['success']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Successfully Added!</strong> Click the event info on the sidebar to view the information.
                              </div>
                          </div>
                        </div>
                      </div>';
                      } ?>

                      <div class="panel-body" style="padding-bottom:30px;">
                         <input name="event_id" type="hidden" value ="<?php echo $event_id ?>"/>

                      <div class="row">
                        <div class="col-md-4">
                            <h5 style="padding-left:5px;">EVENT CODE</h5>
                              <div class="form-group has-feedback">
                               <input type="text" name="event_code" id="event_code" class="form-control" placeholder="Event Code"/>
                            </div>
                        </div>
                          <div class="col-md-8">
                            <h5 style="padding-left:5px;">EVENT NAME</h5>
                            <div class="form-group has-feedback">
                               <input type="text" name="event_name" class="form-control" placeholder="Event Name"/>
                            </div>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-md-5">
                                <h5 style="padding-left:5px;">START DATE</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="start_date">
                                          <input type="text" class="form-control" name="start_date" placeholder="(e.g.mm/dd/YYYY)" value="<?php //echo date("m/d/Y")?>" maxlength="10"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                           </div>
                           <div class="col-md-5">
                                   <h5 style="padding-left:5px;">END DATE</h5>
                                     <div class="form-group">
                                     <div class="dateContainer">
                                         <div class="input-group input-append date" id="end_date">
                                             <input type="text" class="form-control" name="end_date" placeholder="(e.g.mm/dd/YYYY)" value="<?php //echo date("m/d/Y")?>" maxlength="10"/>
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                         </div>
                                     </div>
                                 </div>
                              </div>
                        <div class="col-md-2">
                          <h5 style="padding-left:5px;">NO. OF SESSION</h5>
                          <div class="form-group has-feedback">
                            <select class="form-control" name="no_of_session" id="no_of_session" class="form-control" placeholder="">
                              <option></option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                          <div class="col-md-5">
                             <input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>"/>
                            <input type="hidden" name="next_year" id="next_year" value="<?php echo $next_year; ?>"/>
                                  <h5 style="padding-left:5px;">ACADEMIC YEAR START</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date">
                                          <input type="text" class="form-control" name="acad_year_start" placeholder="(e.g.YYYY)" id="acad_year_start" onchange="get_value_ays()" value="<?php //echo $current_year; ?>"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                             <div class="col-md-3">
                                <h5 style="padding-left:5px;">ACADEMIC YEAR END</h5>
                                  <div>
                                   <input type="hidden" id="acad_year_end" name="acad_year_end" />
                                   <h4 id ="acad_year_start_show"></h4>
                                   </div>
                             </div>
                             <div class="col-md-4">
                             <h5 style="padding-left:5px;">SEMESTER</h5>
                           <div class="form-group has-feedback">
                             <select class="form-control" name="semester" class="form-control" placeholder="">
                               <option></option>
                               <option value="1st Semester">1st Semester</option>
                               <option value="2nd Semester">2nd Semester</option>
                             </select>
                           </div>
                           </div>
                          </div>

                          <div class="row">
                        <div class="col-md-6">
                            <h5 style="padding-left:5px;">(1)TIME-IN</h5>
                              <div class="form-group has-feedback">
                               <input type="time" id="time_in_1" name="time_in_1" class="form-control" placeholder=""/>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <h5 style="padding-left:5px;">(1)TIME-OUT</h5>
                            <div class="form-group has-feedback">
                               <input type="time" id="time_out_1" name="time_out_1" class="form-control" placeholder=""/>
                            </div>
                          </div>
                      </div>

                      <div class="row" id="session_2" hidden>
                        <div class="col-md-6">
                            <h5 style="padding-left:5px;">(2)TIME-IN</h5>
                              <div class="form-group has-feedback">
                               <input type="time" id="time_in_2" name="time_in_2" class="form-control" placeholder=""/>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <h5 style="padding-left:5px;">(2)TIME-OUT</h5>
                            <div class="form-group has-feedback">
                               <input type="time" id="time_out_2" name="time_out_2" class="form-control" placeholder=""/>
                            </div>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">TYPE</h5>
                          <div class="form-group has-feedback">
                            <select class="form-control" name="event_type" class="form-control" placeholder="" disabled="disabled">
                              <option></option>
                              <option value="Job Fair">Job Fair</option>
                              <option value="Seminar">Seminar</option>
                              <option value="Mock Interview" selected="true">Mock Interview</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">Status</h5>
                          <div class="form-group has-feedback">
                            <select class="form-control" name="status" class="form-control" placeholder="">
                              <option></option>
                              <option value="Active">Active</option>
                              <option value="Not Active">Not Active</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">No. of Batch</h5>
                          <div class="form-group has-feedback">
                            <select class="form-control" name="batch_no" class="form-control" placeholder="">
                              <option></option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                            </select>
                          </div>
                        </div>
                      </div>


                      <div class="row"><br><br>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-success btn-block" name="btn-add" id="btn-add"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button>
                        </div>
                        <div class="col-md-4">
                          
                            <a href="e2e_event_manager_add_new_mi_sched_stud_set.php?mi_sched_id=<?php echo $_GET['mi_sched_id'];?>&event_id=<?php echo $_GET['event_id'];?>&event_name=<?php echo $_GET['event_name'];?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                        </div>
                      </div>
                </div>
              </div>
              </form>
            </div><!-- end: content -->
          </div>

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
                      <a href="*"><i class="glyphicon fa fa-building-o"></i>&nbsp; Company Records</a>
                      <a href="*"><i class="glyphicon fa fa-thumbs-o-up"></i>&nbsp; OJT Endorsement</a>
                      <a href="*"><i class="glyphicon fa fa-user-secret"></i>&nbsp; Check Attire</a>
                      <a href="*"><i class="glyphicon fa fa-smile-o"></i>&nbsp; Graduating ID Card</a>
                      <a href="e2e_business_card.php"><i class="glyphicon icons icon-credit-card"></i>&nbsp; Business Card</a>
                      <a href="e2e_event_manager.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Event Manager</a>
                      <a href="*"><i class="glyphicon fa fa-user"></i>&nbsp; User Account</a>0
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
<script src="asset/js/sweetalert-dev.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
 var table = $('#datatables').DataTable();

$('#btn-addzz').click(function(){
    swal({
  title: "Currently Under Development!",
  text: ":((",
  type: "warning",
  showCancelButton: false,
  closeOnConfirm: true,
  animation: "slide-from-bottom",
  inputPlaceholder: "---"
},
function(inputValue){
  var regex = /^[0-9]+$/;
  /*if (inputValue === false) return false;
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
    swal("Nice!", "You wrote: " + inputValue, "success");
    }
*/    });
  });

 });
</script>
<!-- end: Javascript -->
<script type="text/javascript">
function get_value_ays(){
  var selected_acad_year_start = document.getElementById("acad_year_start").value;
  var x = 1;
  var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
  /*document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;*/

  document.getElementById("acad_year_start_show").innerHTML =  selected_acad_year_start;
  document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end").value =  acad_year_end;
}

$(document).ready(function(){
  $('#start_date')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'start_date');
        });
  $('#end_date')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'end_date');
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
            excluded: [':disabled', ':hidden', ':not(:visible)'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                start_date: {
                    validators: {
                        notEmpty: {
                            message: 'Event Start Date is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9/]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                end_date: {
                    validators: {
                        notEmpty: {
                            message: 'Event End Date is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9/]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                acad_year_start: {
                    validators: {
                        notEmpty: {
                            message: 'Academic year start is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                event_code: {
                    message: 'Event Code is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Event Code is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Event Code must be more than 1 and less than 10 characters'
                        },
                 regexp: {
                            regexp: /^[a-zA-Z\ 0-9-_]+$/,
                            message: 'Invalid Character'
                        }
                    }
                },
                event_name: {
                    message: 'Event Name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Event Name is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Event Name must be more than 1 and less than 10 characters'
                        },
                 regexp: {
                            regexp: /^[a-zA-Z\ 0-9-_]+$/,
                            message: 'Invalid Character'
                        }
                    }
                },
                no_of_session: {
                    validators: {
                        notEmpty: {
                            message: 'No. of Session is required and can\'t be empty'
                        }
                    }
                },
                time_in_1: {
                    validators: {
                        notEmpty: {
                            message: 'Time in of 1st Session is required and can\'t be empty'
                        }
                    }
                },
                time_out_1: {
                    validators: {
                        notEmpty: {
                            message: 'Time out of 1st Session is required and can\'t be empty'
                        }
                    }
                },
                time_in_2: {
                    validators: {
                        notEmpty: {
                            message: 'Time in of 2nd Session is required and can\'t be empty'
                        }
                    }
                },
                time_out_2: {
                    validators: {
                        notEmpty: {
                            message: 'Time out of 2nd Session is required and can\'t be empty'
                        }
                    }
                },
                semester: {
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        }
                    }
                },
                event_type: {
                    validators: {
                        notEmpty: {
                            message: 'Event type is required and can\'t be empty'
                        }
                    }
                },
                status: {
                    validators: {
                        notEmpty: {
                            message: 'Event status is required and can\'t be empty'
                        }
                    }
                },
                batch_no: {
                    validators: {
                        notEmpty: {
                            message: 'No. of Batch is required and can\'t be empty'
                        }
                    }
                }
            }
        })
  });

$('#no_of_session').change(function(){
  selection = $(this).val();
  switch(selection)
  {
    case '':
      $('#session_2').hide();
      break;
    case '1':
      $('#session_2').hide();
      break;
    case '2':
      $('#session_2').show();
    default:
      $('#session_2').show();
      break;
  }
});
</script>
</body>
</html>
