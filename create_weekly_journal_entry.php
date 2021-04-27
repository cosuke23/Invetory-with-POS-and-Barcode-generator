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
if(isset($_POST['submit_weekly'])){
if ( $_POST['weekly_dtr_date'] == 0){
header("Location:add_journal_date_select.php?error=no_date");
}
}
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
											<p style="font-size:25px;padding-top:7px;">ADD NEW WEEKLY JOURNAL ENTRY</p>
										</div>
										
									</div>
							</div>
							<?php
								if(isset($_GET['error_empty'])){
											echo '
											<div style="padding-left:120px;">
											<div style="z-index:1;float:right;padding-left:15px;width:310px;height:20px;padding-top:0px;position:absolute;" class="alert alert-danger alert-dismissable">
											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											  <strong>Error: Required fields cannot be empty!</strong> 
											</div>
											</div>';
											$entry_date1 = $_GET['weekly_dtr_date'];	
											$week_no = $_GET['week_no'];	
											}else{
											//explode array on option
											$date_week = $_POST['weekly_dtr_date'];
											$explode_date_week = explode('|',$date_week);
											$entry_date1 = $explode_date_week[0];
											$week_no = $explode_date_week[1];
											}
									?>
						   </div>
						   <?php
								//get the dtr details here gayahin ung add sa app na mga details.. 12/6/2016*
								$entry_weekstart = strtotime($entry_date1) + 86400;
								$entry_weekstart2 = $entry_weekstart - 604800;
								$entry_date2 = strtotime($entry_date1);
								$format = "F d, Y";
								
								$formatted_entry_date = date($format,$entry_date2);
								$formatted_entry_weekstart = date($format,$entry_weekstart2);
								
								//get student comp
								$q_compid = "select comp_id from company_ojt_student where stud_no='$stud_no' and status='Ongoing'";
								$q_compid_res = $dbc->query($q_compid);
								$compid= $q_compid_res->fetch_assoc();
								$stud_compid = $compid['comp_id'];
								$q_compinfo = "select * from company_info where comp_id='$stud_compid'";
								$q_compinfo_res = $dbc->query($q_compinfo);
								$compinfo = $q_compinfo_res->fetch_assoc();
								//
								// get weekday of the entry date
								
							?>
							<h5>NAME OF STUDENT</h5>
							<h4><b><?php echo $studname; ?></b></h4>
							<h5>COMPANY</h5>
							<h4><b><?php echo $compinfo['comp_name']; ?></b></h4>
							<h5>JOURNAL ENTRY TYPE</h5>
							<h4><b>Weekly</b></h4>
							<h5>SCOPE DATE</h5>
							<h4><b><?php echo $formatted_entry_weekstart.' - '.$formatted_entry_date; ?></b></h4>
							<h6><b style="color:red;">*</b> Required field</h6>
							<h5>EVALUATION OF YOUR EXPERIENCES THAT WAS BENEFICIAL TO YOUR PRE-PROFESSIONAL DEVELOPMENT <b style="color:red;">*</b>:</h5>
							<form method="POST" action="insert_weekly_journal.php">
							<div style="padding-left:0px;" class="col-sm-7 col-xs-7">
							<input type="hidden" name="stud_no" value="<?php echo $stud_no; ?>">
							<input type="hidden" name="date_submitted" value="<?php echo $entry_date1; ?>">
							<input type="hidden" name="acad_year_start" value="<?php echo $stud_current_acadyrstart; ?>">
							<input type="hidden" name="semester" value="<?php echo $stud_current_sem; ?>">
							<input type="hidden" name="week_no" value="<?php echo $week_no; ?>">
							<div class="form-group has-feedback">
							<textarea id="weekly_summary" name="weekly_summary" maxlength="255" class="form-control" rows="3"></textarea>
							</div>
							</div>
						</div>
							
							<div class="col-sm-7 col-xs-7">
							
							<button name="btn_submit_weekly" id="btn_haha" class="btn btn-primary" style="float:right;" type="submit">Submit</button>
							<a href="add_weekly_journal_date_select.php" class="" style="font-size:14px;padding-top:10px;padding-right:10px;float:right;">Cancel</a>
							
							</div>
							</form>
						
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
