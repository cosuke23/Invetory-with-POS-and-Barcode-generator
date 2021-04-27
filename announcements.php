<!DOCTYPE html>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//student number static for debugging purposes
require 'session.php';
//get student info

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
    <link rel="icon" href="assets/img/img_steps.png">
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
    <?php
include('sidebar.php');
?>
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
											<p style="font-size:25px;padding-top:7px;">ANNOUNCEMENTS</p>
										</div>
										
									</div>
							</div><br>
							</div>
							<span style="font-size:15px;">Previous announcements or posts from your adviser and E2E officer will be shown here.</span></br><br>
							
						<?php
								$q_messages = "SELECT * from annoucement  order by date desc";
								$q_messages_res = $dbc->query($q_messages);
								if($q_messages_res->num_rows >0){
									while($messages=$q_messages_res->fetch_assoc()){
									$msg_sender = $messages['ann_name'];
									$msg_date = $messages['date'];
									$msg_date2 = strtotime($msg_date);
									$format = "F d, Y";
									$formatted_date = date($format,$msg_date2);
									$msg_content = $messages['content'];
									echo '
									
									<div class="col-lg-8 col-md-8 col-sm-8 mb">
										<div id="announce" style="padding-left:15px;padding-top:5px;" class="transparent-panel-files pn-announce">
											<div style="font-size:15px;padding-left:5px; word-wrap: break-word; padding-right:5px;">
												<b>'.$msg_sender.'</b>
											</div>
											<div style="font-size:12px;padding-left:5px; word-wrap: break-word; padding-right:5px;">
												<b>Date Posted: '.$formatted_date.'</b>
											</div>
											<div style="font-size:14px;padding-top:15px;padding-left:5px; word-wrap: break-word; padding-right:5px;white-space:pre-line">
												<b>'.$msg_content.'</b>
											</div>
									</div>
									</div>';
									}
								}else{
									echo '<div style="padding-top:15px;">
											<span style="font-size:20px;padding-top:10px;" ><b>No announcements to show.</b></span><br>
										  </div>';
								}
								
							
							?>
						
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
