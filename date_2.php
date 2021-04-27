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
$acad_year_start = $stud_enrollment_status['acad_year_start'];
$acad_year_end = $stud_enrollment_status['acad_year_end'];
$semester = $stud_enrollment_status['semester'];
$category_id = $stud_enrollment_status['category_id'];

date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
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
          <section class="wrapper ">
		  
		   <div style="padding-top:20px"  class="">
				
						<div class="col-lg-12 col-md-12 col-sm-12">
						  <div class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-12 col-xs-12">
											<p style="font-size:25px;padding-top:7px;">DAILY TIME RECORD</p>
										</div>
									</div>
									</div>
										<?php

										if(isset($_GET['error'])){

											echo '
											
											<div style="margin-left:-14px;z-index:1;float:right;padding-top:8px;width:250px;height:35px;position:absolute;" class="alert alert-danger alert-dismissable">

											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

											  <strong>Error: No date selected!</strong> 
										
											</div>';
											}

											?>
							</div><br>
									
							</div>
							
							<form action="check_date.php" method="POST" enctype="multipart/form-data">
								<div class="row">
									<input type="hidden" name="stud_no" value="<?php echo $stud_no;?>"/>
									<input type="hidden" name="acad_year_start" value="<?php echo $acad_year_start;?>"/>
									<input type="hidden" name="acad_year_end" value="<?php echo $acad_year_end;?>"/>
									<input type="hidden" name="semester" value="<?php echo $semester;?>"/>
									<input type="hidden" name="category_id" value="<?php echo $category_id;?>"/>
										
									<div class="col-md-12">
										<h2>ENTER DATE:</h2>
									</div>
									<?php 
									if(isset($_GET['msg']))
									{
										print'<div class="col-md-2">
										<h5 style="color:red;font-size:20px;padding:10px;" class="alert alert-danger">Invalid time</h5>
										</div>';
									}
									if(isset($_GET['msg2']))
									{
										print'<div class="col-md-3">
										<h5 style="color:green;font-size:20px;padding:10px;" class="alert alert-success">DTR successfully recorded.</h5>
										</div>';
									}
									?>							
								</div>
								<div class="row">
									<div class="col-md-2">
										<h5>Date:</h5>
										<input style="height:40px;width:263px;" type="date" class="form-control" name="date_sub" id="date_sub"/>
										<input type="hidden" name="hour" value="h"/>
										<input type="hidden" name="minute" value="m"/>
										<input type="hidden" name="ampm" value="mm"/>
									</div>
								</div>
								<br>
								<div class="row">
								<div class="col-md-2">
									<button type="submit" name="btn_date" class="btn btn-primary">Submit</button>
								</div>
								</div>
								</form>	
								<table>
									<?php
										$dtar_query = $dbc->query("SELECT * FROM dtr WHERE stud_no = $stud_no");
										$temp_date = "0";
										$input_mins = 0;
										print '<table>';
										while($row = $dtar_query->fetch_assoc()) {
											if($temp_date == "0") {
												$temp_date = $row["date_submitted"];
												print '<tr><td>' . $row["time_in"] . '-' . $row["time_out"] . '&nbsp;&nbsp;' . $row["date_submitted"] . '</td></tr>';
												$input_mins = $row["input_minutes"];
											} else {
												if($temp_date == $row["date_submitted"]) {
													$temp_date = $row["date_submitted"];
													print '<tr><td>' . $row["time_in"] . '-' . $row["time_out"] . '</td></tr>';
													$input_mins = $input_mins + $row["input_minutes"];
												} else {
													$hour = intval($input_mins / 60);
													$min = $input_mins % 60;
													print '<tr><td>' . $hour . ' hour(s) ' . $min . ' minute(s)</td></tr>';
													$input_mins = $row["input_minutes"];
													print '<tr><td>' . $row["time_in"] . '-' . $row["time_out"] . '&nbsp;&nbsp;' . $row["date_submitted"] . '</td></tr>';
													$temp_date = $row["date_submitted"];
												}
											}
										}
										$hour = intval($input_mins / 60);
										$min = $input_mins % 60;
										print '<tr><td>' . $hour . ' hour(s) ' . $min . ' minute(s)</td></tr>';
													$input_mins = $row["input_minutes"];
										print '</table>';										
									?>
								</table>
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
