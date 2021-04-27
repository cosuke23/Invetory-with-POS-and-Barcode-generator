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
$stud_program_id = $studinfo['course'];
if($stud_program_id==1){

  $stud_course='BSIT';
}else if($stud_program_id==2){

  $stud_course='BSHRM';
}else if($stud_program_id==3){

  $stud_course='BSHRM';
}else if($stud_program_id==4){

  $stud_course='BSHRM';
}else if($stud_program_id==5){

  $stud_course='BSAT';
}else if($stud_program_id==6){

  $stud_course='BSTM';
}else if($stud_program_id==7){

  $stud_course='BSTM';
}else if($stud_program_id==8){

  $stud_course='BSIT';
}else if($stud_program_id==9){

  $stud_course='BSIT';
}else if($stud_program_id==10){

  $stud_course='BSIT';
}else if($stud_program_id==11){

  $stud_course='BSIT';
}else if($stud_program_id==12){

  $stud_course='BSIT';
}else{
  $stud_course='NONE';
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>APOSYS</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
         <link rel="icon" href="assets/img/img_step.jpg">
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
      <?php include('sidebar.php'); ?>
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
											<p style="font-size:25px;padding-top:7px;">Things To Do</p>
										</div>
										
									</div>
							</div>
							<div style="padding-left:150px;padding-bottom:5px;">
							 <?php	
										if(isset($_GET['added'])){
											echo '
											<div style="z-index:1;float:right;padding-left:15px;width:300px;position:absolute;" class="alert alert-success alert-dismissable">
											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											  <strong>Journal entry successfully recorded!</strong> 
												</div>';
											}
										if(isset($_GET['updated'])){
											echo '
											<div style="z-index:1;float:right;padding-left:15px;width:300px;position:absolute;" class="alert alert-success alert-dismissable">
											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											  <strong>Journal entry successfully updated!</strong> 
												</div>';
											}
										?>
							</div>
							<div style="padding-left:15px">
							</div>
							<br>
							
					<div id='calendar'></div>
								
							
							
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
<?php include('admin_calendar_script.php'); ?>
<?php include('script.php'); ?>
  </body>
</html>
