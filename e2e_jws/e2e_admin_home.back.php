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
    if(isset($_GET['grad_no']) && isset($_GET['notgrad_no']) && isset($_GET['q_Employed']) && isset($_GET['q_Unemployed'])
       && isset($_GET['q_Continuing_Study']) && isset($_GET['q_Abroad']) && isset($_GET['q_Self_Employed']) && isset($_GET['q_Under_Graduate']) && isset($_GET['semester']) && isset($_GET['acad_year_start']) && isset($_GET['program_code'])
        && isset($_GET['program_id']) ){

      $grad_no = $_GET['grad_no'];
      $notgrad_no = $_GET['notgrad_no'];
      $q_Employed = $_GET['q_Employed'];
      $q_Unemployed = $_GET['q_Unemployed'];
      $q_Continuing_Study = $_GET['q_Continuing_Study'];
      $q_Abroad = $_GET['q_Abroad'];
      $q_Self_Employed = $_GET['q_Self_Employed'];
      $q_Under_Graduate = $_GET['q_Under_Graduate'];
      $q_total_stud = $grad_no + $notgrad_no;
      $q_total_stud_status  = $q_Employed + $q_Unemployed + $q_Continuing_Study + $q_Abroad + $q_Self_Employed + $q_Under_Graduate;
      $program_id_get = $_GET['program_id'];
      $display ="";

      $semester = $_GET['semester'];
      $acad_year_start = $_GET['acad_year_start'];
      $acad_year_end =  $acad_year_start + 1;
      $program_code = $_GET['program_code'];

      if($program_id_get != 0 ){
          $q_data = $database->query("SELECT * FROM alumni_info_view AS a INNER JOIN program_list AS b INNER JOIN student_info as c INNER JOIN alumni_info as d where a.program_id = b.program_id AND a.stud_no  = c.stud_no AND c.acad_year_start = '$acad_year_start' AND c.semester = '$semester' AND c.program_id = '$program_id_get'")->fetchAll();

          $q_data2 = $database->query("SELECT a.status AS grad_status,a.stud_no,concat(b.lname,', ',b.fname,' ',b.mname) AS student_name,c.* FROM alumni_grad_info AS a INNER JOIN student_info AS b INNER JOIN program_list AS c WHERE a.stud_no = b.stud_no AND a.acad_year_start AND b.acad_year_start AND a.semester and b.semester AND a.program_id = b.program_id AND a.program_id = c.program_id AND a.semester = '$semester' AND a.acad_year_start = '$acad_year_start' AND a.program_id = '$program_id_get'")->fetchAll();

      }else{
        $q_data = $database->query("SELECT * FROM alumni_info_view AS a INNER JOIN program_list AS b INNER JOIN student_info as c where a.program_id = b.program_id AND a.stud_no  = c.stud_no AND c.acad_year_start = '$acad_year_start' AND c.semester = '$semester'")->fetchAll();

          $q_data2 = $database->query("SELECT a.status AS grad_status,a.stud_no,concat(b.lname,', ',b.fname,' ',b.mname) AS student_name,c.* FROM alumni_grad_info AS a INNER JOIN student_info AS b INNER JOIN program_list AS c WHERE a.stud_no = b.stud_no AND a.acad_year_start AND b.acad_year_start AND a.semester and b.semester AND a.program_id = b.program_id AND a.program_id = c.program_id AND a.semester = '$semester' AND a.acad_year_start = '$acad_year_start'")->fetchAll();

      }



    }else{
      $grad_no = "";
      $notgrad_no ="";
      $q_Employed = "";
      $q_Unemployed = "";
      $q_Continuing_Study = "";
      $q_Abroad = "";
      $q_Self_Employed = "";
      $q_Under_Graduate = "";
      $q_total_stud = "";
      $q_total_stud_status  = "";
      $display ="none";

      $semester = "";
      $acad_year_start = "";
      $acad_year_end =  "";
      $program_code = "";
      $program_id_get = "";

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
  <script src="asset/js/jquery.confirm.js"></script>
  <script src="asset/js/sweetalert-dev.js"></script>

<link rel="shortcut icon" href="asset/img/e2elogoc.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style type="text/css">
    hr {
    color:black;display: block;
    height: 2px;
    border: 0;
    border-top: 2px solid #ccc;
    margin: 1em 0;
    padding: 0;
    }
  </style>
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
                        <label class="active">   
                         <a href="e2e/index.html"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label><a href="e2e_admin_home.back.php">
                          <i class="glyphicon glyphicon-tasks"></i>Student Report</a>
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


          <!-- start: Content -->
          <div id="content" class="profile-v1">
             <div class="col-md-12 col-sm-12 profile-v1-wrapper" style="height:420px;">
                <div class="col-md-12  profile-v1-cover-wrap" style="padding-right:0px;">
                    <div class="profile-v1-pp">
                      <?php
                       echo '<img src="data:'.$img_type_profile.';base64,'.$profileData.'">';
                       ?>
                      <h4 style="color:white;"><?php echo $title.". ".$fname." ".$mname." ".$lname ?></h4>
                      <h4 style="color:white;padding-left:30px;">Adminisrator</h4>
                    </div>
                    <div class="col-md-12 profile-v1-cover">
                       <?php
                       echo '<img src="data:'.$img_type_cover.';base64,'.$coverData.'" style="height:400px;" class="img-responsive">';
                       ?>
                    </div>
                </div>
             </div>
             <div class="col-md-12">
                
            <div class="row">
             <div class="col-md-12">
                    <div class="col-md-12 tabs-area">
                     <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#tabs-demo4-area1" id="tabs-demo4-1" role="tab" data-toggle="tab" aria-expanded="true">GRAPH</a>
                      </li>
                    </ul>
                    <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                      <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo4-area1" aria-labelledby="tabs-demo4-area1">
                      <!--count Data -->
                        <input type="hidden" id = "grad_no" value="<?php echo $grad_no; ?>"/>
                        <input type="hidden" id = "notgrad_no" value="<?php echo $notgrad_no; ?>"/>
                        <input type="hidden" id = "q_Employed" value="<?php echo $q_Employed; ?>"/>
                        <input type="hidden" id = "q_Unemployed" value="<?php echo $q_Unemployed; ?>"/>
                        <input type="hidden" id = "q_Continuing_Study" value="<?php echo $q_Continuing_Study; ?>"/>
                        <input type="hidden" id = "q_Abroad" value="<?php echo $q_Abroad; ?>"/>
                        <input type="hidden" id = "q_Self_Employed" value="<?php echo $q_Self_Employed; ?>"/>
                        <input type="hidden" id = "q_Under_Graduate" value="<?php echo $q_Under_Graduate; ?>"/>
                      <div class="row">
                        <div class="col-md-12">
                           <form  action = "graduation_info_filter_process.php" id ="defaultForm_filter"  method="POST">
                            <div class="col-md-3">
                            <h5 style="padding-left:5px;">SEMESTER</h5>
                              <div class="form-group has-feedback">
                                  <select  name="semester" id="semester" class="form-control" placeholder="Semester"> 
                                   <option value="1st Semester">1st Semester</option>
                                   <option value="2nd Semester">2nd Semester</option>
                                   <option value="Summer">Summer</option>
                                    </select>
                              </div>
                           </div>
                           <div class="col-md-2">
                                  <h5 style="padding-left:5px;">SY START</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date">
                                          <input type="text" class="form-control" name="acad_year_start" placeholder="(e.g.YYYY)" id="acad_year_start" onchange="get_value_ays()"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                              <div class="col-md-2">
                                <h5 style="padding-left:5px;">SY END</h5>
                                  <div>
                                   <input type="hidden" id="acad_year_end_value" name="acad_year_end" />
                                   <h4 id ="acad_year_start_show"></h4>
                                   </div>
                             </div>
                             <div class="col-md-2">
                            <h5 style="padding-left:5px;">PROGRAM</h5>
                            <div class="form-group has-feedback">
                                <?php
                                $table_pl = "program_list";
                                $columns_pl = "*";
                                $where_pl = ["status" => 'Active'];
                                $q_pl =$database->select($table_pl,$columns_pl,$where_pl);

                                print'<select class="form-control" name="program_id" class="form-control">';

                                echo "<option value='0'>All</option>";

                                 foreach($q_pl as $q_pl_data){
                                    $program_id2 = $q_pl_data['program_id'];
                                    $program_code2 = $q_pl_data['program_code'];
                                    $counter = 0;
                                if($counter <= $stud_program_id)
                                  {
                                      echo "<option value='".$program_id2."'>".$program_code2."</option>";
                                     $counter++;
                                  }
                                }
                                ?>
                                <?php
                                print '</select>';
                                ?>
                              </div>
                            </div>
                            <div class="col-md-3" style="padding-top:35px;padding-left:5px;">
                              <button type="submit" class="btn btn-primary btn-block" name="btn_filter" id = "btn_filter" >
                                <span class="fa fa-filter"></span>&nbsp; FILTER </button>
                             </div>
                          </form>
                        </div>
                      </div>

                      <div class="row" style="display:<?php echo $display; ?>">
                        <div class="col-md-12">
                        <div class="panel-body">
                        <div class="row" style="background-color:#3385ff">
                          <div class="col-md-12" style="color:white;"> 
                            <div class="col-md-4">
                              <h4>SEMESTER : <?php echo $semester; ?></h4>
                              <input type="hidden" id="semester_get" value="<?php echo $semester; ?>"/> 
                            </div>
                             <div class="col-md-4">
                              <h4>SCHOOL YEAR : <?php echo $acad_year_start." - ".$acad_year_end; ?></h4>
                              <input type="hidden" id="school_year_get" value="<?php echo $acad_year_start." - ".$acad_year_end; ?>"/>
                              <input type="hidden" id="company_name" value="<?php echo  $company_name; ?>"/>
                     
                            </div>
                             <div class="col-md-4">
                              <h4>PROGRAM : <?php echo $program_code; ?></h4>
                              <input type="hidden" id="program_code_get" value="<?php echo $program_code; ?>"/>
                            </div>
                          </div>
                        </div>
                        </div> 

                        <div class="col-md-5">
                            <div class="panel box-v3">  
                                <div class="panel-body">
                                   <div class="panel-heading-white panel-heading text-center">
                                      <h4>STUDENT STATUS</h4>
                                    </div>
                                    <div class="panel-body">
                                        <center>
                                          <canvas class="pie-chart2"></canvas>
                                        </center>
                                        <div class="row">
                                          <div class="col-md-12">
                                             <h4 style="color:#15BA67;"> Employed : 
                                                <label class="pull-right"> &nbsp; <?php echo $q_Employed; ?> </label>
                                             </h4>
                                             <h4 style="color:#e52222;">Unemployed : 
                                                <label class="pull-right"> &nbsp; <?php echo $q_Unemployed; ?> </label>
                                             </h4>
                                             <h4 style="color:#5BAABF;"> Continuing Study : 
                                                <label class="pull-right"> &nbsp; <?php echo $q_Continuing_Study; ?> </label>
                                             </h4>
                                             <h4 style="color:#0ed125;">Abroad : 
                                                <label class="pull-right"> &nbsp; <?php echo $q_Abroad; ?> </label>
                                             </h4>
                                             <h4 style="color:#f442d9;"> Self Employed : 
                                                <label class="pull-right"> &nbsp; <?php echo $q_Self_Employed; ?></label> 
                                              </h4>
                                             <h4 style="color:#ad5d08;">Under Graduate :
                                                <label class="pull-right"> &nbsp; <?php echo $q_Under_Graduate; ?> </label>
                                             </h4>
                                             <hr>
                                              <h4 style="color:#252b2b;"> <b> TOTAL : </b>
                                                <label class="pull-right">
                                                   <b><?php echo $q_total_stud_status; ?></b>
                                                </label>
                                              </h4>
                                          </div>
                                        </div>
                                    </div>

                              </div>
                            </div>

                           </div>

                          <div class="col-md-5">
                            <div class="panel box-v3">  
                                <div class="panel-body">
                                   <div class="panel-heading-white panel-heading text-center">
                                      <h4>GRADUATION INFO</h4>
                                    </div>
                                    <div class="panel-body">
                                        <center>
                                          <canvas class="pie-chart"></canvas>
                                        </center>
                                        <div class="row">
                                          <div class="col-md-12">
                                             <h4 style="color:#298ee8;"> Graduate :
                                                <label class="pull-right"> &nbsp; <?php echo $grad_no; ?></label>
                                             </h4>
                                             <h4 style="color:#e52222;">Not Graduate : 
                                                <label class="pull-right"> &nbsp; <?php echo $notgrad_no; ?></label>
                                             </h4>
                                               <hr>
                                              <h4 style="color:#252b2b;"> <b> TOTAL : </b>
                                                <label class="pull-right">
                                                   <b><?php echo $q_total_stud; ?></b>
                                                </label>
                                              </h4>
                                          </div>
                                        </div>
                                    </div>
                              </div>
                            </div>
                           </div>
                        </div>
                      </div>
                      <div class="row" style="display:<?php echo $display; ?>;">
                        <div class="col-md-12">
                          <div class="col-md-2">
                          </div>
                          <div class="col-md-6"></div>
                           <div class="col-md-4">
                           <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                          </div>
                        </div>
                      </div>    
              <?php

              print '<div class="panel-body" style="display:'.$display.'">
                      <div class="row" style="background-color:#3385ff;">
                      <div class="col-md-12">
                        <h4 class="text-center" style="color:white;"><b>STUDENT STATUS</b></h4>

                      </div>
                    </div>
                    </div>
                      <div class="panel-body" style="display:'.$display.'">
                      <div class="responsive-table">
                      <table id="datatables2" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                         <th class="text-center">STUDENT NUMBER</th>
                          <th class="text-center">STUDENT NAME</th>
                          <th class="text-center">PROGRAM</th>
                          <th class="text-center">COMPANY</th>
                          <th class="text-center">DATE HIRED</th>
                          <th class="text-center">STATUS</th> 
                        </tr>
                      </thead>
                      <tbody>';
                          foreach($q_data AS $qData){
                            $stud_no = $qData['stud_no'];
                            $student_name = $qData['student_name'];
                            $program_code = $qData['program_code'];
                            $company_name = $qData['comp_name'];
                            $date_hired = $qData['date_hired'];
                            $work_status = $qData['work_status'];
                            ?>
                          <tr>
                              <td><?php echo $stud_no; ?></td>
                              <td><?php echo $student_name; ?></td>
                              <td><?php echo $program_code; ?></td>
                              <td><?php echo $company_name; ?></td>
                              <td><?php echo $date_hired; ?></td>
                              <td><?php echo $work_status; ?></td>
                            </tr>
                      <?php
                     }

                  ?>

                     </table>   
                       <div class="col-md-4">


                               <a href="report.php?semester=<?php echo $semester; ?>&start=<?php echo $acad_year_start; ?>&program_code=<?php echo $program_code; ?>"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class=" glyphicon glyphicon-file"> &nbsp;REPORTS</span></button></a>
                             </div>
                     </div>
                     </div>
                     <?php
                     ?>
                     <div class="row" style="display:<?php echo $display; ?>">
                        <div class="col-md-12">
                          <div class="col-md-2">
                          </div>
                          <div class="col-md-6"></div>
                           <div class="col-md-4">
                           <div id="buttons2" class="pull-right" style="padding-top:6px;"></div>
                          </div>
                        </div>
                      </div>
                      <?php
              
              print '<div class="panel-body" style="display:'.$display.'">
                      <div class="row" style="background-color:#3385ff;">
                      <div class="col-md-12">
                        <h4 class="text-center" style="color:white;"><b>GRADUATION INFO</b></h4>
                      </div>
                    </div>
                    </div>
                      <div class="panel-body" style="display:'.$display.'">
                      <div class="responsive-table">
                      <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                         <th class="text-center">STUDENT NUMBER</th>
                          <th class="text-center">STUDENT NAME</th>
                          <th class="text-center">PROGRAM</th>
                          <th class="text-center">STATUS</th> 
                        </tr>
                      </thead>
                      <tbody>';
                          foreach($q_data2 AS $qData2){
                            $stud_no = $qData2['stud_no'];
                            $student_name = $qData2['student_name'];
                            $program_code = $qData2['program_code'];
                            $work_status = $qData2['grad_status'];
                            ?>
                          <tr>
                              <td><?php echo $stud_no; ?></td>
                              <td><?php echo $student_name; ?></td>
                              <td><?php echo $program_code; ?></td>
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
                      <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area2" aria-labelledby="tabs-demo4-area2">
                        hahaha
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area3" aria-labelledby="tabs-demo4-area3">
                        
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area4" aria-labelledby="tabs-demo4-area4">
                        
                      </div>
                    </div>
                  </div>   
                </div>
              </div>
          </div>
          </div>
          <!-- end: content -->
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
                      <a href="e2e_company_records.php"><i class="glyphicon fa fa-building-o"></i>&nbsp; Company Records</a>
                      <a href="*"><i class="glyphicon fa fa-thumbs-o-up"></i>&nbsp; OJT Endorsement</a>
                      <a href="*"><i class="glyphicon fa fa-user-secret"></i>&nbsp; Check Attire</a>
                      <a href="e2e_grad_id.php"><i class="glyphicon fa fa-smile-o"></i>&nbsp; Graduating ID Card</a>
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
<script src="asset/js/plugins/chart.min.js"></script>
<!-- custom -->

<script type="text/javascript">
var grad_no = document.getElementById('grad_no').value;
var notgrad_no = document.getElementById('notgrad_no').value;
var F_grad_no = parseInt(grad_no);
var F_notgrad_no = parseInt(notgrad_no);

var q_Employed = document.getElementById('q_Employed').value;
var q_Unemployed = document.getElementById('q_Unemployed').value;
var q_Continuing_Study = document.getElementById('q_Continuing_Study').value;
var q_Abroad = document.getElementById('q_Abroad').value;
var q_Self_Employed = document.getElementById('q_Self_Employed').value;
var q_Under_Graduate = document.getElementById('q_Under_Graduate').value;

var F_q_Employed = parseInt(q_Employed);
var F_q_Unemployed = parseInt(q_Unemployed);
var F_q_Continuing_Study = parseInt(q_Continuing_Study);
var F_q_Abroad = parseInt(q_Abroad);
var F_q_Self_Employed = parseInt(q_Self_Employed);
var F_q_Under_Graduate = parseInt(q_Under_Graduate);

var company_name = document.getElementById('company_name').value;
var school_year_get = document.getElementById('school_year_get').value;
var semester_get = document.getElementById('semester_get').value;
var program_code_get = document.getElementById('program_code_get').value;

function get_value_ays(){
var selected_acad_year_start = document.getElementById("acad_year_start").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
 document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;
 }

 $(document).ready(function(){
 var table = $('#datatables2').DataTable();
 var buttons = new $.fn.dataTable.Buttons(table, {
     buttons: [
            {
                extend: 'excelHtml5',
                title: 'STUDENT STATUS SEM_'+semester_get+'_SY_'+school_year_get+'_PROGRAM_'+program_code_get, 
                 text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                 className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'print',
                title: ' STUDENT STATUS',
                message: 'SY : '+school_year_get+' || SEM : '+semester_get+ ' || PROGRAM : ' + program_code_get+' || Emp.: '+F_q_Employed+' || Unemp. : '+F_q_Unemployed+' || CS: '+F_q_Continuing_Study+' || Abr.: '+F_q_Abroad+' || S.emp.: '+q_Self_Employed+' || UG: '+F_q_Under_Graduate,                
                text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'pdf',
                title: 'STUDENT STATUS',
                message: 'SY : '+school_year_get+' || SEM : '+semester_get+ ' || PROGRAM : ' + program_code_get+' || Emp.: '+F_q_Employed+' || Unemp. : '+F_q_Unemployed+' || CS: '+F_q_Continuing_Study+' || Abr.: '+F_q_Abroad+' || S.emp.: '+q_Self_Employed+' || UG: '+F_q_Under_Graduate,                
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },  
        ]
    }).container().appendTo($('#buttons')); 


 var table2 = $('#datatables').DataTable();
 var buttons = new $.fn.dataTable.Buttons(table2, {
     buttons: [
            {
                extend: 'excelHtml5',
                title: 'GRADUATION INFO STATUS SEM'+semester_get+'_SY_'+school_year_get+'_PROGRAM_'+program_code_get,              
                text: '<i class="glyphicon glyphicon-save-file"></i> EXCELs',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'print',
                title: 'GRADUATION INFO',
                message: 'SY : '+school_year_get+' || SEM : '+semester_get+ ' || PROGRAM : ' + program_code_get+' || GRADUATE : '+ F_grad_no+ ' || NOT GRADUATE : '+F_notgrad_no,
                text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'pdf',
                title: 'GRADUATION INFO',
                message: 'SY : '+school_year_get+' || SEM : '+semester_get+ ' || PROGRAM : ' + program_code_get+' || GRADUATE : '+ F_grad_no+ ' || NOT GRADUATE : '+F_notgrad_no,
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },  
        ]
    }).container().appendTo($('#buttons2')); 

   $('#acad_year_start')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm_filter').bootstrapValidator('revalidateField', 'acad_year_start');
        });
 });
