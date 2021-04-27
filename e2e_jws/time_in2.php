<?php
ob_start("ob_gzhandler");
date_default_timezone_set("Asia/Manila");
//$date_today =  "01/17/2017";
$date_today = date("m/d/Y");
$time_now = date("h:i A");
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
if(isset($_GET['stud_no'])) { 
  $stud_no=$_GET['stud_no'];
  
  $table = "student_info";
  $columns = "*";
  $where = ["stud_no"=>$stud_no];
  $q_sn = $database->select($table,$columns,$where);
  foreach($q_sn AS $q_snData){
    $lname_stud = $q_snData["lname"];
    $fname_stud = $q_snData["fname"];
    $mname_stud = $q_snData["mname"];

    $stud_name  = $lname_stud.", ".$fname_stud." ".$mname_stud;
  }
}
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
                         &nbsp; > Time In Session 2
                        </p>
                    </div>
                  </div>
              </div>
                      <?php
                         $table_em  ="event_manager";
                        $columns_em = "*";
                        $where_em = ["status"=>"Active"];
                        $q_em = $database->select($table_em,$columns_em,$where_em);
                        foreach($q_em AS $q_em_data){
                            $event_id = $q_em_data["event_id"];
                            $event_name = $q_em_data["event_name"];
                            $event_date = $q_em_data["event_date"];
                            $s2_start = $q_em_data["s2_start"];
                            $s2_end =  $q_em_data["s2_end"];
                            $acad_year_start_seminar =  $q_em_data["acad_year_start_seminar"];
                            $acad_year_end_seminar =  $q_em_data["acad_year_end_seminar"];
                            $semester =  $q_em_data["semester"];
                            $batch_active = $q_em_data["batch_active"];
                         }

                         if($s2_start == 0 and $s2_end == 0){
                          $F_s2_start = "No Data";
                          $F_s2_end = "No Data";
                          $btn_display = "none";
                         }else{
                          $F_s2_start = date("h:i A",$s2_start);
                          $F_s2_end = date("h:i A",$s2_end);
                          $btn_display = "";
                         }


                         $s2_timein = strtotime($time_now);

                         $s2_start_plus30 = date("h:i A",strtotime("+30 minutes",$s2_start));
                         $F_plus30 = strtotime($s2_start_plus30);
                         if($s2_timein <= $s2_start){
                          $s2_status = "On Time";
                         }elseif($s2_timein > $s2_start && $s2_timein <= $F_plus30){
                            $s2_status = "Late";
                         }
                         elseif($s2_timein > $F_plus30){
                            $s2_status = "Absent";
                         }
                      ?>

              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <h3>ADD TIME IN SESSION 2</h3>
                      <?php
                      $q_check_session = $database->query("SELECT * FROM event_manager WHERE status = 'Active'");
                            foreach($q_check_session AS $q_checkData){
                              $no_session = $q_checkData['no_session'];
                            }
                     $q_tin = $database->count("seminar_attended_2","*",
                                ["AND"=>["event_id"=>$event_id,"stud_no"=>$stud_no]]);
                      if($q_tin == ""){
                           $based_value = 0;
                           if($no_session == 1){
                                 $btn_status ="none";
                              }
                      }else{
                           $based_value = 1;
                            $table_sa2 = "seminar_attended_2";
                            $columns_sa2  = "*";
                            $where_sa2 = ["AND"=>["event_id"=>$event_id,"stud_no"=>$stud_no]];
                            $q_slct_timein1 = $database->select($table_sa2,$columns_sa2,$where_sa2);   

                          foreach($q_slct_timein1  AS $q_dataT1){
                            $s2_timein2 = $q_dataT1["s2_timein"];
                            $sa_id = $q_dataT1["sa_id"];
                          }
                           if($s2_timein2 == 0){
                              if($date_today != $event_date){
                               $btn_status ="none";
                              }else{
                                $btn = "";
                              }
                           }else{
                              $btn_status = "none";
                            }
                      }


                      
                    ?>
                    </div>
                      <form id="defaultForm" method="post" action="add_time_in2_process.php" enctype="multipart/form-data">
                      <div class="panel-body" style="padding-bottom:30px;">
                      <div class="row" style="background-color:#3385ff;">
                      
                        <input type="hidden" name ="sa_id" value="<?php echo $sa_id; ?>">
                        <input type="hidden" name="event_id" value ="<?php echo $event_id; ?>">
                        <input type="hidden" name="s2_end" value ="<?php echo $s2_end; ?>">
                        <input type="hidden" name="stud_no" value ="<?php echo $stud_no; ?>">
                        <input type="hidden" name="semester" value ="<?php echo $semester; ?>">
                        <input type="hidden" name="acad_year_start_seminar" value ="<?php echo $acad_year_start_seminar; ?>">
                        <input type="hidden" name = "batch_active" value="<?php echo $batch_active; ?>">
                        <input type="hidden" name = "based_value" value="<?php echo $based_value; ?>">
                          <div class="col-md-12">
                            <div class="col-md-4">
                              <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                            </div>
                            <div class="col-md-6">
                              <h4 style="color:white;"><b>STUDENT NAME:  
                                <?php echo $stud_name; ?></b></h4>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <h4>SEMESTER : <?php echo $semester; ?></h4>
                          </div>
                          <div class="col-md-4">
                            <h4>SCHOOL YEAR : <?php echo $acad_year_start_seminar." - ".$acad_year_end_seminar; ?></h4>
                          </div>
                          <div class="col-md-4">
                            <h4>BATCH ACTIVE : <label style="color:orange;"> <?php echo $batch_active; ?></label></h4>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                            <h4>EVENT NAME: <?php echo $event_name; ?></h4>
                          </div>
                          <div class="col-md-4">
                            <h4>EVENT DATE: <?php echo $event_date; ?></h4>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                            <h4>Session 2 start time: <?php echo $F_s2_start; ?></h4>
                          </div>
                          <div class="col-md-4">
                              <h4>Session 2 time out: <?php echo $F_s2_end; ?></h4>
                          </div>  
                        </div>
                        <br>
                        <div class="row" style="display:<?php echo $btn_display; ?>">
                            <div class="col-md-12">
                                  <div class="col-md-4">
                                   <h5 style="padding-left:5px;">(S2)TIME IN</h5>
                                    <div class="form-group has-feedback">
                                    <input type="hidden" class="form-control" name="s2_timein" value="<?php echo $s2_timein; ?>" >
                                    <input type="text" class="form-control"   value="<?php echo date("h:i A",$s2_timein); ?>" disabled>
                                    </div>
                                </div>
                              <div class="col-md-4">
                                 <h5 style="padding-left:5px;">(S2)TIME OUT</h5>
                                  <div class="form-group has-feedback">
                                  <input type="text"  class="form-control" value=" <?php echo date("h:i A",$s2_end); ?>" disabled>
                                     <input type="hidden" name="s2_timeout" id="s2_timeout" class="form-control" 
                                    value=" <?php echo $s2_end; ?>" >
                                  </div>
                              </div>
                              <div class="col-md-4">
                                 <h5 style="padding-left:5px;">(S2)STATUS</h5>
                                  <div class="form-group has-feedback">
                                  <input type="text" class="form-control" value="<?php echo $s2_status; ?>" disabled>
                                    <input type="hidden" name= "s2_status" value="<?php echo $s2_status; ?>">
                                  </div>
                              </div>   
                            </div> 
                          </div>
                       
                        <br>
                       <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-success"  name="btn_add_seminar_attended2" id="btn_add_seminar_attended2" style="display:<?php echo $btn_status; ?>">
                                  <span class="glyphicon glyphicon-plus"></span> &nbsp;ADD
                                 </button>
                             </div>
                              <div class="col-md-4">
                               <a href="e2e_student_records.php"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                       </div>
                          </div>
                      </div><!--ENd of panel body-->
                      </form>
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
<script type="text/javascript"></script>
<!-- end: Javascript -->
</body>
</html>