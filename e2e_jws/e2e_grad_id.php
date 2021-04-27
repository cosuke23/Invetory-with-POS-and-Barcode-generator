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
		    $sender_user = $q_user_info_data["username"];

         $decoded_img_profile = base64_decode($profileData);
         $f = finfo_open(); 
         $img_type_profile = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);

         $decoded_img_cover = base64_decode($coverData);
         $f = finfo_open(); 
         $img_type_cover = finfo_buffer($f, $decoded_img_cover, FILEINFO_MIME_TYPE);

    } 
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
                        <label><a href="e2e_reports.php">
                          <i class="glyphicon fa fa-thumbs-o-up"></i>Reports</a>
                        </label><br>
                        <label  class="active"><a href="e2e_grad_id.php">
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
                        <h1 class="animated fadeInLeft">GRADUATING ID CARD</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                           View and manage the students records.
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>GENERATE GRADUATING ID CARD</h3></div>
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                         <?php
                         if(isset($_GET['error_id']) && isset($_GET['stud_no'])) 
                            {   
                              $stud_no_csn = $_GET['stud_no'];
                             echo '<script language = javascript>
                             swal({
                                title: "Error!",
                                 html: true,
                                text: " <strong>This Student Number : '. $stud_no_csn.' does not exist <br> or not yet registered!</strong> ",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_grad_id.php";
                                }
                              });
                          </script>';
                            }
                            elseif(isset($_GET['error_id_dp']) && isset($_GET['stud_no'])) 
                            {   
                              $stud_no_csn = $_GET['stud_no'];
                             echo '<script language = javascript>
                             swal({
                                title: "Error!",
                                 html: true,
                                text: " <strong>This Student Number : '. $stud_no_csn.'! error in picture</strong> ",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_grad_id.php";
                                }
                              });
                          </script>';
                            }
                          elseif(isset($_GET['error_id2'])) 
                            {   
                             
                             echo '<script language = javascript>
                             swal({
                                title: "Error!",
                                 html: true,
                                text: " <strong>The Student Number(s) does not exist or <br> not yet registred!</strong> ",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_grad_id.php";
                                }
                              });
                          </script>';
                            }
                            elseif(isset($_GET['claimed'])) 
                            {   
                             
                             echo '<script language = javascript>
                             swal({
                                title: "Success!",
                                 html: true,
                                text: " <strong>Graduating ID was successfully claimed!</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_grad_id.php";
                                }
                              });
                          </script>';
                            } 
                            elseif(isset($_GET['error_id3'])) 
                            {   
                             
                             echo '<script language = javascript>
                             swal({
                                title: "Error!",
                                 html: true,
                                text: " <strong>Sorry., You can only generate (1) graduating ID card to 1 student at a time!</strong> ",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_grad_id.php";
                                }
                              });
                          </script>';
                            } 
                            elseif(isset($_GET['error_id4'])) 
                            {   
                             
                             echo '<script language = javascript>
                             swal({
                                title: "Error!",
                                 html: true,
                                text: " <strong>Sorry,Unable to generate graduating ID!</strong> ",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_grad_id.php";
                                }
                              });
                          </script>';
                            } 
                            ?>
                    <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation">
                        <a href="#tab_sa1" id="tabs_sa1" role="tab" data-toggle="tab" aria-expanded="false">
                          <span class="fa fa-credit-card"></span> GENERATE Graduating ID 
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#tab_sa2" id="tabs_sa2" role="tab" data-toggle="tab" aria-expanded="false">
                           <span class="fa fa-credit-card"></span> GENERATE Two (2) Graduating ID'
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#tab_sa3" id="tabs_sa3" role="tab" data-toggle="tab" aria-expanded="false">
                           <span class="fa fa-credit-card"></span> GENERATE Graduating ID(BATCH)'
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#tab_sa4" id="tabs_sa4" role="tab" data-toggle="tab" aria-expanded="false">
                           <span class="fa fa-credit-card"></span> GENERATE Graduating (BACK) ID'
                        </a>
                      </li>
                    </ul>
                    <div id="tabsDemo4Content" class="tab-content tab-content-v4">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_sa1" aria-labelledby="tab_sa1">
                    <div class="panel-body">
                      <form action="grad_id/grad_data/generate_grad_id.php" method="post" id="defaultForm1">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="col-md-2">
                           <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                          </div>
                          <div class="col-md-3">
                               <div class="form-group has-feedback">
                                <input type="text" name="stud_no" id="stud_no" class="form-control" maxlength="11"
                                placeholder="Type student Number..."/>
                               </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_gen_data" id="btn_gen_data">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;GENERATE ID
                                 </button>
                             </div>
                          </div>
                        </div>
                    </form>
                    </div><!--end of panel body2-->
                  </div><!--end of tab2-->
                  <div role="tabpanel" class="tab-pane fade" id="tab_sa2" aria-labelledby="tab_sa2">
                    <div class="panel-body">
                    <form action="grad_id/grad_data/generate_grad_id2.php" method="POST" id="defaultForm2">
                      <div class="row">
                        <div class="col-md-12">
                        <div class="col-md-2">
                           <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                          </div>
                          <div class="col-md-3">
                               <div class="form-group has-feedback">
                                <input type="text" name="stud_no11" id="stud_no11" class="form-control" maxlength="11"
                                placeholder="Type student Number..."/>
                               </div>
                          </div>
                          <div class="col-md-2">
                           <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                          </div>
                          <div class="col-md-3">
                               <div class="form-group has-feedback">
                                <input type="text" name="stud_no22" id="stud_no22" class="form-control" maxlength="11"
                                placeholder="Type student Number..."/>
                               </div>
                          </div>
                        </div>
                      </div>
                     
                      <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_gen_data2" id="btn_gen_data">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;GENERATE ID
                                 </button>
                             </div>
                          </div>
                        </div>
                    </form>
                    </div><!--end of panel body2-->
                  </div><!--end of tab2-->
                   
                   <div role="tabpanel" class="tab-pane fade" id="tab_sa3" aria-labelledby="tab_sa3">
                    <div class="panel-body">
                    <form action="grad_id/grad_data/generate_grad_id_all.php" method="POST" id="defaultForm_YsANDSem">
                    <div classs="row">
                      <div class="col-md-12">
                        <div class="col-md-3">
                          <h5 style="padding-left:5px;">SEMESTER</h5>
                          <div class="form-group has-feedback">
                          <select class="form-control" name="semester" id="semester">
                            <option value=""></option>
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                            <option value="Summer">Summer</option>
                          </select>
                          </div>
                        </div>
                       <div class="col-md-3">
                             <input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>"/>
                            <input type="hidden" name="next_year" id="next_year" value="<?php echo $next_year; ?>"/>
                                  <h5 style="padding-left:5px;">ACADEMIC YEAR START</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date">
                                          <input type="text" class="form-control" name="acad_year_start" placeholder="(e.g.YYYY)" id="acad_year_start" onchange="get_value_ays()" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                             <div class="col-md-3">
                                <h5 style="padding-left:5px;">ACADEMIC YEAR END</h5>
                                  <div>
                                   <input type="hidden" id="acad_year_end_value" name="acad_year_end" />
                                   <h4 id ="acad_year_start_show"></h4>
                                   </div>
                             </div>
                             <br>
                             <div class="col-md-3">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  
                                  name="btn_gen_data_all" id="btn_gen_data_all">
                                  <span class="fa fa-credit-card"></span> &nbsp;GENERATE ID
                                 </button>
                             </div>
                      </div>
                    </div>
                    </form>
                    </div><!--end of panel body3-->
                  </div><!--end of tab3-->

                   <div role="tabpanel" class="tab-pane fade" id="tab_sa4" aria-labelledby="tab_sa4">
                    <div class="panel-body">
                    <form action="grad_id/grad_data/generate_grad_back.php" method="POST" id="defaultForm3">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="col-md-2">
                           <h5 style="padding-left:5px;">BACK(COVER)</h5>
                          </div>
                          <div class="col-md-3">
                               <div class="form-group has-feedback">
                                <input type="text" name="back_cover" id="back_cover" class="form-control" maxlength="3"
                                placeholder="Type here ..."/>
                               </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_gen_back" id="btn_gen_back">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;GENERATE (BACK) ID
                                 </button>
                             </div>
                          </div>
                        </div>
                    </form>
                    </div><!--end of panel body3-->
                  </div><!--end of tab3-->
                  </div><!--end of main div of tab-->
                 </div>
              </div>
              </div>
               <!--start of check grad id table-->
                <div class="panel box-shadow-none content-header">
                  
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>CHECK GRADUATING ID CARD</h3></div>
                    <div class="panel-body">
                    <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                           
                              <form action="#" method="get" onsubmit="return filters()" id="defaultForm_YsANDSem1">
                                  <div class="col-md-2">
                                  <h5 style="padding-left:5px;">PROGRAM</h5>
                                  <div class="form-group has-feedback">
                                      <?php
                                      $table_pl = "program_list";
                                      $columns_pl = "*";
                                      $where_pl = ["status" => 'Active'];
                                      $q_pl =$database->select($table_pl,$columns_pl,$where_pl);
                                      
                                      print'<select class="form-control"  name="program_id1" id="program_id1" class="form-control">';
                                      
                                       echo "<option value='0'>ALL</option>";

                                       foreach($q_pl as $q_pl_data){
                         
                                          $program_id2 = $q_pl_data['program_id'];
                                          $program_code2 = $q_pl_data['program_code'];
                                          $counter = 0;
                                      if($counter <= $program_id2)
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
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">SEMESTER</h5>
                                    <div class="form-group has-feedback">
                                    <select class="form-control" name="semester1" id="semester1">
                                      <option value="1st Semester">1st Semester</option>
                                      <option value="2nd Semester">2nd Semester</option>
                                      <option value="Summer">Summer</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2">
                             <input type="hidden" name="current_year1" id="current_year1" value="<?php echo $current_year; ?>"/>
                            <input type="hidden" name="next_year1" id="next_year1" value="<?php echo $next_year; ?>"/>
                                  <h5 style="padding-left:5px;">S.Y. START</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date">
                                          <input type="text" class="form-control" name="acad_year_start1" placeholder="(e.g.YYYY)" id="acad_year_start1" onchange="get_value_ays1()" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                             <div class="col-md-2">
                                <h5>S.Y. END</h5>
                                  <div>
                                   <input type="hidden" id="acad_year_end_value1" name="acad_year_end1" />
                                   <h4 id ="acad_year_start_show1"></h4>
                                   </div>
                             </div>
                             <div class="col-md-3" style="padding-top:30px;">
                              <button type="submit" class="btn btn-primary btn-block" name="btn_search" id = "btn_search">
                                <span class="fa fa-search"></span>&nbsp; Search</button>
                             </div>
                          </form>
                          </div>
                        </div> 
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-8">
                          </div>
                            <div class="col-md-4">
                              <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                        </div> 
                        </div>
                        <br>
                      <div class="responsive-table">
                      <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                        <th class="col-md-1"></th>
                         <th class="text-center" style="width:140px;">STUDENT NUMBER</th>
                          <th class="text-center">LASTNAME</th>
                          <th class="text-center">FIRSTNAME</th>
                          <th class="text-center">MIDDLENAME</th>
                          <th class="text-center">PROGRAM</th>
                          <th class="text-center">SEMESTER</th>
                          <th class="text-center">SY START</th>
                          <th class="text-center">SY END</th>   
                          <th class="text-center"># PRINT</th> 
                          <th class="text-center">REMARKS</th>
                          <th class="text-center" style="width:50px;"></th>
                        </tr>
                      </thead>
                     </table>
                     </div>
                     </div>
                  </div>
                 </div>
                </div>
                 <!--end of check grad id table-->
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
<!-- end: Javascript -->
<script>
 function get_value_ays1(){
var selected_acad_year_start1 = document.getElementById("acad_year_start1").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start1) + parseInt(x);
 document.getElementById("acad_year_start_show1").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value1").value =  acad_year_end;
 }
 
  function filters() {
    var semester1 = document.getElementById('semester1').value;
 var acad_year_start1 = document.getElementById("acad_year_start1").value;
 var program_id1 = document.getElementById('program_id1').value;
    $('#datatables').dataTable().fnDestroy();
     var table = $('#datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 2, "asc" ]],
        "ajax": "e2e_student_grad_id_search_proccessing.php?semester1="+semester1+"&acad_year_start1="+acad_year_start1+"&program_id1="+program_id1,
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],

  });
    
 var buttons = new $.fn.dataTable.Buttons(table, {

     buttons: [
            {
                extend: 'excelHtml5',
                title: 'Graduating ID Card',         
                 text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                 className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,2,4,5,6,7,8,10]
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
   return false;
}
function get_value_ays(){
var selected_acad_year_start = document.getElementById("acad_year_start").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
 document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;
 }

$(document).ready(function(){

 $('#acad_year_start')
        .datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm_YsANDSem').bootstrapValidator('revalidateField', 'acad_year_start');
        });
  $('#acad_year_start1')
        .datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm_YsANDSem1').bootstrapValidator('revalidateField', 'acad_year_start1');
        });

  $('#datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 2, "asc" ]],
        "ajax": "e2e_student_grad_id_processing.php",
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },

  });


 var table = $('#datatables').DataTable();
 var buttons = new $.fn.dataTable.Buttons(table, {

     buttons: [
            {
                extend: 'excelHtml5',
                title: 'Graduating ID Card',         
                 text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                 className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,2,4,5,6,7,8,10]
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
 //start of stud 2
$('#defaultForm_YsANDSem')
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
$('#defaultForm_YsANDSem1')
    .bootstrapValidator({
        message: 'This value is invalid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid:'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          semester1: {
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        },
                    },
                },
                acad_year_start1: {
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
              program_id1: {
                    validators: {
                        notEmpty: {
                            message: 'Program Code is required and can\'t be empty'
                        },
                    },
                },
        }
    });
//start of stud 1
$('#defaultForm1')
    .bootstrapValidator({
        message: 'This value is invalid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid:'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            stud_no: {
                validators: {
                    notEmpty: {
                        message: 'Student number is required and can\'t be empty'
                    },
                regexp: {
                        regexp: /[0-9]+$/,
                        message: 'Student number can only consist of numbers'
                    },
        stringLength: {
                        min: 11,
                        max: 11,
                        message: 'Student number must be 11 numbers'
                    }
                }
            },
        }
    });
