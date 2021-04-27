<?php

$page_title = 'OJT AssiSTI';



if(!isset($_COOKIE["uid"])) {
  header ("Location: login.php");
  exit;
}
$username = $_COOKIE["uid"];
$usertype = $_COOKIE["ut"];
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

if($usertype == 1)
{
  $query2 = "SELECT * FROM admin_info WHERE admin_id = '$username'";
  $result2 = mysqli_query($dbc,$query2);
    if(mysqli_num_rows($result2)>0)
        {
          $row2 = mysqli_fetch_assoc($result2);
          $admin_id = $row2["admin_id"];
          $lname = $row2["lname"];
          $fname = $row2["fname"];
          $mname = $row2["mname"];
          $title = $row2["title"];
        }
}
if($usertype != 1)
{
     header("Location: adviser_home.php");
}
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");



 //dapat mging status unread ung expired today


 



$query_resume_pending ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '1'";
$result_resume_pending =  mysqli_query($dbc, $query_resume_pending);         
          if($result_resume_pending->num_rows > 0)
               {   
                while ($row_pending = mysqli_fetch_array($result_resume_pending))
                   {
                     $count_resume_pending = $row_pending[0];      
                    }
              }


 $query_resume_app ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '2'";
$result_resume_app =  mysqli_query($dbc, $query_resume_app);         
          if($result_resume_app->num_rows > 0)
               {   
                while ($row_app_resume = mysqli_fetch_array($result_resume_app))
                   {
                     $count_resume_approved = $row_app_resume[0];      
                    }
              }
$query_resume_rej ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '3'";
$result_resume_rej =  mysqli_query($dbc, $query_resume_rej);         
          if($result_resume_rej->num_rows > 0)
               {   
                while ($row_rej_resume = mysqli_fetch_array($result_resume_rej))
                   {
                     $count_rej_resume = $row_rej_resume[0];      
                    }
              } 
$query_resume_no ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '0'";
$result_resume_no =  mysqli_query($dbc, $query_resume_no);         
          if($result_resume_no->num_rows > 0)
               {   
                while ($row_resume_no = mysqli_fetch_array($result_resume_no))
                   {
                     $count_no_resume = $row_resume_no[0];      
                    }
              }                           


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OJT assiSTI</title>



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

<link rel="shortcut icon" href="asset/img/ojtassistilogo.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    
    <?php
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
    ?>
</head>

<body id="mimin" class="dashboard">
      <!-- start: Header -->
        <nav class="navbar navbar-custom header navbar-fixed-top">
          <div class="col-md-12">
            <div class="navbar-header" style="width:100%;">
              <div class="opener-left-menu is-open">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
              </div>
                <a href="home.php" class="navbar-brand"> 
                 <b>OJT assiSTI</b>
                </a>

              <ul class="nav navbar-nav navbar-right user-nav">
          
                
                  
                  <li class="user-name"><span>&nbsp; Hi' <?php echo  $title." ".$fname ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <br>
                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>

                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="admin_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span> My Account</a></li>
                     <?php
                      $query2 = "SELECT * from user WHERE username = '$username'";
  $result2 = mysqli_query($dbc,$query2);
    if(mysqli_num_rows($result2)>0)
    {
      $row2 = mysqli_fetch_assoc($result2);
      $user = $row2["usertype"];
      if($user==1||$user==3){ ?>
  <li><a href="add_admin_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span> Add Admin</a></li>

    <?php  }

    } ?>
                   
                      <li><a href="logout.php"><span class="fa fa-power-off "> Log Out</span></a></li> 
                  </ul>
                </li>
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
                      <img src="asset/img/ojtassistilogo.png" style="padding-top:10px;margin-left:35px;width:150px;height:150px;" class="animated fadeInLeft">
                    </div>
                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:100px;">
                    <br>
                       <p class="animated fadeInRight" style="color:gray;margin-left:20px;margin-top:60px;">
                               <?php
                                 echo  date("l, F j, Y"); 
                               ?>
                        </p>
                    </div>

                      <div class="nav-side-menu">
                        <label class="active">
                          <a href="home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label>
                          <a href="Company_info.php"><i class="glyphicon glyphicon-globe"></i>Partner Companies</a>
                        </label><br>
                         <label>
                          <a href="ojt_offers_masterlist.php"><i class="fa fa-briefcase"></i>OJT Offers List</a>
                        </label><br>
                        <label>
                          <a href="OJT_adviser.php"><i class="glyphicon glyphicon-user"></i>OJT Advisers</a>
                        </label><br>
                        <label>
                         <a href="Student_information.php"><i class="glyphicon glyphicon-info-sign"></i>OJT Students</a>
                        </label><br>
                         
                         <label>
                           <a href="Manage_course.php"><i class="glyphicon glyphicon-list-alt"></i>Manage Programs</a>
                         </label><br>
                         <label>
                          <a href="ojtsoftcopy.php"><i class=" glyphicon glyphicon-folder-open"></i>OJT Softcopy Files</a>
                         </label><br>
                          <label>
                          <a href="program_category_list.php"><i class="glyphicon glyphicon-th-list"></i>OJT Category List</a>
                          </label><br>
                         <label>
                          <a href="student_deliverables.php"><i class="fa fa-folder"></i>Student Deliverables</a>
                          </label><br> 
                          <label>
                          <a href="upload.php"><i class="fa fa-file-excel-o"></i>Official Students</a>
                          </label><br>
              <label>
                          <a href="update_semester_ay.php"><i class="fa fa-calendar-check-o"></i>Active Semester and Year</a>
                          </label><br>
                      </div>
              </div>
            </div>


              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Company Visited of Student</h4>
                  </div>
                  <div class="modal-body">
                  <?php

 $query_student_pendings ="SELECT stud_no FROM student_checklist  WHERE remarks = 'Completed' and deliverable_id=7 and stud_no='$stud_no' ";
