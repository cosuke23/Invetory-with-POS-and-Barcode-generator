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
                        <p class="animated fadeInDown" style="padding-left:10px;">
                           View and manage events.
                        </p>                                                        
              
                    <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                        <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-calendar-check-o"></span> SEMINAR</a>
                      </li>
                      <li role="presentation">
                        <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> MOCK INTERVIEW</a>
                      </li>
                      <li role="presentation">
                        <a href="#tab3" id="tabs3" role="tab" data-toggle="tab" aria-expanded="false"><span class="glyphicon glyphicon-briefcase"></span> JOB FAIR</a>
                      </li>                      
                    </ul>  
                      </div><!-- col-md-12 -->
                </div><!-- panel-body -->
              </div><!-- panel box-shadow-none -->                                      
                                

                      <?php
                      if(isset($_GET['delete_event'])&&isset($_GET['event_id'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Deleted Event!",
                            html: true,
                           text: "<strong> Deleted Event with ID: '. $_GET['event_id'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager.php";
                           }
                         });
                     </script>';
                      }

                      if(isset($_GET['error_id4'])) 
                            {   
                             
                             echo '<script language = javascript>
                             swal({
                                title: "Error!",
                                 html: true,
                                text: " <strong>Sorry,Unable to generate certificate!</strong> ",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_event_manager.php";
                                }
                              });
                          </script>';
                            } 


                      if(isset($_GET['delete_cancelled'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Deleted Event Cancelled!",
                            html: true,
                           text: "<strong> Deletion of Event is Cancelled.</strong>",
                           type: "success",
                           showCancelButton: false,
                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager.php";
                           }
                         });
                     </script>';
                      }
                      if(isset($_GET['add_event'])&&isset($_GET['event_name'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Added Event!",
                            html: true,
                           text: "<strong> Added Event Name: '. $_GET['event_name'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager.php";
                           }
                         });
                     </script>';
                      }
                      if(isset($_GET['change_status']) && isset($_GET['event_id']) && isset($_GET['remarks'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully '.$_GET['remarks'].' Event!",
                            html: true,
                           text: "<strong> '.$_GET['remarks'].' Event with ID: '. $_GET['event_id'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager.php";
                           }
                         });
                     </script>';
                      }
                      if(isset($_GET['change_batch'])&&isset($_GET['active_date'])&&isset($_GET['active_batch'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Updated Active Event Date and Batch!",
                            html: true,
                           text: "<strong> Event Date: '. $_GET['active_date'] .' - Batch Active: '. $_GET['active_batch'] .'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager.php";
                           }
                         });
                     </script>';
                      }
                      ?>

                      <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-body">
                      <div class="col-md-12">
                       <div id="tabsDemo4Content" class="tab-content tab-content-v3">                       
                      <!-- SEMINAR Tab -->
                      <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-2">
                              <a href="e2e_event_manager_add_new_event_seminar.php">
                                <button class="btn btn-success btn-outline btn-block btn-sm" style="margin-top:10px;">
                                  <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                </button>
                              </a>
                            </div>
                            <div class="col-md-4" align="center">
                              <?php
                                $table_em  ="event_manager";
                                $columns_em = "*";
                                $where_em = ["status"=>"Active"];
                                $q_em = $database->select($table_em,$columns_em,$where_em);
                                foreach($q_em AS $q_em_data){
                                  $event_id = $q_em_data["event_id"];
                                  $event_name = $q_em_data["event_name"];
                                  $event_start_date = $q_em_data["event_start_date"];
                                  $event_end_date = $q_em_data["event_end_date"];
                                  $event_date = $q_em_data["event_date"];
                                  $batch_active = $q_em_data["batch_active"];
                                  $batch_no = $q_em_data["batch_no"];
                                }    
                                if($q_em==null){
                                  print '<h5><b>ACTIVE EVENT: No Active Event';
                                } else{
                                  print '<h5><b>ACTIVE EVENT: '.$event_name.'';
                                  if($event_start_date==$event_end_date)
                                    print '<h5>EVENT PERIOD: '.$event_start_date.'</b>';
                                  else
                                    print '<h5>EVENT PERIOD: '.$event_start_date.' - '.$event_end_date.'</b>';
                                  function getDatesFromRange($start, $end, $format = 'm/d/Y') {
                                    $array = array();
                                    $interval = new DateInterval('P1D');
                                    $realEnd = new DateTime($end);
                                    $realEnd->add($interval);
                                    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
                                    foreach($period as $date) {
                                      $array[] = $date->format($format);
                                    }
                                    return $array;
                                  }
                                  $dates = getDatesFromRange($event_start_date, $event_end_date);        
                                  $date_no = count($dates);
                                  $option_dates = "";
                                  $intX = 0;
                                  while($intX<$date_no){
                                    if($dates[$intX]==$event_date){
                                      $option_dates .= "<option selected value=".$dates[$intX].">".$dates[$intX]."</option>";
                                    } else{
                                      $option_dates .= "<option value=".$dates[$intX].">".$dates[$intX]."</option>";
                                    }
                                    $intX++;
                                  }
                                  $option_batches = "";
                                  $intX = 1;
                                  while($intX<=$batch_no){
                                    if($intX==$batch_active){
                                      $option_batches .= "<option selected value=".$intX.">".$intX."</option>";
                                    } else{
                                      $option_batches .= "<option value=".$intX.">".$intX."</option>";
                                    }
                                    $intX++;
                                  }
                                }
                              ?>
                            </div>
                            <div class="col-md-6">                            
                              <?php
                                if($q_em!=null){                                  
                                  print '
                                    <form id="defaultForm" method="post" action="e2e_event_change_active_batch.php" enctype="multipart/form-data">
                                      <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2" style="text-align:center; margin-top:-8px;"><h5><b>ACTIVE DATE:</div>
                                        <div class="col-md-3">    
                                          <input type="hidden" value="'.$event_id.'" name="event_id" />
                                          <select class="form-control" name="event_dates" id="event_dates" class="form-control" style="vertical-align: bottom;min-width:120px;">
                                          '.$option_dates.'
                                          </select>
                                        </div>
                                        <div class="col-md-2" style="text-align:center; margin-top:-8px;">ACTIVE BATCH:</div>
                                        <div class="col-md-2">
                                          <select class="form-control" name="event_batches" id="event_batches" class="form-control" style="vertical-align: bottom;">'.$option_batches.'
                                          </select>
                                        </div>
                                        <div class="col-md-3">
                                          <button type="submit" id ="btn_change_event_batch" name="btn_change_event_batch" class="btn btn-primary btn-block" style="height:30px; vertical-align: bottom;margin-top:2px;font-size:11px;">Update Batch
                                          </button>
                                        </div>
                                      </div>
                                    </form>          
                                  ';
                                }
                                print '</b></h5>';
                              ?>                              
                            </div>
                          </div>
                        </div>
                        <?php
                          $table = "event_manager";
                          $columns = "*";
                          $where = ["type"=>"Seminar"];
                          $q_event_info =$database->select($table,$columns,$where);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="col-md-1"></th>
                          <th class="text-center">EVENT CODE</th>
                          <th class="text-center">EVENT NAME</th>
                          <th class="text-center">DATE RANGE</th>
                          <th class="text-center">VENUE</th>
                          <th class="text-center" style="width:160px;">ACTION</th>                          
                          </tr>
                          </thead>
                          <tbody>';
                          foreach($q_event_info as $event_data){
                          $event_id = $event_data['event_id'];
                          $event_code = $event_data['event_code'];
                          $event_name = $event_data['event_name'];
                          $event_start_date = $event_data['event_start_date'];
                          $event_end_date = $event_data['event_end_date'];
                          $event_date_range = "";                          
                          if($event_start_date == $event_end_date){
                          $event_date_range = $event_start_date;
                          } else{
                          $event_date_range = $event_start_date . " - " . $event_end_date;
                          }
                          $venue = $event_data['venue'];
                          $status = $event_data['status'];
                          ?>                                              
                          <tr>
                          <td><?php echo  $event_id; ?></td>
                          <td><?php echo $event_code; ?></td>
                          <td><?php echo $event_name; ?></td>
                          <td><?php echo $event_date_range; ?></td>
                          <td><?php echo $venue; ?></td>
                          <td>
                          <a href="e2e_event_manager_update_event.php?event_id=<?php echo $event_id; ?>" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Update Info"><span class="glyphicon glyphicon-pencil"></span></a>
                          <a href="e2e_event_delete_select.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>" class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Event"><span class="glyphicon glyphicon-trash"></span></a>                                          
                          <?php
                          if($status=="Active"){
                          print '
                          <button class="btn btn-outline btn-warning" disabled="disabled"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Currently Active"></span></button>                                        
                          ';
                          } else{
                          print '                          
                          <a href="e2e_event_change_status.php?event_id='.$event_id.'&&status='.$status.'" class="btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Activate"><span class="glyphicon glyphicon-info-sign"></span></a>
                          ';
                          }
                          ?>                                
                          <a target="_blank" href="grad_id/grad_data/generate_certificate_all.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>" class=" btn btn-outline btn-success" data-toggle="tooltip" data-placement="top" title="Print Certificate"><span class="glyphicon glyphicon-list-alt"></span></a>
                          </td>
                          </tr>
                          <?php
                          }
                          print '</tbody>
                          </table>
                          </div>
                          </div>';
                        ?>
                      </div>

                      <!-- MOCK INTERVIEW Tab -->
                      <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-2">
                              <a href="e2e_event_manager_add_new_event_mock_interview.php">
                                <button class="btn btn-success btn-outline btn-block btn-sm" style="margin-top:10px;">
                                  <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                </button>
                              </a>
                            </div>
                            <div class="col-md-4" align="center">
                              <?php
                                $table_em1  ="event_manager";
                                $columns_em1 = "*";
                                $where_em1 = ["status"=>"Active"];
                                $q_em1 = $database->select($table_em1,$columns_em1,$where_em1);
                                foreach($q_em1 AS $q_em_data1){
                                  $event_id1 = $q_em_data1["event_id"];
                                  $event_name1 = $q_em_data1["event_name"];
                                  $event_start_date1 = $q_em_data1["event_start_date"];
                                  $event_end_date1 = $q_em_data1["event_end_date"];
                                  $event_date1 = $q_em_data1["event_date"];
                                  $batch_active1 = $q_em_data1["batch_active"];
                                  $batch_no1 = $q_em_data1["batch_no"];
                                }    
                                if($q_em1==null){
                                  print '<h5><b>ACTIVE EVENT: No Active Event';
                                } else{
                                  print '<h5><b>ACTIVE EVENT: '.$event_name1.'';
                                  if($event_start_date1==$event_end_date1)
                                    print '<h5>EVENT PERIOD: '.$event_start_date1.'</b>';
                                  else
                                    print '<h5>EVENT PERIOD: '.$event_start_date1.' - '.$event_end_date1.'</b>';
                                  function getDatesFromRange1($start1, $end1, $format1 = 'm/d/Y') {
                                    $array1 = array();
                                    $interval1 = new DateInterval('P1D');
                                    $realEnd1 = new DateTime($end1);
                                    $realEnd1->add($interval1);
                                    $period1 = new DatePeriod(new DateTime($start1), $interval1, $realEnd1);
                                    foreach($period1 as $date1) {
                                      $array1[] = $date1->format($format1);
                                    }
                                    return $array1;
                                  }
                                  $dates1 = getDatesFromRange1($event_start_date1, $event_end_date1);        
                                  $date_no1 = count($dates1);
                                  $option_dates1 = "";
                                  $intX1 = 0;
                                  while($intX1<$date_no1){
                                    if($dates1[$intX1]==$event_date1){
                                      $option_dates1 .= "<option selected value=".$dates1[$intX1].">".$dates1[$intX1]."</option>";
                                    } else{
                                      $option_dates1 .= "<option value=".$dates1[$intX1].">".$dates1[$intX1]."</option>";
                                    }
                                    $intX1++;
                                  }
                                  $option_batches1 = "";
                                  $intX1 = 1;
                                  while($intX1<=$batch_no1){
                                    if($intX1==$batch_active1){
                                      $option_batches1 .= "<option selected value=".$intX1.">".$intX1."</option>";
                                    } else{
                                      $option_batches1 .= "<option value=".$intX1.">".$intX1."</option>";
                                    }
                                    $intX1++;
                                  }
                                }
                              ?>
                            </div>
                            <div class="col-md-6">                            
                              <?php
                                if($q_em1!=null){                                  
                                  print '
                                    <form id="defaultForm" method="post" action="e2e_event_change_active_batch.php" enctype="multipart/form-data">
                                      <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2" style="text-align:center; margin-top:-8px;"><h5><b>ACTIVE DATE:</div>
                                        <div class="col-md-3">    
                                          <input type="hidden" value="'.$event_id1.'" name="event_id" />
                                          <select class="form-control" name="event_dates" id="event_dates" class="form-control" style="vertical-align: bottom;min-width:120px;">
                                          '.$option_dates1.'
                                          </select>
                                        </div>
                                        <div class="col-md-2" style="text-align:center; margin-top:-8px;">ACTIVE BATCH:</div>
                                        <div class="col-md-2">
                                          <select class="form-control" name="event_batches" id="event_batches" class="form-control" style="vertical-align: bottom;">'.$option_batches1.'
                                          </select>
                                        </div>
                                        <div class="col-md-3">
                                          <button type="submit" id ="btn_change_event_batch" name="btn_change_event_batch" class="btn btn-primary btn-block" style="height:30px; vertical-align: bottom;margin-top:2px;font-size:11px;">Update Batch
                                          </button>
                                        </div>
                                      </div>
                                    </form>          
                                  ';
                                }
                                print '</b></h5>';
                              ?>                              
                            </div>
                          </div>
                        </div>
                        <?php
                          $table = "event_manager";
                          $columns = "*";
                          $where = ["type"=>"Mock Interview"];
                          $q_event_info =$database->select($table,$columns,$where);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables1"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="col-md-1"></th>
                          <th class="text-center">EVENT CODE</th>
                          <th class="text-center">EVENT NAME</th>
                          <th class="text-center">DATE RANGE</th>
                          <th class="text-center">VENUE</th>
                          <th class="text-center" style="width:200px;">ACTION</th>                          
                          </tr>
                          </thead>
                          <tbody>';
                          foreach($q_event_info as $event_data){
                          $event_id = $event_data['event_id'];
                          $event_code = $event_data['event_code'];
                          $event_name = $event_data['event_name'];
                          $event_start_date = $event_data['event_start_date'];
                          $event_end_date = $event_data['event_end_date'];
                          $event_date_range = "";
                          if($event_start_date == $event_end_date){
                          $event_date_range = $event_start_date;
                          } else{
                          $event_date_range = $event_start_date . " - " . $event_end_date;
                          }
                          $venue = $event_data['venue'];
                          $status = $event_data['status'];
                          ?>                                              
                          <tr>
                          <td><?php echo  $event_id; ?></td>
                          <td><?php echo $event_code; ?></td>
                          <td><?php echo $event_name; ?></td>
                          <td><?php echo $event_date_range; ?></td>
                          <td><?php echo $venue; ?></td>
                          <td>
                          <a href="e2e_event_manager_update_event.php?event_id=<?php echo $event_id; ?>" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Update Info"><span class="glyphicon glyphicon-pencil"></span></a>
                          <a href="e2e_event_delete_select.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>" class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Event"><span class="glyphicon glyphicon-trash"></span></a>                                          
                          <?php
                          if($status=="Active"){
                          print '
                          <button class="btn btn-outline btn-warning" disabled="disabled"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Currently Active"></span></button>                                        
                          ';
                          } else{
                          print '
                          <a href="e2e_event_activate.php">
                          <a href="e2e_event_change_status.php?event_id='.$event_id.'&&status='.$status.'" class="btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Activate"><span class="glyphicon glyphicon-info-sign"></span></a></a>
                          ';
                          }
                          ?>                                
                          <a href="e2e_event_manager_add_new_mi_sched.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>" class=" btn btn-outline btn-success" data-toggle="tooltip" data-placement="top" title="Manage Sched"><span class="glyphicon glyphicon-list-alt"></span></a>


<!-- BOOKMARK(Currently Updating...) -->
                          <a href="e2e_event_manager_print_mi_sched.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>" class=" btn btn-outline btn-warning" data-toggle="tooltip" data-placement="top" title="Print Mock Interview Schedule"><span class="fa fa-file-excel-o"></span></a>



                          </td>
                          </tr>
                          <?php
                          }
                          print '</tbody>
                          </table>
                          </div>
                          </div>';
                        ?>
                      </div>

                      <!-- JOB FAIR Tab -->
                      <div role="tabpanel" class="tab-pane fade" id="tab3" aria-labelledby="tab3">                      
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-2">
                              <a href="e2e_event_manager_add_new_event_job_fair.php">
                                <button class="btn btn-success btn-outline btn-block btn-sm" style="margin-top:10px;">
                                  <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                </button>
                              </a>
                            </div>
                            <div class="col-md-4" align="center">
                              <?php
                                $table_em2  ="event_manager";
                                $columns_em2 = "*";
                                $where_em2 = ["status"=>"Active"];
                                $q_em2 = $database->select($table_em2,$columns_em2,$where_em2);
                                foreach($q_em2 AS $q_em_data2){
                                  $event_id2 = $q_em_data2["event_id"];
                                  $event_name2 = $q_em_data2["event_name"];
                                  $event_start_date2 = $q_em_data2["event_start_date"];
                                  $event_end_date2 = $q_em_data2["event_end_date"];
                                  $event_date2 = $q_em_data2["event_date"];
                                  $batch_active2 = $q_em_data2["batch_active"];
                                  $batch_no2 = $q_em_data2["batch_no"];
                                }    
                                if($q_em2==null){
                                  print '<h5><b>ACTIVE EVENT: No Active Event';
                                } else{
                                  print '<h5><b>ACTIVE EVENT: '.$event_name2.'';
                                  if($event_start_date2==$event_end_date2)
                                    print '<h5>EVENT PERIOD: '.$event_start_date2.'</b>';
                                  else
                                    print '<h5>EVENT PERIOD: '.$event_start_date2.' - '.$event_end_date2.'</b>';
                                  function getDatesFromRange2($start2, $end2, $format2 = 'm/d/Y') {
                                    $array2 = array();
                                    $interval2 = new DateInterval('P1D');
                                    $realEnd2 = new DateTime($end2);
                                    $realEnd2->add($interval2);
                                    $period2 = new DatePeriod(new DateTime($start2), $interval2, $realEnd2);
                                    foreach($period2 as $date2) {
                                      $array2[] = $date2->format($format2);
                                    }
                                    return $array2;
                                  }
                                  $dates2 = getDatesFromRange2($event_start_date2, $event_end_date2);        
                                  $date_no2 = count($dates2);
                                  $option_dates2 = "";
                                  $intX2 = 0;
                                  while($intX2<$date_no2){
                                    if($dates2[$intX2]==$event_date2){
                                      $option_dates2 .= "<option selected value=".$dates2[$intX2].">".$dates2[$intX2]."</option>";
                                    } else{
                                      $option_dates2 .= "<option value=".$dates2[$intX2].">".$dates2[$intX2]."</option>";
                                    }
                                    $intX2++;
                                  }
                                  $option_batches2 = "";
                                  $intX2 = 1;
                                  while($intX2<=$batch_no2){
                                    if($intX2==$batch_active2){
                                      $option_batches2 .= "<option selected value=".$intX2.">".$intX2."</option>";
                                    } else{
                                      $option_batches2 .= "<option value=".$intX2.">".$intX2."</option>";
                                    }
                                    $intX2++;
                                  }
                                }
                              ?>
                            </div>
                            <div class="col-md-6">                            
                              <?php
                                if($q_em2!=null){                                  
                                  print '
                                    <form id="defaultForm" method="post" action="e2e_event_change_active_batch.php" enctype="multipart/form-data">
                                      <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2" style="text-align:center; margin-top:-8px;"><h5><b>ACTIVE DATE:</div>
                                        <div class="col-md-3">    
                                          <input type="hidden" value="'.$event_id2.'" name="event_id" />
                                          <select class="form-control" name="event_dates" id="event_dates" class="form-control" style="vertical-align: bottom;min-width:120px;">
                                          '.$option_dates2.'
                                          </select>
                                        </div>
                                        <div class="col-md-2" style="text-align:center; margin-top:-8px;">ACTIVE BATCH:</div>
                                        <div class="col-md-2">
                                          <select class="form-control" name="event_batches" id="event_batches" class="form-control" style="vertical-align: bottom;">'.$option_batches2.'
                                          </select>
                                        </div>
                                        <div class="col-md-3">
                                          <button type="submit" id ="btn_change_event_batch" name="btn_change_event_batch" class="btn btn-primary btn-block" style="height:30px; vertical-align: bottom;margin-top:2px;font-size:11px;">Update Batch
                                          </button>
                                        </div>
                                      </div>
                                    </form>          
                                  ';
                                }
                                print '</b></h5>';
                              ?>                              
                            </div>
                          </div>
                        </div>
                        <?php
                          $table = "event_manager";
                          $columns = "*";
                          $where = ["type"=>"Job Fair"];
                          $q_event_info =$database->select($table,$columns,$where);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables2"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="col-md-1"></th>
                          <th class="text-center">EVENT CODE</th>
                          <th class="text-center">EVENT NAME</th>
                          <th class="text-center">DATE RANGE</th>
                          <th class="text-center">VENUE</th>
                          <th class="text-center" style="width:160px;">ACTION</th>                          
                          </tr>
                          </thead>
                          <tbody>';
                          foreach($q_event_info as $event_data){
                          $event_id = $event_data['event_id'];
                          $event_code = $event_data['event_code'];
                          $event_name = $event_data['event_name'];
                          $event_start_date = $event_data['event_start_date'];
                          $event_end_date = $event_data['event_end_date'];
                          $event_date_range = "";
                          if($event_start_date == $event_end_date){
                          $event_date_range = $event_start_date;
                          } else{
                          $event_date_range = $event_start_date . " - " . $event_end_date;
                          }
                          $venue = $event_data['venue'];
                          $status = $event_data['status'];
                          ?>                                              
                          <tr>
                          <td><?php echo  $event_id; ?></td>
                          <td><?php echo $event_code; ?></td>
                          <td><?php echo $event_name; ?></td>
                          <td><?php echo $event_date_range; ?></td>
                          <td><?php echo $venue; ?></td>
                          <td>
                          <a href="e2e_event_manager_update_event.php?event_id=<?php echo $event_id; ?>" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Update Info"><span class="glyphicon glyphicon-pencil"></span></a>
                          <a href="e2e_event_delete_select.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>" class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Event"><span class="glyphicon glyphicon-trash"></span></a>                                          
                          <?php
                          if($status=="Active"){
                          print '
                          <button class="btn btn-outline btn-warning" disabled="disabled"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Currently Active"></span></button>                                        
                          ';
                          } else{
                          print '
                          <a href="e2e_event_activate.php">
                          <a href="e2e_event_change_status.php?event_id='.$event_id.'&&status='.$status.'" class="btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Activate"><span class="glyphicon glyphicon-info-sign"></span></a></a>
                          ';
                          }
                          ?>                                
                          <a href="e2e_event_print_certificate.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>" class=" btn btn-outline btn-success" data-toggle="tooltip" data-placement="top" title="Manage Sched"><span class="glyphicon glyphicon-list-alt"></span></a>
                          </td>
                          </tr>
                          <?php
                          }
                          print '</tbody>
                          </table>
                          </div>
                          </div>';
                        ?>          
                      </div>
                  </div>

                  </div>
                </div>
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

<<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
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
  $(document).ready(function(){
 var js_event_dates = document.getElementById('event_dates');
 var table = $('#datatables').DataTable();
 var table = $('#datatables1').DataTable();
 var table = $('#datatables2').DataTable();
 });
</script>
<!-- end: Javascript -->
</body>
</html>
