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
		    $sender_user = $q_user_info_data["username"];

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

$current_year = date("Y");
$next_year = date("Y")+ 1;
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
             <!--START: COUNT MESSAGE-->
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
					<!--END: COUNT MESSAGE-->
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
                    <div class="panel-heading"><h3>Update Event</h3></div>
                    <br>
                    <form id="defaultForm" method="post" action="e2e_event_manager_update_event_process.php" enctype="multipart/form-data">
                    <?php

                      if(isset($_GET['update_event_success'])&&isset($_GET['event_id'])){
                        $event_id=$_GET['event_id'];
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Updated Event!",
                            html: true,
                           text: "<strong> Updated Event with ID: '. $_GET['event_id'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager_update_event.php?event_id='.$event_id.'";
                           }
                         });
                     </script>';
                      }
                      if(isset($_GET['update_event_failed'])&&isset($_GET['event_id'])){
                        $event_id=$_GET['event_id'];
                        echo '<script language = javascript>
                        swal({
                           title: "Event Update Unsuccessful!",
                            html: true,
                           text: "<strong> Unsuccessful Update of Event with ID: '. $_GET['event_id'].'</strong>",
                           type: "warning",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager_update_event.php?event_id='.$event_id.'";
                           }
                         });
                     </script>';
                      }

                      if(isset($_GET['event_id'])) {

                        $event_id=$_GET['event_id'];

                        //echo $event_id;

                        $table = "event_manager";
                        $columns = "*";
                        $where = ["event_id" => $event_id];
                        $q_event_info =$database->select($table,$columns,$where);

                        foreach($q_event_info as $event_data){

                          $event_code         =   $event_data['event_code'];
                          $event_name         =   $event_data['event_name'];
                          $event_start_date   =   $event_data['event_start_date'];
                          $event_end_date     =   $event_data['event_end_date'];
                          $event_date         =   $event_data['event_date'];
                          $no_of_session      =   $event_data['no_session'];
                          $acad_year_start    =   $event_data['acad_year_start_seminar'];
                          $acad_year_end      =   $event_data['acad_year_end_seminar'];
                          $semester           =   $event_data['semester'];
                          $time_in_1          =   $event_data['s1_start'];
                          $time_out_1         =   $event_data['s1_end'];
                          $time_in_2          =   $event_data['s2_start'];
                          $time_out_2         =   $event_data['s2_end'];
                          $event_type         =   $event_data['type'];
                          $event_status       =   $event_data['status'];
                          $batch_active       =   $event_data['batch_active'];
                          $batch_no           =   $event_data['batch_no'];
                          $venue              =   $event_data['venue'];
                        }
                      }

                      ?>

                      <div class="panel-body" style="padding-bottom:30px;">
                         <input name="event_id" type="hidden" value ="<?php echo $event_id ?>"/>

                      <div class="row">
                        <div class="col-md-4">
                            <h5 style="padding-left:5px;">EVENT CODE</h5>
                              <div class="form-group has-feedback">
                               <input type="text" name="event_code" class="form-control" placeholder="Event Code" value ="<?php echo $event_code ?>"/>
                            </div>
                        </div>
                          <div class="col-md-8">
                            <h5 style="padding-left:5px;">EVENT NAME</h5>
                            <div class="form-group has-feedback">
                               <input type="text" name="event_name" class="form-control" placeholder="Event Name" value ="<?php echo $event_name ?>"/>
                            </div>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">START DATE</h5>
                          <div class="form-group">
                            <div class="dateContainer">
                              <div class="input-group input-append date" id="event_start_date">
                                <input type="text" class="form-control" name="event_start_date" placeholder="(e.g.mm/dd/YYYY)" value="<?php echo date('m/j/Y',strtotime($event_start_date)) ?>" maxlength="10"/>
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">END DATE</h5>
                          <div class="form-group">
                            <div class="dateContainer">
                              <div class="input-group input-append date" id="event_end_date">
                                <input type="text" class="form-control" name="event_end_date" placeholder="(e.g.mm/dd/YYYY)" value="<?php echo date('m/j/Y',strtotime($event_end_date)) ?>" maxlength="10"/>
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">ACTIVE DATE</h5>
                          <div class="form-group">
                            <div class="dateContainer">
                              <div class="input-group input-append date" id="event_date">
                                <input type="text" class="form-control" name="event_date" placeholder="(e.g.mm/dd/YYYY)" value="<?php echo date('m/j/Y',strtotime($event_date)) ?>" maxlength="10"/>
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </div>
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
                   else if($semester=="2nd Semester")
                   {
                  $comstart2="<!--";
                   }
                   ?>
                   <select class="form-control" name="semester" class="form-control" placeholder="">
                          <option><?php echo $semester; ?></option>
                          <?php echo $comstart1;?><option value="1st Semester">1st Semester</option><?php echo $comend;?>
                          <?php echo $comstart2;?><option value="2nd Semester">2nd Semester</option><?php echo $comend;?>
                          </select>
                    </div>


                          </div>
                          <div class="col-md-5">
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
                             <div class="col-md-4">
                                <h5 style="padding-left:5px;">ACADEMIC YEAR END</h5>
                                  <div>
                                   <input type="hidden" id="acad_year_end_value" name="acad_year_end" value="<?php echo $next_year; ?>" />
                                   <h4 id ="acad_year_start_show"><?php echo $acad_year_start + 1; ?></h4>
                                   </div>
                             </div>
                          </div>

                      <div class="row">
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">NO. OF SESSION</h5>

                          <div class="form-group has-feedback">
                                   <?php
                   $comstart1="";
                   $comstart2="";
                   $comend="-->";
                   if($no_of_session=="1")
                   {
                  $comstart1="<!--";
                   }
                   else if($no_of_session=="2")
                   {
                  $comstart2="<!--";
                   }
                   ?>
                   <select class="form-control" name="no_of_session" id="no_of_session" class="form-control" placeholder="">
                                    <option><?php echo $no_of_session; ?></option>
                                    <?php echo $comstart1;?><option value="1">1</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="2">2</option><?php echo $comend;?>
                                    </select>
                              </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">TYPE</h5>
                          <div class="form-group has-feedback">
                                   <?php
                   $comstart1="";
                   $comstart2="";
                   $comstart3="";
                   $comend="-->";
                   if($event_type=="Job Fair")
                   {
                  $comstart1="<!--";
                   }
                   else if($event_type=="Seminar")
                   {
                  $comstart2="<!--";
                   }
                   else if($event_type=="Mock Interview")
                   {
                  $comstart3="<!--";
                   }
                   ?>
                   <select class="form-control" name="event_type" class="form-control" placeholder="">
                                    <option><?php echo $event_type; ?></option>
                                    <?php echo $comstart1;?><option value="Job Fair">Job Fair</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Seminar">Seminar</option><?php echo $comend;?>
                                    <?php echo $comstart3;?><option value="Mock Interview">Mock Interview</option><?php echo $comend;?>
                                    </select>
                              </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">EVENT STATUS</h5>

                          <div class="form-group has-feedback">
                                   <?php
                   $comstart1="";
                   $comstart2="";
                   $comend="-->";
                   if($event_status=="Active")
                   {
                  $comstart1="<!--";
                   }
                   else if($event_status=="Not Active")
                   {
                  $comstart2="<!--";
                   }
                   ?>
                   <select class="form-control" name="event_status" class="form-control" placeholder="">
                                    <option><?php echo $event_status; ?></option>
                                    <?php echo $comstart1;?><option value="Active">Active</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Not Active">Not Active</option><?php echo $comend;?>
                                    </select>
                              </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">NO. OF BATCHES</h5>

                          <div class="form-group has-feedback">
                                   <?php
                 $comstart1="";
                 $comstart2="";
                 $comstart3="";
                 $comstart4="";
                 $comstart5="";
                 $comstart6="";
                 $comstart7="";
                 $comstart8="";
                 $comstart9="";
                 $comend="-->";
                 if($batch_no=="1")
                    $comstart1="<!--";
                 else if($batch_no=="2")
                    $comstart2="<!--";
                 else if($batch_no=="3")
                    $comstart3="<!--";
                 else if($batch_no=="4")
                    $comstart4="<!--";
                 else if($batch_no=="5")
                    $comstart5="<!--";
                 else if($batch_no=="6")
                    $comstart6="<!--";
                 else if($batch_no=="7")
                    $comstart7="<!--";
                 else if($batch_no=="8")
                    $comstart8="<!--";
                 else if($batch_no=="9")
                    $comstart9="<!--";
                   ?>
                   <select class="form-control" name="batch_no" id="batch_no" class="form-control" placeholder="">
                                    <option><?php echo $batch_no; ?></option>
                                    <?php echo $comstart1;?><option value="1">1</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="2">2</option><?php echo $comend;?>
                                    <?php echo $comstart3;?><option value="3">3</option><?php echo $comend;?>
                                    <?php echo $comstart4;?><option value="4">4</option><?php echo $comend;?>
                                    <?php echo $comstart5;?><option value="5">5</option><?php echo $comend;?>
                                    <?php echo $comstart6;?><option value="6">6</option><?php echo $comend;?>
                                    <?php echo $comstart7;?><option value="7">7</option><?php echo $comend;?>
                                    <?php echo $comstart8;?><option value="8">8</option><?php echo $comend;?>
                                    <?php echo $comstart9;?><option value="9">9</option><?php echo $comend;?>
                                    </select>
                              </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">ACTIVE BATCH</h5>

                          <div class="form-group has-feedback">
                                   <?php
                                   $intX = 1;
                                   $arrComstart = [];
                                   while($intX <= $batch_no){
                                     $arrComstart[$intX]="";
                                     if($batch_active==$intX)
                                      $arrComstart[$intX]="<!--";
                                     $intX++;

                                   }
                                  $comend="-->";

                   ?>
                   <select class="form-control" name="batch_active" id="batch_active" class="form-control" placeholder="">
                                    <option><?php echo $batch_active; ?></option>
                                    <?php
                                      $intX = 1;
                                      while($intX <= $batch_no){
                                        echo "". $arrComstart[$intX] ."<option value=".$intX.">".$intX."</option>".$comend."";
                                        $intX++;
                                      }
                                    ?>
                                    </select>
                              </div>
                        </div>
                        <div class="col-md-4">
                            <h5 style="padding-left:5px;">VENUE</h5>
                              <div class="form-group has-feedback">
                               <input type="text" name="venue" class="form-control" placeholder="Event Code" value ="<?php echo $venue ?>"/>
                            </div>
                        </div>
                      </div>

                          <div class="row">
                            <?php
                            // echo $time_in_1."---".date('H:i A',$time_in_1)."<br>".
                            //      $time_out_1."---".date('H:i A',$time_out_1)."<br>".
                            //      $time_in_2."---".date('H:i A',$time_in_2)."<br>".
                            //      $time_out_2."---".date('H:i A',$time_out_2)."<br>";
                            ?>

                        <div class="col-md-6">
                            <h5 style="padding-left:5px;">(1)TIME-IN
                              <strong>(<?php if($time_in_1==0)
                                              echo "---";
                                             else
                                              echo date("h:i A",$time_in_1);
                                       ?>)</strong>
                            </h5>
                              <div class="form-group has-feedback">
                                <div style="display:flex;">
                        					<div style="margin:5px; text-align:center;">
                        						<h4>Hrs.</h4>
                        						<select style="width:80px; height:30px;" name="ti1_hour">
                                      <option value="---">---</option>
                        							<?php
                                        if($time_in_1==0)
                                          $ti1_hour = "---";
                                        else
                                          $ti1_hour = date("h",$time_in_1);

                        								$x=1;
                        								while($x<=12){
                        									if($x<10){
                        										$hourValue = "0".$x;
                        										if($ti1_hour==$hourValue)
                        											echo '<option selected value='.$x.'>'.$hourValue.'</option>';
                        										else
                        											echo '<option value='.$x.'>'.$hourValue.'</option>';
                        									}else{
                        										if($ti1_hour==$x)
                        											echo '<option selected value='.$x.'>'.$x.'</option>';
                        										else
                        											echo '<option value='.$x.'>'.$x.'</option>';
                        									}
                        									$x++;
                        								}
                        							?>
                        						</select>
                        					</div>
                        					<div style="margin:5px; text-align:center;">
                        						<h4>Mins.</h4>
                        						<select style="width:80px; height:30px;" name="ti1_minute">
                                      <option value="---">---</option>
                        							<?php
                                        if($time_in_1==0)
                                          $ti1_minute = "---";
                                        else
                                          $ti1_minute = date("i",$time_in_1);

                        								$x=0;
                        								while($x<=59){
                        									if($x<10){
                        										$minuteValue = "0".$x;
                        										if($ti1_minute==$minuteValue)
                        											echo '<option selected value='.$x.'>'.$minuteValue.'</option>';
                        										else
                        											echo '<option value='.$x.'>'.$minuteValue.'</option>';
                        									}else{
                        										if($ti1_minute==$x)
                        											echo '<option selected value='.$x.'>'.$x.'</option>';
                        										else
                        											echo '<option value='.$x.'>'.$x.'</option>';
                        									}
                        									$x++;
                        								}
                        							?>
                        						</select>
                        					</div>
                        					<div style="margin:5px; text-align:center;">
                        						<h4>Period</h4>
                        						<select style="width:85px; height:30px;" name="ti1_period" >
                                      <option value="---">---</option>
                        							<?php
                                        if($time_in_1==0)
                                          $ti1_period = "---";
                                        else
                                          $ti1_period = date("A",$time_in_1);

                        								if($ti1_period=="AM"){
                        									echo '<option selected value="AM">'.$ti1_period.'</option>';
                        									echo '<option value="PM">PM</option>';
                        								} else if($ti1_period=="PM"){
                        									echo '<option value="AM">AM</option>';
                        									echo '<option selected value="PM">'.$ti1_period.'</option>';
                        								} else{
                                          echo '<option value="AM">AM</option>';
                        									echo '<option value="PM">PM</option>';
                                        }
                        							?>
                        						</select>
                        					</div>
                        				</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 style="padding-left:5px;">(1)TIME-OUT
                              <strong>(<?php if($time_out_1==0)
                                              echo "---";
                                             else
                                              echo date("h:i A",$time_out_1);
                                       ?>)</strong>
                            </h5>
                              <div class="form-group has-feedback">
                                <div style="display:flex;">
                                  <div style="margin:5px; text-align:center;">
                                    <h4>Hrs.</h4>
                                    <select style="width:80px; height:30px;" name="to1_hour">
                                      <option value="---">---</option>
                                      <?php
                                        if($time_out_1==0)
                                          $to1_hour = "---";
                                        else
                                          $to1_hour = date("h",$time_out_1);

                                        $x=1;
                                        while($x<=12){
                                          if($x<10){
                                            $hourValue = "0".$x;
                                            if($to1_hour==$hourValue)
                                              echo '<option selected value='.$x.'>'.$hourValue.'</option>';
                                            else
                                              echo '<option value='.$x.'>'.$hourValue.'</option>';
                                          }else{
                                            if($to1_hour==$x)
                                              echo '<option selected value='.$x.'>'.$x.'</option>';
                                            else
                                              echo '<option value='.$x.'>'.$x.'</option>';
                                          }
                                          $x++;
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <div style="margin:5px; text-align:center;">
                                    <h4>Mins.</h4>
                                    <select style="width:80px; height:30px;" name="to1_minute">
                                      <option value="---">---</option>
                                      <?php
                                        if($time_out_1==0)
                                          $to1_minute = "---";
                                        else
                                          $to1_minute = date("i",$time_out_1);

                                        $x=0;
                                        while($x<=59){
                                          if($x<10){
                                            $minuteValue = "0".$x;
                                            if($to1_minute==$minuteValue)
                                              echo '<option selected value='.$x.'>'.$minuteValue.'</option>';
                                            else
                                              echo '<option value='.$x.'>'.$minuteValue.'</option>';
                                          }else{
                                            if($to1_minute==$x)
                                              echo '<option selected value='.$x.'>'.$x.'</option>';
                                            else
                                              echo '<option value='.$x.'>'.$x.'</option>';
                                          }
                                          $x++;
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <div style="margin:5px; text-align:center;">
                                    <h4>Period</h4>
                                    <select style="width:85px; height:30px;" name="to1_period" >
                                      <option value="---">---</option>
                                      <?php
                                        if($time_out_1==0)
                                          $to1_period = "---";
                                        else
                                          $to1_period = date("A",$time_out_1);

                                        if($to1_period=="AM"){
                                          echo '<option selected value="AM">'.$to1_period.'</option>';
                                          echo '<option value="PM">PM</option>';
                                        } else if($to1_period=="PM"){
                                          echo '<option value="AM">AM</option>';
                                          echo '<option selected value="PM">'.$to1_period.'</option>';
                                        } else{
                                          echo '<option value="AM">AM</option>';
                        									echo '<option value="PM">PM</option>';
                                        }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="row" id="session_2">
                    <div class="col-md-6">
                        <h5 style="padding-left:5px;">(2)TIME-IN
                          <strong>(<?php if($time_in_2==0)
                                          echo "---";
                                         else
                                          echo date("h:i A",$time_in_2);
                                   ?>)</strong>
                        </h5>
                          <div class="form-group has-feedback">
                            <div style="display:flex;">
                              <div style="margin:5px; text-align:center;">
                                <h4>Hrs.</h4>
                                <select style="width:80px; height:30px;" name="ti2_hour">
                                  <option value="---">---</option>
                                  <?php
                                    if($time_in_2==0)
                                      $ti2_hour = "---";
                                    else
                                      $ti2_hour = date("h",$time_in_2);

                                    $x=1;
                                    while($x<=12){
                                      if($x<10){
                                        $hourValue = "0".$x;
                                        if($ti2_hour==$hourValue)
                                          echo '<option selected value='.$x.'>'.$hourValue.'</option>';
                                        else
                                          echo '<option value='.$x.'>'.$hourValue.'</option>';
                                      }else{
                                        if($ti2_hour==$x)
                                          echo '<option selected value='.$x.'>'.$x.'</option>';
                                        else
                                          echo '<option value='.$x.'>'.$x.'</option>';
                                      }
                                      $x++;
                                    }
                                  ?>
                                </select>
                              </div>
                              <div style="margin:5px; text-align:center;">
                                <h4>Mins.</h4>
                                <select style="width:80px; height:30px;" name="ti2_minute">
                                  <option value="---">---</option>
                                  <?php
                                    if($time_in_2==0)
                                      $ti2_minute = "---";
                                    else
                                      $ti2_minute = date("i",$time_in_2);

                                    $x=0;
                                    while($x<=59){
                                      if($x<10){
                                        $minuteValue = "0".$x;
                                        if($ti2_minute==$minuteValue)
                                          echo '<option selected value='.$x.'>'.$minuteValue.'</option>';
                                        else
                                          echo '<option value='.$x.'>'.$minuteValue.'</option>';
                                      }else{
                                        if($ti2_minute==$x)
                                          echo '<option selected value='.$x.'>'.$x.'</option>';
                                        else
                                          echo '<option value='.$x.'>'.$x.'</option>';
                                      }
                                      $x++;
                                    }
                                  ?>
                                </select>
                              </div>
                              <div style="margin:5px; text-align:center;">
                                <h4>Period</h4>
                                <select style="width:85px; height:30px;" name="ti2_period" >
                                  <option value="---">---</option>
                                  <?php
                                    if($time_in_2==0)
                                      $ti2_period = "---";
                                    else
                                      $ti2_period = date("A",$time_in_2);

                                    if($ti2_period=="AM"){
                                      echo '<option selected value="AM">'.$ti2_period.'</option>';
                                      echo '<option value="PM">PM</option>';
                                    } else if($ti2_period=="PM"){
                                      echo '<option value="AM">AM</option>';
                                      echo '<option selected value="PM">'.$ti2_period.'</option>';
                                    } else{
                                      echo '<option value="AM">AM</option>';
                                      echo '<option value="PM">PM</option>';
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 style="padding-left:5px;">(2)TIME-OUT
                          <strong>(<?php if($time_out_2==0)
                                          echo "---";
                                         else
                                          echo date("h:i A",$time_out_2);
                                   ?>)</strong>
                        </h5>
                          <div class="form-group has-feedback">
                            <div style="display:flex;">
                              <div style="margin:5px; text-align:center;">
                                <h4>Hrs.</h4>
                                <select style="width:80px; height:30px;" name="to2_hour">
                                  <option value="---">---</option>
                                  <?php
                                    if($time_out_2==0)
                                      $to2_hour = "---";
                                    else
                                      $to2_hour = date("h",$time_out_2);
                                    $x=1;
                                    while($x<=12){
                                      if($x<10){
                                        $hourValue = "0".$x;
                                        if($to2_hour==$hourValue)
                                          echo '<option selected value='.$x.'>'.$hourValue.'</option>';
                                        else
                                          echo '<option value='.$x.'>'.$hourValue.'</option>';
                                      }else{
                                        if($to2_hour==$x)
                                          echo '<option selected value='.$x.'>'.$x.'</option>';
                                        else
                                          echo '<option value='.$x.'>'.$x.'</option>';
                                      }
                                      $x++;
                                    }
                                  ?>
                                </select>
                              </div>
                              <div style="margin:5px; text-align:center;">
                                <h4>Mins.</h4>
                                <select style="width:80px; height:30px;" name="to2_minute">
                                  <option value="---">---</option>
                                  <?php
                                    if($time_out_2==0)
                                      $to2_minute = "---";
                                    else
                                      $to2_minute = date("i",$time_out_2);

                                    $x=0;
                                    while($x<=59){
                                      if($x<10){
                                        $minuteValue = "0".$x;
                                        if($to2_minute==$minuteValue)
                                          echo '<option selected value='.$x.'>'.$minuteValue.'</option>';
                                        else
                                          echo '<option value='.$x.'>'.$minuteValue.'</option>';
                                      }else{
                                        if($to2_minute==$x)
                                          echo '<option selected value='.$x.'>'.$x.'</option>';
                                        else
                                          echo '<option value='.$x.'>'.$x.'</option>';
                                      }
                                      $x++;
                                    }
                                  ?>
                                </select>
                              </div>
                              <div style="margin:5px; text-align:center;">
                                <h4>Period</h4>
                                <select style="width:85px; height:30px;" name="to2_period" >
                                  <option value="---">---</option>
                                  <?php
                                    if($time_out_2==0)
                                      $to2_period = "---";
                                    else
                                      $to2_period = date("A",$time_out_2);

                                    if($to2_period=="AM"){
                                      echo '<option selected value="AM">'.$to2_period.'</option>';
                                      echo '<option value="PM">PM</option>';
                                    } else if($to2_period=="PM"){
                                      echo '<option value="AM">AM</option>';
                                      echo '<option selected value="PM">'.$to2_period.'</option>';
                                    } else{
                                      echo '<option value="AM">AM</option>';
                                      echo '<option value="PM">PM</option>';
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>



                      <div class="row"><br><br>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-info btn-block" name="btn-update" id="btn-update"><span class="glyphicon glyphicon-plus"></span> &nbsp;UPDATE</button>
                        </div>
                        <div class="col-md-4">
                            <a href="e2e_event_manager.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                        </div>
                      </div>
                </div>
              </div>
              </form>
            </div><!-- end: content -->
          </div>

         <!-- START: RIGHT MENU-->
          <?php
            require ("chat.php");
          ?>
		  <!-- END: RIGHT MENU-->

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

$('#btn-updatezz').click(function(){
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

var selected = document.getElementById('no_of_session').value;
if(selected=="1"){
  document.getElementById('session_2').style.display = "none";
}
if(selected=="2"){
  document.getElementById('session_2').style.display = "block";
}


function get_value_ays(){
  var selected_acad_year_start = document.getElementById("acad_year_start").value;
  var x = 1;
  var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
  document.getElementById("acad_year_start_show").innerHTML =  selected_acad_year_start;
  document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;
}

$(document).ready(function(){

  $("#batch_no").change(function () {
        var val = $(this).val();
        document.getElementById("batch_active").options.length = 0;
        var intA = 1;
        select = document.getElementById('batch_active');
        while(intA <= val){
          var opt = document.createElement('option');
          opt.value = intA;
          opt.innerHTML = intA;
          select.appendChild(opt);
          intA++;
        }
    });
  $('#event_start_date')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'event_date');
        });
  $('#event_end_date')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'event_date');
        });
  $('#event_date')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'event_date');
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
                event_start_date: {
                    validators: {
                        notEmpty: {
                            message: 'Start Date is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9 /]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                event_end_date: {
                    validators: {
                        notEmpty: {
                            message: 'End Date is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9 /]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                event_date: {
                    validators: {
                        notEmpty: {
                            message: 'Active Date is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9 /]+$/,
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
                            max: 80,
                            message: 'Event Name must be more than 1 and less than 80 characters'
                        },
                 regexp: {
                            regexp: /^[a-zA-Z\ 0-9-_()\[\] ]+$/,
                            message: 'Invalid Character'
                        }
                    }
                },
                venue: {
                    message: 'Venue is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Venue is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 80,
                            message: 'Venue of event must be more than 1 and less than 80 characters'
                        },
                 regexp: {
                            regexp: /^[a-zA-Z\ 0-9-_()\[\] ]+$/,
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
                }
            }
        })
  });

$('#no_of_session').change(function(){
  selection = $(this).val();
  switch(selection)
  {
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
