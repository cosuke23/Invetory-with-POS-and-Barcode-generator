<!DOCTYPE html>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
include('session.php');
//student number static for debugging purposes***

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
											<p style="font-size:25px;padding-top:7px;">UPLOAD RESUME</p>
										</div>
										
									</div>
							</div><br>
							</div>
							<?php
								if(isset($_GET['error_invalid'])){
									echo '<div class="alert alert-danger">
										<span>Oops! You have selected an invalid file format. Please make sure that you select a file with .docx file extension.</span>
									</div>';
								}if(isset($_GET['error_no_file'])){
									echo '<div class="alert alert-danger">
										<span>There was no file selected.</span>
									</div>';
								}
							
							?>
						  </div>
						</div>
						<?php
							
							//check if the student has resume data
							$q_check_resume = "SELECT * from student_resume_data where stud_no='$stud_no'";
							$q_check_resume_res = $dbc->query($q_check_resume);
							$check_resume= $q_check_resume_res->fetch_assoc();
							$resume_data= $check_resume['resume_status'];
							$resume_remarks = $check_resume['resume_remarks'];
							
							if(!empty($resume_document64)){
								$resume_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
							}
							if($resume_data == 0){//no resume data
							?>
								<img src="assets/img/icon_warning.png" class="goleft img-circle" width="80">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span style="font-size:17px;">No resume uploaded yet.</span><br><br>
								<form action="upload_resume_process.php" method="POST" enctype="multipart/form-data">
									<input type="hidden" value="<?php echo $stud_no; ?>" name="stud_no" />
									<input id="resume_file" accept=".docx" type="file" name="resume_file"/>
								<br>
								<span style="font-size:17px;">Only Microsoft Word documents with the <b>*.docx</b> file extension are supported.</span></br>
								<span style="font-size:17px;">Make sure to check on this page for your resume feedback.</span></br><br>
									<input class="btn btn-default" type="submit" value="Submit Resume" name="btn_submit_resume">
								</form>
						<?php	
							}
							if($resume_data == 1){//pending
							?>
								<img src="assets/img/check.png" class="goleft img-circle" width="80">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span style="font-size:17px;">Your resume has already been uploaded and is now waiting for approval.</span><br><br>
								<br>
								<span style="font-size:17px;">Make sure to check on this page for your resume feedback. No further action is required.</span></br><br>
								
							
						<?php	
							}
							if($resume_data == 2){ //approved
							?>
								<img src="assets/img/check.png" class="goleft img-circle" width="80">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span style="font-size:17px;">Your resume has already been <b>approved</b>!</span><br><br>
								<br>
								<span style="font-size:17px;">You may click on link below to download your approved resume:</span></br><br>
								<div class="">
									
									<?php echo '<a href="files/resume/'.$stud_no.'.docx" download="'.$stud_no.'">'; ?>
									<button style="padding-left:25px;padding-top:12px;" class="btn btn-default">
										<span style="font-size:15px;padding-top:10px;" ><b>Download Resume</b></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<img src="assets/img/download_icon.png" class="goleft img-circle" width="25">
										
									</button></a>
								
						<?php	
							}
							if($resume_data == 3){//reject
							?>
								<img src="assets/img/icon_warning.png" class="goleft img-circle" width="80">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span style="font-size:17px;">The resume that you uploaded earlier has been <b>rejected</b></span><br><br>
									<div class="alert alert-warning" width="" style="word-wrap: break-word;">
										<span style="font-size:17px;">Feedback: <?php echo nl2br($resume_remarks); ?></span>
									</div>
								<form action="upload_resume_process.php" method="POST" enctype="multipart/form-data">
									<input type="hidden" value="<?php echo $stud_no; ?>" name="stud_no" />
									<input id="resume_file" accept=".docx" type="file" name="resume_file"/>
								<br>
								<span style="font-size:17px;">Only Microsoft Word documents with the <b>*.docx</b> file extension are supported.</span></br>
									<input class="btn btn-default" type="submit" value="Submit Resume" name="btn_update_resume">
								</form>
						<?php
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
