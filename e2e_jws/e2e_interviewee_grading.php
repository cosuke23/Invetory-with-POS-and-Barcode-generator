<?php
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';
require 'default_cover.php';
///COOKIE CODES 
if(!isset($_COOKIE["miid"])) {
  header ("Location: e2e_company_mi_login.php");
  exit;
}
$interviewer_id = $_COOKIE["miid"];

    $table = "tbl_interviewer";
    $columns = "*";
    $where = ["interviewer_id" => $interviewer_id];
    $q_interviewer_info =$database->select($table,$columns,$where);

    foreach ($q_interviewer_info as $q_interviewer_info_data)
    {
          $comp_id = $q_interviewer_info_data["comp_id"];
          $lname = $q_interviewer_info_data["lname"];
          $fname = $q_interviewer_info_data["fname"];
          $position = $q_interviewer_info_data["position"];

          $table2 = "company_info";
          $columns2 = "*";
          $where2 = ["comp_id" => $comp_id];
          $q_comp_info =$database->select($table2,$columns2,$where2);

          foreach ($q_comp_info as $q_comp_info_data)
          {
            $comp_name = $q_comp_info_data["comp_name"];
            $comp_logo = $q_comp_info_data["comp_logo"];
          }
    } 
        $decoded_img_profile = base64_decode($comp_logo);
         $f = finfo_open(); 
         $img_type_profile = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);

         $decoded_img_cover = base64_decode($default_cover);
         $f = finfo_open(); 
         $img_type_cover = finfo_buffer($f, $decoded_img_cover, FILEINFO_MIME_TYPE);
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
  <style type="text/css">
