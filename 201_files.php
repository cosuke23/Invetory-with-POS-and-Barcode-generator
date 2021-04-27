<!DOCTYPE html>
<?php

 include('db.php');
 include('session.php');
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
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
                      <p style="font-size:25px;padding-top:7px;">201 FILES</p>
                    </div>
                    
                  </div>
              </div><br>
              </div>
              <span style="font-size:15px;">Take note that you need the proper applications to view these files</span></br><br>
              <span style="font-size:15px;">Please click to download:</span><br>
              </div>
             
              <?php
                $user_query = mysql_query("SELECT * from student_resume_data where stud_no='$stud_no'")or die(mysql_error());
$num_rows=mysql_num_rows($user_query);
                if($num_rows >0){
                  while($user_row = mysql_fetch_array($user_query)){
                  $file_name = $user_row['stud_no'];
                  $file_desc=$user_row['stud_no'];
                  echo '
                  <div class="">
                  <div class="col-md-8 mb">
                  <a href="files/resume/'.$file_name.'.docx"><div style="padding-left:25px;padding-top:5px;" class="transparent-panel-files pn-files">
                    <img src="assets/img/icon_files.png" class="goleft img-circle" width="50">
                    <span style="font-size:15px;padding-top:10px;" ><b>'.$file_desc.'</b></span>  
                  </div></a>
                  </div>';
                  
                  
                  
                  
                  }
      

                }
              
              ?>

                <?php
                $user_query = mysql_query("SELECT * from ojt_softcopy_files order by fileID desc ")or die(mysql_error());
$num_rows=mysql_num_rows($user_query);
                if($num_rows >0){
                  while($user_row = mysql_fetch_array($user_query)){
                  $file_name = $user_row['fileName'];
                  $file_desc=$user_row['fileDescription'];
                  echo '
                  <div class="">
                  <div class="col-md-8 mb">
                  <a href="files/downloadables/'.$file_name.'"><div style="padding-left:25px;padding-top:5px;" class="transparent-panel-files pn-files">
                    <img src="assets/img/icon_files.png" class="goleft img-circle" width="50">
                    <span style="font-size:15px;padding-top:10px;" ><b>'.$file_desc.'</b></span>  
                  </div></a>
                  </div>';
                  
                  
                  
                  
                  }
      

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
