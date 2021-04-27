<?php



$page_title = 'OJT-assiSTI';



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



?>

<!DOCTYPE html>

<html lang="en">

<head>



  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OJT-assiSTI</title>



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

			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");

		?>

</head>



<body id="mimin" class="dashboard">



   <div class="container-fluid mimin-wrapper">

          <!-- start: Content -->

            <div>

               <div class="panel box-shadow-none content-header">

                  <div class="panel-body">

                    <div class="col-md-12">

                        <h1 class="animated fadeInLeft">STUDENT REGISTRATION</h1>

                        <p class="animated fadeInDown" style="padding-left:10px;color:red;">

                         Please input your student number below.

                        </p>

                    </div>

                  </div>

              </div>

              <div class="col-md-12 padding-0">

                <div class="col-md-12">

                  <div class="panel">

                    <div class="panel-heading"><h3>VALIDATE STUDENT NUMBER</h3></div>

                    <form id="defaultForm" method="post"  action="check_student_number_process.php" >

                      <div class="panel-body" style="padding-bottom:30px;">

                      	<div class="row">

                      		<div class="col-md-3"></div>

                      		<div class="col-md-6">

							<?php

								if(isset($_GET['error']))

								{

									echo "<h5 class='text-danger'><span class='fa fa-close'></span> This student number already registered!</h5>";

								}

								if(isset($_GET['error2']))

								{

									echo "<h5 class='text-danger'><span class='fa fa-close'></span> Invalid Student number!</h5>";

								}

							?>

                            </div>

                      	</div>

                      	<br>

                        <div class="row" style="padding-left:5px;">

                        <div class="col-md-3">

                        	 <h4 style="padding-left:5px;">STUDENT NUMBER</h4>

                        </div>

                          <div class="col-md-3">  

                               <div class="form-group has-feedback">

                                <input type="text" name="stud_no" id="stud_no" class="form-control" maxlength="11" value="<?php if(isset($_GET['stud_no'])){$stud_no=$_GET['stud_no']; echo $stud_no;}?>"/>

                           </div>

                          </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="panel-body">

                                  <div class="well well-sm">

                                      <h4><span class="glyphicon glyphicon-exclamation-sign text-warning "></span>

                                      <strong><label class="text-warning">NOTE</label></strong></h5>

                                      <h4> 

                                      &nbsp;  &nbsp;  &nbsp; Click <strong><mark class="text-primary">Validate</mark></strong> to validate your student number</h4>

                                   </div>

                                </div>  

                          </div>

                        </div>

                         <div class="row">

                            <div class="col-md-4"></div>                       

                            

							<div class="col-md-4">

                                 <a href="Student_information.php" class="btn btn-default btn-block">

                                  <span class="fa fa-remove"></span> &nbsp; CANCEL

                                 </a>

                             </div>

							 <div class="col-md-4">

                                 <button type="submit" class="btn btn-warning btn-block"  name="btn_student_chk_stud" id="btn_student_chk_stud">

                                  <span class="fa fa-exclamation-triangle"></span> &nbsp; VALIDATE

                                 </button>

                             </div>

                          </div>



                      </div><!--ENd of panel body-->

                      </form>

                      </div>

                     </div>

                </div>

            </div> <!-- end: content -->

      </div>



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



  $('#btn_update_stud_info').click( function() {

    $.post( 'update_Student_information_process.php');

});

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

        stud_no: {

                    validators: {

                        notEmpty: {

                            message: 'Student number is required and can\'t be empty'

                        },

            regexp: {

                            regexp: /[0-9]+$/,

                            message: 'Student number can only consist of numberic characters'

                        },

            stringLength: {

                  min: 11,

                  max:11,

                            message: 'Student number must be 11 numbers'

                        }

                    }

                },

          }   

        });   

  });

</script>

<!-- end: Javascript -->

</body>

</html>