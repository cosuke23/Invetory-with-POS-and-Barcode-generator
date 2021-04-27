<?php

// Start the session..

$page_title = 'OJT AssiSTI Student Page';



if(isset($_COOKIE["uid"])) {

	header ("Location: home.php");

	exit;

}



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';

//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

$error = false;

//set COOKIE-------------------------------------------------------------------------------------------------------------------------------------

					if(isset($_POST["btn_student_number_login"])) {

						sleep(2);

						$username = $_POST["validate_student_number"];

						$password = $_POST["validate_student_password"];

						$sqlcu = $dbc->query("SELECT * FROM student_info WHERE BINARY stud_no = '$username' AND BINARY password = '$password'");

						if($sqlcu->num_rows != 0) {

							$cr = $sqlcu->fetch_assoc();

							if($cr['stud_no']==$username)

							{	setcookie('uid',$cr["username"],time() + 86400);

								setcookie('ut',3,time() + 86400);

								header ("Location: student_home.php?stud_no=$username");

								exit;

							}

						}

						else {

							setcookie('error','1',time() + 86400);

							header ("Location: Student_login.php");

							exit;		

						}

					}

//set COOKIE-------------------------------------------------------------------------------------------------------------------------------------

//check if form is submitted

if (isset($_POST['next'])) {

  $student_number = mysqli_real_escape_string($dbc, $_POST['student_number']);

  

  $query = "SELECT stud_no from student_info";

   $result_section_handled = mysqli_query($dbc,$query);

     $num_rows2 = mysqli_num_rows($result_section_handled);

   while($row_pl = mysqli_fetch_array($result_section_handled))

   {        

       $stud_no = $row_pl[0]; 

   }

   

  //name can contain only alpha characters and space

  if($student_number == $stud_no) {

    $error = true;

    $student_error = "This student number already registered!";

  }else

  {

     $error = true;

    $student_error = "registered!";

  }

}



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

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>





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

					         <form id="signupForm" method="POST" class="form-signin"> 

                            <div class="form-group form-animate-text" style="margin-top:40px !important;" >

                              <input type="text" class="form-text" id="validate_student_number" name="validate_student_number" required maxlength="11">

                              <span class="bar"></span>

                              <label class="customlabel">STUDENT NUMBER</label>

                            </div>

                             <div class="form-group form-animate-text" style="margin-top:40px !important;" >

                              <input type="password" class="form-text" id="validate_student_password" name="validate_student_password" required maxlength="32">

                              <span class="bar"></span>

                              <label class="customlabel">PASSWORD</label>

                            </div>                     

                             <button type="submit" class="btn btn-primary btn-info btn-lg btn-block" name="btn_student_number_login" id="btn_student_number_login">

              							<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In

              							</button> 

                      </form>    

              </div>

              <div class="text-center">

                    <a href="#" ><label style="color:#f2f2f2;"> FORGET PASSWORD ? | </label></a>  

                      <a href="check_student_number.php"> REGISTER </a> 

                </div>	

          </div>

        </div>

      </div>

      </body>



      <!-- end: Content -->

<!-- start: Javascript -->

<script src="asset/js/jquery.min.js"></script>

<script src="asset/js/jquery.ui.min.js"></script>

<script src="asset/js/bootstrap.min.js"></script>

<script src="asset/js/plugins/icheck.min.js"></script>



<!-- plugins -->

<script src="asset/js/plugins/moment.min.js"></script>

<script src="asset/js/plugins/jquery.datatables.min.js"></script>

<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>

<script src="asset/js/plugins/jquery.nicescroll.js"></script>



<script src="asset/js/plugins/jquery.knob.js"></script>

<script src="asset/js/plugins/ion.rangeSlider.min.js"></script>

<script src="asset/js/plugins/bootstrap-material-datetimepicker.js"></script>

<script src="asset/js/plugins/jquery.nicescroll.js"></script>

<script src="asset/js/plugins/jquery.mask.min.js"></script>

<script src="asset/js/plugins/select2.full.min.js"></script>

<script src="asset/js/plugins/nouislider.min.js"></script>

<script src="asset/js/plugins/jquery.validate.min.js"></script>



<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>

<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="asset/js/export.js"></script>

<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>

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

        validate_student_number: {

          required: true,

		      minlength: 11,

          maxlength:11,

          digits:true

        },

         validate_student_password: {

          required: true,

          minlength: 5,

          maxlength:32,

        }

	  },

      messages: {

        validate_student_number: {

          required: "Please enter your student number",

          minlength: "Your student number must consist of 11 numbers",

          digits: "Your student number must only consist numbers"

        },

        validate_student_password: {

          required: "Please enter password password",

          minlength: "Your password must be must atleast 5 characters",

          maxlength: "Your password must be less than 32 characters"

        },

      },

	   submitHandler: submitForm

    });



	 function submitForm()

	   {		

			var data = $("#signupForm").serialize();

				

			$.ajax({		

			type : 'POST',

			url  : 'student_login_process.php',

			data : data,

			beforeSend: function()

			{	

				$("#error").fadeOut();

				$("#btn_student_number_login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp;Loading ...');

			},

			success :  function(response)

			   {						

					if(response=="ok"){

									

						$("#btn_student_number_login").html('<img src="btn-ajax-loader.gif"/> &nbsp; Signing In ...');

						setTimeout('window.location.href = "home.php"; ',1000);

					}

					else{

									

						$("#error").fadeIn(1000, function(){						

							$("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');

											$("#btn_student_number_login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');

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