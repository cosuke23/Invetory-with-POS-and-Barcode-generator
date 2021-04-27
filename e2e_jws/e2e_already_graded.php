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
                        <label>
                          <a href="e2e_scheduled_interviewees.php"><i class="fa fa-paste"></i>Scheduled Interviewees</a>
                        </label><br>
                        <label>
                          <a href="e2e_pending_interviewees.php"><i class="fa fa-paste"></i>Pending Interviewees</a>
                        </label><br>
                        <label class="active">
                          <a href="e2e_already_graded.php"><i class="fa fa-paste"></i>Already Graded</a>
                        </label><br>       
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->

          <!-- start: Content -->
          <div id="content" class="profile-v1">
            <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">ALREADY GRADED</h1>
                    </div>
                  </div>
              </div>
            <div class="col-md-12 padding-0">
              <div class="col-md-12">
                <div class="panel">
                  <div class="panel-heading">
                    <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-home"></span> HOME</a>
                      </li>
                      <li role="presentation">
                        <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-list-alt"></span> LIST</a>
                      </li>
                    </ul>
                  </div><br>

                  <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
                      <div class="panel box-v7">
                        <div class="panel-body">
                          <!-- Start -->
                          <?php
                            $table = "event_mi_interview_grade";
                            $columns = "*";
                            $where = ["total[!]"=>null,"ORDER" => ["total" => "DESC"]];
                            $q_grade = $database->select($table,$columns,$where);

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

                                $tableX = "event_mi_sched_stud_set";
                                $columnsX = "mi_sched_id";
                                $whereX = ["mi_sched_stud_set_id" => $mi_sched_stud_set_id];
                                $q_mi_sched_id = $database->get($tableX,$columnsX,$whereX);

                                $tableY = "event_mi_sched";
                                $columnsY = ["event_mi_batch_date","time_start","time_end"];
                                $whereY = ["mi_sched_id" => $q_mi_sched_id];
                                $q_y = $database->get($tableY,$columnsY,$whereY);                                

                                $batch_dateY = $q_y["event_mi_batch_date"];
                                $time_startY = $q_y["time_start"];
                                $time_endY   = $q_y["time_end"];



                                $table3 = "tbl_interviewer";
                                $columns3 = "*";
                                $where2 = ["AND"=>["interviewer_id" => $interviewer_id,"comp_id"=>$comp_id]];
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
                                      $stud_lname = ucwords(strtolower($q_student_data['lname']));
                                      $stud_fname = ucwords(strtolower($q_student_data['fname']));
                                      $stud_mname = ucwords(strtolower($q_student_data['mname']));
                                      $stud_dp = $q_student_data['stud_dp'];
                                      $program_id = $q_student_data['program_id'];

                                      $table6 = "program_list";
                                      $columns6 = "*";
                                      $where5 = ["program_id" => $program_id];
                                      $q_program = $database->select($table6,$columns6,$where5);

                                      foreach ($q_program AS $q_program_data){
                                        $program_code = $q_program_data['program_code'];

                                        $table7 = "resume_data";
                                        $columns7 = "*";
                                        $where7 = ["stud_no"=>$stud_no];
                                        $q_resume = $database->select($table7,$columns7,$where7);

                                        foreach($q_resume as $q_res_data){
                                          $resume_id = $q_res_data["resume_id"];
                                          $file_name = $q_res_data["file_name"];
                                          $stud_no_res = $q_res_data["stud_no"];
                                          $resume_link = $q_res_data["resume_link"];
                          ?>
                          <div class="col-md-3 padding-0 box-v7-header">
                            <div class="col-md-12 padding-0" style="background:#0d47a1;padding:10px;">
                              <div class="col-md-12 padding-0">
                                <img src="grad_id/grad_data/student_image/<?php echo $stud_dp; ?>" class="box-v7-avatar pull-left" style="width:90px;height:90px;" />                                
                                <h6 style="color:#fff;font-size:12px;"><?php echo $stud_lname.", ".$stud_fname." ".$stud_mname; ?></h6>
                                <h6 style="color:#fff;font-size:12px;"><?php echo $program_code; ?></h6>
                                <a class="btn-info btn-sm" href="asset/resume_data/<?php echo $file_name; ?>" target="resume"> VIEW RESUME
                                </a>
                              </div>
                            </div>
                            <div class="panel-body" style="border:1px solid black;">
                              <div class="row">
                                <div class="col-md-9">
                                  <h5 style="color:#a10d0d;font-weight:bold;">COMM SKILL</h5>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="color:black;font-weight:bold;"><?php echo $comm_skill; ?></h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-9">
                                  <h5 style="color:#640da1;font-weight:bold;">PAPER SCREENING</h5>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="color:black;font-weight:bold;"><?php echo $paper_screening; ?></h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-9">
                                  <h5 style="color:#0d48a1;font-weight:bold;">SKILL FIT</h5>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="color:black;font-weight:bold;"><?php echo $skill_fit; ?></h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-9">
                                  <h5 style="color:#0da156;font-weight:bold;">ORG FIT</h5>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="color:black;font-weight:bold;"><?php echo $org_fit; ?></h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-9">
                                  <h5 style="color:#d07f00;font-weight:bold;">CONFIDENCE</h5>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="color:black;font-weight:bold;"><?php echo $confidence; ?></h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-9">
                                  <h5 style="color:#a77e00;font-weight:bold;">TOTAL</h5>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="color:black;font-weight:bold;"><?php echo $total; ?></h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-8">
                                  <h5 style="color:black;font-weight:bold;">REMARKS</h5>
                                </div>
                                <div class="col-md-4">
                                  <?php 
                                    if($remarks == 'Passed'){
                                  ?>
                                      <h5 style="color:#007005;font-weight:bold;"><?php echo $remarks; ?></h5>
                                  <?php
                                    }
                                    else{
                                  ?>
                                      <h5 style="color:#9a0000;font-weight:bold;"><?php echo $remarks; ?></h5>
                                  <?php
                                    }
                                  ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="panel-body">
                                  <div class="col-md-12" style="background:#ffe57f;">
                                  <h6 style="text-align:center;color:black;font-size:10px;">DATE:&nbsp;
                                    <span style="font-weight:bold;font-size:11px;"><?php echo date("F d, Y",strtotime($batch_dateY)); ?><span></h6>

                                    <h6 style="text-align:center;color:black;font-size:10px;">INTERVIEWER:</h6>
                                    <h6 style="font-weight:bold;text-align:center;color:black;font-size:11px;"><?php echo $interviewer_fname." ".$interviewer_lname ?></h6>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- End -->
                        <?php 
                                      }
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
                    <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">
                      <div class="panel box-v7">
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                              <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                          </div><br>
                          <div class="responsive-table">
                            <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <th class="col-md-1"></th>
                                  <th class="text-center">STUDENT NAME</th>
                                  <th class="text-center">PROGRAM</th>
                                  <th class="text-center" style="width:10%;">COMM SKILL</th>
                                  <th class="text-center" style="width:10%;">PAPER SCREENING</th>
                                  <th class="text-center" style="width:10%;">SKILL FIT</th>
                                  <th class="text-center" style="width:10%;">ORG FIT</th>
                                  <th class="text-center" style="width:10%;">CONFIDENCE</th>
                                  <th class="text-center" style="width:10%;">TOTAL</th>                                  
                                  <th class="text-center" style="width:10%;">REMARKS</th>
                                  <th class="text-center" style="width:15%;">DATE</th>
                                  <th class="text-center" style="width:15%;">COMMENTS</th>
                                </tr>
                              </thead>
                            <tbody>
                          <!-- Start -->
                            <?php
                              // $table = "event_mi_interview_grade";
                              // $columns = "*";
                              // $where = ["total[!]"=>null,"ORDER" => ["total" => "DESC"]];
                              // $q_grade = $database->select($table,$columns,$where);

                              // foreach ($q_grade AS $q_grade_data){
                              //   $mi_interview_list_id = $q_grade_data['mi_interview_list_id'];
                              //   $comm_skill = $q_grade_data['comm_skill'];
                              //   $paper_screening = $q_grade_data['paper_screening'];
                              //   $skill_fit = $q_grade_data['skill_fit'];
                              //   $org_fit = $q_grade_data['org_fit'];
                              //   $confidence = $q_grade_data['confidence'];
                              //   $total = $q_grade_data['total'];
                              //   $remarks = $q_grade_data['remarks'];
                              //   $comment = $q_grade_data['comment'];

                              //   $table2 = "event_mi_interview_list";
                              //   $columns2 = "*";
                              //   $where = ["mi_interview_list_id" => $mi_interview_list_id];
                              //   $q_list = $database->select($table2,$columns2,$where);

                              //   foreach ($q_list AS $q_list_data){
                              //     $interviewer_id = $q_list_data['interviewer_id'];
                              //     $mi_sched_stud_set_id = $q_list_data['mi_sched_stud_set_id'];

                              //     $table3 = "tbl_interviewer";
                              //     $columns3 = "*";
                              //     $where2 = ["AND"=>["interviewer_id" => $interviewer_id,"comp_id"=>$comp_id]];
                              //     $q_interviewer = $database->select($table3,$columns3,$where2);

                              //     foreach ($q_interviewer AS $q_interviewer_data){
                              //       $interviewer_lname = $q_interviewer_data['lname'];
                              //       $interviewer_fname = $q_interviewer_data['fname'];
                              //       $position = $q_interviewer_data['position'];

                              //       $table4 = "event_mi_sched_stud_set";
                              //       $columns4 = "*";
                              //       $where3 = ["mi_sched_stud_set_id" => $mi_sched_stud_set_id];
                              //       $q_sched = $database->select($table4,$columns4,$where3);

                              //       foreach ($q_sched AS $q_sched_data){
                              //         $stud_no = $q_sched_data['stud_no'];
                              //         $mi_sched_id = $q_sched_data['mi_sched_id'];

                              //         $tableW = "event_mi_sched";
                              //         $columnsW = ["event_mi_batch_date","time_start","time_end"];
                              //         $whereW = ["mi_sched_id" => $q_mi_sched_id];
                              //         $q_w = $database->get($tableW,$columnsW,$whereW);                                

                              //         $batch_dateW = $q_w["event_mi_batch_date"];                                      

                              //         $table5 = "student_info";
                              //         $columns5 = "*";
                              //         $where4 = ["stud_no" => $stud_no];
                              //         $q_student = $database->select($table5,$columns5,$where4);

                              //         foreach ($q_student AS $q_student_data){
                              //           $stud_no = $q_student_data['stud_no'];
                              //           $stud_lname = ucwords(strtolower($q_student_data['lname']));
                              //           $stud_fname = ucwords(strtolower($q_student_data['fname']));
                              //           $stud_mname = ucwords(strtolower($q_student_data['mname']));
                              //           $stud_dp = $q_student_data['stud_dp'];
                              //           $program_id = $q_student_data['program_id'];

                              //           $table6 = "program_list";
                              //           $columns6 = "*";
                              //           $where5 = ["program_id" => $program_id];
                              //           $q_program = $database->select($table6,$columns6,$where5);

                              //           foreach ($q_program AS $q_program_data){
                              //             $program_code = $q_program_data['program_code'];

                              //             $table7 = "resume_data";
                              //             $columns7 = "*";
                              //             $where7 = ["stud_no"=>$stud_no];
                              //             $q_resume = $database->select($table7,$columns7,$where7);

                            $table = "event_mi_interview_grade";
                            $columns = "*";
                            $where = ["total[!]"=>null,"ORDER" => ["total" => "DESC"]];
                            $q_grade = $database->select($table,$columns,$where);

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

                                $tableX = "event_mi_sched_stud_set";
                                $columnsX = "mi_sched_id";
                                $whereX = ["mi_sched_stud_set_id" => $mi_sched_stud_set_id];
                                $q_mi_sched_id = $database->get($tableX,$columnsX,$whereX);

                                $tableY = "event_mi_sched";
                                $columnsY = ["event_mi_batch_date","time_start","time_end"];
                                $whereY = ["mi_sched_id" => $q_mi_sched_id];
                                $q_y = $database->get($tableY,$columnsY,$whereY);                                

                                $batch_dateY = $q_y["event_mi_batch_date"];
                                $time_startY = $q_y["time_start"];
                                $time_endY   = $q_y["time_end"];



                                $table3 = "tbl_interviewer";
                                $columns3 = "*";
                                $where2 = ["AND"=>["interviewer_id" => $interviewer_id,"comp_id"=>$comp_id]];
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
                                      $stud_lname = ucwords(strtolower($q_student_data['lname']));
                                      $stud_fname = ucwords(strtolower($q_student_data['fname']));
                                      $stud_mname = ucwords(strtolower($q_student_data['mname']));
                                      $stud_dp = $q_student_data['stud_dp'];
                                      $program_id = $q_student_data['program_id'];

                                      $table6 = "program_list";
                                      $columns6 = "*";
                                      $where5 = ["program_id" => $program_id];
                                      $q_program = $database->select($table6,$columns6,$where5);

                                      foreach ($q_program AS $q_program_data){
                                        $program_code = $q_program_data['program_code'];

                                        $table7 = "resume_data";
                                        $columns7 = "*";
                                        $where7 = ["stud_no"=>$stud_no];
                                        $q_resume = $database->select($table7,$columns7,$where7);

                                        foreach($q_resume as $q_res_data){
                                          $resume_id = $q_res_data["resume_id"];
                                          $file_name = $q_res_data["file_name"];
                                          $stud_no_res = $q_res_data["stud_no"];
                                          $resume_link = $q_res_data["resume_link"];
                            ?>
                                  <tr>
                                    <td class="text-center"><img src="grad_id/grad_data/student_image/<?php echo $stud_dp; ?>" style="height:40px;width:50px;"></td>
                                    <td class="text-center"><?php echo $stud_lname.", ".$stud_fname." ".$stud_mname; ?></td>
                                    <td class="text-center"><?php echo $program_code; ?></td>
                                    <td class="text-center"><?php echo $comm_skill; ?>/20</td>
                                    <td class="text-center"><?php echo $paper_screening; ?>/10</td>
                                    <td class="text-center"><?php echo $skill_fit; ?>/25</td>
                                    <td class="text-center"><?php echo $org_fit; ?>/25</td>
                                    <td class="text-center"><?php echo $confidence; ?>/20</td>
                                    <td class="text-center"><?php echo $total; ?>/100</td>
                                      <?php 
                                        if($remarks == 'Passed'){
                                      ?>
                                          <td class="text-center" style="color:#007005;"><?php echo $remarks; ?></td>
                                      <?php
                                        }
                                        else{
                                      ?>
                                          <td class="text-center" style="color:#9a0000;"><?php echo $remarks; ?></td>  
                                      <?php
                                        }
                                      ?>
                                    </td>
                                    <td class="text-center"><?php echo $batch_dateY; ?></td>                                    
                                    <td class="text-center"><?php echo $comment; ?></td>
                                  </tr>
                          <?php 
                                     }
                                    }
                                  }
                                }
                              }
                            }
                          } 
                          ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- end: content -->
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
<script type="text/javascript">
    $(document).ready(function(){
    var table = $('#datatables').DataTable();
    var buttons = new $.fn.dataTable.Buttons(table, {
      buttons: [
            {
                extend: 'excelHtml5',
                title: 'STUDENT LIST',         
                 text: '<i class="glyphicon glyphicon-print"></i> EXCEL',
                 className: 'btn btn-info btn-outline btn-sm',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10]
                }
            },
            {
                extend: 'print',
                title: 'STUDENT LIST',
                text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                className: 'btn btn-info btn-outline btn-sm',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9]
                }
            },
            {
                extend: 'pdf',
                title: 'STUDENT LIST',
                text: '<i class="glyphicon glyphicon-print"></i> PDF',
                className: 'btn btn-info btn-outline btn-sm',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10]
                }
            },
        ]
      }).container().appendTo($('#buttons'));
    });  
</script>

<!-- end: Javascript -->
</body>
</html>