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
    <?php
include('sidebar.php');
?>  <!--sidebar end-->
      
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
					
						   </div>
						
						
							<h5>NAME OF STAFF</h5>
        
							
							<form action="insert_daily_journal.php" method="POST">
				
        			<div class="col-sm-7 col-xs-7">
              <?php
              if($stud_no=='admin'){
                ?>
				      <select name='admin' value="<?php echo $row['admin_id']; ?>">
                                          <?php
                                          $date_today=date('Y-m-d');
                $query = mysql_query("SELECT * from admin_info ")or die(mysql_error());
                while($row = mysql_fetch_array($query)){
                ?>
                                            <option class="input focused" value="<?php echo $row['admin_id']; ?>"   required><?php echo $row['admin_id']; ?>
                                            <?php
                                          }
                                            ?>
                                            </select>
<?php
}else{
?>
<h5><?php echo $full; ?></h5>
<input type="hidden" name="admin" value="<?php echo $stud_no; ?>">
<?php
}
?>
							<input type="hidden" name="date_submitted" value="<?php echo $date_today; ?>">
							
							<h5>Task to do! <b style="color:red;">*</b></h5>
							<div class="form-group">
							<textarea id="skills_and_knowledge_used" name="skills_and_knowledge_used" maxlength="120" class="form-control" rows=3></textarea>
							</div>
							
						
							</div>
						</div>
							
							<div class="col-sm-7 col-xs-7">
							<button name="btn_submit_journal" class="btn btn-primary" style="float:right;" type="submit">Submit</button>
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