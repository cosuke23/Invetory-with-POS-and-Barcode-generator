<!DOCTYPE html>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//student number static for debugging purposes

 include('session.php');

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

    <link rel="icon" href="assets/img/img_stepsg.png">
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
            <a href="home.php" class="logo" style="font-size:25px"><b>APOSYS</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
               
            </div>
           
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
   <?php include('sidebar.php'); ?>   <!--sidebar end-->
      
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
											<p style="font-size:20px;padding-top:7px;">CHANGE PICTURE</p>
										</div>
									</div>
									</div><!-- /weather-2 header -->
								
						</div><! --/col-md-4 -->
						<div style="padding-left:20px;padding-top:15px" class="row">
									<img src=<?php echo "files/student_pics/".$stud_no.".jpg"; ?> class="img-circle" height="150" width="150">	
									<div style="padding-top:10px;"></div>
									
									 <?php
										if(isset($_GET['error_invalid'])){
											echo '<div class="alert alert-danger">
												<span>Oops! You have selected an invalid file format. Please make sure that you select an image file.</span>
											</div>';
										}if(isset($_GET['error_no_file'])){
											echo '<div class="alert alert-danger">
												<span>There was no file selected.</span>
											</div>';
										}
							
							?>
									<div style="padding-top:15px;">
									<form action="change_picture_process.php" method="POST" enctype="multipart/form-data">
										<input type="hidden" name="stud_no" value="<?php echo $stud_no; ?>">
										<input class="" type="file" accept="image/*" name="nw_pic">
										<div style="padding-top:15px;">
										<input  type="submit" class="btn btn-default" value="Upload Picture" name="btn_change_pic">
										</div>
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
