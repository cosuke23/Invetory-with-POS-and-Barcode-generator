<!doctype html>
<?php include('navbar_about.php'); ?>
<?php include'header.php'; ?>
<html><head>
    <meta charset="utf-8">
    <title>MSCO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Carlos Alvarez - Alvarez.is">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>



    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

  	<!-- Google Fonts call. Font Used Open Sans -->
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
  	
  	<!-- FullCalendar Files - JS & CSS Configuration -->


  	
  </head>
  <body>
  	<!-- NAVIGATION MENU -->

	<div class="container">

      <!-- CONTENT -->
		<div class="row">
      		<!-- Event Selector -->
											<div class="navbar navbar-inner block-header">
											<div class="muted pull-left">Calendar</div>
															<div id='calendar'></div>	
				</div>
        	</div><!-- /span3 -->

      		<!-- Calendar -->
        	<div class="col-sm-9 col-lg-9">
	        
				<div style="clear:both"></div>
			</div><!-- /span9 -->
	      </div><!-- /row -->
	   </div> <!-- /container -->
     <br>
    <!-- Footer -->
	<div id="footerwrap">
      	<footer class="clearfix"></footer>
      	<div class="container">
      		<div class="row">
      			<div class="col-sm-12 col-lg-12">


      			</div>

      		</div><!-- /row -->
      	</div><!-- /container -->		
	</div><!-- /footerwrap -->


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/admin.js"></script>
    

  
</body></html>
	<?php include('script.php'); ?>
	<?php include('admin_calendar_script.php'); ?>