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

//get student's enrollment status and section based on sem and acad yr
$q_stud_record = "select * from student_ojt_records where stud_no='$stud_no' and ojt_status='Ongoing'";
$q_stud_record_res = $dbc->query($q_stud_record);
$stud_record = $q_stud_record_res->fetch_assoc();
$enrollment_status = $stud_record['enrollment_status'];
$stud_sectionid = $stud_record['section_id'];
$stud_current_sem = $stud_record['semester'];
$stud_current_acadyrstart = $stud_record['acad_year_start'];
//if section id is 1.. no adviser else get adviser info
//sa section handled muna get adviser id
$q_adviser_id = "select * from adviser_section_handled where section_id='$stud_sectionid' and status='Active' and semester='$stud_current_sem' and acad_year_start='$stud_current_acadyrstart'";
$q_adviser_id_res = $dbc->query($q_adviser_id);
if($q_adviser_id_res->num_rows >0){
		$get_adviser_id = $q_adviser_id_res->fetch_assoc();
		$adviser_id= $get_adviser_id['adviser_id'];
		//get adviser info
		$q_adviser_info = "select * from adviser_info where adviser_id='$adviser_id'";
		$q_adviser_info_res = $dbc->query($q_adviser_info);
		$adviser_info = $q_adviser_info_res->fetch_assoc();
		$adviser_name = $adviser_info['title'].' '.$adviser_info['fname'].' '.$adviser_info['lname'];
		$adviser_email = $adviser_info['email'];
		$adviser_contact = $adviser_info['mobile_no'];
	
}else{
$no_adviser="No Records to Show. Please confirm your section at the E2E Office.";
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
		  
		   <div style="padding-top:20px"  class="row">
				
						<div class="col-lg-12 col-md-12 col-sm-12 mb">
						  <div style="padding-right:15px;padding-left:15px;"  class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-12 col-xs-12">
											<p style="font-size:25px;padding-top:7px;">ADVISER INFORMATION</p>
										</div>
										
									</div>
							</div><br>
							</div>
							<?php
								$q_adviser_id = "select * from adviser_section_handled where section_id='$stud_sectionid' and status='Active' and semester='$stud_current_sem' and acad_year_start='$stud_current_acadyrstart'";
										$q_adviser_id_res = $dbc->query($q_adviser_id);
										if($q_adviser_id_res->num_rows >0){
												$get_adviser_id = $q_adviser_id_res->fetch_assoc();
												$adviser_id= $get_adviser_id['adviser_id'];
												//get adviser info
												$q_adviser_info = "select * from adviser_info where adviser_id='$adviser_id'";
												$q_adviser_info_res = $dbc->query($q_adviser_info);
												$adviser_info = $q_adviser_info_res->fetch_assoc();
												$adviser_name = $adviser_info['title'].' '.$adviser_info['fname'].' '.$adviser_info['lname'];
												$adviser_email = $adviser_info['email'];
												$adviser_contact = $adviser_info['mobile_no'];
												
										
							?>
							
							<div style="padding-left:20px;padding-top:15px" class="row">
									<img src=<?php echo "../files/admin_pics/".$adviser_id.".jpg"; ?> class="img-circle" height="150" width="150">	
									<div style="padding-top:35px;padding-left:5px;">
										<span style="font-size:16px">Adviser Name: <b><?php echo $adviser_name; ?></b></span><br><br>	
										
									</div>
								</div>
						  </div>
						</div>
						 <div style="padding-right:15px;padding-left:15px;"  class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-10 col-xs-10">
											<p style="font-size:18px;padding-top:7px;">ADVISER EMAIL</p>
										</div>
										
									</div>
							</div>
						</div>
							<div style="padding-left:20px;padding-top:15px" class="row">	
									<div style="padding-left:5px;">
										<span style="font-size:16px"><b><?php echo $adviser_email; ?></b></span><br><br>	
										
									</div>
								</div>
						 <div style="padding-right:15px;padding-left:15px;"  class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-10 col-xs-10">
											<p style="font-size:18px;padding-top:7px;">ADVISER CONTACT NUMBER</p>
										</div>
										
									</div>
							</div>
						</div>
							<div style="padding-left:20px;padding-top:15px" class="row">	
									<div style="padding-left:10px;">
										<span style="font-size:16px">
										<b><?php 
											if($adviser_contact == 00000000000){
											echo "Not Available";
											}else{
											echo '<b>'.$adviser_contact.'</b>';
											}
										
										?>
										</b></span><br><br>	
										
									</div>
								</div>
						<div style="padding-right:15px;padding-left:15px;"  class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-10 col-xs-10">
											<p style="font-size:18px;padding-top:7px;">ADVISER CONSULTATION HOURS</p>
										</div>
										
									</div>
							</div>
						</div>
							<div style="padding-left:20px;padding-top:15px" class="row">	
									<div style="">
										
										<b><?php //query muna ung consultation hours wait
											$q_consultation = "select * from adviser_consultation_hours where adviser_id='$adviser_id'";
											$q_consultation_res = $dbc->query($q_consultation);
											if($q_consultation_res->num_rows > 0){
												while($consultation = $q_consultation_res->fetch_assoc()){
												//convert ung kakaibang consultation time :v
													$temp_consultation_hour_start = $consultation['hour_start'];
													$temp_consultation_hour_end = $consultation['hour_end'];
													if($temp_consultation_hour_start == 7){$hour_start = "7:00 am";}
													if($temp_consultation_hour_start == 8){$hour_start = "7:30 am";}
													if($temp_consultation_hour_start == 9){$hour_start = "8:00 am";}
													if($temp_consultation_hour_start == 10){$hour_start = "8:30 am";}
													if($temp_consultation_hour_start == 11){$hour_start = "9:00 am";}
													if($temp_consultation_hour_start == 12){$hour_start = "9:30 am";}
													if($temp_consultation_hour_start == 13){$hour_start = "10:00 am";}
													if($temp_consultation_hour_start == 14){$hour_start = "10:30 am";}
													if($temp_consultation_hour_start == 15){$hour_start = "11:00 am";}
													if($temp_consultation_hour_start == 16){$hour_start = "11:30 am";}
													if($temp_consultation_hour_start == 17){$hour_start = "12:00 pm";}
													if($temp_consultation_hour_start == 18){$hour_start = "12:30 pm";}
													if($temp_consultation_hour_start == 19){$hour_start = "1:00 pm";}
													if($temp_consultation_hour_start == 20){$hour_start = "1:30 pm";}
													if($temp_consultation_hour_start == 21){$hour_start = "2:00 pm";}
													if($temp_consultation_hour_start == 22){$hour_start = "2:30 pm";}
													if($temp_consultation_hour_start == 23){$hour_start = "3:00 pm";}
													if($temp_consultation_hour_start == 24){$hour_start = "3:30 pm";}
													if($temp_consultation_hour_start == 25){$hour_start = "4:00 pm";}
													if($temp_consultation_hour_start == 26){$hour_start = "4:30 pm";}
													if($temp_consultation_hour_start == 27){$hour_start = "5:00 pm";}
													if($temp_consultation_hour_start == 28){$hour_start = "5:30 pm";}
													if($temp_consultation_hour_start == 29){$hour_start = "6:00 pm";}
													if($temp_consultation_hour_start == 30){$hour_start = "6:30 pm";}
													if($temp_consultation_hour_start == 31){$hour_start = "7:00 pm";}
													//hour end 
													if($temp_consultation_hour_end == 7){$hour_end = "7:00 am";}
													if($temp_consultation_hour_end == 8){$hour_end = "7:30 am";}
													if($temp_consultation_hour_end == 9){$hour_end = "8:00 am";}
													if($temp_consultation_hour_end == 10){$hour_end = "8:30 am";}
													if($temp_consultation_hour_end == 11){$hour_end = "9:00 am";}
													if($temp_consultation_hour_end == 12){$hour_end = "9:30 am";}
													if($temp_consultation_hour_end == 13){$hour_end = "10:00 am";}
													if($temp_consultation_hour_end == 14){$hour_end = "10:30 am";}
													if($temp_consultation_hour_end == 15){$hour_end = "11:00 am";}
													if($temp_consultation_hour_end == 16){$hour_end = "11:30 am";}
													if($temp_consultation_hour_end == 17){$hour_end = "12:00 pm";}
													if($temp_consultation_hour_end == 18){$hour_end = "12:30 pm";}
													if($temp_consultation_hour_end == 19){$hour_end = "1:00 pm";}
													if($temp_consultation_hour_end == 20){$hour_end = "1:30 pm";}
													if($temp_consultation_hour_end == 21){$hour_end = "2:00 pm";}
													if($temp_consultation_hour_end == 22){$hour_end = "2:30 pm";}
													if($temp_consultation_hour_end == 23){$hour_end = "3:00 pm";}
													if($temp_consultation_hour_end == 24){$hour_end = "3:30 pm";}
													if($temp_consultation_hour_end == 25){$hour_end = "4:00 pm";}
													if($temp_consultation_hour_end == 26){$hour_end = "4:30 pm";}
													if($temp_consultation_hour_end == 27){$hour_end = "5:00 pm";}
													if($temp_consultation_hour_end == 28){$hour_end = "5:30 pm";}
													if($temp_consultation_hour_end == 29){$hour_end = "6:00 pm";}
													if($temp_consultation_hour_end == 30){$hour_end = "6:30 pm";}
													if($temp_consultation_hour_end == 31){$hour_end = "7:00 pm";}
												//
												echo '
													<div class="">
													<div class="col-md-8 mb">
													<div style="border-left:8px solid #0c66ae;padding-left:45px;padding-top:5px;" class="transparent-panel-files pn-consultation">
														<span style="font-size:17px;padding-top:10px;" ><b>'.$consultation['day'].'</b></span><br>
														<span style="font-size:17px;padding-top:10px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$hour_start.' - '.$hour_end.'</b></span>	
													</div>
													</div>';
												}
											
											}
										
										?>
										</b></span><br><br>	
										
									</div>
								</div>										
							<?php
							}else{
								$no_adviser="No Records to Show. Please confirm your section at the E2E Office.";
								echo '
									<div class="">
									<div class="col-md-8 mb">
									<div style="padding-left:45px;padding-top:5px;" class="transparent-panel-files">
									<img src="assets/img/icon_warning.png" class="goleft img-circle" width="80">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span style="font-size:17px;padding-top:10px;" ><b>'.$no_adviser.'</b></span><br>
									</div>
									</div>';
								}
							?>
							
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
