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

      <div class="container-fluid mimin-wrapper">
  
          <!-- start:Left Menu -->
            <div id="left-menu">
              <div class="sub-left-menu scroll">

                    <div  style="background: linear-gradient(#ebebe0, 50%,#ebebe0);height:90px;">
                      <img src="asset/img/e2elogoc.png" style="padding-top:4px;margin-left:1px;width:230px;height:100px;" class="animated fadeInLeft">
                    </div>
                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:70px;">
                    <br>
                       <p class="animated fadeInRight" style="color:gray;margin-left:10px;margin-top:20px;text-align:center;">
                               <?php
                                 echo  date("l, F j, Y"); 
                               ?>
                        </p>
                    </div>
                    <h4 style="text-align:center;"><?php echo $fname." ".$lname; ?></h4>
                      <h6 style="text-align:center;"><?php echo $position; ?></h6>

                      <div class="nav-side-menu">
                      <label class="active">
                        <a href="e2e_mock_interview_home.php"><i class="fa fa-home"></i>Home</a>
                      </label><br>       
                      <label>
                        <a href="e2e_scheduled_interviewees.php"><i class="fa fa-paste"></i>Scheduled Interviewees</a>
                      </label><br>       
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->

          <!-- start: Content -->
          <div id="content" class="profile-v1">
             <div class="col-md-12 col-sm-12 profile-v1-wrapper" style="height:420px;">
                <div class="col-md-12  profile-v1-cover-wrap" style="padding-right:0px;">
                    <div class="profile-v1-pp">
                      <?php 
                       echo '<img src="data:'.$img_type_profile.';base64,'.$comp_logo.'">';
                       ?>
                      <h4 style="color:white;padding-left:40px;"><?php echo $comp_name; ?></h4>
                      <h5 style="color:white;padding-left:40px;">COMPANY NAME</h5>
                    </div>
                    <div class="col-md-12 profile-v1-cover">
                       <?php 
                       echo '<img src="data:'.$img_type_cover.';base64,'.$default_cover.'" style="height:400px;" class="img-responsive">';
                       ?>
                    </div>
                </div>     
             </div>
             <div class="col-md-12">
              <?php
                $table = "event_mi_interview_grade";
                $columns = "*";
                $q_grade = $database->select($table,$columns);

                foreach ($q_grade AS $q_grade_data){
                  $mi_interview_list_id = $q_grade_data['mi_interview_list_id'];
                  $comm_skill = $q_grade_data['comm_skill'];
                  $paper_screening = $q_grade_data['paper_screening'];
                  $skill_fit = $q_grade_data['skill_fit'];
                  $org_fit = $q_grade_data['org_fit'];
                  $confidence = $q_grade_data['confidence'];
                  $total = $q_grade_data['total'];
                  $remarks = $q_grade_data['remarks'];
                  $comment = $q_grade_data['comment'];

                  $table2 = "event_mi_interview_list";
                  $columns2 = "*";
                  $where = ["mi_interview_list_id" => $mi_interview_list_id];
                  $q_list = $database->select($table2,$columns2,$where);

                  foreach ($q_list AS $q_list_data){
                    $interviewer_id = $q_list_data['interviewer_id'];
                    $mi_sched_stud_set_id = $q_list_data['mi_sched_stud_set_id'];

                    $table3 = "tbl_interviewer";
                    $columns3 = "*";
                    $where2 = ["interviewer_id" => $interviewer_id];
                    $q_interviewer = $database->select($table3,$columns3,$where2);

                    foreach ($q_interviewer AS $q_interviewer_data){
                      $interviewer_lname = $q_interviewer_data['lname'];
                      $interviewer_fname = $q_interviewer_data['fname'];
                      $position = $q_interviewer_data['position'];

                      $table4 = "event_mi_sched_stud_set";
                      $columns4 = "*";
                      $where3 = ["mi_sched_stud_set_id" => $mi_sched_stud_set_id];
                      $q_sched = $database->select($table4,$columns4,$where3);

                      foreach ($q_sched AS $q_sched_data){
                        $stud_no = $q_sched_data['stud_no'];

                        $table5 = "student_info";
                        $columns5 = "*";
                        $where4 = ["stud_no" => $stud_no];
                        $q_student = $database->select($table5,$columns5,$where4);

                        foreach ($q_student AS $q_student_data){
                          $stud_no = $q_student_data['stud_no'];
                          $stud_lname = $q_student_data['lname'];
                          $stud_fname = $q_student_data['fname'];
                          $stud_mname = $q_student_data['mname'];
                          $stud_dp = $q_student_data['stud_dp'];
                          $program_id = $q_student_data['program_id'];

                          $table6 = "program_list";
                          $columns6 = "*";
                          $where5 = ["program_id" => $program_id];
                          $q_program = $database->select($table6,$columns6,$where5);

                          foreach ($q_program AS $q_program_data){
                            $program_code = $q_program_data['program_code'];
              ?>
                <div class="row">
                  <div class="col-sm-6 col-md-3 product-grid">
                    <div class="thumbnail">                                                           
                      <img src="grad_id/grad_data/student_image/<?php echo $stud_dp; ?>" style="border-style:solid;border-color:black;border-width:2px;height:200px;">         
                      <div style="background-color:#99d7ff;margin-top:5px;padding-top:3px;padding-bottom:3px;color:white;padding-left:10px;color:black;">
                        <label style="font-weight:bold;"><?php echo $stud_no; ?></label><br>
                        <label style="font-weight:bold;"><?php echo $stud_lname.", ".$stud_fname." ".$stud_mname; ?></label><br>
                        <label style="font-weight:bold;"><?php echo $program_code; ?></label>
                      </div>
                      <div class="caption"> 
                        <table style="font-size:14px;">
                          <tr>
                            <td style="text-align:left;"><b>COMM SKILL</b>:</td>
                            <td style="text-align:right;"><?php echo $comm_skill; ?></td>
                          </tr>
                          <tr>
                            <td style="text-align:left;"><b>PAPER SCREENING</b>:</td>
                            <td style="text-align:right;"><?php echo $paper_screening; ?></td>
                          </tr>
                          <tr style="text-align:left;">
                            <td><b>SKILL FIT</b>:</td>
                            <td style="text-align:right;"><?php echo $skill_fit; ?></td>
                          </tr>
                          <tr style="text-align:left;">
                            <td><b>ORG FIT</b>:</td>
                            <td style="text-align:right;"><?php echo $org_fit; ?></td>
                          </tr>
                          <tr style="text-align:left;">
                            <td><b>CONFIDENCE</b>:</td>
                            <td style="text-align:right;"><?php echo $confidence; ?></td>
                          </tr>
                          <tr style="text-align:left;">
                            <td><b>TOTAL</b>:</td>
                            <td style="text-align:right;"><?php echo $total; ?></td>
                          </tr>
                          <tr>
                            <td style="text-align:left;"><b>REMARKS</b>:</td>
                            <?php
                              if($remarks == "Passed"){
                            ?>
                                <td style="text-align:center;color:green;font-weight:bold;"><?php echo $remarks; ?></td>
                            <?php
                              }
                              else{
                             ?>
                                <td style="text-align:right;color:red;font-weight:bold;"><?php echo $remarks; ?></td>
                             <?php
                              }
                             ?>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                <?php 
                            }
                          }
                        }
                      }
                    }
                  } 
                ?>
                </div>
              </div>
          </div>
        </div>
        <!-- end: content -->
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

<!-- end: Javascript -->
</body>
</html>