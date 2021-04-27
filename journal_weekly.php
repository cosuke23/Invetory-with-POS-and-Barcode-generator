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
											<p style="font-size:25px;padding-top:7px;">MY JOURNAL</p>
										</div>
										
									</div>
							</div>
							<div style="padding-left:15px">
							<a  class="btn btn-primary" href="journal.php">Daily</a>
							<a  class="active btn btn-primary" href="journal_weekly.php">Weekly</a>
							</div>
							<br>
							</div>
							
							<?php
							
							//get all journal entries
							$q_journals = "select * from journal where stud_no='$stud_no' and semester='$stud_current_sem' and acad_year_start='$stud_current_acadyrstart' and type='Weekly' order by date_submitted";
							$q_journals_res = $dbc->query($q_journals);
							if($q_journals_res->num_rows>0){
								while($journals=$q_journals_res->fetch_assoc()){
								$journal_date = $journals['date_submitted'];
								$week_no = $journals['week_no'];
								$entry_weekstart = strtotime($journal_date) + 86400;
								$entry_weekstart2 = $entry_weekstart - 604800;
								$entry_date2 = strtotime($journal_date);
								$format = "F d, Y";
								
								$formatted_entry_date = date($format,$entry_date2);
								$formatted_entry_weekstart = date($format,$entry_weekstart2);
							
							?>
							<!-- journal Panel -->
								<div class="col-lg-8 col-md-8 col-sm-8 mb">
									<div class="content-panel2 pn-journal">
										<a href="edit_weekly_journal.php?weekly_journal_date=<?php echo $journal_date; ?>" style="color:#ffffff;float:right;padding-right:10px;">Edit <i class="fa fa-pencil"></i></a>
										<div style="font-size:14px;padding-left:5px; word-wrap: break-word; padding-right:5px;color:#ffffff;">
											<?php echo $journals['journal_entry'] ?>
										</div>
										
									</div>
									<div class="" style="font-size:13px;padding-left:2px;padding-top:5px;bottom:10px;background:#ffff80;">
											
											<span style="word-wrap: break-word;"> <?php echo 'Week# '.$week_no.': '.$formatted_entry_weekstart.' - '.$formatted_entry_date; ?></span>
											<?php
												$q_download_journal = "select setting from preferences;";
												$q_download_journal_res = mysqli_query($dbc,$q_download_journal);
												$row = mysqli_fetch_array($q_download_journal_res);
												$setting = $row[0];
												if($setting == 0){
													echo '<span style="float:right;padding-right:2px;word-wrap: break-word;background:#ffff80;">Download PDF  <i style="color:#000000" class="glyphicon glyphicon-print"></i></span>';
												
												}else{
													echo '<a href="../backend/download_journal/download_journal_main/weekly_journal.php?weekly_date='.$journal_date.'&stud_no='.$stud_no.'&acad_year_start='.$stud_current_acadyrstart.'&semester='.$stud_current_sem.'&week_num='.$week_no.'" style="float:right;padding-right:2px;word-wrap: break-word;background:#ffff80;">Download PDF  <i style="color:#000000" class="glyphicon glyphicon-print"></i></a>';
												}
											?>
											
										
									</div>
								</div><!--end journal panel-->
								
							<?php
								}
							}else{
								echo '<h4>No records to show.</h4>';
							}
							?>
							
							<a href="add_weekly_journal_date_select.php" style="padding-top:3px;position:fixed;font-size:45px;width:70px;height:70px;bottom:70px;right:50px;" class="img-circle pn-journal-add centered"><b>+</b></a>
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
