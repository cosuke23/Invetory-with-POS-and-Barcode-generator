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
                        <label class="active"><a href="e2e_company_records.php">
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
                        <h1 class="animated fadeInLeft">COMPANY RECORDS</h1>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Mock Interview Records</h3></div>
                     <br>
                     <div class="panel-body">
                       <div class="row">
                         <div class="col-md-12">
                           <div style="background-color:#22c222;color:#fff;padding:5px;">
                             <?php
                              if(isset($_GET["comp_id"])){
                                $comp_id = $_GET["comp_id"];
                                $table = "company_info";
                                $columns = "*";
                                $where = ["comp_id"=>$comp_id];
                                $qcomp = $database->select($table,$columns,$where);

                                foreach ($qcomp as $qcomp_data) {
                                  $comp_name = $qcomp_data["comp_name"];
                                  echo "<div style='font-size:18px;font-weight:bold;'>".$comp_name."</div>";
                                }
                              }
                             ?>
                           </div>
                         </div>
                       </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                    <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                            <div class="col-md-8"></div>
                             <div class="col-md-4">
                             <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                          </div>
                    </div>

                      <div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                         <th class="col-md-1"></th>
                         <th class="text-center">STUDENT NUMBER</th>
                         <th class="text-center">LAST NAME</th>
                         <th class="text-center">FIRST NAME</th>
                         <th class="text-center">MIDDLE NAME</th>
                         <th class="text-center">PROGRAM</th>
                         <th class="text-center">SEM</th>
                         <th class="text-center">ACAD YEAR</th>
                         <th class="text-center">GRADE</th>
                         <th class="text-center">REMARKS</th>
                         <th class="text-center">COMMENT</th>
                        </tr>
                      </thead>
                      <?php
                        if(isset($_GET['comp_id'])){
                          $comp_id = $_GET['comp_id'];
                          $table = "tbl_interviewer";
                          $columns = "*";
                          $where = ["comp_id"=>$comp_id];
                          $q_comp = $database->select($table,$columns,$where);

                          foreach ($q_comp as $q_comp_data){
                            $interviewer_id = $q_comp_data["interviewer_id"];

                            $table2 = "event_mi_interview_list";
                            $columns2 = "*";
                            $where2 = ["interviewer_id"=>$interviewer_id];
                            $q_inter = $database->select($table2,$columns2,$where2);

                            foreach ($q_inter as $q_inter_data){
                              $mi_interview_list_id = $q_inter_data["mi_interview_list_id"];
                              $mi_sched_stud_set_id = $q_inter_data["mi_sched_stud_set_id"];

                              $table3 = "event_mi_sched_stud_set";
                              $columns3 = "*";
                              $where3 = ["AND"=>["mi_sched_stud_set_id"=>$mi_sched_stud_set_id,"status"=>'Already Graded']];
                              $q_stud_set = $database->select($table3,$columns3,$where3);

                              foreach ($q_stud_set as $q_stud_set_data){
                                $stud_no = $q_stud_set_data["stud_no"];

                                $table4 = "student_info";
                                $columns4 = "*";
                                $where4 = ["stud_no"=>$stud_no];
                                $q_stud = $database->select($table4,$columns4,$where4);

                                foreach ($q_stud as $q_stud_data){
                                  $stud_dp = $q_stud_data["stud_dp"];
                                  $stud_no = $q_stud_data["stud_no"];
                                  $lname = $q_stud_data["lname"];
                                  $fname = $q_stud_data["fname"];
                                  $mname = $q_stud_data["mname"];
                                  $program_id = $q_stud_data["program_id"];
                                  $semester = $q_stud_data["semester"];
                                  $semester = $q_stud_data["semester"];
                                  $acad_year = $q_stud_data["acad_year_start"].'-'.$q_stud_data["acad_year_end"];

                                  $table5 = "program_list";
                                  $columns5 = "*";
                                  $where5 = ["program_id"=>$program_id];
                                  $q_program = $database->select($table5,$columns5,$where5);

                                  foreach ($q_program as $q_program_data){
                                    $program_code = $q_program_data["program_code"];

                                    $table6 = "event_mi_interview_grade";
                                    $columns6 = "*";
                                    $where6 = ["mi_interview_list_id"=>$mi_interview_list_id];
                                    $q_grade = $database->select($table6,$columns6,$where6);

                                    foreach ($q_grade as $q_grade_data){
                                      $total = $q_grade_data["total"];
                                      $remarks = $q_grade_data["remarks"];
                                      $comment = $q_grade_data["comment"];
                                    ?>
                                      <tr>
                                        <td><img src="grad_id/grad_data/student_image/<?php echo $stud_dp; ?>" style="height:40px;width:50px;"></td>
                                        <td><?php echo $stud_no; ?></td>
                                        <td><?php echo $lname; ?></td>
                                        <td><?php echo $fname; ?></td>
                                        <td><?php echo $mname; ?></td>
                                        <td><?php echo $program_code; ?></td>
                                        <td>
                                          <?php
                                            if($semester=='1st Semester'){
                                              echo '1st Sem';
                                            }
                                            elseif($semester=='2nd Semester'){
                                              echo '2nd Sem';
                                            }
                                          ?>
                                        </td>
                                        <td><?php echo $acad_year ?></td>
                                        <td><?php echo $total; ?>/100</td>
                                        <td>
                                          <?php
                                            if($remarks=='Passed'){
                                          ?>
                                              <div style="font-weight:bold;color:green"><?php echo $remarks; ?></div>
                                          <?php
                                            }
                                            else{
                                          ?>
                                              <div style="font-weight:bold;color:red"><?php echo $remarks; ?></div>
                                          <?php
                                            }
                                          ?>
                                        </td>
                                        <td><?php echo $comment; ?></td>
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
                     </table>
                     </div>
                     </div>
                  </div>
                </div>
              </div>
            </div><!-- end: content -->

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
                      <a href="*"><i class="glyphicon fa fa-smile-o"></i>&nbsp; Graduating ID Card</a>
                      <a href="e2e_business_card.php"><i class="glyphicon icons icon-credit-card"></i>&nbsp; Business Card</a>
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
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#datatables').DataTable();
      var buttons = new $.fn.dataTable.Buttons(table, {

          buttons: [
                 {
                     extend: 'excelHtml5',
                     title: 'A',
                      text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                      className: 'btn btn-info btn-outline',
                     exportOptions: {
                         columns: [2,3,4,5,8,9,10]
                     }
                 },
                 {
                     extend: 'print',
                     title: 'a',
                     text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                     className: 'btn btn-info btn-outline',
                     exportOptions: {
                         columns: [2,3,4,5,8,9,10]
                     }
                 },

             ]
         }).container().appendTo($('#buttons'));
 });
</script>
<!-- end: Javascript -->
</body>
</html>