$result_student_pendings =  mysqli_query($dbc, $query_student_pendings);         
          if($result_student_pendings->num_rows > 0)
               {   
                while ($row_pendings = mysqli_fetch_array($result_student_pendings))
                   {
                     $query_student_pending ="SELECT stud_no,date_submitted FROM student_checklist  WHERE remarks = 'Completed' and deliverable_id=5 and stud_no='$stud_no' ";
$result_student_pending =  mysqli_query($dbc, $query_student_pending);
$row_pending = mysqli_fetch_array($result_student_pending);

$day=$row_pending['date_submitted'];

$expi=date('Y-m-d',strtotime($day. '+ 14 days'));
 }         

                    $query_studList = "
                    SELECT si.lname,si.fname,si.mname,sc.remarks,sc.deliverable_id,sc.date_submitted
                    FROM student_info AS si 
                    left JOIN student_checklist as sc on sc.stud_no = si.stud_no
                    left JOIN student_deliverables as sd on sc.deliverable_id = sd.deliverable_id
                    WHERE si.stud_no='$stud_no' ";
                    $result_studList = mysqli_query($dbc, $query_studList);
                    $nr = mysqli_num_rows($result_studList);
                     
                  
                    print'<div class="panel-body">

                    <div class="responsive-table">
                    <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                      <th class="text-center">COMPANY NAME</th>
                      <th class="text-center">CITY</th>   
                      <th class="text-center">DATE</th>
                      <th class="text-center">CONTACT PERSON</th>
                      <th class="text-center">POSITION</th>  
                      <th class="text-center">ADVISER</th>                      
                    </tr>
                    </thead>
                    <tbody>';
                    
                    while($r_m = mysqli_fetch_array($result_studList)) {
                    
                    $compname = $r_m[0];
                    $city = $r_m[1];
                    $date = $r_m[2];
                    $contact_person = $r_m[3];
                    $position = $r_m[4];
                    $lname = $r_m[5];
                    $fname = $r_m[6];
                    $mname = $r_m[7];
                    $title = $r_m[8];
                    
                    ?>
                    <tr>
                    <td><?php echo $compname; ?></td>
                    <td><?php echo $city;?></td>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $contact_person; ?></td>
                    <td><?php echo $position; ?></td>
                    <td><?php echo $title ." ".$fname." ".$mname." ".$lname; ?></td>
                    </tr>
                    </tbody>

                    <?php }
                    }?>
                   </table>
                   </div>
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
                       echo '<img src="../files/admin_pics/' . $admin_id. '.jpg">';
                       ?>
                      <h4 style="color:white;"><?php echo $title." ".$fname." ".$mname." ".$lname ?></h4>
                      <h4 style="color:white;">Administrator</h4>
                    </div>
                    <div class="col-md-12 profile-v1-cover">
                       <?php 
                       echo '<img src="../files/default_cover.jpg" style="height:400px;" class="img-responsive">';
                       ?>
                    </div>
                </div>     
             </div>
             <br>
             <div class="col-md-12 col-sm-12 profile-v1-body">
                <div class="col-md-7">

                <br>
                    <div class="row">
                      <div class="col-md-12">

                         <?php
                         if(isset($_GET['success'])) 
                            {   
                            print '<div class="col-md-12">
                              <div class="alert alert-info alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp;Your information was sucessfully updated!</strong>
                               </div></div>';
                            }  
                             else if(isset($_GET['posted'])) 
                                {   
                                print '<div class="col-md-12">
                                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                                         <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                        <strong>&nbsp;Announcement was successfully posted!</strong>
                                   </div></div>';
                                }
                          ?>
                      </div>
                  </div>
                 <form action="post_announcements.php" method="POST" id="defaultForm">
                   <div class="box-v5 panel">
                  
                    <div class="panel-heading padding-0 bg-white border-none">
                    <input type="hidden" name="date_today" value="<?php echo $date_today; ?>" />
                    <input type="hidden" name="lname" value="<?php echo $lname; ?>" />
                    <input type="hidden" name="fname" value="<?php echo $fname; ?>" />
                    <input type="hidden" name="mname" value="<?php echo $mname; ?>" />
                     <input type="hidden" name="title" value="<?php echo $title; ?>" />

                    <div class="form-group has-feedback">
                        <textarea placeholder="Post Announcement" class="form-control" rows ="2" name ="announcement" id="announcement"></textarea>
                      </div>
                    </div>
                    <div class="panel-body">
                      <div class="col-md-12 padding-0">
                        <div class="col-md-6 col-sm-6 col-xs-6 tool">
                          
                          
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 padding-0">
                          <button type="submit" class="btn btn-round pull-right btn-info" name="btn_post">
                            <span>POST</span>
                            <span class="icons icon-cursor" ></span>
                          </button>
                        </div>
                      </div>
                    </div>
                   
                  </div>
                   </form>

                  <?php 
                          $query_select_annoucement = "SELECT msg_id,message, DATE_FORMAT(date_posted,'%M %d, %Y') as date_posted,name FROM messages WHERE section_id = '1' order by msg_id desc";
                          $result_select_annoucement = mysqli_query($dbc, $query_select_annoucement);
                          
                  if($result_select_annoucement->num_rows>0)
                  {
                     while($row2 = mysqli_fetch_array($result_select_annoucement)) {
                            $msg_id = $row2[0];
                            $message = $row2[1];
                            $date_posted2 = $row2[2];
                            $name = $row2[3];
                    print '<div class="panel box-v7">
                        <div class="panel-body">
                          <div class="col-md-12 padding-0 box-v7-header">
                              <div class="col-md-12 padding-0">
                                  <div class="col-md-10 padding-0">
                                   <img src="../files/admin_pics/'.$admin_id.'.jpg" class="box-v7-avatar pull-left">
                                  <h4>'.$name.'</h4>
                                  <h5>Date posted: '.$date_posted2.'</h5>
                                  </div>
                                  <div class="col-md-2 padding-0">
                                    <a href="delete_post.php?msg_id='.$msg_id.'" class="text-danger pull-right"><span class="glyphicon glyphicon-trash">
                                        </span></a>
                                  </div>
                              </div>
                          </div>
                         <div class="col-md-12 padding-0 box-v7-body">
                              <p></p>        
                          </div>
                          <div class="col-md-12 padding-0 box-v7-comment"> 
                              <div class="media">
                                <div class="media-left">  
                                </div>
                                <div class="media-body" style="white-space:pre-line;">'.$message.'</div>
                              </div>
                          </div>
                        </div>
                    </div>';  
                  }

                  }
                        

                    ?>

                    

                </div>
        <div class="col-md-5" >
          <div class="panel box-v3">
            <div class="panel-heading bg-white border-none">
              <h3><b>ADVISERS' OJT MONITORING</b></h3>
            </div>
            <div class="panel-body">
              <a href="view_report.php"><button class="btn btn-primary" style="width:350px;height:40px;font-size:18px"><?php echo $count_report." / ".$count_report_total;?> Unread report from adviser(s).</button></a>
            </div>
          </div>
        </div>
                <div class="col-md-5" >
                     <div class="panel box-v3">
                                <div class="panel-heading bg-white border-none">
                                  <h3><b>DASHBOARD</b></h3>
                                </div>
                                <div class="panel-body">
                                    
                                  <div class="media">
                                    <div class="media-left">
                                        <span class="glyphicon glyphicon-globe" style="font-size:5em;color:#5c5cd6;"></span>
                                    </div>
                                    <div class="media-body">
                                      <h5 class="media-heading">PARTNER COMPANIES</h5>
                                        <div>
                                            <h5>Active: <?php echo $count_act_comp; ?></h5>
                                             <h5>Not Active: <?php echo $count_not_act_comp; ?></h5>
                                          </div>
                                        </div>
                                    </div>


                                  <div class="media">
                                    <div class="media-left">
                                        <span class="glyphicon glyphicon-user" style="font-size:5em;color:#70db70;"></span>
                                    </div>
                                    <div class="media-body">
                                      <h5 class="media-heading">OJT ADVISER</h5>
                                        <div>
                                            <h5>Active: <?php echo $count_act_adv; ?></h5>
                                             <h5>Not Active: <?php echo $count_not_act_adv; ?></h5>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="media">
                                    <div class="media-left">
                                        <span class="fa fa-briefcase" style="font-size:5em;color:#ff33cc;"></span>
                                    </div>
                                    <div class="media-body">
                                      <h5 class="media-heading">OJT OFFERS</h5>
                                        <div>
                                            <h5>Available: <?php echo $count_avail_offers; ?></h5>
                                             <h5>Not Available: <?php echo $count_not_avail_offers; ?></h5>
                                          </div>
                                        </div>
                                    </div>

                                     <div class="media">
                                    <div class="media-left">
                                        <span class="fa fa-folder" style="font-size:5em;color:#8a8a5c;"></span>
                                    </div>
                                    <div class="media-body">
                                      <h5 class="media-heading">STUDENT DELIVERABLES</h5>
                                        <div>
                                            <h5>Authorized by Admin: <?php echo $row_Admin; ?></h5>
                                            <h5>Authorized by Adviser: <?php echo $row_Adviser; ?></h5>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="media">
                                    <div class="media-left">
                                        <span class="glyphicon glyphicon-tasks" style="font-size:5em;color:#ff9933;"></span>
                                    </div>
                                    <div class="media-body">
                                      <h5 class="media-heading">STUDENT OJT RECORDS</h5>
                                        <div>
                                            <h5>On going: <?php echo $count_ongoing; ?></h5>
                                             <h5>Finished: <?php echo $count_finished; ?></h5>
                                          </div>
                                        </div>
                                    </div>

                                     <div class="media">
                                    <div class="media-left">
                                        <span class="glyphicon glyphicon-folder-open" style="font-size:4em;color:#75a3a3;"></span>
                                    </div>
                                    <div class="media-body">
                                      <h5 class="media-heading" style="margin-left:10px;">OJT SOFTCOPY FILES</h5>
                                        <div>
                                            <h5 style="margin-left:10px;">Number of Files: <?php echo $count_file_id; ?></h5>
                                          </div>
                                        </div>
                                    </div>

                                     <div class="media">
                                    <div class="media-left">
                                    
                                        <span class="fa fa-file-word-o" style="font-size:4em;color:#666666;"></span>
                                    </div>
                                    <div class="media-body">
                                      <h5 class="media-heading" style="margin-left:10px;">STUDENT RESUME</h5>
                                        <div>
                                            <h5 style="margin-left:10px;">
                                                   Pending: <?php echo $count_resume_pending; ?>
                                                   Approved: <?php echo $count_resume_approved; ?>
                                              </h5>
                                            <h5 style="margin-left:10px;">
                                                
                                                Rejected: <?php echo $count_rej_resume; ?>
                                                No Resume: <?php echo $count_no_resume; ?>
                                            </h5>
                                          
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
     
    <!-- end: content -->
     <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                    </li>
                     <li class="ripple">
                      <a href="Company_info.php"><i class="glyphicon glyphicon-globe"></i>&nbsp; Partner Companies</a>
                    </li>
                    <li class="ripple">
                      <a href="ojt_offers_masterlist.php"><i class="fa fa-briefcase"></i>OJT Offers List</a>
                    </li>
                     <li class="ripple">
                      <a href="OJT_adviser.php"><i class="glyphicon glyphicon-user"></i>&nbsp; OJT Adviser</a>
                    </li>
                     <li class="ripple">
                      <a href="Student_information.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp; OJT Students</a>
                    </li>
                     ]
                     <li class="ripple">
                     <a href="Manage_course.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Manage Programs</a>
                    </li>
                     <li class="ripple">
                      <a href="ojtsoftcopy.php"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; OJT Softcopy Files
                      </a>
                    </li>
                     <li class="ripple">
                       <a href="program_category_list.php"><i class="glyphicon glyphicon-th-list"></i>&nbsp; OJT Category List</a>
                      </a>
                    </li>
                      <li class="ripple">
                        <a href="student_deliverables.php"><i class="fa fa-folder"></i>&nbsp;Student Deliverables</a>
                    </li>
                     </li>
                      <li class="ripple">
                        <a href="upload.php"><i class="fa fa-file-excel-o"></i>Official Students</a>
                    </li>
          <li>
          <a href="upload_semester_ay.php"><i class="fa fa-calendar-check-o"></i>Active Semester and Year</a>
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
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
 

   $('#defaultForm')
        .bootstrapValidator({
            message: ' ',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
               announcement: {
                    message: ' ',
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/ \n\t ? 0-9]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
            }
        })
  });
</script>
<!-- end: Javascript -->
</body>
</html>