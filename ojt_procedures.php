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

//get student's enrollment status
$q_stud_enrollment_status = "select * from student_ojt_records where stud_no='$stud_no' and ojt_status='Ongoing'";
$q_stud_enrollment_status_res = $dbc->query($q_stud_enrollment_status);
$stud_enrollment_status = $q_stud_enrollment_status_res->fetch_assoc();
$enrollment_status = $stud_enrollment_status['enrollment_status'];

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
	 <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 50%;
      margin: auto;
  }
  </style>
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
				<div  style="padding-right:15px;padding-left:15px;"  class="">
						  <div style="padding-top:20px" class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-12 col-xs-12">
											<p style="font-size:25px;padding-top:7px;">OJT PROCEDURES</p>
										</div>
										
									</div>
							</div><br>
							</div>
							<span style="font-size:15px;">The step by step OJT Procedures are shown here.</span></br>
							<span style="font-size:15px;">You may click on the button below to download a copy.</span></br><br>
				</div>
			<div id="myCarousel" width = "250" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
	<li data-target="#myCarousel" data-slide-to="4"></li>
	<li data-target="#myCarousel" data-slide-to="5"></li>
	<li data-target="#myCarousel" data-slide-to="6"></li>
	<li data-target="#myCarousel" data-slide-to="7"></li>
	<li data-target="#myCarousel" data-slide-to="8"></li>
	<li data-target="#myCarousel" data-slide-to="9"></li>
	<li data-target="#myCarousel" data-slide-to="10"></li>
	<li data-target="#myCarousel" data-slide-to="11"></li>
	<li data-target="#myCarousel" data-slide-to="12"></li>
	<li data-target="#myCarousel" data-slide-to="13"></li>
	<li data-target="#myCarousel" data-slide-to="14"></li>
	<li data-target="#myCarousel" data-slide-to="15"></li>
	<li data-target="#myCarousel" data-slide-to="16"></li>
	<li data-target="#myCarousel" data-slide-to="17"></li>
	<li data-target="#myCarousel" data-slide-to="18"></li>
	<li data-target="#myCarousel" data-slide-to="19"></li>
	<li data-target="#myCarousel" data-slide-to="20"></li>
	<li data-target="#myCarousel" data-slide-to="21"></li>
	<li data-target="#myCarousel" data-slide-to="22"></li>
	<li data-target="#myCarousel" data-slide-to="23"></li>
	<li data-target="#myCarousel" data-slide-to="24"></li>
	<li data-target="#myCarousel" data-slide-to="25"></li>
	<li data-target="#myCarousel" data-slide-to="26"></li>
	<li data-target="#myCarousel" data-slide-to="27"></li>
	<li data-target="#myCarousel" data-slide-to="28"></li>
	<li data-target="#myCarousel" data-slide-to="29"></li>
	<li data-target="#myCarousel" data-slide-to="30"></li>
	<li data-target="#myCarousel" data-slide-to="31"></li>
	<li data-target="#myCarousel" data-slide-to="32"></li>
	<li data-target="#myCarousel" data-slide-to="33"></li>
	<li data-target="#myCarousel" data-slide-to="34"></li>
	<li data-target="#myCarousel" data-slide-to="35"></li>
	<li data-target="#myCarousel" data-slide-to="36"></li>
	<li data-target="#myCarousel" data-slide-to="37"></li>
	
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="assets/img/ojt_process/Slide1.JPG" width="360" height="245">
    </div>

    <div class="item">
      <img src="assets/img/ojt_process/Slide2.JPG" width="360" height="245">
    </div>

    <div class="item">
      <img src="assets/img/ojt_process/Slide3.JPG" width="360" height="245">
    </div>

    <div class="item">
      <img src="assets/img/ojt_process/Slide4.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide5.JPG" width="140" height="140">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide6.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide7.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide8.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide9.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide10.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide11.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide12.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide13.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide14.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide15.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide16.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide17.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide18.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide19.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide20.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide21.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide22.JPG" width="360" height="245">
    </div>
	
	 <div class="item">
      <img src="assets/img/ojt_process/Slide23.JPG" width="360" height="245">
    </div>
	
	<div class="item">
      <img src="assets/img/ojt_process/Slide24.JPG" width="360" height="245">
    </div>
	
	<div class="item">
      <img src="assets/img/ojt_process/Slide25.JPG" width="360" height="245">
    </div>
	
	<div class="item">
      <img src="assets/img/ojt_process/Slide26.JPG" width="360" height="245">
    </div>
	
	<div class="item">
      <img src="assets/img/ojt_process/Slide27.JPG" width="360" height="245">
    </div>	
	<div class="item">
      <img src="assets/img/ojt_process/Slide28.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide29.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide30.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide31.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide32.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide33.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide34.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide35.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide36.JPG" width="360" height="245">
    </div>
	<div class="item">
      <img src="assets/img/ojt_process/Slide37.JPG" width="360" height="245">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
			<br> <br>
				
				<a href="assets/Uploads/OJT_Process.zip">
				<button type="button" style="margin-left:auto;margin-right:auto;display:block;" class="btn btn-default" >
					<span style="font-size:15px;padding-top:10px;" ><b>Download OJT Procedures</b></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="assets/img/download_icon.png" class="goleft img-circle" width="25">
				</button></a>
		
			
		
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
