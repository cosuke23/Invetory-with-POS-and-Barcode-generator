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

    //pie
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
///end of COOKIE CODES
$current_year = date("Y")-2;
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
                        <label  class="active"><a href="e2e_reports.php">
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
                    <h1 class="animated fadeInLeft"> REPORTS</h1>
                </div><!-- panel-body -->
              </div><!-- panel box-shadow-none -->
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                  
                  </div><br>
                  <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
                   
                      <div id="tabsDemo3Content" class="tab-content tabs-content-v2">
                        <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo3-area1" aria-labelledby="tabs-demo3-area1">
                          <div class="panel box-v7">
                            <div class="panel-body">
                              <div class="panel-body">
                                <form id="batch_certi" method="post" action="report_check.php" enctype="multipart/form-data">
                                  <div class="row">
                                    <div class="col-md-2">
                                      <h5 style="padding-left:5px;">PROGRAM</h5>
                                      <div class="form-group has-feedback">
                                        <?php
                                          $table = "program_list";
                                          $columns = "*";
                                          $q_program =$database->select($table,$columns);

                                          print'<select class="form-control"  name="program" class="form-control">';
                                          echo "<option value='".$program_id."' disabled selected>".$program_code."</option>";

                                          foreach($q_program as $q_program_data){
                                            $program_id2 = $q_program_data['program_id'];
                                            $program_code2 = $q_program_data['program_code'];
                                            $counter = 0;

                                            $comstart3="";
                                            if($program_code==$program_code2)
                                            {
                                              $comstart3="<!--";
                                            }
                                            if($counter <= $program_id)
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

                                       
                                    <div class="col-md-3"><br>
                                      <button type="submit" class="btn btn-ripple btn-raised btn-primary" name="btn_prog" id="btn_update_stud_info" style="margin-top:15px;">
                                        <span class="glyphicon glyphicon-ok"></span> &nbsp;OK PO
                                      </button>
                                    </div>
                                     <div class="col-md-4">
                              <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                                  </div>
                                </form>

                                <div class="responsive-table"  >
                             <!--   <div style=" overflow-y: scroll;">-->
                                  <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                    <thead>
                                      <tr>
                                        <th class="col-md-1">Program</th>
                                        <th class="text-center">Program Duration</th>
                                        <th class="text-center">Sy Graduated</th>
                                        <th class="text-center">Term Graduated</th>
                                        <th class="text-center">Monitoring</th>
                                        <th class="text-center">Date Contacted</th>
                                        <th class="text-center">Full Name</th>
                                        <th class="text-center">Contact</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Company</th>
                                        <th class="text-center">Postion</th>
                                        <th class="text-center">Industry</th>
                                        <th class="text-center">Sub-Class</th>
                                        <th class="text-center">Date-Hired</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Action</th>
                                       
                                      </tr>
                                    </thead>
                                    <?php
                                    include('db.php');
                                    $program_code2 = $_GET['program_code'];
                                      $q_data = mysql_query("SELECT alumni_info.date_hired,alumni_grad_info.acad_year_start,student_info.stud_no,student_info.lname,company_info.position,student_info.fname,student_info.mname,alumni_info.work_status,company_info.type_industry,student_info.email,student_info.contact_no,program_list.program_id,student_info.acad_year_end,student_info.program_id,program_list.program_code,alumni_info.comp_name,program_list.program_name,alumni_info.date_contact,
student_info.si_id,alumni_info.stud_no from student_info
left join program_list on student_info.program_id=program_list.program_id
left join alumni_info on student_info.stud_no=alumni_info.stud_no
left join alumni_grad_info on student_info.stud_no=alumni_grad_info.stud_no
left join company_info on company_info.comp_name=alumni_info.comp_name where program_list.program_code='$program_code2'
")or die(mysql_error());

 while($qData=mysql_fetch_array($q_data)){
                            $stud_no = $qData['stud_no'];
                            $program_code = $qData['program_code'];
                            $program_id = $qData['program_id'];
                            $company_name = $qData['comp_name'];
                            $year_grad = $qData['acad_year_end'];
                            $date_contact = $qData['date_contact'];
                            $lname = $qData['lname'];
                            $year_grads=$qData['acad_year_start'];
                           
                            $fname = $qData['fname'];
                            $mname = $qData['mname'];
                            $email = $qData['email'];
                            $work_status = $qData['work_status'];
                            $position = $qData['position'];
                            $date_hired = $qData['date_hired'];
                            $contact = $qData['contact_no'];
                            $comp_name = $qData['comp_name'];
                            $work_status = $qData['work_status'];
                            ?>
                          <tr>
                              <td><?php echo $program_code; ?></td>
                              <?php
                              if ($program_id>7&&$program_id<13) {
                                     echo '<td>2 yrs </td>';
                              }else{
                                echo '<td>4 yrs </td>';
                              }
                                 # code...
                                ?>
                              <td><?php echo $year_grads; ?>-<?php echo $year_grad; ?> </td>
                            
                     
                              <td></td>
                              <td></td>
                              <td><?php echo $date_contact; ?></td>
                              <td><?php echo $lname; ?> <?php echo $fname; ?> <?php echo $mname; ?></td>
                              <td><?php echo $contact; ?></td>
                              <td><?php echo $email; ?></td>
                              <td><?php echo $work_status; ?></td>
                              <td></td>
                              <td><?php echo $position; ?></td>
                              <td><?php echo $comp_name; ?></td>
                              <td></td>
                              <td><?php echo $date_hired; ?></td>
                              <td></td>
                             <td> <a href="e2e_edit_alumni_record.php?stud_no=<?php echo $stud_no; ?>">
                                  <button type="submit" class=" btn btn-outline btn-primary" data-toggle="tooltip" title= "Update Info">
                                  <span class="glyphicon glyphicon-pencil"></span></button>
                                  </a></td>
                              
                            </tr>
                      <?php
                     }
                      ?>
                  </tbody>

                     </table>
              <!--    </div>-->
                     </div>
                     </div>
                    
                                    
                                        <tr>
                                    
                                        </tr>
                                      <?php
                                        
                                      ?>
                                  </table>
                                </div>
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
                                        <?php
                                        $status=mysql_query("SELECT count(work_status) as status from alumni_info where work_status='Employed' ") or die(mysql_error());
                                        $em=mysql_fetch_array($status);
                                        $Employed=$em['status']; ?>
                                          <div class="col-md-12">
                                             <h4 style="color:#15BA67;"> Employed : 
                                                <label class="pull-right"> &nbsp; <?php echo $Employed ;?> </label>
                                             </h4>
                                              <?php
                                        $status=mysql_query("SELECT count(work_status) as status from alumni_info where work_status='Unemployed' ") or die(mysql_error());
                                        $em=mysql_fetch_array($status);
                                        $Unemployed=$em['status']; ?>
                                             <h4 style="color:#e52222;">Unemployed : 
                                                <label class="pull-right"> &nbsp; <?php echo $Unemployed; ?> </label>
                                             </h4>
                                                   <?php
                                        $status=mysql_query("SELECT count(work_status) as status from alumni_info where work_status='Continuing Study' ") or die(mysql_error());
                                        $em=mysql_fetch_array($status);
                                        $Continuing=$em['status']; ?> 
                                             <h4 style="color:#5BAABF;"> Continuing Study : 
                                                <label class="pull-right"> &nbsp; <?php echo $Continuing; ?> </label>
                                             </h4>
                                                        <?php
                                        $status=mysql_query("SELECT count(work_status) as status from alumni_info where work_status='Abroad' ") or die(mysql_error());
                                        $em=mysql_fetch_array($status);
                                        $Abroad=$em['status']; ?> 
                                             <h4 style="color:#0ed125;">Abroad : 
                                                <label class="pull-right"> &nbsp; <?php echo $Abroad; ?> </label>
                                             </h4>
                                                    <?php
                                        $status=mysql_query("SELECT count(work_status) as status from alumni_info where work_status='Selfemployed' ") or die(mysql_error());
                                        $em=mysql_fetch_array($status);
                                        $Selfemployed=$em['status']; ?> 
                                             <h4 style="color:#f442d9;"> SelfEmployed : 
                                                <label class="pull-right"> &nbsp; <?php echo $Selfemployed; ?></label> 
                                              </h4>
                                                   <?php
                                        $status=mysql_query("SELECT count(work_status) as status from alumni_info where work_status='UnderGraduate' ") or die(mysql_error());
                                        $em=mysql_fetch_array($status);
                                        $UnderGraduate=$em['status']; ?>
                                             <h4 style="color:#ad5d08;">Under Graduate :
                                                <label class="pull-right"> &nbsp; <?php echo $UnderGraduate; ?> </label>
                                             </h4>
                                             <hr>
                                                <?php
                                        $status=mysql_query("SELECT count(work_status) as status from alumni_info  ") or die(mysql_error());
                                        $em=mysql_fetch_array($status);
                                        $total=$em['status']; ?>
                                              <h4 style="color:#252b2b;"> <b> TOTAL : </b>
                                                <label class="pull-right">
                                                   <b><?php echo $total; ?></b>
                                                </label>
                                              </h4>
                                          </div>
                                        </div>
                                    </div>

                              </div>
                            </div>

                           </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">
                    <div id="tabsDemo3Content" class="tab-content tabs-content-v2">
                      <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo3-area1" aria-labelledby="tabs-demo3-area1">
                        <div class="panel box-v7">
                          <div class="panel-body">
                            <form action="#" method="get" onsubmit="return filters()" id="defaultForm_search">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-5">
                                    <h5>EVENT NAME</h5>
                                    <div class="form-group has-feedback">
                                      <input type="text" list="suggestion" class="form-control" name="event_name" id="event_name"/>
                                      <?php
                                      $query_em_list=$database->query("SELECT * FROM alumni_info_view AS a INNER JOIN program_list AS b INNER JOIN student_info as c INNER JOIN alumni_info as d where a.program_id = b.program_id AND a.stud_no  = c.stud_no AND c.acad_year_start = '$acad_year_start' AND c.semester = '$semester' AND c.program_id = '$program_id_get'");
                                      print'<datalist id="suggestion">';
                                      foreach($query_em_list  AS $qemDAta){
                                        $event_id = $qemDAta["event_id"];
                                        $event_name = $qemDAta["event_name"];

                                        echo "<option data-value='".$event_id."'>".$event_name."</option>";
                                      }
                                      ?>
                                          <input type="hidden" name="event_name-hidden" id="event_name-hidden"/>
                                          <script>
                                          document.querySelector('input[list]').addEventListener('input', function(e) {
                                            var input = e.target,
                                            list = input.getAttribute('list'),
                                            options = document.querySelectorAll('#' + list + ' option'),
                                            hiddenInput = document.getElementById(input.id + '-hidden'),
                                            inputValue = input.value;
                                            hiddenInput.value = inputValue;
                                            for(var i = 0; i < options.length; i++) {
                                              var option = options[i];
                                              if(option.innerText === inputValue) {
                                                hiddenInput.value = option.getAttribute('data-value');
                                                break;
                                              }
                                            }
                                          });
                                        </script>
                                      <?php
                                      print '</datalist>';
                                      ?>
                                    </div>
                                  </div>
                                 
                        
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div><!-- panel -->
                </div><!-- col-md-12 -->
              </div><!-- col-md-12 padding-0 -->
            </div><!-- end content -->
          </div><!-- container-fluid mimin-wrapper -->
           <!-- START: RIGHT MENU-->
          <?php
            require ("chat.php");
          ?>
      <!-- END: RIGHT MENU-->
      </div>
      <!-- start: Mobile -->
    
    
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



 var event_name = document.getElementById('event_name').value;

function get_value_ays(){
          var selected_acad_year_start = document.getElementById("acad_year_start").value;
          var x = 1;
          var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
           document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
            document.getElementById("acad_year_end_value").value =  acad_year_end;
 }


function filters() {
        var semester = document.getElementById('semester').value;
         var acad_year_start = document.getElementById("acad_year_start").value;
         var program_id = document.getElementById('program_id').value;
         
         
         
         var event_name = document.getElementById('event_name').value + " Attendance";
         var batch_id = document.getElementById('batch_id').value;
          var event_id_hidden = document.getElementById('event_name-hidden').value;
          //alert("batch id="+batch_id+"program_id="+program_id+"event_id="+event_id_hidden);
            $('#datatables2').dataTable().fnDestroy();
             var table = $('#datatables2').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [[ 1, "asc" ]],
                "ajax": "e2e_reports_search_processing.php?semester="+semester+"&acad_year_start="+acad_year_start+"&program_id="+program_id+"&batch_id="+batch_id+"&event_id="+event_id_hidden,
                lengthMenu: [[10, 50, -1], [10, 50, "All"]],
                oLanguage: {
                 sProcessing: "<img src='asset/img/table_loader.gif'>"
                },


          });
           return false;
}

