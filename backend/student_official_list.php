<?php



$page_title = 'OJT-assiSTI Student Registration';



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



$stud_no = $_GET["stud_no"];



if(isset($_GET['rb']))

{

	$rb=$_GET['rb'];

}

else

{

	$rb=0;

}

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

                

                  <div class="panel">

                    <div class="panel-heading"><h3>VALIDATE MIDDLENAME</h3>

				

						</div>

            <br>

            <div class="row">

                       <div class="col-md-12">



            </div>

            </div>		

                    <form id="defaultForm" method="post"  action="student_official_list_process.php?rb=<?php echo $rb;?>" >

					<div class="panel-body" style="padding-bottom:30px;">

						<div class="row">

                            <div class="col-md-12">

                                <div class="panel-body">

                                  <div class="well well-sm">

                                      <h4><span class="glyphicon glyphicon-exclamation-sign text-warning "></span>

                                      <strong><label class="text-warning">NOTE</label></strong></h5>

                                      <h4> 

                                      &nbsp;  &nbsp;  &nbsp; Middle name is<strong><mark class="text-danger">Case sensitive</mark></strong>. If your middle name is invalid, try to <strong><mark class="text-primary">Upper case</mark></strong> or <strong><mark class="text-primary">Lower case</mark></strong> the first letter of your middle name.</h4>

                                   </div>

                                </div>

                          </div>

                        </div>

						<div class="col-md-6"></div>

						<?php if(isset($_GET['error'])) 

                        {   



                        print '

                        <div class="col-md-3" id="error">

                         <div class="alert alert-danger alert-dismissible fade in" style="height:40px;" role="alert">

                                 <span class="fa fa-exclamation-triangle fa-1"></span>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                 <span aria-hidden="true">×</span></button> &nbsp;&nbsp; <span style="font-size:14px">Invalid Info!</span>

                              </div>

                          </div>

                        ';

                        }

						

            ?>

                        <div class="row" style="padding-left:5px;">

						<div class="col-md-12"></div>

						<div class="col-md-2">

							<h4 style="font-size:20px">STUDENT NO.</h4>

                        </div>

                        <div class="col-md-2">  

							<div class="form-group has-feedback">

								<label style="font-size:25px"><?php echo $stud_no;?></label>

								<input type="hidden" name="stud_no" id="stud_no" value="<?php echo $stud_no;?>" class="form-control"/>

							</div>

						</div> 

						

					    <div class="col-md-2">

                        	 <h4 style="padding-left:5px;">MIDDLENAME</h4>

                        </div>

						          

                          <div class="col-md-3">  

                               <div class="form-group has-feedback">

                                <input type="text" name="mname_val" id="mname_val" class="form-control" maxlength="32" />

								

						   </div>

                          </div> 						  

                        </div>

                         <div class="row">

                            <div class="col-md-8"></div>

							

                            <div class="col-md-4">

                                 <button type="submit" class="btn btn-warning btn-block"  name="btn_mname" id="btn_mname">

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



   $('#defaultForm')

        .bootstrapValidator({

            message: 'This value is not valid',

            feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid:'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            },

        fields: {

         mname_val: {

                    message: 'Middlename name is not valid.',

                    validators: {

                        notEmpty: {

                            message: 'Middlename is required and can\'t be empty. If you dont have a middle name please input. "."(period)'

                        },

            stringLength: {

                            min: 1,

                            max: 32,

                            message: 'Middlename must be more than 1 and less than 32 letters'

                        },

                regexp: {

                            regexp: /^[a-zA-Z\ .]+$/,

                            message: 'Middlename can only consist of letters'

                        },

                    }

                }

          }   

        });

	

  });

</script>

<!-- end: Javascript -->

</body>

</html>