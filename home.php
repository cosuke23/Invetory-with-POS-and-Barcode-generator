<!DOCTYPE html>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
include('session.php');
//student number static for debugging purposes***

//get student info
$user_query = mysqli_query($conn,"SELECT * from user where user_id= '$session_id'")or die(mysqli_error());
$user_row = mysqli_fetch_array($user_query);
//get student course
if($user_row['username'] ='cojul'){

  $stud_id="Creator";
}

if($stud_info['user_id']=2){
$stud_program_id="Staff";
} 

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>JMCT</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
       <link rel="icon" href="assets/img/img_step.jpg">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<?php
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
		?>
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
            <a href="home.php" class="logo" style="font-size:25px"><b</b></a>
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
		  <div class="row">
			<div class="col-lg-13 col-md-13 col-sm-13 mb">
				<div class="row">

				</div>
			</div>
		  </div>
        <h4><i class="fa fa-angle-right"></i> Welcome,<?php echo $title; ?> <?php echo $studname; ?></h4>
      <?php
      $user_query = mysqli_query($conn,"SELECT * from user where user_id = '$session_id'")or die(mysqli_error());
$user_row = mysqli_fetch_array($user_query);

$admin = $user_row['username'];
$id = $user_row['user_id'];
$usr_lvl = $user_row['user_level'];
if($usr_lvl!=1){
?>

         
		
        <?php 
      }else{
      ?>

    <!-- /col-md-3 -->
				<div class="col-md-5 mb">
						<a href="admin/calendar_of_events.php"><div style="padding-right:15px" class="transparent-panel pn">
							<p><img src="assets/img/calendar.jpg" class="img-circle" width="100"></p>
							<p style="font-size:15px;padding-top: 10px;"><b>Calender of Events</b></p>	
						</div><a href="">
				</div><!-- /col-md-3 -->
			  <?php 
      }
      ?>
				<div class="col-md-5 mb">
						<a href="e2e_view_items.php"><div style="padding-right:15px" class="transparent-panel pn">
							<p><img src="assets/img/procedure.jpg" class="img-circle" width="100"></p>
							<p style="font-size:15px;padding-top: 10px;"><b>INVENTORY</b></p>	
						</div><a href="">
				</div><!-- /col-md-3 -->
                    <?php
      $q_studinfo ="SELECT * from admin_info where username='$session_id'";
$q_studinfo_res = $dbc->query($q_studinfo);
$studinfo = $q_studinfo_res->fetch_assoc();
$admin = $studinfo['admin_id'];
if($stud_no==1){
?>
				<div class="col-md-5 mb">
						<a href="admin_201_files.php"><div style="padding-right:15px" class="transparent-panel pn">
							<p><img src="assets/img/ojt_files.jpg" class="img-circle" width="100"></p>
							<p style="font-size:15px;padding-top: 10px;"><b>201 FILES</b></p>	
						</div><a href="">
				</div><!-- /col-md-3 -->
          <div style="<?php echo $with_comp_icon; ?>" class="col-md-5 mb">
            <a href="201_files.php"><div style="padding-right:15px" class="transparent-panel pn">
              <p><img src="assets/img/upload_resume.jpg" class="img-circle" width="100"></p>
              <p style="font-size:15px;padding-top: 10px;"><b>FORMS</b></p> 
            </div><a href="">
        </div><!-- /col-md-4 -->
        </div>

       <?php 
      }else{
      ?>        
  <div class="col-md-5 mb">
            <a href="201_files.php"><div style="padding-right:15px" class="transparent-panel pn">
              <p><img src="assets/img/ojt_files.jpg" class="img-circle" width="100"></p>
              <p style="font-size:15px;padding-top: 10px;"><b>201 FILES</b></p> 
            </div><a href="">
        </div>
 <?php 
      }
      ?>  
            <?php
      $q_studinfo ="SELECT * from admin_info where username='$session_id'";
$q_studinfo_res = $dbc->query($q_studinfo);
$studinfo = $q_studinfo_res->fetch_assoc();
$admin = $studinfo['admin_id'];
if($stud_no!=1){
?>
				<div style="<?php echo $with_comp_icon; ?>" class="col-md-5 mb">
						<a href="upload_resume.php"><div style="padding-right:15px" class="transparent-panel pn">
							<p><img src="assets/img/upload_resume.jpg" class="img-circle" width="100"></p>
							<p style="font-size:15px;padding-top: 10px;"><b>Upload OJT Resume</b></p>	
						</div><a href="">
				</div><!-- /col-md-4 -->
				</div><!-- /row mt -->
			
			 <?php 
      }
      ?>	
			</div>
      <!-- /row mt -->
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