$(document).ready(function() {  

          $('#acad_year_start')
                  .datepicker({
                      format: "yyyy",
                      viewMode: "years",
                      minViewMode: "years",
                      autoClose: true
                  }).on('changeDate', function(e) {
                      // Revalidate the start date field
                      $('#defaultForm_search').bootstrapValidator('revalidateField', 'acad_year_start');
                  });


          var tablex = $('#datatables').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
              
                scrollX:        true,
                scrollCollapse: true,
                paging:         true,
                fixedColumns:   {
                    leftColumns: 2
                }
            } );

            var buttons = new $.fn.dataTable.Buttons(tablex, {

               buttons: [
                      {
                          extend: 'excelHtml5',
                          title: 'Report',         
                           text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                           className: 'btn btn-info btn-outline',
                          exportOptions: {
                              columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]
                          }
                      },
                      {
                          extend: 'print',
                          title: 'Graduating ID Card',
                          text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                          className: 'btn btn-info btn-outline',
                          exportOptions: {
                              columns: [1,2,4,5,6,7,8,10]
                          }
                      },
                      {
                          extend: 'pdf',
                          title: 'Graduating ID Card',
                          text: '<i class="glyphicon glyphicon-print"></i> PDF',
                          className: 'btn btn-info btn-outline',
                          exportOptions: {
                              columns: [1,2,4,5,6,7,8,10]
                          }
                      },
                  ]
              }).container().appendTo($('#buttons')); 

              $('#defaultForm_search')
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
                        batch_id: {
                                  validators: {
                                      notEmpty: {
                                          message: 'Batch Number is required and can\'t be empty'
                                      },
                                      stringLength: {
                                      min: 1,
                                      max: 4,
                                      message: 'Batch Number must be more than 1 / less than 3 characters'
                                  }
                                  },
                              },
                        event_name: {
                                  validators: {
                                      notEmpty: {
                                          message: 'Event Name is required and can\'t be empty'
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
                              }
                      }
                  });


  

} );

var grad_no = document.getElementById('grad_no').value;
var notgrad_no = document.getElementById('notgrad_no').value;
var F_grad_no = parseInt(grad_no);
var F_notgrad_no = parseInt(notgrad_no);

var Employed = document.getElementById('Employed').value;
// var q_Unemployed = document.getElementById('q_Unemployed').value;
//var q_Continuing_Study = document.getElementById('q_Continuing_Study').value;
//var q_Abroad = document.getElementById('q_Abroad').value;
//var q_Self_Employed = document.getElementById('q_Self_Employed').value;
// var q_Under_Graduate = document.getElementById('q_Under_Graduate').value;

var Employed = parseInt(Employed);
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
                    value: Employed,
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
