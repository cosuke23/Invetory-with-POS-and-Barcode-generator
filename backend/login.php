<?php

// Start the session..

//session_start();

$page_title = 'OJT AssiSTI Login Page';

if(isset($_COOKIE["uid"])) {

	header ("Location: home.php");

	exit;

}

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';

//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

?>

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="keyword" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OJT assiSTI</title>

  <!-- start: Css -->

  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">





  <!-- plugins -->

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/nouislider.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/select2.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/ionrangeslider/ion.rangeSlider.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/ionrangeslider/ion.rangeSlider.skinFlat.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/bootstrap-material-datetimepicker.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/spinkit.css"/>

  <link href="asset/css/style.css" rel="stylesheet">

  <!-- end: Css -->



  <link rel="shortcut icon" href="asset/img/ojtassistilogo.png">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      <![endif]-->

	  

	  <?php

			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");

		?>

    </head>



    <body id="mimin" class="dashboard form-signin-wrapper">

      <div class="container">

        <div  class="form-signin">

          <div class="panel periodic-login">

              <span class="atomic-number">WELCOME!</span>

              <div class="panel-body text-center">

                  <div>

                  <img src="asset/img/ojtassistilogo.png" alt="OJT assiSTI Logo" >

                   </div>

      				   <div id="error">

      						<!-- error will be shown here ! -->

      				   </div>

					   

					   <?php

					   if(isset($_POST["btn-login"])) {

						sleep(2);

						$username = $_POST["validate_username"];

						$password = $_POST["validate_password"];

						$sqlcu = $dbc->query("SELECT * FROM user WHERE BINARY username = '$username' AND BINARY password = '$password'");

						if($sqlcu->num_rows != 0) {

							$cr = $sqlcu->fetch_assoc();

							if($cr['usertype']==1)

							{	setcookie('uid',$cr["username"],time() + 86400);

								setcookie('ut',1,time() + 86400);

								header ("Location: admin_home.php?admin_id=$username");

								exit;

							}

              if($cr['usertype']==3)

              { setcookie('uid',$cr["username"],time() + 86400);

                setcookie('ut',1,time() + 86400);

                header ("Location: admin_homes.php?admin_id=$username");

                exit;

              }

							if($cr['usertype']==2)

							{

								setcookie('uid',$cr["username"],time() + 86400);

								setcookie('ut',$cr["usertype"],time() + 86400);

								header ("Location: adviser_home.php?adviser_id=$username");

								exit;

							}

						}

						else {

							setcookie('error','1',time() + 86400);

							header ("Location: logins.php");

							exit;		

						}

					}

					  ?> 

					   

					        <form id="signupForm" method="POST" class="form-signin">

							<div class="form-group form-animate-text" style="margin-top:40px !important;" >

                            

							<input type="text" class="form-text" id="validate_username" name="validate_username">

                              <span class="bar"></span>

                              <label class="customlabel">Username</label>

                            </div>

                            <div class="form-group form-animate-text" style="margin-top:40px !important;">

                              <input type="password" class="form-text" id="validate_password" name="validate_password" maxlength="32">

                              <span class="bar"></span>

                              <label class="customlabel">Password</label>

                            </div>                     

                             <button type="submit" class="btn btn-primary btn-info btn-lg btn-block" name="btn-login" id="btn-login">

              							<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In

              							</button> 

                      </form>

              </div>

                <div class="text-center">

                    <a href="user_forget_pass_request.php" ><label style="color:#f2f2f2;"> Forgot Password ? Click here! </label> </a>

                </div>

				

          </div>

        </div>

      </div>

      <!-- end: Content -->

      <!-- start: Javascript -->

      <script src="asset/js/jquery.min.js"></script>

      <script src="asset/js/jquery.ui.min.js"></script>

      <script src="asset/js/bootstrap.min.js"></script>



      <script src="asset/js/plugins/moment.min.js"></script>

      <script src="asset/js/plugins/icheck.min.js"></script>

	

		<script src="asset/js/plugins/jquery.validate.min.js"></script>

      <!-- custom -->

      <script src="asset/js/main.js"></script>

      <script type="text/javascript">

   $(document).ready(function(){

   	

	$("#signupForm").validate({

      errorElement: "em",

      errorPlacement: function(error, element) {

        $(element.parent("div").addClass("form-animate-error"));

        error.appendTo(element.parent("div"));

      },

      success: function(label) {

        $(label.parent("div").removeClass("form-animate-error"));

      },

      rules: {

        validate_password: {

          required: true,

          minlength: 1

        },

        validate_username: {

          required: true,

		   minlength: 1

        }

	  },

      messages: {

        validate_username: {

          required: "Please enter a username",

          minlength: "Your username must consist of 11 characters"

        },

        validate_password: {

          required: "Please provide a password",

          minlength: "Your password must be at least 6 characters long"

        }

      },

	   submitHandler: submitForm

    });



	 function submitForm()

	   {		

			var data = $("#signupForm").serialize();

				

			$.ajax({		

			type : 'POST',

			url  : 'login_process.php',

			data : data,

			beforeSend: function()

			{	

				$("#error").fadeOut();

				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp;Loading ...');

			},

			success :  function(response)

			   {						

					if(response=="ok"){

									

						$("#btn-login").html('<img src="btn-ajax-loader.gif"/> &nbsp; Signing In ...');

						setTimeout('window.location.href = "home.php"; ',1000);

					}

					else{

									

						$("#error").fadeIn(1000, function(){						

							$("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');

											$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');

									});

					}

			  }

			});

				return false;

		}

	

});

     </script>

     <!-- end: Javascript -->

   </body>

   </html>