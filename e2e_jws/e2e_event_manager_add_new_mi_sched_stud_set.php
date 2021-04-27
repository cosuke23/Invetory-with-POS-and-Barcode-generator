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

                      $table = "event_mi_sched";
                      $columns = "*";
                      $where = ["mi_sched_id"=>$_GET['mi_sched_id']];
                      $q_event_info =$database->get($table,$columns,$where);
                      $batch_no = $q_event_info['event_mi_batch_no'];
                      $batch_date = $q_event_info['event_mi_batch_date'];
                      $venue = $q_event_info['venue'];
                      $time_start = $q_event_info['time_start'];
                      $time_start = $q_event_info['time_start'];
                      $time_end = $q_event_info['time_end'];
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
                    <div class="panel-heading"><h3>Mock Interview Scheduler</h3> 
                      <div class="row" style="background-color:#3385ff;margin-right:1px">
                          <div class="col-md-12">
                            <h4 style="color:white;"><b><?php echo $_GET['event_name'];?> Batch <?php echo $batch_no ." - ". date("F d, Y",strtotime($batch_date)) . " (" . date("h:i A",strtotime($time_start));?> - <?php echo date("h:i A",strtotime($time_end)) . ") - Venue: " . $venue;?></b>
                            </h4>                          
                          </div>
                        </div>
                   </div>
                   <div class="panel-heading animated fadeInDown">
                  <h5><b><span class="icon icon-user"></span> SCHEDULED STUDENT(S)</h5></b></div>
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
                                <strong>&nbsp;Successfully Added!</strong> 
                              </div>
                          </div>
                        </div>
                      </div>';
                      }
                      if(isset($_GET['change_status']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Successfully Changed Active Sched!</strong>
                              </div>
                          </div>
                        </div>
                      </div>';
                      } 
                      if(isset($_GET['success_delete']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Successfully Deleted a Sched!</strong>
                              </div>
                          </div>
                        </div>
                      </div>';
                      } 
                      if(isset($_GET['mark_attendance']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Successfully Marked Student Attendance!</strong>
                              </div>
                          </div>
                        </div>
                      </div>';
                      } 
                      if(isset($_GET['success_delete_sched']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Successfully Deleted a Sched!</strong>
                              </div>
                          </div>
                        </div>
                      </div>';
                      } 
                      if(isset($_GET['success_delete_stud']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Successfully Deleted a Student in this Sched!</strong>
                              </div>
                          </div>
                        </div>
                      </div>';
                      } 
                      if(isset($_GET['stud_already_onsched']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Student is already in this Sched!</strong> 
                              </div>
                          </div>
                        </div>
                      </div>';
                      }  
                      if(isset($_GET['stud_already_havesched']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Student already has another scheduled interview!</strong> 
                              </div>
                          </div>
                        </div>
                      </div>';
                      }  
                      if(isset($_GET['stud_inserted_onsched']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Student is successfully inserted in this Sched!</strong> 
                              </div>
                          </div>
                        </div>
                      </div>';
                      }                              
                      ?>                    
                      <!-- <div class="row" style="margin:1px;">                                                
                        <div class="col-md-4"><a href='e2e_event_manager_add_stud_to_sched.php?mi_sched_id=<?php //echo $_GET['mi_sched_id'];?>&&event_id=<?php //echo $_GET['event_id'];?>&&event_name=<?php //echo $_GET['event_name'];?>'>
                        <button type="submit" class="btn btn-success btn-block" name="btn-add" id="btn-add"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button></a>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">                            
                        </div>
                      </div> -->

                      <div class="row">
                      <div class="col-md-3" style="margin-top:15px;margin-left:15px;margin-bottom:15px;">
                      <?php
                        $table_m = "event_mi_sched";
                        $columns_m = "*";
                        $where_m = ["mi_sched_id" => $_GET['mi_sched_id']];
                        $q_m =$database->get($table_m,$columns_m,$where_m);
                        if($q_m['status']!="Finished"){
                        ?>

                        <button type="submit" class="btn btn-success btn-block" id="btn_toggle_mi"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button>
                        
                        <?php
                        }
                      ?>                                        
                      </div>
                      
                    </div>

                    <div class="mi_form" style="display:none;">


                        <form action="#" method="get" onsubmit="return filters()" id="defaultForm_search">
                          <div class="row" style="margin:5px;">
                            <div class="col-md-3">
                              <h5 style="padding-left:5px;">PROGRAM</h5>
                              <div class="form-group has-feedback">
                              <?php
                                $mi_sched_id = $_GET['mi_sched_id'];
                                $event_id = $_GET['event_id'];
                                $event_name = $_GET['event_name'];
                              ?>

                              <input type="hidden" id="mi_sched_id" name="mi_sched_id" value="<?php echo $mi_sched_id; ?>" />
                              <input type="hidden" id="event_id" name="event_id" value="<?php echo $event_id; ?>" />
                              <input type="hidden" id="event_name" name="event_name" value="<?php echo $event_name; ?>" />                              
                                <?php
                                $table_pl = "program_list";
                                $columns_pl = "*";
                                $where_pl = ["status" => 'Active'];
                                $q_pl =$database->select($table_pl,$columns_pl,$where_pl);
                                
                                print'<select class="form-control" name="program_id" id="program_id">';
                                
                                 echo "<option value='0'>ALL</option>";

                                 foreach($q_pl as $q_pl_data){
                   
                                    $program_id2 = $q_pl_data['program_id'];
                                    $program_code2 = $q_pl_data['program_code'];
                                    $counter = 0;
                                if($counter <= $program_id2)
                                  {
                                    if($program_id2==3)
                                        echo "<option value='".$program_id2."' selected>".$program_code2."</option>";
                                    else
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
                                    <select class="form-control" name="semester" id="semester">
                                      <option value="1st Semester">1st Semester</option>
                                      <option value="2nd Semester" selected>2nd Semester</option>
                                      <option value="Summer">Summer</option>
                                    </select>
                                  </div>
                            </div>
                            <div class="col-md-3">
                                <input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>"/>
                            <input type="hidden" name="next_year" id="next_year" value="<?php echo $next_year; ?>"/>
                                  <h5 style="padding-left:5px;">S.Y. START</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date">
                                          <input type="text" class="form-control" name="acad_year_start" placeholder="(e.g.YYYY)" id="acad_year_start" onchange="get_value_ays()" value="2016" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                              <div class="col-md-3">
                                  <h5>S.Y. END</h5>
                                  <div>
                                   <input type="hidden" id="acad_year_end_value" name="acad_year_end" value="2017" />
                                   <h4 id ="acad_year_start_show">2017</h4>
                                   </div>
                            </div>
                          </div>  
                          <div class="row" style="margin:1px;">
                              
                          <div class="col-md-9"> 
                          
                          
                           SELECT COMPANY ASSIGNMENT
                              <input type="text" list="suggestion" class="form-control" name="nop_comp" id="nop_comp"/>
                              <?php
                              $query_em_list=$database->query("SELECT * FROM company_info AS a INNER JOIN nop_mock_interview AS b ON a.comp_id=b.comp_id INNER JOIN event_manager AS c ON b.event_mi_id=c.event_id WHERE c.type='Mock Interview' AND c.`status`='Active'");
                              print'<datalist id="suggestion">';      
                              foreach($query_em_list  AS $qemDAta){
                                $mi_id = $qemDAta["mi_id"];
                                $comp_name = $qemDAta["comp_name"];

                                echo "<option data-value='".$mi_id."'>".$comp_name."</option>"; 
                              }
                              ?>
                                  <input type="hidden" name="nop_comp-hidden" id="nop_comp-hidden"/>
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


                            <div class="col-md-3" style="padding-top:0px;">
                              <button type="submit" class="btn btn-primary btn-block" name="btn_search" id = "btn_search">
                                <span class="fa fa-search"></span>&nbsp; Search</button>
                             </div>
                          </div>  
                        </form>


                      <div class="responsive-table" style="margin:15px;">
                      <table id="datatables_stud" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th class="col-md-1"></th>
                            <th class="text-center" style="width:150px;">STUDENT NUMBER</th>
                            <th class="text-center">LASTNAME</th>
                            <th class="text-center">FIRSTNAME</th>                            
                            <th class="text-center" style="width:260px;">COURSE</th>
                            <th class="text-center" style="width:260px;">RESUME FILE NAME</th>                            
                            <th class="text-center" style="width:20px;"></th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                      </div>

                      <div class="row" style="background-color:#3385ff;margin:5px;">
                          <div class="col-md-12">
                            <h4 style="color:white;"><b>Scheduled Student(s)</b>
                            </h4>                          
                          </div>
                        </div>


                  <?php
                          $event_id = $_GET['event_id'];
                          $table = "event_mi_sched_stud_set";
                          $columns = "*";
                          $where = ["mi_sched_id"=>$_GET['mi_sched_id']];
                          $q_event_info =$database->select($table,$columns,$where);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="col-md-1"></th>                          
                          <th class="text-center">STUD NO.</th>
                          <th class="text-center">LAST NAME</th>
                          <th class="text-center">FIRST NAME</th>
                          <th class="text-center">COURSE</th>
                          <th class="text-center">COMPANY ASSIGNED INTERVIEWER</th>                            
                          <th class="text-center">INTERVIEW STATUS</th>
                          <th class="text-center" style="width:160px;">ACTION</th>                          
                          </tr>
                          </thead>
                          <tbody>';
                          foreach($q_event_info as $event_data){
                          $mi_sched_stud_set_id = $event_data['mi_sched_stud_set_id'];                          
                          $mi_sched_id = $event_data['mi_sched_id'];
                          $stud_no = $event_data['stud_no'];
                          $status = $event_data['status'];
                          $company_assigned_id = $event_data['company_assigned_id'];

                          $table = "event_mi_sched";
                          $columns = "*";
                          $where = ["mi_sched_id"=>$mi_sched_id];
                          $q_sched_info_curr =$database->get($table,$columns,$where);
                          $sched_status = $q_sched_info_curr['status'];

                          $table = "student_info";
                          $columns = "*";
                          $where = ["stud_no"=>$stud_no];
                          $q_stud_info =$database->get($table,$columns,$where);
                          $stud_dp = $q_stud_info['stud_dp'];
                          $lname = $q_stud_info['lname'];
                          $fname = $q_stud_info['fname'];
                          
                          $program_id = $q_stud_info['program_id'];

                          $table = "program_list";
                          $columns = "*";
                          $where = ["program_id"=>$program_id];
                          $q_program_info =$database->get($table,$columns,$where);
                          $program_code = $q_program_info['program_code']; 

                          $table = "nop_mock_interview";
                          $columns = "*";
                          $where = ["AND" => [
                                              "mi_id"=>$company_assigned_id,
                                              "event_mi_id"=>$event_id,
                                             ]
                                   ];
                          $q_nop_company_info =$database->get($table,$columns,$where);
                          $comp_id = $q_nop_company_info['comp_id'];  

                          $table = "company_info";
                          $columns = "*";
                          $where = ["comp_id"=>$comp_id];
                          $q_comp_info =$database->get($table,$columns,$where);                         
                          $comp_name = $q_comp_info["comp_name"];
                         
                          print '
                                  <tr>
                                  <td><img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;"></td>

                                  <td>'.  $stud_no .'</td>
                                  <td>'.  $lname .'</td>
                                  <td>'.  $fname .'</td>
                                  <td>'.  $program_code .'</td>
                                  <td>'.  $comp_name .'</td>
                                  <td>'.  $status .'</td>
                                  <td style="width:10%;"> ';

                                  if($sched_status=="On Going"){
                                    if($status=="Set"){
                                      $event_id = $_GET['event_id'];
                                        $event_name = $_GET['event_name'];
                                      print '                          
                                      <a href="e2e_event_stud_set_attendance.php?event_name='.$event_name.'&&event_id='.$event_id.'&&mi_sched_id='.$mi_sched_id.'&&status='.$status.'&&mi_sched_stud_set_id='.$mi_sched_stud_set_id.'" class="btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Mark Attended"><span class="glyphicon glyphicon-info-sign"></span></a>
                                      ';                                      
                                      } elseif($status=="Available"){
                                        print '
                                        <button class="btn btn-outline btn-success" disabled="disabled"><span class="glyphicon glyphicon-check" data-toggle="tooltip" data-placement="top" title="Attendance has been Set"></span></button>                                        
                                        ';
                                      } else{
                                        print '
                                        <button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="ETC."></span></button>                                        
                                        ';
                                      } 
                                  } else{
                                    print '
                                      <button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Schedule is not On Going"></span></button>  
                                    ';

                                  }
                                    
                                    print '
                                    <button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="Disabled Delete Function"></span></button>                                        
                                    
                                    <!-- <a href="e2e_event_manager_delete_mi_sched_stud_set_process.php?mi_sched_stud_set_id='.$mi_sched_stud_set_id.'&&mi_sched_id='.$mi_sched_id.'&&event_id='.$_GET['event_id'].'&&event_name='.$_GET['event_name'].'" class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Sched"><span class="glyphicon glyphicon-trash"></span></a> -->                                         
                          
                          </td>
                          </tr>

                                ';  
                          

                          
                          }
                          print '</tbody>
                          </table>
                          </div>
                          </div>';
                        ?>      
                        
                      <div class="row" style="padding:10px;padding-top:0px">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                          <a href="e2e_event_manager_add_new_mi_sched.php?event_id=<?php echo $_GET['event_id']; ?>&&event_name=<?php echo $_GET['event_name']; ?>"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                        </div>
                      </div>                        
                    </div>
                    
                    
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
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script src="asset/js/jquery.confirm.min.js"></script>
<script src="asset/js/jquery.confirm.js"></script>
<script src="asset/js/sweetalert-dev.js"></script>
<!-- custom -->
<script src="asset/js/main.js">  
</script>
<script type="text/javascript">
  function filters() {
var semester = document.getElementById('semester').value;
 var acad_year_start = document.getElementById("acad_year_start").value;
 var program_id = document.getElementById('program_id').value;
 var event_name = document.getElementById('event_name').value;
 var event_id = document.getElementById('event_id').value;
 var mi_sched_id = document.getElementById('mi_sched_id').value;

 var nop_comp = document.getElementById('nop_comp-hidden').value;

  // alert("nop_comp="+nop_comp);
    $('#datatables_stud').dataTable().fnDestroy();
     var table = $('#datatables_stud').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 1, "asc" ]],
        "ajax": "e2e_event_manager_stud_mi_search_processing.php?mi_sched_id="+mi_sched_id+"&event_id="+event_id+"&event_name="+event_name+"&semester="+semester+"&acad_year_start="+acad_year_start+"&program_id="+program_id+"&nop_comp="+nop_comp,
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        }

  });

     return false;
  }

  $(document).ready(function(){
 var table = $('#datatables').DataTable();

 $('#datatables_stud').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": "e2e_event_manager_add_stud_to_sched_processing.php?mi_sched_id=<?php echo $_GET['mi_sched_id'];?>&event_id=<?php echo $_GET['event_id'];?>&event_name=<?php echo $_GET['event_name'];?>",
          lengthMenu: [[10, 50, -1], [10, 50, "All"]],

        });

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

// var table = $('#datatables').DataTable();

// $('#datatables').DataTable({
//         "processing": true,
//         "serverSide": true,
//         "order": [[ 2, "asc" ]],
//         "ajax": "e2e_add_new_mi_sched_stud_set_processing.php",
//         lengthMenu: [[10, 50, -1], [10, 50, "All"]],
//         oLanguage: {
//          sProcessing: "<img src='asset/img/table_loader.gif'>"
//         },

//   });

  $("#btn_toggle_mi").click(function(){
    $(".mi_form").toggle();
  });

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
                nop_comp: {
                    validators: {
                        notEmpty: {
                            message: 'Company Mock Interview Partner is required and can\'t be empty'
                        },
                    },
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
