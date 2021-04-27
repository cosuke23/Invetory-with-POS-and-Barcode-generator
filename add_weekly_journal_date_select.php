<!DOCTYPE html>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//student number static for debugging purposes
if(!isset($_COOKIE["sid"])) {
	header ("Location: login.php");
	exit;
}
$stud_no=$_COOKIE['sid'];
//get student info
$q_studinfo ="select * from student_info where stud_no='$stud_no'";
$q_studinfo_res = $dbc->query($q_studinfo);
$studinfo = $q_studinfo_res->fetch_assoc();
$studname= $studinfo['fname']. ' ' .$studinfo['lname'];
//get student course
$stud_program_id = $studinfo['program_id'];
$q_course = "select * from program_list where program_id='$stud_program_id'";
$q_course_res = $dbc->query($q_course);
$course = $q_course_res->fetch_assoc();
$stud_course = $course['program_code'];
//get student's enrollment status/cur sem and yr
$q_stud_record = "select * from student_ojt_records where stud_no='$stud_no' and ojt_status='Ongoing'";
$q_stud_record_res = $dbc->query($q_stud_record);
$stud_record = $q_stud_record_res->fetch_assoc();
$enrollment_status = $stud_record['enrollment_status'];
$stud_current_sem = $stud_record['semester'];
$stud_current_acadyrstart = $stud_record['acad_year_start'];
//get ojt start date
$q_ojt_start = "select ojt_start_date from company_ojt_student where stud_no='$stud_no' and status='Ongoing'";
$q_ojt_start_res = $dbc->query($q_ojt_start);
$ojt_start_date = $q_ojt_start_res->fetch_assoc();
$start_date = $ojt_start_date['ojt_start_date'];
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>OJT-assiSTI</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link rel="icon" href="assets/img/icon.png">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div style="color:#ffffff;" class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="home.php" class="logo" style="font-size:25px"><b>OJT-assiSTI</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
               
            </div>
           
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	   <p class="centered"><img src=<?php echo "../files/student_pics/".$stud_no.".jpg"; ?> class="img-circle" style="height:100px;width:100px;"></p>
              	  <h5 class="centered"><?php echo $studname; ?></h5>
				  <h6 class="centered" style="color:#ffffff"><?php echo $stud_course; ?></h6>
              	  	
                  <li class="mt">
                      <a href="home.php">
                          <i class="fa fa-home"></i>
                          <span>Home</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="my_account.php">
                          <i class="fa fa-user"></i>
                          <span>My Account</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="announcements.php">
                          <i class="fa fa-bullhorn"></i>
                          <span>Announcements</span>
                      </a>
                  </li>
				    <li class="sub-menu">
                      <a href="about_us.php">
                          <i class="glyphicon glyphicon-question-sign"></i>
                          <span>About us</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="logout.php">
                          <i class="fa fa-gear"></i>
                          <span>Logout</span>
                      </a>
                  </li>
              </ul>
			  
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
		  
		   <div style="padding-top:20px"  class="">
				
						<div class="col-lg-12 col-md-12 col-sm-12 mb">
						  <div class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-12 col-xs-12">
											<p style="font-size:25px;padding-top:7px;">WEEKLY JOURNAL</p>
										</div>
										
									</div>
							</div>
							<div style="padding-left:150px;padding-bottom:5px;">
							 <?php
										if(isset($_GET['error'])){
											echo '
											<div style="z-index:1;float:right;padding-top:8px;width:300px;height:35px;position:absolute;" class="alert alert-danger alert-dismissable">
											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											  <strong>Error: No date selected!</strong> 
												</div>';
											}
											?>
							</div>
						   </div>
						   <div>
								<h4>Select Date:</h4>
						   </div>
						   <div class=" col-sm-5 col-xs-5"> 
							<form action="create_weekly_journal_entry.php" method="POST">
								<select style="height:40px;width:263px;" class="form-control" name="weekly_dtr_date">
								<?php
									//get all weekly dates from dtr where there is no journal entry record
										$date = date("Y-m-d");
	
										$ojt_start_date = strtotime($start_date);
										$date_now = strtotime($date);
										
										 $tempformat = "D";
										$tempday = date($tempformat, $ojt_start_date);
										
										
										switch($tempday) {
											case 'Sun':
												$ojt_start_date = $ojt_start_date + 86400;
												break;
										/*	case 'Mon':
												$ojt_start_date = $ojt_start_date - 86400;
												break;
											case 'Tue':
												$ojt_start_date = $ojt_start_date - 172800;
												break;
											case 'Wed':
												$ojt_start_date = $ojt_start_date - 259200;
												break;
											case 'Thu':
												$ojt_start_date = $ojt_start_date - 345600;
												break;
											case 'Fri':
												$ojt_start_date = $ojt_start_date - 432000;
												break;
											case 'Sat':
												$ojt_start_date = $ojt_start_date - 518400;
												break;*/
										}
										
										$data = array();
										
										$week = 1;
										
										while($date_now > $ojt_start_date) {
											$start = strtotime('last week sunday', $ojt_start_date);
											$end = strtotime('this week saturday', $ojt_start_date);	
											$format = "Y-m-d";
											$format2 = "F d, Y";
											$date1 = date($format, $start);
											$date2 = date($format, $end);
											$display_date1 = date($format2, $start);
											$display_date2 = date($format2, $end);
											//--filter the dates
												$q_journal_entry = "select date_submitted from journal where date_submitted='$date2' and type='Weekly' and stud_no='$stud_no' and acad_year_start='$stud_current_acadyrstart' and semester='$stud_current_sem'";
												$q_journal_entry_res = $dbc->query($q_journal_entry);
											//
											if($q_journal_entry_res->num_rows == 0){
												/*$dtr_date2 = strtotime($dtr_date);
												$format = "F d, Y";
												$formatted_dtr_date = date($format,$dtr_date2);*/
												echo '<option value="'.$date2.'|'.$week.'">Week '.$week.': '.$display_date1 . ' - ' . $display_date2 . '</option>';
														}
											//echo $date1 . " - " . $date2 . " week " . $week . "<br>";
											
											$ojt_start_date = $ojt_start_date + 604800;
											
											$week = $week + 1;
										}
																		
						
								?>
								</select>

								<br>
								<div style="height:40px;width:263px;">
									<button style="float:right;" type="submit"  name="submit_weekly" class="btn btn-primary">Create weekly summary entry</button>
									<a href="journal_weekly.php" class="" style="font-size:14px;padding-top:10px;padding-right:10px;float:right;">Cancel</a>
								</form>
								</div>
						   </div>
						</div>
						
						
		</section><! --/wrapper -->
		
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->
      
  </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    <!--script for this page-->
    
  <script>
      //custom select box
      $(function(){
          $('select.styled').customSelect();
      });
  </script>
  </body>
</html>