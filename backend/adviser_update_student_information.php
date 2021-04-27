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
if($usertype==1)
{
	header("Location: admin_home.php");
}
if($usertype!=1)
{
	$query2 = "SELECT * from adviser_info WHERE adviser_id = '$username'";
	$result2 = mysqli_query($dbc,$query2);
		if(mysqli_num_rows($result2)>0)
		{
			$row2 = mysqli_fetch_assoc($result2);
			$fname2 = $row2["fname"];
		}
}
  if(isset($_GET['stud_no']) &&  isset($_GET['acad_year_start_rd']) && isset($_GET['semester_rd']) && isset($_GET['section_id'])) {
  
  $stud_no=$_GET['stud_no'];
  $acad_year_start_rd=$_GET['acad_year_start_rd'];
  $semester_rd=$_GET['semester_rd'];
  $section_id=$_GET['section_id'];
  $query_update_stud_info ="SELECT a.stud_no,a.lname,a.fname,a.mname,a.gender,DATE_FORMAT(a.bday, '%m/%d/%Y') AS bday,a.email,a.mobile_no,a.tel_no,a.address,a.facebook,a.program_id,b.program_code,a.imageData,c.adviser_id,c.program_id FROM student_info AS a INNER JOIN program_list AS b INNER JOIN adviser_section_handled AS c WHERE a.program_id = b.program_id AND a.program_id = c.program_id AND c.adviser_id = '$username' AND a.stud_no ='$stud_no'";
                 
  $result_update_stud_info =  mysqli_query($dbc, $query_update_stud_info);         
          if($result_update_stud_info->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_update_stud_info))
              {
                            $stud_no = $row[0];
                            $lname = $row[1];
                            $fname = $row[2];
                            $mname = $row[3];
                            $gender = $row[4];
                            $bday = $row[5];
                            $email = $row[6];
                            $mobile_no = $row[7];
                            $tel_no = $row[8];
                            $address = $row[9];
                            $facebook = $row[10];
                            $a_program_id= $row[11];
                            $program_code = $row[12];
                            $imageData = $row[13];
                            $c_adviser_id = $row[14];
                            $c_program_id = $row[15];             
              }
           }
           $decoded_img = base64_decode($imageData);
           $f = finfo_open(); 
           $img_type = finfo_buffer($f, $decoded_img, FILEINFO_MIME_TYPE);      
}
$query_select_SAYR_SID = "SELECT acad_year_start,semester,section_id FROM OJT ";
// check if there are unread remarks from companies
		$q_unread = "select count(status) as num from company_remarks where status = 'unread'";
		$q_unread_res = $dbc->query($q_unread);
		$unread = $q_unread_res->fetch_assoc();
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
   <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>
  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
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
          <div class="col-md-12 nav-wrapper">
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
                <li class="user-name">Messages<span class="badge badge-primary"><?php echo $unread['num'];?></span>&nbsp;&nbsp;<span>&nbsp;Hi' <?php echo $fname2 ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <br>
                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="adviser_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span> My Account</a></li>
                      
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
                      <img src="asset/img/ojtassistilogo.png" style="padding-top:10px;margin-left:65px;width:80px;height:80px;" class="animated fadeInLeft">
                    </div>
                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:75px;">
                      <h1 class="animated fadeInLeft" style="color:gray;margin-left:30px;">
                                <?php 
                                  date_default_timezone_set("Asia/Manila");
                                  echo date("h:i A"); 
                                ?>  
                      </h1>
                       <p class="animated fadeInRight" style="color:gray;margin-left:30px;">
                               <?php
                                 echo  date("l, F j, Y"); 
                               ?>
                        </p>
                    </div>
                    <div class="nav-side-menu">
                       <label>
                          <a href="adviser_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label>
                          <a href="adviser_company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Information</a>
                        </label><br>
                        <label class="active">
                           <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;My Students</a>
                        </label><br>
                          <label>
                          <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i>Company Comments</a>
                          </label><br>
                           
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->
          <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">STUDENT INFORMATION</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                         This section will show all the student information.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE STUDENT INFORMATION</h3></div>
                    <form id="defaultForm" method="post" action="#" enctype="multipart/form-data">
                      <div class="panel-body" style="padding-bottom:30px;">
                         <div class="row">     
                           <div class="col-md-3">
                            <h5>STUDENT PICTURE &nbsp; <i class="fa fa-camera"></i></h5> 
                           <?php 
                             echo '<img src="data:'.$img_type.';base64,'.$imageData.'" style="height:200px;width:200px;">';
                             ?>
                           </div>
                          <div class="col-md-6">
                          </div>
                        </div>
                        <div class="row">
                         <input name="stud_no" type="hidden" value ="<?php echo $stud_no; ?>"/>
                          <div class="col-md-3">
                             <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                               <div class="form-group has-feedback">
                                <h4 style="padding-left:5px;"><?php echo $stud_no; ?></h4>
                               </div>
                          </div>
                         <div class="col-md-3">
                             <h5 style="padding-left:5px;">LASTNAME</h5>
                              <div class="form-group has-feedback">
                               <h4 style="padding-left:5px;"><?php echo $lname; ?></h4>
                              </div>
                          </div>
                          <div class="col-md-3">
                             <h5 style="padding-left:5px;">FIRSTNAME</h5>
                              <div class="form-group has-feedback">
                                <h4 style="padding-left:5px;"><?php echo $fname; ?></h4>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">MIDDLENAME</h5>
                              <div class="form-group has-feedback">
                                 <h4 style="padding-left:5px;"><?php echo $mname; ?></h4>
                              </div>
                          </div>                  
                        </div>
                        
                        <div class="row">
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">GENDER</h5>
                              <div class="form-group has-feedback">
                                    <h4 style="padding-left:5px;"><?php echo $gender; ?></h4>
                              </div>
                          </div>
                           <div class="col-md-3">
                                <h5 style="padding-left:5px;">BIRTHDAY</h5>
                                  <div class="form-group">
                                   <h4 style="padding-left:5px;"><?php echo $bday; ?></h4>
                                 </div>
                           </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">PROGRAM</h5>
                            <div class="form-group has-feedback">
                                   <h4 style="padding-left:5px;"><?php echo $program_code; ?></h4>
                              </div>
                            </div>
                            <div class="col-md-3"></div>
                          </div>
                           <div class="row">
                            <h2 style="margin-left:13px;">Contact Information</h2>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                                 <h5 style="padding-left:5px;">ADDRESS</h5>
                                <div class="form-group has-feedback">
                                  <h4 style="padding-left:5px;"><?php echo $address; ?></h4>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                               <h5 style="padding-left:5px;">EMAIL</h5>
                                <div class="form-group has-feedback">
                                    <h4 style="padding-left:5px;"><?php echo $email; ?></h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">FACEBOOK</h5>
                                <div class="form-group has-feedback">
                                  <h4 style="padding-left:5px;"><?php echo $facebook; ?></h4>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                                <h5 style="padding-left:5px;">TELEPHONE NUMBER</h5>
                                <div class="form-group has-feedback">
                                    <h4 style="padding-left:5px;"><?php echo $tel_no; ?></h4>
                                </div>
                            </div>
                             <div class="col-md-4">
                                  <h5 style="padding-left:5px;">MOBILE NUMBER</h5>
                                 <h4 style="padding-left:5px;"><?php echo $mobile_no; ?></h4>
                            </div>
                             <div class="col-md-4">
                            </div>
                          </div>
                      </div><!--ENd of panel body-->
                      </form>
                      </div>
                     </div>
                </div>
  
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">OJT STUDENT RECORDS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section will show the student records.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE OJT STUDENT RECORDS</h3></div>
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row">
                        <?php 
                           $query_stud_records = "SELECT a.stud_no,a.year_level,a.semester,a.section_id,a.category_id,a.enrollment_status,a.ojt_status,a.acad_year_start,a.acad_year_end,b.category_description,d.section FROM student_ojt_records AS a INNER JOIN program_category_list AS b INNER JOIN section_list AS d INNER JOIN adviser_section_handled AS c WHERE a.category_id = b.category_id  AND a.acad_year_start = '$acad_year_start_rd' AND c.acad_year_start = '$acad_year_start_rd' AND c.semester = '$semester_rd' AND c.section_id = '$section_id' AND a.semester = '$semester_rd' AND c.adviser_id = '$username' AND a.stud_no = '$stud_no' AND a.section_id = '$section_id' AND a.section_id = d.section_id  AND d.section_id = '$section_id' AND c.status ='Active'";
                          $result_stud_records = mysqli_query($dbc, $query_stud_records);
                          $num_rows = mysqli_num_rows($result_stud_records);
                          
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables" class="display table table-striped table-bordered table-condensed" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                             <th class="text-center">YEAR LEVEL</th>
                             <th class="text-center">SEMESTER</th>
                             <th class="text-center">SECTION</th>
                             <th class="text-center">OJT CATEGORY</th>
                             <th class="text-center">ENROLLMENT STATUS</th>
                              <th class="text-center">OJT STATUS</th>
                             <th class="text-center">SCHOOL YEAR</th>
                             <th class="text-center" style="width:100px;">ACTION</th>
                             <th class="text-center" style="width:100px;">ACTION</th>
                             <th class="text-center" style="width:100px;">ACTION</th>
                             <th class="text-center" style="width:100px;">ACTION</th>                   
                            </tr>
                          </thead>
                          <tbody>';
                        while($row = mysqli_fetch_array($result_stud_records)) {
               
                            $stud_no_records = $row[0];
                            $year_level_rd = $row[1];
                            $semester_rd = $row[2];
                            $section_id = $row[3];
                            $ojt_category_id = $row[4];
                            $enrollment_status_rd = $row[5];
                            $ojt_status_rd = $row[6];
                            $acad_year_start_rd = $row[7];
                            $acad_year_end_rd = $row[8];
                            $category_description = $row[9];
                            $section_name = $row[10];
                      ?>
                       <?php 
                           if($ojt_status_rd == "Ongoing")
                            {
                              $new_ojt_status_rd =  "On going";
                            }else{
                              $new_ojt_status_rd = "Finished";
                                 }  
                         ?>
                      <tr>      
                                <td><?php echo $year_level_rd; ?></td> 
                                <td><?php echo $semester_rd; ?></td>
                                <td><?php echo $section_name; ?></td>
                                <td><?php echo $category_description; ?></td>
                                <td><?php echo $enrollment_status_rd; ?></td>
                                <td><?php echo $new_ojt_status_rd; ?></td> 
                                <td><?php echo $acad_year_start_rd." - ".$acad_year_end_rd;  ?></td>
                              <td>
                                  <a href="adviser_update_student_records.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo $stud_no_records; ?>">
                                  <button type="submit" class=" btn btn-outline btn-primary btn-block btn-sm">
                                  <span class="glyphicon glyphicon-pencil"></span> &nbsp;&nbsp; Update &nbsp; &nbsp;</button>
                                  </a>
                              </td>
                              <td>
                                  <a href="adviser_OJT_student_checklist.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo $stud_no_records; ?>">
                                  <button type="submit" class="btn btn-outline btn-warning btn-block btn-sm">
                                  <span class="glyphicon glyphicon-folder-open"></span> &nbsp; OJT Checklist</button>
                                  </a>
                              </td>
                               <td>
                                  <a href="dtr.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo $stud_no_records; ?>">
                                  <button type="submit" class="btn btn-outline btn-info btn-block btn-sm">
                                  <span class="fa fa-calendar-check-o"></span> &nbsp; DTR</button>
                                  </a>
                              </td>
                                <td>
                                  <a href="journal.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo $stud_no_records; ?>">
                                  <button type="submit" class="btn btn-outline btn-default btn-block btn-sm">
                                  <span class="fa fa-book"></span> &nbsp; JOURNAL</button>
                                  </a>
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
                       
                       <div class="row">
                      <div class="col-md-8"></div>
                      <div class="col-md-4">
                               <a href="adviser_student_information.php?semester=<?php echo $semester_rd; ?>&acad_year_start=<?php echo $acad_year_start_rd; ?>&acad_year_end=<?php echo $acad_year_end_rd; ?>&program_code=<?php echo $program_code; ?>&program_id=<?php echo $c_program_id; ?>&section_id=<?php echo $section_id; ?>">
                               <button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                       </div>
                      </div>        
                      </div><!--ENd of panel body-->
                      </div>
                     </div>
                </div>
            </div> <!-- end: content -->
      </div>
     
    <!-- end: content -->
      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
               <ul class="nav nav-list">
                    <li class="ripple">
                     <a href="adviser_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                    </li>
                     <li class="ripple">
                       <a href="adviser_company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Info</a>
                    </li>
                     <li class="ripple">
                      <a href="adviser_ojt_student_list.php"><i class="glyphicon glyphicon-object-align-bottom"></i> OJT Student list</a>
                    </li>
                     <li class="ripple">
                        <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Section Handled</a>
                    </li>
                    <li class="ripple">
                       <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i>Company Remarks</a>
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
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#datatables').DataTable();
});
</script>
<!-- end: Javascript -->
</body>
</html>