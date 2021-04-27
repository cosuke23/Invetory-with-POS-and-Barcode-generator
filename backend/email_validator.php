<?php



$page_title = 'OJT AssiSTI Student Registration';



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



$stud_no = $_GET["stud_no"];

if(isset($_GET['rb']))

{

	$rb=$_GET['rb'];

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

  

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OJT assiSTI</title>



  <!-- start: Css -->

  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker.css"/>

  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />

  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />

  <link rel="stylesheet"  type="text/css" href="asset/css/animate.notify.css" />

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>





  <!-- plugins -->

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>

  <link href="asset/css/style.css" rel="stylesheet">

  <!-- end: Css -->



  <link rel="shortcut icon" href="asset/img/ojtassistilogo.png">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      <![endif]-->

	  

	  <?php

			//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			//header("Cache-Control: post-check=0, pre-check=0", false);

			//header("Pragma: no-cache");

		?>

</head>



<body class="dashboard">

      

          <!-- start: Content -->

           <div style="padding-top:50px;">

               <div class="panel box-shadow-none content-header">

                  <div class="panel-body">

                    <div class="col-md-12">

                        <h1 class="animated fadeInLeft">STUDENT REGISTRATION</h1>

                        <p class="animated fadeInDown" style="padding-left:10px;color:red;">

                         Please input your email address below.

                        </p>

                    </div>

                  </div>

              </div>

              <div class="col-md-12 padding-0">

                <?php

					if(isset($_GET['rb']))

					{

						echo "<input type='hidden' name='rb' value='1'/>";

					}

				?>

                  <div class="panel">

                    <div class="panel-heading"><h3>VALIDATE EMAIL ADDRESS</h3></div>

					

                    <form id="defaultForm" method="post"  action="email_validator_process.php?rb=<?php echo $rb;?>" >

                    		

					<div class="panel-body" style="padding-bottom:30px;">

                      	<div class="row">

                      		<div class="col-md-3"></div>

                      		<div class="col-md-6">

							</div>

							<?php if(isset($_GET['error'])) 

							{

								print '<div class="row">

							   <div class="col-md-12">

								<div class="col-md-3" id="error">

								 <div class="alert alert-danger alert-dismissible fade in" style="height:40px;" role="alert">

										 <span class="fa fa-exclamation-triangle fa-1"></span>

										<button type="button" class="close" data-dismiss="alert" aria-label="Close">

										 <span aria-hidden="true">×</span></button> &nbsp;&nbsp; Email address exists.

									  </div>

								  </div>

								</div>

							  </div>';



							}

						?>

                      	</div>

                      	<br>

                        <div class="row" style="padding-left:5px;">

                        <div class="col-md-2">

                        	 <h4 style="font-size:20px">STUDENT NO.</h4>

                        </div>

                          <div class="col-md-2">  

                               <div class="form-group has-feedback">

							   <label style="font-size:25px"><?php echo $stud_no;?></label>

                               <input type="hidden" name="stud_no" id="stud_no" value="<?php echo $stud_no;?>"/>

                           </div>

                          </div>

						

						<div class="col-md-2">

                        	 <h4 style="padding-left:5px;">EMAIL ADDRESS</h4>

                        </div>

						

                          <div class="col-md-3">  

                               <div class="form-group has-feedback">

                                <input type="text" name="email" id="email" class="form-control"/>

						   </div>

                          </div> 						  

                        </div>

                         <div class="row">

                            <div class="col-md-4"></div>

                            <div class="col-md-4">

                                 <a href="student_official_list.php?stud_no=<?php echo $stud_no;?>" class="btn btn-default btn-block">

                                  <span class="icons icon-action-undo"></span> &nbsp; BACK

                                 </a>

                             </div>                        

                            <div class="col-md-4">

                                 <button type="submit" class="btn btn-warning btn-block"  name="btn_email" id="btn_email">

                                  <span class="fa fa-exclamation-triangle"></span> &nbsp; VALIDATE

                                 </button>

                             </div>

                          </div>



                      </div><!--ENd of panel body-->

                      </form>

                      </div>

                     </div>

					 </div>

             <!-- end: content -->

      

     



<!-- start: Javascript -->

<script src="asset/js/jquery.min.js"></script>

<script src="asset/js/jquery.ui.min.js"></script>

<script src="asset/js/bootstrap.min.js"></script>

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

<script type="text/javascript" src="asset/js/moment.min.js"></script>

<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>

<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>

<!-- custom -->

<script src="asset/js/main.js"></script>



<script type="text/javascript">

$(document).ready(function(){

  $("#added").on("click", function() {

              $.notify({

          // options

          icon: 'glyphicon glyphicon-warning-sign',

          title: 'Bootstrap notify',

          message: 'Turning standard Bootstrap alerts into "notify" like notifications',

          target: '_blank'

        },{

          // settings

          element: 'body',

          position: null,

          type: "info",

          allow_dismiss: true,

          newest_on_top: false,

          showProgressbar: false,

          placement: {

            from: "top",

            align: "right"

          },

          offset: 20,

          spacing: 10,

          z_index: 1031,

          delay: 5000,

          timer: 1000,

          url_target: '_blank',

          mouse_over: null,

          animate: {

            enter: 'animated fadeInDown',

            exit: 'animated fadeOutUp'

          },

          onShow: null,

          onShown: null,

          onClose: null,

          onClosed: null,

          icon_type: 'class',

          template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +

            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +

            '<span data-notify="icon"></span> ' +

            '<span data-notify="title">{1}</span> ' +

            '<span data-notify="message">{2}</span>' +

            '<div class="progress" data-notify="progressbar">' +

              '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +

            '</div>' +

            '<a href="{3}" target="{4}" data-notify="url"></a>' +

          '</div>' 

        });

    });



  $('#datatables').DataTable();

   $('#bday')

        .datepicker({

            format: 'mm/dd/yyyy',

            autoClose: true

        })

        .on('changeDate', function(e) {

            // Revalidate the start date field

            $('#defaultForm').bootstrapValidator('revalidateField', 'bday');

        });



   $('#defaultForm')

        .bootstrapValidator({

            message: 'This value is not valid',

            feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid:'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            },

        fields: {

        email: {

            validators: {

                        notEmpty: {

                            message: 'Email is required and can\'t be empty'

                        },

            emailAddress: {

							

                            message: 'Invalid email address'

                        },

                        regexp: {

                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,

                            message: 'Invalid character'

                        }

                    }

                },

				submitHandler: submitForm

          }   

        });



function submitForm()

	   {		

			var data = $("#defaultForm").serialize();

				

			$.ajax({		

			type : 'POST',

			url  : 'email_validator_process.php',

			data : data,

			beforeSend: function()

			{	

				$("#error").fadeOut();

				$("#btn-email").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp;Loading ...');

			},

			success :  function(response)

			   {						

					if(response=="ok"){

						

						setTimeout('window.location.href = "student_registration.php?stud_no=$stud_no&email=$email"; ',1000);

					}

					else{

									

						$("#error").fadeIn(1000, function(){						

							$("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');

											

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