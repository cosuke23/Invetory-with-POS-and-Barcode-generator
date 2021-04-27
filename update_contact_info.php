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
											<p style="font-size:20px;padding-top:7px;">UPDATE CONTACT INFORMATION</p>
										</div>
									</div>
									</div><!-- /weather-2 header -->
								<form action="update_contact_info_process.php" method="POST" id="d_form" enctype="multipart/form-data">
									<input type="hidden" name="this_stud_no" value="<?php echo $stud_no; ?>">
									<div class="row" style="padding-top:20px">
									 <div class="col-md-3">
										<h5 style="padding-left:5px;">Email:</h5>
										<div class="form-group has-feedback">
											<input class="form-control" type="text" id="nw_email" name="nw_email" value="<?php echo $email; ?>"/>
										</div>
									</div>
									
									<div class="col-md-3">
										<h5 style="padding-left:5px;">Mobile Number:</h5>
										<div class="form-group has-feedback">
											<input class="form-control" type="text" id="nw_mobile_no" name="nw_mobile_no" value="<?php echo $mobile_no; ?>"/>
										</div>
									</div>
									
									<div class="col-md-3">
										<h5 style="padding-left:5px;">Facebook:</h5>
										<div class="form-group has-feedback">
											<input class="form-control" type="text" id="nw_fb" name="nw_fb" value="<?php echo $fb; ?>"/>
										</div>
									</div>
									
									<div class="col-md-3">
										<h5 style="padding-left:5px;">Home Address:</h5>
										<div class="form-group has-feedback">
											<textarea class="form-control" id="nw_address" name="nw_address"  rows="2"><?php echo $address; ?></textarea>
										</div>
									</div>
									
									</div>
									<div class="row">
									<div class="col-md-6">
										<div class="form-group has-feedback">
											<button type="submit" name="btn_update_info" class="btn btn-default"><span class="fa fa-save"></span>&nbsp;Save Changes</button>
										</div>
									</div>
									</div>
									
									
									
								</form>
							</div>
						</div><!--/col-md-4 -->
		  </div>
		</section><!--/wrapper -->
		
      </section><!--/MAIN CONTENT -->

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
	<script src="assets/js/bootstrapValidator.js"></script>
	<script src="assets/js/plugins/jquery.validate.min.js"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    <script type="text/javascript">
		$(document).ready(function(){
			$('#d_form')
			.bootstrapValidator({
            message: 'This value is not valid',
            
        fields:
		{
			nw_email:
			{
                validators:
					{
                        notEmpty:
							{},
						emailAddress:
							{
								message: 'Invalid email address'
							},
                        regexp:
							{
								regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
								
							},
                        stringLength:
							{
								max: 100,
							},
					}
			},
			nw_mobile_no: {
                    validators: {
                        notEmpty: {},
            regexp: {
                            regexp: /[0-9]+$/,
                    },
            stringLength: {
                            min: 11,
                            max: 11,
                        }
                    }
                },
				nw_fb: {
                    validators: {
					//notEmpty: {},
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    },
                },
				nw_address: {
                    validators: {
                        notEmpty: {},
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    }
                },
		}
			});
		});
	</script>
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
