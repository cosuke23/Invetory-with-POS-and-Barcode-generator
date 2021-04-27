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
//additional data for body
$stud_fullname=$studinfo['lname']. ', ' .$studinfo['fname'].' '.$studinfo['mname'];
$gender = $studinfo['gender'];
$bday = $studinfo['bday'];
$email = $studinfo['email'];
$mobile_no = $studinfo['mobile_no'];
$address = $studinfo['address'];
$fb = $studinfo['facebook'];

//get student's enrollment status
$q_stud_enrollment_status = "select * from student_ojt_records where stud_no='$stud_no' and ojt_status='Ongoing'";
$q_stud_enrollment_status_res = $dbc->query($q_stud_enrollment_status);
$stud_enrollment_status = $q_stud_enrollment_status_res->fetch_assoc();
$enrollment_status = $stud_enrollment_status['enrollment_status'];
$stud_sectionid = $stud_enrollment_status['section_id'];
//get student section
$q_section = "select * from section_list where section_id='$stud_sectionid'";
$q_section_res = $dbc->query($q_section);
$section=$q_section_res->fetch_assoc();

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
                      <a class="active" href="my_account.php">
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
          	<!-- WEATHER-2 PANEL -->
						<div class="col-lg-12 col-md-12 col-sm-12 mb">
							<div class="weather-2">		
								<div style="padding-top:15px">
									<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-10 col-xs-10">
											<p style="font-size:20px;padding-top:7px;">CHANGE PASSWORD</p>
										</div>
									</div>
									</div><!-- /weather-2 header -->
									<form action="change_password_process.php" method="POST" enctype="multipart/form-data">
									<input type="hidden" name="this_stud_no" value="<?php echo $stud_no; ?>">
									
									<div style="padding-top:20px;">
									<?php
										if(isset($_GET['error1']))
										{
											$msg = $_GET['error1'];
											print '<div style="height:30px;"><span class="alert alert-danger" style="font-size:17px;color:red;padding:5px;"><b>'.$msg.'</b></span></div>';
										}
										if(isset($_GET['error3']))
										{
											$msg = $_GET['error3'];
											print '<div style="height:30px;"><span class="alert alert-success" style="font-size:17px;padding:5px;"><b>'.$msg.'</b></span></div>';
										}
									?>
									<div>
									<span  style="font-size:17px;">Current password: &nbsp;</span><input class="form-control" type="password" name="cur_pass" style="width:250px;font-size:15px" required>
									</div></div>
									<div style="padding-top:20px;">
										<span  style="font-size:17px;">New password: &nbsp;</span><input class="form-control" type="password" name="nw_pass" style="width:250px;font-size:15px" required>
									</div>
									<div style="padding-top:20px;">
									<?php
										if(isset($_GET['error2']))
										{
											$msg = $_GET['error2'];
											print '<div style="height:30px;"><span class="alert alert-danger" style="font-size:17px;color:red;padding:5px;"><b>'.$msg.'</b></span></div>';
										}
									?>
										<div>
										<span  style="font-size:17px;">Confirm password: &nbsp;</span><input class="form-control" type="password" name="con_pass" style="width:250px;font-size:15px" required>
									</div></div>
								</div><br><br>
								<button type="submit" name="btn_change_pass" class="btn btn-default"><span class="fa fa-save"></span>&nbsp;Save Changes</button>&nbsp; &nbsp; &nbsp;
								</form>
							</div>
						</div><! --/col-md-4 -->
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
