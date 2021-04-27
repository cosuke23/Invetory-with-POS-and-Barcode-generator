<!DOCTYPE html>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//student number static for debugging purposes
include('session.php');
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
          <section class="wrapper site-min-height" >
		  
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
							<div style="padding-left:150px;padding-bottom:5px;" >
							 <?php	
										if(isset($_GET['added'])){
											echo '
											<div style="z-index:1;float:right;padding-left:15px;width:300px;position:absolute;" class="alert alert-success alert-dismissable">
											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											  <strong>Things to do successfully added!</strong> 
												</div>';
											}
										if(isset($_GET['updated'])){
											echo '
											<div style="z-index:1;float:right;padding-left:15px;width:300px;position:absolute;" class="alert alert-success alert-dismissable">
											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											  <strong>Things to do successfully updated!</strong> 
												</div>';
											}
										?>
							</div>
							<div style="padding-left:15px;color:red;" >
							</div>
							<br>
							
							<?php
							
							//get all journal entries
              if($stud_no!='admin'){
							$q_journals = "SELECT * from journal where stud_no='$stud_no'  order by id desc";
                }else{
                $q_journals = "SELECT * from journal  order by id desc";
              }
							$q_journals_res = $dbc->query($q_journals);
							if($q_journals_res->num_rows>0){
								while($journals=$q_journals_res->fetch_assoc()){
								$journal_date = $journals['id'];
								$journal_date2 = strtotime($journal_date);
								$format = "F d, Y";
								$formatted_journal_date = date($format,$journal_date2);
                $staff=$journals['stud_no'];
                $comander=$journals['comander'];

							?>
							<!-- journal Panel -->
								<div class="col-lg-8 col-md-8 col-sm-8 mb"  >
              <?php
                  if($comander=='admin'){
                ?>
									<div class="content-panel pn-journal" style="background:#67bbfc;" >

                  <?php
                }else{
                  ?>
<div class="content-panel pn-journal" style="background:#F8ff60;" >
                     <?php
                }
                ?> 
                  <?php
               
              
              //get all journal entries
              if($stud_no=='admin'){
                ?>
										<a href="edit_journal.php?journal_date=<?php echo $journal_date; ?>" style="float:right;padding-right:10px;"><i class="fa fa-pencil"></i></a>
                   <?php
              
              //get all journal entries
              }
                ?>
										<div style="font-size:20px;padding-left:5px; word-wrap: break-word; padding-right:5px;color:black;">
										(<?php echo $journals['status'] ?>)	<?php echo $journals['journal_entry'] ?>
										</div>
										
									</div>
                   <?php
if($comander=='admin'){
                ?>
									<div class="" style="font-size:14px;padding-left:5px;padding-top:5px;height:30px;bottom:10px;background:yellow;color:#ffffff;">
								
                          <?php
              
              //get all journal entries
              }else{
                ?>

<div class="" style="font-size:14px;padding-left:5px;padding-top:5px;height:30px;bottom:10px;background:#67bbfc;color:#ffffff;">
                       <?php
         
              
              //get all journal entries
              }
                ?>		<span style="font-size: 20px;color:black"> <?php echo $staff; ?> </span>
                    <span class="pull-right" style="color:black"> <?php echo $formatted_journal_date; ?> </span>
									</div>
								</div><!--end journal panel-->
								
							<?php
								}
							}else{
								echo '<h4>No records to show.</h4>';
							}
							?>
							

							<a href="create_journal_entry.php" style="padding-top:3px;position:fixed;font-size:45px;width:70px;height:70px;bottom:70px;right:50px;" class="img-circle pn-journal-add centered"><b>+</b></a>
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
