<!DOCTYPE html>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//student number static for debugging purposes
include('session.php');
//student number static for debugging purposes
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
         <?php
include('sidebar.php');
?> <!--sidebar end-->
      
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
											<p style="font-size:25px;padding-top:7px;">EDIT To Do List</p>
										</div>
										
									</div>
							</div>
							<?php
								if(isset($_GET['error_empty'])){
											echo '
											<div style="padding-left:120px;">
											<div style="z-index:1;float:right;padding-left:15px;width:310px;height:20px;padding-top:0px;position:absolute;" class="alert alert-danger alert-dismissable">
											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											  <strong>Error: Required fields cannot be empty!</strong> 
											</div>
											</div>';
											
											}
									?>
						   </div>
						   <?php
								//get the dtr details here gayahin ung add sa app na mga details.. 12/6/2016*
								$entry_date1 = $_GET['journal_date'];
								$entry_date2 = strtotime($entry_date1);
								$format = "F d, Y";
								$formato = "D";
								$formatted_entry_date = date($format,$entry_date2);
								$formattedo_entry_date = date($formato,$entry_date2);
								//get working hours
								
								$total_hrs=0;
								$total_minutes = 0;

								//
								// get entry details
								$q_journal_entry ="SELECT * from journal where  id='$entry_date1'";
								$q_journal_entry_res = $dbc->query($q_journal_entry);
								$journal_entry= $q_journal_entry_res->fetch_assoc();
								$td_id=$journal_entry['id'];
								$stud=$journal_entry['stud_no'];
								$status=$journal_entry['status'];
							?>
							<h5>NAME OF Staff</h5>
							<h4><b><?php echo $stud; ?></b></h4>
							<h5>ENTRY DATE</h5>
							<h4><b><?php echo $formatted_entry_date; ?></b></h4>
							<form action="update_daily_journal.php" method="POST">
							<div class="col-sm-7 col-xs-7">
							<input type="hidden" name="stud_no" value="<?php echo $stud; ?>">
							<input type="hidden" name="date_submitted" value="<?php echo $entry_date1; ?>">
							<input type="hidden" name="td_id" value="<?php echo $td_id; ?>">
							<input type="hidden" name="semester" value="<?php echo $stud_current_sem; ?>">
							<h5>STATUS! <b style="color:red;">*</b></h5>
							 <select name='status' value="">
                 
                                            <option class="input focused" value="<?php echo $status ?>"   readonly>
                                            <?php echo $status ?></option>
                                            <option class="input focused" value="Ongoing"   required>
                                            On Going</option>
                                            <option class="input focused" value="Finish"   required>
                                            Finish</option>
                                         
                                            </select>

							<h5>TO DO! <b style="color:red;">*</b></h5>
							<div class="form-group">
							<textarea id="nature_of_activity" name="nature_of_activity" maxlength="120" class="form-control" rows=3><?php echo $journal_entry['skills_and_knowledge_used']; ?></textarea>
							</div>
							
							</div>
						</div>
							
							<div class="col-sm-7 col-xs-7">
							<button name="btn_update_journal" class="btn btn-primary" style="float:right;" type="submit">Update</button>
							<a href="journal.php" class="" style="font-size:14px;padding-top:10px;padding-right:10px;float:right;">Cancel</a>
							</div>
							</form>
						
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