//start of form validation 
$('#defaultForm_filter')
    .bootstrapValidator({
        message: 'This value is invalid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid:'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          semester: {
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        },
                    },
                },
           program_id: {
                    validators: {
                        notEmpty: {
                            message: 'Program is required and can\'t be empty'
                        },
                    },
                },
                 
                acad_year_start: {
                    validators: {
                        notEmpty: {
                            message: 'Academic year start is required and can\'t be empty'
                        }, 
                        stringLength: {
                        min: 4,
                        max: 4,
                        message: 'Batch Number must be more 4 numbers'
                    },                      
                         regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                }
        }
    });

      (function(jQuery){
        var doughnutData = [
                      {
                          value: F_grad_no,
                          color:"#298ee8",
                          highlight: "#469dea",
                          label: "Graduate"
                      },
                      {
                          value: F_notgrad_no,
                          color: "#e52222",
                          highlight: "#ef3939",
                          label: "Not Graduate"
                      }
                  ];
          var doughnutData2 = [
                      {
                    value: F_q_Employed,
                    color:"#15BA67",
                    highlight: "#15BA67",
                    label: "Employed"
                },
                { 
                    value: F_q_Unemployed,
                    color: "#e52222",
                    highlight: "#e52222",
                    label: "Unemployed"
                },
                {
                    value: F_q_Continuing_Study,
                    color: "#5BAABF",
                    highlight: "#5BAABF",
                    label: "Continuing Study"
                },
                {
                    value: F_q_Abroad,
                    color: "#0ed125",
                    highlight: "#0ed125",
                    label: "Abroad"
                },
                {
                    value: F_q_Self_Employed,
                    color: "#f442d9",
                    highlight: "#f442d9",
                    label: "Self Employed"
                },
                {
                    value: F_q_Under_Graduate,
                    color: "#ad5d08",
                    highlight: "#ad5d08",
                    label: "Under Graduate"
                }  
                  ];
          window.onload = function(){

                      var ctx2 = $(".pie-chart")[0].getContext("2d");
                      window.myPie = new Chart(ctx2).Pie(doughnutData, {
                          responsive : true,
                          showTooltips: true
                      });

                      var ctx3 = $(".pie-chart2")[0].getContext("2d");
                      window.myPie = new Chart(ctx3).Pie(doughnutData2, {
                          responsive : true,
                          showTooltips : true
                      });
                  };
        })(jQuery);
</script>

<!-- end: Javascript -->
</body>
</html>
