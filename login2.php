<?php
date_default_timezone_set('Asia/Manila');
if(isset($_COOKIE["sid"])) {
	header ("Location: home.php");
	exit;
}
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);


if(isset($_GET['stud_no']))
{
	$stud_no = $_GET['stud_no'];
}
?>
<!DOCTYPE html>
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

      <!--**********************************************************************************************************************************************************
      MAIN CONTENT
      ***********************************************************************************************************************************************************-->
<br>
<br>
<br>
<br>
<br>

<br>
<br>
<br>
<br>
	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" id="form-login" action="login_process.php" method="post">
		        <h2 class="form-login-heading">Sign in now</h2>
		        <div class="login-wrap">
					<?php 
					if(isset($_GET['error']))
					{
						print '<label style="font-size:14px;color:red;">&nbsp;<b>Password incorrect</b></label>';
					}
					?>
		            <br>
					<input type="hidden" name="stud_no" value="<?php echo $stud_no;?>"/>
		            <input type="password" name="pass" class="form-control" placeholder="Password" required autofocus/>
		            <label class="checkbox">
		                <span class="pull-right">
		                    <!--<a href="http://my.sticaloocan.edu.ph/ojtassisti/web/forget_pass_request.php"> Forgot Password?</a>-->	
							<a onclick="window.open(this.href); return false;" href="forget_pass_request.php" > Forgot Password?</a>
						</span>
		            </label>
		            <button class="btn btn-primaryo btn-block" id="btn-login2" name="btn-login2" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
		            <hr>
					
		 
		        </div>
		
		         
		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/e2efooter.jpg", {speed: 500});
    </script>
  </body>
</html>
