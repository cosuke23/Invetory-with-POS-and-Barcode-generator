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
      $title2 = $row2["title"];
      $mname2 = $row2["mname"];
      $fname2 = $row2["fname"];
    }
}
if((isset($_GET['section_id'])) && (isset($_GET['semester'])) && (isset($_GET['acad_year_start'])) && (isset($_GET['acad_year_end'])) 
    && (isset($_GET['program_code'])) && isset($_GET['program_id']))
  {
  
  $section_id=$_GET['section_id'];
  $semester_rd=$_GET['semester'];
  $acad_year_start_rd=$_GET['acad_year_start'];
  $acad_year_end_rd=$_GET['acad_year_end'];
  $program_code=$_GET['program_code'];
  $program_id=$_GET['program_id'];
  $query_select_section_name = "SELECT section FROM section_list WHERE section_id = '$section_id'";
  $result_select_section_name = mysqli_query($dbc,$query_select_section_name);
    if($result_select_section_name->num_rows>0){
        while($row = mysqli_fetch_array($result_select_section_name)){
          $section_name = $row[0];
        }
    }
  }
  
  
 
//// check if there are unread remarks from companies
  //COMPANY COMMENTS NOTIFICATION FIX
    $x=0;
    $q_advsec = "select distinct section_id from adviser_section_handled where adviser_id='$username' and status = 'Active'";
    $q_advsec_res = $dbc->query($q_advsec);
    if($q_advsec_res->num_rows > 0){
      while($advsec = $q_advsec_res->fetch_assoc()){
        $sec = $advsec['section_id'];
        $q_advstud = "select * from student_ojt_records where section_id = '$sec' and ojt_status='Ongoing'";
        $q_advstud_res = $dbc->query($q_advstud);
        while($advstud = $q_advstud_res->fetch_assoc()){
          $stud=$advstud['stud_no'];
          $q_compstudnt = "select * from company_ojt_student where stud_no = '$stud' and status='Ongoing'";
          $q_compstudnt_res=$dbc->query($q_compstudnt);
          while($compstudnt=$q_compstudnt_res->fetch_assoc()){
            $student = $compstudnt['stud_no'];
            $q = "select count(status) as unread_count from company_remarks where stud_no='$student' and status='unread'";
            $q_res = $dbc->query($q);
            $count= $q_res->fetch_assoc();
            $x = $x + intval($count['unread_count']);
          }
        }
      }
      $unread_msg = $x;
    }else{
      $unread_msg = '0';
    }
    //note: pakipalitan ung echo sa baba ung dating unread['num'] change to $unread_msg 
    //--end of fix
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OJT assiSTI</title>
 <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>
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
                <?php
	$s_id="SELECT id FROM conversations WHERE parent='$username' OR child='$username'";
				$r_id=mysqli_query($dbc, $s_id);
				if(mysqli_num_rows($r_id)>0)
				{	
					$count_conv=0;
					while($row_id = mysqli_fetch_assoc($r_id))
					{
						$idd = $row_id['id'];
						$s_conv="SELECT COUNT(conv_id) AS count FROM conversations_data WHERE id='$idd' AND sender!='$username' AND read_status='unread'";
						$r_conv=mysqli_query($dbc, $s_conv);
						if(mysqli_num_rows($r_conv)>0)
						{
							$row_conv = mysqli_fetch_assoc($r_conv);
							$count_conv += $row_conv['count'];	
						}
					}
				}
				else
				{
					$count_conv='0';
				}
               print '<li class="dropdown avatar-dropdown">
                              <br>
                               
                               <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" 
                                style="padding:1px 1px 1px 1px;">
                                    <i class="glyphicon glyphicon-envelope" style="color:white;font-size:17px;"></i>
                                    <label style="font-size:15px;padding:2px 5px 2px 5px;" class="badge badge-danger"> '.$count_conv.'</label></span>
                               <ul class="dropdown-menu user-dropdown">
							   <div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                                      <li>
                                        <a href="adviser_chat.php">
                                              <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;"><label class="text-primary"> '.$count_conv.' </label> message(s).
                                              </div>
                                      </a>
                                      </li>
                                        </div>
                       </ul></li>';
					   ?>
                <li class="dropdown avatar-dropdown">
                <br>     
                    <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:7px 10px 7px 10px">
                    <i class="fa fa-building-o" style="color:white;font-size:17px;"></i><label class="badge badge-danger" style="font-size:15px;padding:1px 10px 3px 10px;"><?php echo $unread_msg ;?></label>
                    </span>
					<ul class="dropdown-menu user-dropdown">
					<div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                        <li>
                            <a href="adviser_company_remarks.php">
                            <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;">There is/are
                                <label class="text-primary"> <?php echo  $unread_msg; ?> </label> unread company comment/s.
                            </div>
                            </a>
                        </li>
                    </div>
					</ul>
				</li>
				<li class="user-name">&nbsp;<span>&nbsp;<?php echo $fname2 ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <br>
                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="adviser_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span>&nbsp;My Account</a></li>
                      <li><a href="logout.php"><span class="fa fa-power-off ">&nbsp;Log Out</span></a></li> 
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
                           <label>
                          <a href="pending_student_list.php"><i class="fa fa-list"></i>Pending Students</a>
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
                        <h1 class="animated fadeInLeft">MY STUDENTS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                           Manage your OJT students here.
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                     <div class="row">
                      <div class="col-md-9">
                        <h3>Student list of 
                          <label style="color:black;"><?php echo $program_code; ?></label>
                            - 
                          <label style="color:black;"><?php echo $section_name; ?>
                        </h3>
                      </div>
                        <div class="col-md-3" style="padding-top:10px;padding-left:5px;padding-right:30px;">
                          <label style="color:black;" class="pull-right">School Year : <?php echo $acad_year_start_rd." - ".$acad_year_end_rd; ?><br>Semester : <?php echo $semester_rd; ?></label>
                          
                        </div>
                      </div>
                    </div>
                      <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                               <div class="col-md-8"> </div>
                             <div class="col-md-4">
                             <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                          </div>
                        </div>    
            <?php
                       print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                         <th class="col-md-1"></th>
                         <th class="text-center">STUDENT NUMBER</th>
                          <th class="text-center">NAME</th>
                          
                          <th class="text-center">OJT CAETEGORY</th>
                          
                          <th class="text-center">COMPANY NAME</th>
                          <th class="text-center">OJT PROGRESS</th>
                          <th class="text-center">ACTION</th>
                          <th class="text-center">ACTION</th>
                          <th class="text-center">ACTION</th>
                          <th class="text-center">ACTION</th>
                          <th class="text-center">ACTION</th>
                        </tr>
                      </thead>
                      <tbody>';
                  $q_ongoingStudents = "SELECT * FROM student_ojt_records WHERE ojt_status IN('Ongoing','Incomplete')  AND acad_year_start = '$acad_year_start_rd' AND semester ='$semester_rd' AND section_id = '$section_id'";
                 $q_ongoingStudents_res = $dbc->query($q_ongoingStudents);
                 if($q_ongoingStudents_res->num_rows > 0){
                while($ongoingStudent = $q_ongoingStudents_res->fetch_assoc()){
                  //get stud no, semester, acad year start, category id, enrollment status, section Id
                  $ongoing_stud_no = $ongoingStudent['stud_no'];
                  $ongoing_stud_semester = $ongoingStudent['semester'];
                  $ongoing_stud_acadyearstart = $ongoingStudent['acad_year_start'];
                  $ongoing_stud_acadyearend = $ongoingStudent['acad_year_end'];
                  $ongoing_stud_category_id = $ongoingStudent['category_id'];
                  $ongoing_stud_enrollment_status = $ongoingStudent['enrollment_status'];
                $ongoing_category = $ongoingStudent['category_id'];
                  //get stud name and program ID
                  $q_studinfo = "select * from student_info where stud_no='$ongoing_stud_no'";
                  $q_studinfo_res = $dbc->query($q_studinfo);
                  $studinfo = $q_studinfo_res->fetch_assoc();
                  $studname = $studinfo['lname'].', '.$studinfo['fname'].' '.$studinfo['mname'] ;
                  $studprogram_id = $studinfo['program_id'];
                  //get program code
                  $q_programcode = "select * from program_list where program_id='$studprogram_id'";
                  $q_programcode_res = $dbc->query($q_programcode);
                  $programcode = $q_programcode_res->fetch_assoc();
                  $studprogram_code = $programcode['program_code'];
                  //get section
                 
                  //get ojt category
                  $q_getojtcategory = "select * from program_category_list where category_id='$ongoing_stud_category_id'";
                  $q_getojtcategory_res = $dbc->query($q_getojtcategory);
                  $getojtcategory = $q_getojtcategory_res->fetch_assoc();
                  $stud_ojtcategory = $getojtcategory['category_description'];
                  //get company id from company ojt student table the company id
                  $q_companyid = "SELECT * FROM company_ojt_student WHERE acad_year_start='$acad_year_start_rd' AND semester='$semester_rd' AND stud_no ='$ongoing_stud_no' AND status in ('Ongoing','Pending')";
                  $q_companyid_res = $dbc->query($q_companyid);
                  $companyid = $q_companyid_res->fetch_assoc();
                  $stud_comp_id = $companyid['comp_id'];
                  $stud_comp_status = $companyid['status'];
                  //get company name BUT if comp id = 0  echo empty else get the real comp name
                  $q_compname = "select * from company_info where comp_id='$stud_comp_id'";
                  $q_compname_res = $dbc->query($q_compname);
                  if($q_compname_res->num_rows > 0){
                    $compname = $q_compname_res->fetch_assoc();
                    $stud_comp_name = $compname['comp_name'];
                    
                  }else{
                    $stud_comp_name = "None";
                  }
              //compute the percentage of how many are finished in the checklist
              //count the total done by student
              $q_countChecklistdone = "SELECT COUNT(deliverable_id) AS totalfinished FROM student_checklist WHERE stud_no='$ongoing_stud_no' AND acad_year_start='$ongoing_stud_acadyearstart' AND semester='$ongoing_stud_semester' AND category_id='$ongoing_category' AND remarks='Completed'";
              $q_countChecklistdone_res = $dbc->query($q_countChecklistdone);
              $checklistdone = $q_countChecklistdone_res->fetch_assoc();
              $totalchecklistdone = $checklistdone['totalfinished'];
              //count the total number of deliverables
              $q_totaldeliverables = "select count(deliverable_id) as totaldeliverables from student_deliverables";
              $q_totaldeliverables_res =$dbc->query($q_totaldeliverables);
              $totaldeliverablescount = $q_totaldeliverables_res->fetch_assoc();
              $totaldeliverables = $totaldeliverablescount['totaldeliverables'];
              //compute percentage 
              $percentage=($totalchecklistdone / $totaldeliverables) * 100;
          
                      ?>
                      <tr>  
                          
								<td><a href="adviser_view_student_information.php?stud_no=<?php echo  $ongoing_stud_no; ?>" style="color:gray;"><?php echo '<img src="../files/student_pics/'.$ongoing_stud_no.'.jpg" style="height:50px;width:60px;">';?></a></td> 
                                <td><a href="adviser_view_student_information.php?stud_no=<?php echo  $ongoing_stud_no; ?>" style="color:gray;"><?php echo $ongoing_stud_no; ?></a></td> 
                                <td><a href="adviser_view_student_information.php?stud_no=<?php echo  $ongoing_stud_no; ?>" style="color:gray;"><?php echo $studname; ?></a></td>
                                
                                
                                <td><a href="adviser_view_student_information.php?stud_no=<?php echo  $ongoing_stud_no; ?>" style="color:gray;"><?php echo $stud_ojtcategory; ?></a></td>
                                
                                <td><a href="adviser_view_student_information.php?stud_no=<?php echo  $ongoing_stud_no; ?>" style="color:gray;"><?php echo $stud_comp_name; ?></a></td>
                                <td class="text-center" style="font-size:25px;color:#0099ff;"><b><?php echo intval($percentage).'%' ; ?></b></td> 
                              <?php
                              if($stud_comp_status =="Pending")
                              {
                                print '<td>
                                  <a href="adviser_update_student_records.php?acad_year_start_rd='.$acad_year_start_rd.'&semester_rd='.$semester_rd.'&stud_no_records='.$ongoing_stud_no.'"> 
                                  <button type="submit" class=" btn btn-outline btn-primary btn-block btn-sm">
                                  &nbsp; START OJT </button>
                                  </a>
                              </td>';
                              }
							  else
							  {
                                  print '<td>
                                  <a href="adviser_update_student_records.php?acad_year_start_rd='.$acad_year_start_rd.'&semester_rd='.$semester_rd.'&stud_no_records='.$ongoing_stud_no.'"> 
                                  <button type="submit" class=" btn btn-outline btn-info btn-block btn-sm">
                                  &nbsp; OJT DETAILS </button>
                                  </a>
                              </td>';
                              }
							  
                              ?>  
                              <td>
                                  <a href="adviser_OJT_student_checklist.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo  $ongoing_stud_no; ?>">
                                  <button type="submit" class="btn btn-outline btn-warning btn-block btn-sm">
                                  &nbsp; OJT Checklist</button>
                                  </a>
                              </td>
                               <td>
                                  <a href="dtr.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo  $ongoing_stud_no; ?>">
                                  <button type="submit" class="btn btn-outline btn-info btn-block btn-sm">
                                  &nbsp; DTR</button>
                                  </a>
                              <hr>
                                  <a href="journal.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo  $ongoing_stud_no; ?>">
                                  <button type="submit" class="btn btn-outline btn-default btn-block btn-sm">
                                  &nbsp; JOURNAL</button>
                                  </a>
                              </td>
							  
                                
							  <?php
							  $check = "SELECT stud_no FROM endorsement WHERE stud_no='$ongoing_stud_no' AND status='Active'";
							  $result=mysqli_query($dbc, $check);
							  if(mysqli_num_rows($result)>0)
							  {
								print '<td>
                                <a href="prepare_endorsement.php?stud_no='.$ongoing_stud_no.'">
                                  <button type="submit" class="btn btn-outline btn-success btn-block btn-sm">
                                  &nbsp;ENDORSEMENT&nbsp;</button>
                                  </a>
                                </td>';
							  }
                              else{
                                 print '<td><label data-toggle="tooltip" title="No Approved for Company Endorsement" class="btn btn-danger btn-outline  btn-block btn-sm"> <span class="glyphicon glyphicon-lock"  data-placement="right" ></span>  &nbsp;  Endorsement </label> </td>';
                              }
                              ?> 
                              <td>
                                <a href="remove_student.php?stud_no=<?php echo $ongoing_stud_no; ?>&stud_name=<?php echo $studname; ?>">
                                  <button type="submit" class="btn btn-outline btn-danger btn-block btn-sm">
                                  &nbsp;Remove&nbsp;</button>
                                  </a>
                              </td>  
  
                      </tr>
                      <?php 
              }
          }
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?> 
                     
                  </div>
                </div>
              </div>
            </div><!-- end: content -->
     </div>
          
      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
              <ul class="nav nav-list">
                    <li class="ripple">
                     <a href="adviser_home.php"><i class="glyphicon glyphicon-home"></i> Home</a>
                    </li>
                     <li class="ripple">
                       <a href="adviser_company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Information</a>
                    </li>
                     <li class="ripple">
                      <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;My Students</a>
                    </li>
                     <li class="ripple">
                      <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i> Company Comments</a>
                    </li>
                    <li class="ripple">
                       <a href="pending_student_list.php"><i class="fa fa-list"></i>Pending Students</a>
                    </li>
                </ul>
            </div>
        </div>       
      </div>
      <input type="hidden" id="name_DT" value="<?php echo $program_code." - ".$section_name." SY:".$acad_year_start_rd."-".$acad_year_end_rd." Term:".$semester_rd; ?>" /> 
      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle"  style="background-color:#0d47a1;">
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
  var name_DT = document.getElementById('name_DT').value;
 var buttons = new $.fn.dataTable.Buttons(table, {
     buttons: [
            {
                extend: 'excelHtml5',
                title: name_DT,         
                 text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                 className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,2,3,4,5]
                }
            },
            {
                extend: 'print',
                title: name_DT,
                text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,2,3,4,5]
                }
            },
        ]
    }).container().appendTo($('#buttons'));  
  });
  function FunctionDelete(){
             
              var r = confirm("Are you sure you want to delete?");
              
              if(r == true){
                  alert("Successfully deleted");
                  document.comptb.action = "delete_comp_info.php";
                  document.comptb.submit(); 
              }
              if(r == false){
                event.preventDefault();
              }
            } 
</script>
<!-- end: Javascript -->
</body>
</html>