#sticky.stick {
    margin-top: 0 !important;
    position: fixed;
    background: #f5f5f5;
    top: 0;
    z-index: 10000;
    margin-right: 30px;
    padding: 15px;
}
  </style>
  <!-- end: Css -->

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
                <li class="user-name"><span>&nbsp; <?php echo  $comp_name; ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <?php 
                       echo '<img src="data:'.$img_type_profile.';base64,'.$comp_logo.'" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
                  ?>
                  
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="#"><span class="fa fa-user"></span> My Profile</a></li>
                     <li><a href="company_mi_logout.php"><span class="fa fa-power-off"></span> Log out</a></li>
                  </ul>
                </li>
                <li ><a href="#" class="opener-right-menu"><span class="fa fa-coffee"></span></a></li>
              </ul>
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <?php
              if(isset($_GET['mi_interview_list_id'])) { 
                $mi_interview_list_id = $_GET['mi_interview_list_id'];
                $table = "event_mi_interview_list";
                $columns = "*";
                $where = ["mi_interview_list_id" => $mi_interview_list_id];
                $q_interview_list = $database->select($table,$columns,$where);

                foreach ($q_interview_list AS $q_interview_list) {
                  $mi_sched_stud_set_id = $q_interview_list["mi_sched_stud_set_id"];

                  $table2 = "event_mi_sched_stud_set";
                  $columns2 = "*";
                  $where2 = ["mi_sched_stud_set_id" => $mi_sched_stud_set_id];
                  $q_sched_stud = $database->select($table2,$columns2,$where2);

                  foreach ($q_sched_stud AS $q_sched_stud_data) {
                    $stud_no_sched = $q_sched_stud_data["stud_no"];

                    $table3 = "student_info";
                    $columns3 = "*";
                    $where3 = ["stud_no" => $stud_no_sched];
                    $q_stud = $database->select($table3,$columns3,$where3);

                    foreach ($q_stud AS $q_stud_data) {
                      $stud_no = $q_stud_data["stud_no"];
                      $lname = $q_stud_data["lname"];
                      $fname = $q_stud_data["fname"];
                      $mname = $q_stud_data["mname"];
                      $program_id = $q_stud_data["program_id"];
                      $stud_dp = $q_stud_data["stud_dp"];

                      $table4 = "program_list";
                      $columns4 = "*";
                      $where4 = ["program_id" => $program_id];
                      $q_program = $database->select($table4,$columns4,$where4);

                      foreach ($q_program AS $q_program_data) {
                        $program_code = $q_program_data["program_code"];

                        $table5 = "resume_data";
                        $columns5 = "*";
                        $where5 = ["stud_no"=>$stud_no];
                        $q_resume = $database->select($table5,$columns5,$where5);

                        foreach($q_resume as $q_res_data){
                            $resume_id = $q_res_data["resume_id"];
                            $file_name = $q_res_data["file_name"];
                            $stud_no_res = $q_res_data["stud_no"];
                            $resume_link = $q_res_data["resume_link"];

                            $table6 = "event_mi_interview_grade";
                            $columns6 = "*";
                            $where6 = ["mi_interview_list_id"=>$mi_interview_list_id];
                            $q_grade = $database->select($table6,$columns6);

                            foreach ($q_grade AS $q_grade_data) {
                              $mi_interview_grade_id = $q_grade_data["mi_interview_grade_id"];
                            }
                        }
                      }
                    }
                  }         
                }
              }
            ?>

      <div class="container-fluid mimin-wrapper">
          <div id="content left-side"><br><br><br><br>
            <div class="col-md-12 padding-0">
              <div class="col-md-8">
                <div class="panel">
                  <div class="panel-heading"><h3>Student Applicant</h3></div>
                  <div class="panel-body">
                      <div class="col-md-12">
                        <div class="row" style="background:#115fc0;color:white;">
                          <div class="col-md-7">
                            <h4>STUDENT NAME: <b><?php echo $lname.", ".$fname." ".$mname; ?></b></h4>
                          </div>
                          <div class="col-md-4">
                            <h4>PROGRAM: <b>BSIT</b></h4>
                          </div>
                        </div>
                      </div><br><br><br>
                      <div class="col-md-12">
                        <iframe name="resume" height="750px" src="asset/resume_data/<?php echo $file_name; ?>" width="100%" frameborder="0"></iframe>
                      </div>
                    </div>
                </div>
              </div>
              <form method="post" action="e2e_submit_interview_grades_process.php" id="interview_grade" enctype="multipart/form-data">
                <input type="hidden" name="mi_interview_list_id" value="<?php echo $mi_interview_list_id; ?>">
                <input type="hidden" name="mi_sched_stud_set_id" value="<?php echo $mi_sched_stud_set_id; ?>">
                <div class="col-md-4">
                  <div class="panel">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group has-feedback">
                            <h5 style="padding-left:5px;">COMMENTS</h5>
                            <textarea rows ="3" name="comment" id="comment" class="form-control" placeholder="Comment..."></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <h5 style="font-weight:bold;color:black;text-align:center;">Passing Grade: 60</h5>
                      <div class="row">
                        <div class="col-md-6">
                          <div style="color:white;padding:4px;">
                            <h5 style="font-weight:bold;color:#a10d0d;">COMM SKILL</h5>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div style="color:white;padding:4px;">
                            <h6 style="font-weight:bold;color:#a10d0d;">(out of 20)</h6>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group has-feedback">
                            <input type='text' class='mi_grade' name="comm_skill" maxlength="2" style="width:100%;text-align:center;color:black;font-weight:bold;" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div style="color:#640da1;padding:4px;">
                            <h5 style="font-weight:bold;">PAPER SCREENING</h5>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div style="color:#640da1;padding:4px;">
                            <h6 style="font-weight:bold;">(out of 10)</h6>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group has-feedback">
                            <input type='text' class='mi_grade' name="paper_screening" maxlength="2" style="width:100%;text-align:center;color:black;font-weight:bold;" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div style="color:#0d48a1;padding:4px;">
                            <h5 style="font-weight:bold;">SKILL FIT</h5>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div style="color:#0d48a1;padding:4px;">
                            <h6 style="font-weight:bold;">(out of 25)</h6>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group has-feedback">
                            <input type='text' class='mi_grade' name="skill_fit" maxlength="2" style="width:100%;text-align:center;color:black;font-weight:bold;" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div style="color:#0da156;;padding:4px;">
                            <h5 style="font-weight:bold;">ORG FIT</h5>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div style="color:#0da156;;padding:4px;">
                            <h6 style="font-weight:bold;">(out of 25)</h6>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group has-feedback">
                            <input type='text' class='mi_grade' name="org_fit" maxlength="2" style="width:100%;text-align:center;color:black;font-weight:bold;" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div style="color:#d07f00;padding:4px;  ">
                            <h5 style="font-weight:bold;">CONFIDENCE</h5>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div style="color:#d07f00;padding:4px;">
                            <h6 style="font-weight:bold;">(out of 20)</h6>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group has-feedback">
                            <input type='text' class='mi_grade' name="confidence" maxlength="2" style="width:100%;text-align:center;color:black;font-weight:bold;" />
                          </div>
                        </div>
                      </div><br>
                      <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                          <div style="color:#a77e00;padding:4px;text-align:center;">
                            <h5 style="font-weight:bold;">TOTAL</h5>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <input type='text' class='total_grade' name="total" style="width:100%;border:0px solid;background-color:transparent;text-align:center;font-weight:bold;color:black;pointer-events:none;" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                          <div style="color:black;padding:4px;text-align:center;">
                            <h5 style="font-weight:bold;">PASSED?</h5>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <input type='text' class='remark' name="remark" style="width:100%;border:0px solid;background-color:transparent;text-align:center;font-weight:bold;color:black;pointer-events:none;" />
                        </div>
                      </div><br>
                      <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-success btn-block btn-md" name="btn_submit" id="btn-add"><span class="glyphicon glyphicon-ok"></span> &nbsp;SUBMIT</button>
                        </div>
                        <div class="col-md-4">
                          <a href="e2e_back_interviewee_available.php?mi_interview_list_id=<?php echo $mi_interview_list_id; ?>&&mi_interview_grade_id=<?php echo $mi_interview_grade_id; ?>&&mi_sched_stud_set_id=<?php echo $mi_sched_stud_set_id; ?>" class="btn btn-danger btn-block btn-md">
                            <span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
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
                      <a href="e2e_company_home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                      <a href="e2e_company_add_applicant.php"><i class="glyphicon glyphicon-user"></i>&nbsp; Add Applicant</a>
                      <a href="e2e_company_applicant_list.php"><i class="fa fa-paste"></i>&nbsp; Applicant(s) list</a>
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
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script src="asset/js/plugins/chart.min.js"></script>
<!-- custom -->
<script src="asset/js/plugins/holder.min.js"></script>
<script src="asset/js/main.js"></script>
<script>
$('.mi_grade').keyup(function () {
  var sum = 0;

  $('.mi_grade').each(function() {
    sum += Number($(this).val());
  });
  $('.total_grade').val(sum);
  if(sum<60){
    $('.remark').val('No');
    $('.remark').css("background", "#d50000 ");
    $('.remark').css("color", "#fff");
    $('.total_grade').css("background", "#d50000");
    $('.total_grade').css("color", "#fff");
  }
  else{
    $('.remark').val('Yes');
    $('.remark').css("background", "#00c853");
    $('.remark').css("color", "#fff");
    $('.total_grade').css("background", "#00c853");
    $('.total_grade').css("color", "#fff");
  } 
});
</script>
<script type="text/javascript">
$('#interview_grade')
    .bootstrapValidator({
      message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
              comm_skill: {
                validators: {
                  notEmpty: {
                    message: 'Comm skill is required and can\'t be empty'
                  },
                  lessThan: {
                    value: 20,
                    message: 'The value must be less than or equal to 20'
                  },
                  regexp:{
                    regexp: /^[-/ 0-9]+$/,
                    message: 'Invalid characters'
                  },
                }
              },
              paper_screening: {
                validators: {
                  notEmpty: {
                    message: 'Paper screening is required and can\'t be empty'
                  },
                  lessThan: {
                    value: 10,
                    message: 'The value must be less than or equal to 10'
                  },
                  regexp:{
                    regexp: /^[-/ 0-9]+$/,
                    message: 'Invalid characters'
                  },
                }
              },
              skill_fit: {
                validators: {
                  notEmpty: {
                    message: 'Skill fit is required and can\'t be empty'
                  },
                  lessThan: {
                    value: 25,
                    message: 'The value must be less than or equal to 25'
                  },
                  regexp:{
                    regexp: /^[-/ 0-9]+$/,
                    message: 'Invalid characters'
                  },
                }
              },
              org_fit: {
                validators: {
                  notEmpty: {
                    message: 'Org fit is required and can\'t be empty'
                  },
                  lessThan: {
                    value: 25,
                    message: 'The value must be less than or equal to 25'
                  },
                  regexp:{
                    regexp: /^[-/ 0-9]+$/,
                    message: 'Invalid characters'
                  },
                }
              }, 
              confidence: {
                validators: {
                  notEmpty: {
                    message: 'Confidence is required and can\'t be empty'
                  },
                  lessThan: {
                    value: 20,
                    message: 'The value must be less than or equal to 20'
                  },
                  regexp:{
                    regexp: /^[-/ 0-9]+$/,
                    message: 'Invalid characters'
                  },
                }
              },                  
            }
      })
</script>
<script type="text/javascript">
  function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('#sticky-anchor').offset().top;
    if (window_top > div_top) {
        $('#sticky').addClass('stick');
        $('#sticky-anchor').height($('#sticky').outerHeight());
    } else {
        $('#sticky').removeClass('stick');
        $('#sticky-anchor').height(0);
    }
}

$(function() {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});

var dir = 1;
var MIN_TOP = 100;
var MAX_TOP = 350;

function autoscroll() {
    var window_top = $(window).scrollTop() + dir;
    if (window_top >= MAX_TOP) {
        window_top = MAX_TOP;
        dir = -1;
    } else if (window_top <= MIN_TOP) {
        window_top = MIN_TOP;
        dir = 1;
    }
    $(window).scrollTop(window_top);
    window.setTimeout(autoscroll, 100);
}
</script> 
<!-- end: Javascript -->
</body>
</html>