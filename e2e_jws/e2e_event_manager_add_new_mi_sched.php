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
                    <div class="panel-heading"><h3>Mock Interview Scheduler (<?php echo $_GET['event_name'];?>)</h3></div>
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
                                <strong>&nbsp;Successfully Changed On Going Sched!</strong> 
                              </div>
                          </div>
                        </div>
                      </div>';
                      } 
                      if(isset($_GET['change_status_fin']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Successfully Finished a Schedule!</strong> 
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
                      if(isset($_GET['success_update']))
                        {
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Successfully Updated a Sched!</strong>
                              </div>
                          </div>
                        </div>
                      </div>';
                      } 
                      ?>
                    <div class="row">
                      <div class="col-md-3" style="margin-top:15px;margin-left:15px;margin-bottom:15px;">
                        <button type="submit" class="btn btn-success btn-block" id="btn_toggle_mi"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button>
                      </div>
                    </div>

                    <div class="mi_form" style="display:none;">
                      <form id="defaultForm" method="post" action="e2e_event_manager_add_new_mi_sched_process.php"  enctype="multipart/form-data">                    
                      <div class="panel-body" style="padding-bottom:30px;">
                         <input name="event_id" type="hidden" value ="<?php echo $_GET['event_id'] ?>"/>
                         <input name="event_name" type="hidden" value ="<?php echo $_GET['event_name'] ?>"/>

                      <div class="row">
                      <div class="col-md-5">
                          <h5 style="padding-left:5px;">BATCH NO</h5>
                          <div class="form-group has-feedback">
                                   <?php
                                    $table = "event_manager";
                                    $columns = "*";
                                    $where = ["event_id"=>$_GET['event_id']];
                                    $q_ev_info =$database->get($table,$columns,$where);
                                    $no_of_batch = $q_ev_info['batch_no'];                                   
                                    $venue = $q_ev_info['venue'];  
                                  ?>
                   <select class="form-control" name="batch_no" id="batch_no" class="form-control" placeholder="">
                                    <option></option>
                                    <?php
                                      $intX = 1;
                                      while($intX <= $no_of_batch){
                                        echo "<option value=".$intX.">".$intX."</option>";
                                        $intX++;
                                      }
                                    ?>
                                    </select>
                              </div>
                        </div>

                        <div class="col-md-7">
                            <h5 style="padding-left:5px;">VENUE</h5>
                              <div class="form-group has-feedback">
                               <input type="text" name="venue" id="venue" class="form-control" placeholder="Venue" value="<?php echo $venue ?>"/>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">                                                
                          <h5 style="padding-left:5px;">BATCH DATE</h5>
                          <div class="form-group">
                            <div class="dateContainer">
                              <div class="input-group input-append date" id="batch_date">
                                <input type="text" class="form-control" name="batch_date" placeholder="(e.g.mm/dd/YYYY)" value="" maxlength="30"/>
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </div>
                          </div>                        
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">TIME START</h5>
                          <div class="form-group has-feedback">
                            <select class="form-control" name="time_start" class="form-control" placeholder="">
                              <option></option>
                              <option value="5:00 AM">5:00 AM</option>
                              <option value="5:30 AM">5:30 AM</option>
                              <option value="6:00 AM">6:00 AM</option>
                              <option value="6:30 AM">6:30 AM</option>
                              <option value="7:00 AM">7:00 AM</option>
                              <option value="7:30 AM">7:30 AM</option>                              
                              <option value="8:00 AM">8:00 AM</option>
                              <option value="8:30 AM">8:30 AM</option>
                              <option value="9:00 AM">9:00 AM</option>
                              <option value="9:30 AM">9:30 AM</option>
                              <option value="10:00 AM">10:00 AM</option>
                              <option value="10:30 AM">10:30 AM</option>
                              <option value="11:00 AM">11:00 AM</option>
                              <option value="11:30 AM">11:30 AM</option>
                              <option value="12:00 PM">12:00 PM</option>
                              <option value="12:30 PM">12:30 PM</option>
                              <option value="1:00 PM">1:00 PM</option>
                              <option value="1:30 PM">1:30 PM</option>
                              <option value="2:00 PM">2:00 PM</option>
                              <option value="2:30 PM">2:30 PM</option>
                              <option value="3:00 PM">3:00 PM</option>
                              <option value="3:30 PM">3:30 PM</option>
                              <option value="4:00 PM">4:00 PM</option>
                              <option value="4:30 PM">4:30 PM</option>
                              <option value="5:00 PM">5:00 PM</option>
                              <option value="5:30 PM">5:30 PM</option>
                              <option value="6:00 PM">6:00 PM</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">TIME END</h5>
                          <div class="form-group has-feedback">
                            <select class="form-control" name="time_end" class="form-control" placeholder="">
                              <option></option>
                              <option value="5:00 AM">5:00 AM</option>
                              <option value="5:30 AM">5:30 AM</option>
                              <option value="6:00 AM">6:00 AM</option>
                              <option value="6:30 AM">6:30 AM</option>
                              <option value="7:00 AM">7:00 AM</option>
                              <option value="7:30 AM">7:30 AM</option>                              
                              <option value="8:00 AM">8:00 AM</option>
                              <option value="8:30 AM">8:30 AM</option>
                              <option value="9:00 AM">9:00 AM</option>
                              <option value="9:30 AM">9:30 AM</option>
                              <option value="10:00 AM">10:00 AM</option>
                              <option value="10:30 AM">10:30 AM</option>
                              <option value="11:00 AM">11:00 AM</option>
                              <option value="11:30 AM">11:30 AM</option>
                              <option value="12:00 PM">12:00 PM</option>
                              <option value="12:30 PM">12:30 PM</option>
                              <option value="1:00 PM">1:00 PM</option>
                              <option value="1:30 PM">1:30 PM</option>
                              <option value="2:00 PM">2:00 PM</option>
                              <option value="2:30 PM">2:30 PM</option>
                              <option value="3:00 PM">3:00 PM</option>
                              <option value="3:30 PM">3:30 PM</option>
                              <option value="4:00 PM">4:00 PM</option>
                              <option value="4:30 PM">4:30 PM</option>
                              <option value="5:00 PM">5:00 PM</option>
                              <option value="5:30 PM">5:30 PM</option>
                              <option value="6:00 PM">6:00 PM</option>
                            </select>
                          </div>
                        </div>                        
                      </div>

                      <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-success btn-block" name="btn-add" id="btn-add"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button>
                        </div>                        
                      </div>
                </div>
              </div>
              </form>
               

                <?php
                          $table = "event_mi_sched";
                          $columns = "*";
                          $where = ["event_id"=>$_GET['event_id']];
                          $q_event_info =$database->select($table,$columns,$where);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>                                                  

                          <th class="text-center">BATCH NO.</th>
                          <th class="text-center">BATCH DATE</th>                          

                          <th class="text-center">START TIME</th>
                          <th class="text-center">END TIME</th>

                          <th class="text-center">VENUE</th>

                          <th class="text-center">STATUS</th>
                          <th class="text-center" style="width:160px;">ACTION</th>                          
                          </tr>
                          </thead>
                          <tbody>';
                          foreach($q_event_info as $event_data){
                          $mi_sched_id = $event_data['mi_sched_id'];                          
                          $event_id = $event_data['event_id'];
                          $event_mi_batch_no = $event_data['event_mi_batch_no'];
                          $event_mi_batch_date = $event_data['event_mi_batch_date'];
                          $time_start = $event_data['time_start'];
                          $time_end = $event_data['time_end'];
                          $venue = $event_data['venue'];
                          $status = $event_data['status'];                          
                          ?>                                              
                          <tr>                          
                          <td><?php echo $event_mi_batch_no; ?></td>
                          <td><?php echo date("F d, Y",strtotime($event_mi_batch_date)); ?></td>
                          <td><?php echo date("h:i A", strtotime($time_start)); ?></td>
                          <td><?php echo date("h:i A", strtotime($time_end)); ?></td>
                          <td><?php echo $venue; ?></td>
                          <td><?php echo $status; ?></td>
                          <td style="width:22%;"> 
                          <a href="e2e_event_manager_update_mi_sched.php?mi_sched_id=<?php echo $mi_sched_id; ?>&&event_id=<?php echo $_GET['event_id']; ?>&&event_name=<?php echo $_GET['event_name']; ?>" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Update Info"><span class="glyphicon glyphicon-pencil"></span></a>

                          <button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="Disabled Delete Function"></span></button>     

                          <!-- <a href="e2e_event_delete_mi_sched_process.php?mi_sched_id=<?php //echo $mi_sched_id; ?>&&event_id=<?php //echo $_GET['event_id']; ?>&&event_name=<?php //echo $_GET['event_name']; ?>" class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Sched"><span class="glyphicon glyphicon-trash"></span></a>   -->                                        

                          <?php
                          $event_id = $_GET['event_id'];
                            $event_name = $_GET['event_name'];
                          if($status=="On Going"){
                          print '<a href="e2e_event_change_status_mi.php?event_name='.$event_name.'&&event_id='.$event_id.'&&mi_sched_id='.$mi_sched_id.'&&status='.$status.'" class="btn btn-outline btn-warning" data-toggle="tooltip" data-placement="top" title="On Going"><span class="glyphicon glyphicon-info-sign"></span></a>                                        
                          ';
                          } elseif($status=="Finished"){
                            print '
                            <button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Sched already Finished"></span></button>                                        
                            ';
                          } else{
                            
                          print '                          
                          <a href="e2e_event_change_status_mi.php?event_name='.$event_name.'&&event_id='.$event_id.'&&mi_sched_id='.$mi_sched_id.'&&status='.$status.'" class="btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Change Ongoing Sched"><span class="glyphicon glyphicon-info-sign"></span></a>
                          ';
                          }
                          ?>                                
                          <a href="e2e_event_manager_add_new_mi_sched_stud_set.php?mi_sched_id=<?php echo $mi_sched_id; ?>&&event_id=<?php echo $_GET['event_id']; ?>&&event_name=<?php echo $_GET['event_name']; ?>" class=" btn btn-outline btn-success" data-toggle="tooltip" data-placement="top" title="Scheduled Student(s)"><span class="glyphicon fa fa-user"></span></a>


                          <?php
                          if($status=="On Going"){
                          print '
                          <button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-check" data-toggle="tooltip" data-placement="top" title="Set as Finished"></span></button>                                        
                          ';
                          } elseif($status=="Finished"){
                            print '
                            <button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-check" data-toggle="tooltip" data-placement="top" title="Sched already Finished"></span></button>                                        
                            ';
                          } else{
                            $event_id = $_GET['event_id'];
                            $event_name = $_GET['event_name'];
                          print '                          
                          <a href="e2e_event_change_status_mi_finished.php?event_name='.$event_name.'&&event_id='.$event_id.'&&mi_sched_id='.$mi_sched_id.'&&status='.$status.'" class="btn btn-outline btn-warning" data-toggle="tooltip" data-placement="top" title="Set as Finished"><span class="glyphicon glyphicon-check"></span></a>
                          ';
                          }
                          ?>



                          </td>
                          </tr>
                          <?php
                          }
                          print '</tbody>
                          </table>
                          </div>
                          </div>';
                        ?>      
                        <div class="row" style="padding:10px;padding-top:0px">
                          <div class="col-md-8"></div>
                          <div class="col-md-4">
                            <a href="e2e_event_manager.php"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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
<script src="asset/js/sweetalert-dev.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
 var table = $('#datatables').DataTable();

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

var table = $('#datatables').DataTable();

  $("#btn_toggle_mi").click(function(){
    $(".mi_form").toggle();
  });

  $('#batch_date')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'batch_date');
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
                batch_date: {
                    validators: {
                        notEmpty: {
                            message: 'Batch Date is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9 /]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                time_start: {
                    validators: {
                        notEmpty: {
                            message: 'Start Time is required and can\'t be empty'
                        }
                    }
                },
                time_end: {
                    validators: {
                        notEmpty: {
                            message: 'End Time is required and can\'t be empty'
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
