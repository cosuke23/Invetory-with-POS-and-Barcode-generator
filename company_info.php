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
//get company information
$comp_id = $_GET['comp_id'];
$q_comp_info= "select * from company_info where comp_id = '$comp_id'";
$q_comp_info_res = $dbc->query($q_comp_info);
$comp_info = $q_comp_info_res->fetch_assoc();
//get company_pic

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
											<p style="font-size:18px;padding-top:7px;">COMPANY INFORMATION</p>
										</div>
										
									</div>
							</div><br>
							
								<img class="" style="" src=<?php echo "../files/company/".$comp_id.".jpg"; ?> width="150" height="150"></br>
								<span style="font-size:25px;"><b><?php echo $comp_info['comp_name']; ?></b></span></br>
								<span style="font-size:15px;"><?php echo $comp_info['address']; ?></span></br></br></br>
								<span style="font-size:15px;"><?php echo $comp_info['comp_desc']; ?></span></br>
								
								<div style="padding-top:20px">
									<div class="weather-2-header row">
										<div class="">
											<div class="col-sm-10 col-xs-10">
												<p style="font-size:18px;padding-top:7px;">PROGRAMS OFFERED</p>
											</div>
										</div>
									</div><!-- /weather-2 header -->
									<?php
										//get comp programs
										$q_comp_programs= "select * from company_program where comp_id='$comp_id' and comp_program_status='Active'";
										$q_comp_programs_res = $dbc->query($q_comp_programs);
										if($q_comp_programs_res->num_rows>0){
										while($comp_prog_id = $q_comp_programs_res->fetch_assoc()){
											$prog_id = $comp_prog_id['program_id'];
											//get program names
											$q_progname = "select * from program_list where program_id='$prog_id'";
											$q_progname_res= $dbc->query($q_progname);
											$progname= $q_progname_res->fetch_assoc();
											$program_name = $progname['program_name'];	
											echo
												'<div style="padding-top:20px">
													<span  style=";font-size:17px"><b>'.$program_name.'</b></span>
												</div style="padding-top:20px">';
												
										}
										}else{
											$program_name = "Not Specified";
											echo '<div style="padding-top:20px">
													<span  style=";font-size:17px"><b>'.$program_name.'</b></span>
												</div style="padding-top:20px">';
										}
									?>
										
										
									</div>
								
								<div style="padding-top:20px">
									<div class="weather-2-header row">
										<div class="">
											<div class="col-sm-10 col-xs-10">
												<p style="font-size:18px;padding-top:7px;">DATE NOTARY</p>
											</div>
										</div>
									</div><!-- /weather-2 header -->
									<?php
										if($comp_info['date_notary'] == "1970-01-01"){
											$formatted_notary_date = "N/A";
										}else{
											$cmp_notary = $comp_info['date_notary'];
											$cmp_notary2 = strtotime($cmp_notary);
											$format = "F d, Y";
											$formatted_notary_date = date($format,$cmp_notary2);
										}
									?>
									<span  style="font-size:17px"><b><?php echo $formatted_notary_date; ?></b></span>
								</div>
								<div style="padding-top:20px">
									<div class="weather-2-header row">
										<div class="">
											<div class="col-sm-10 col-xs-10">
												<p style="font-size:18px;padding-top:7px;">DATE EXPIRY</p>
											</div>
										</div>
									</div><!-- /weather-2 header -->
									<?php
										if($comp_info['date_expiry'] == "1970-01-01"){
											$formatted_expiry_date = "N/A";
										}else{
											$cmp_expiry = $comp_info['date_expiry'];
											$cmp_expiry2 = strtotime($cmp_expiry);
											$format = "F d, Y";
											$formatted_expiry_date = date($format,$cmp_expiry2);
										}
									?>
									<span  style="font-size:17px"><b><?php echo $formatted_expiry_date; ?></b></span>
								</div>
								<div style="padding-top:20px">
									<div class="weather-2-header row">
										<div class="">
											<div class="col-sm-10 col-xs-10">
												<p style="font-size:18px;padding-top:7px;">REMARKS</p>
											</div>
										</div>
									</div><!-- /weather-2 header -->
									
									<span  style="font-size:17px"><b><?php echo $comp_info['remarks']; ?></b></span>
								</div>
									<div style="padding-top:20px">
										
									<div style="" class="weather-2-header row">
										<div class="">
											<div class="col-sm-10 col-xs-10">
												<p style="font-size:18px;padding-top:7px;">CONTACT PERSON</p>
											</div>
										</div>
									</div><!-- /weather-2 header -->
												<span style="font-size:14px;padding-top:7px;"><?php echo $comp_info['position']; ?></span><br>
												<span style="font-size:17px;"><b><?php echo $comp_info['contact_person']; ?></b></span>
											<br><br>
												<span style="font-size:14px;padding-top:7px;">E-MAIL ADDRESS</span><br>
												<span style="font-size:17px;"><b><?php echo $comp_info['email']; ?></b></span>
											<br><br>
												<span style="font-size:14px;padding-top:7px;">CONTACT NUMBER</span><br>
												<span style="font-size:17px;"><b><?php echo $comp_info['tel_no']; ?></b></span>
									
								</div>
								<div style="padding-top:20px">
									<div style="" class="weather-2-header row">
										<div class="">
											<div class="col-sm-10 col-xs-10">
												<p style="font-size:18px;padding-top:7px;">OJT OFFERS</p>
											</div>
										</div>
									</div><!-- /weather-2 header -->
									<?php
									//get offers
									$q_ojtoffers = "select * from ojt_offers where comp_id='$comp_id'";
									$q_ojtoffers_res = $dbc->query($q_ojtoffers);
									if($q_ojtoffers_res->num_rows>0){
										while($ojtoffers = $q_ojtoffers_res->fetch_assoc()){
										echo '
													<a href="view_offer.php?ojt_offers_id='.$ojtoffers['ojt_offers_id'].'">
													<div class="col-md-7 mb">
													<div style="border-left:8px solid #0c66ae;padding-left:20px;padding-top:10px;" class="transparent-panel-files pn-consultation">
														<span style="font-size:15px;" ><b>'.$ojtoffers['ojt_title'].'</b></span>
														
													</div>
													</div>
													</a>';
										}
									}else{
										echo '<span  style=";font-size:17px">Nothing to show.</b></span>';
									}
									?>
									</div>
										</div><!-- /weather-2 header -->
									

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
