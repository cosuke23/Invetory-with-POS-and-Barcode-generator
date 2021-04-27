<?php



$page_title = 'OJT AssiSTI';



if(!isset($_COOKIE["cid"])) {

	header ("Location: company_login.php");

	exit;

}

$username = $_COOKIE["cid"];

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';





$query2 = "SELECT * from company_info WHERE username = '$username'";

	$result2 = mysqli_query($dbc,$query2);

		if(mysqli_num_rows($result2)>0)

		{

			$row2 = mysqli_fetch_assoc($result2);

			$fname2 = $row2["comp_name"];

			$comp_id = $row2["comp_id"];

		}



date_default_timezone_set("Asia/Manila");

$date_today =  date("Y-m-d");

        

?>

<!DOCTYPE html>

<html lang="en">

<head>

  

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OJT assiSTI</title>



  <!-- start: Css -->

  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">



  <!-- plugins -->

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/red.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>

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

      <!-- start: Header -->

        <nav class="navbar navbar-custom header navbar-fixed-top">

          <div class="col-md-12 nav-wrapper">

            <div class="navbar-header" style="width:100%;">

              <div class="opener-left-menu is-open">

                <span class="top"></span>

                <span class="middle"></span>

                <span class="bottom"></span>

              </div>

                <a href="home.php" class="navbar-brand"> 

                 <b>OJT assiSTI</b>

                </a>

              <ul class="nav navbar-nav navbar-right user-nav">

                  <li class="user-name"><span>&nbsp;<?php echo $fname2 ; ?>&nbsp;</span></li>

                  <li class="dropdown avatar-dropdown">

                  <br>

                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:30px;color:yellow;"/></span>



                   <ul class="dropdown-menu user-dropdown">

                     <li><a href="comp_change_pass.php?comp_id=<?php echo $comp_id;?>"><span class="fa fa-user"></span> Change password</a></li>

                      <li><a href="logout.php"><span class="fa fa-power-off "> Log Out</span></a></li> 

                  </ul>

                </li>

              </ul>

            </div>

          </div>

        </nav>

      <!-- end: Header -->

   <div class="container-fluid mimin-wrapper">

  <!-- start:Left Menu -->

            <div id="left-menu">

              <div class="sub-left-menu scroll">



                      <div  style="background: linear-gradient(#ebebe0, 50%,#ebebe0);height:90px;">

                      <img src="asset/img/ojtassistilogo.png" style="padding-top:10px;margin-left:35px;width:150px;height:150px;" class="animated fadeInLeft">

                    </div>

                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:100px;">

                    <br>

                       <p class="animated fadeInRight" style="color:gray;margin-left:20px;margin-top:60px;">

                               <?php

                                 echo  date("l, F j, Y"); 

                               ?>

                        </p>

                    </div>



                      <div class="nav-side-menu">

						<label>

                          <a href="comp_company_remarks.php?comp_id=<?php echo $row2['comp_id']; ?>"><i class="glyphicon glyphicon-globe"></i>Company OJT Students</a>

                          </label><br>

						  <label>

                          <a href="sti_ojtofficer_contact.php"><i class="glyphicon glyphicon-user"></i>STI OJT Officer Contact</a>

                          </label><br>

						  <label>

                          <a href="comp_sent.php?comp_id=<?php echo $row2['comp_id']; ?>"><i class="glyphicon glyphicon-envelope"></i>Comment Sent</a>

                          </label><br>                 

                      </div>

              </div>

            </div>

          <!-- end: Left Menu -->



           <!-- start: Content -->

            <div id="content">

               <div class="panel box-shadow-none content-header">

                  <div class="panel-body">

                    <div class="col-md-12">

                        <h1 class="animated fadeInLeft">CHANGE PASSWORD</h1>

                        <p class="animated fadeInDown">

                        </p>

                    </div>

                  </div>

              </div>

              <div class="col-md-12 padding-0">

                <div class="col-md-12">

                  <div class="panel">

                    <div class="panel-heading"><h3>ENTER NEW PASSWORD</h3></div>

                    <form id="defaultForm" method="post" action="comp_change_pass_process.php" enctype="multipart/form-data">

                      <div class="panel-body" style="padding-bottom:30px;">

						<div class="row">

                             <div class="col-md-3">

                               <h5 style="padding-left:5px;">USERNAME</h5>

                                <div class="form-group has-feedback">

                                  <h4><?php echo $username; ?></h4>

                                  <input type="hidden" name="comp_id" value="<?php echo $comp_id; ?>"/>

								  <input type="hidden" name="username" value="<?php echo $username; ?>"/>

                                </div>                  

                            </div>

                             <div class="col-md-3">

                               <h5 style="padding-left:5px;">NEW PASSWORD</h5>

                                <div class="form-group has-feedback">

                                  <input type="password" name="new_pass" id="new_pass" class="form-control" maxlength="=40" />

                                </div>                  

                            </div>

                             <div class="col-md-3">

                               <h5 style="padding-left:5px;">CONFIRM PASSWORD</h5>

                                <div class="form-group has-feedback">

                                  <input type="password" name="confirm_pass" id="confirm_pass" class="form-control"  maxlength="=40"/>

                                </div>                  

                            </div>

                        </div>



                         <div class="row">

                            <div class="col-md-8"></div>

                             

                            <div class="col-md-4">

                                 <button type="submit" class="btn btn-info btn-block"  name="btn_changepass" id="btn_changepass">

                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE

                                 </button>

                             </div>

                          </div>



                      </div><!--ENd of panel body-->

                      </form>

                      </div>

                     </div>

                </div>

            </div>

      </div>

          

     

    <!-- end: content -->

     <!-- start: Mobile -->

      <div id="mimin-mobile" class="reverse">

        <div class="mimin-mobile-menu-list">

            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">

              <ul class="nav nav-list">

                    <li class="ripple">

                     <a href="comp_company_remarks.php?comp_id=<?php echo $comp_id; ?>"><i class="glyphicon glyphicon-globe"></i> Company OJT Students</a>

                    </li>

                     <li class="ripple">

                       <a href="sti_ojtofficer_contact.php"><i class="glyphicon glyphicon-user"></i> STI OJT Officer Contact</a>

                    </li>

                     <li class="ripple">

                      <a href="comp_sent.php?comp_id=<?php echo $comp_id; ?>"><i class="glyphicon glyphicon-envelope"></i> Comment Sent</a>

                    </li>



                </ul>

            </div>

        </div>       

      </div>

      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle"  style="background-color:#0d47a1;">

        <span class="fa fa-bars" style="color:yellow;"></span>

      </button>

       <!-- end: Mobile -->



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

                new_pass: {

                  validators: {

                        notEmpty: {},

						regexp: {

                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,

                            message: 'Invalid character'

                        },

                        stringLength: {

                            min: 6,

                            max: 32,

                            message: 'Password must be more than 6 and less than 32 characters long'

                        },

                    }

                },

              confirm_pass: {

                  validators: {

						notEmpty: {},

                        regexp: {

                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,

                            message: 'Invalid character'

                        },

                        stringLength: {

                            min: 6,

                            max: 32,

                            message: 'Confirm Password must be more than 6 and less than 32 characters long'

                        },

                        identical: {

                          field:'new_pass',

                          message: 'Confirm password did not match'

                        }

                    }

                }



            }

        });     

  });

</script>

<!-- end: Javascript -->

</body>

</html>