//start of stud 2
$('#defaultForm2')
    .bootstrapValidator({
        message: 'This value is invalid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid:'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            stud_no11: {
                validators: {
                    notEmpty: {
                        message: 'Student number is required and can\'t be empty'
                    },
                regexp: {
                        regexp: /[0-9]+$/,
                        message: 'Student number can only consist of numbers'
                    },
        stringLength: {
                        min: 11,
                        max: 11,
                        message: 'Student number must be 11 numbers'
                    }
                }
            },
            stud_no22: {
                validators: {
                    notEmpty: {
                        message: 'Student number is required and can\'t be empty'
                    },
                regexp: {
                        regexp: /[0-9]+$/,
                        message: 'Student number can only consist of numbers'
                    },
        stringLength: {
                        min: 11,
                        max: 11,
                        message: 'Student number must be 11 numbers'
                    }
                }
            }
        }
    });
}); 
//start of stud 3
$('#defaultForm3')
    .bootstrapValidator({
        message: 'This value is invalid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid:'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            back_cover: {
                validators: {
                    notEmpty: {
                        message: 'This field is required and can\'t be empty'
                    },
                regexp: {
                        regexp: /[0-9]+$/,
                        message: 'This field can only consist of numbers'
                    },
           stringLength: {
                        min: 1,
                        max: 3,
                        message: 'This field must be greater than 1 and less than 999'
                    },
            greaterThan:{
                value: 1,
                message: 'This fields must be greater than 1 and less than 999'
                    },
                }
            },
        }
    });
</script>
</body>
</html>