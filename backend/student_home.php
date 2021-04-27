<?php



$page_title = 'OJT AssiSTI Student Registration';

if(!isset($_COOKIE["uid"])) {

	header ("Location: Student_login.php");

	exit;

}

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



date_default_timezone_set("Asia/Manila");

$acad_year_start = date('Y');

$acad_year_end = $acad_year_start +1;



 $stud_no= $_COOKIE["uid"];

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

                <a href="#" class="navbar-brand"> 

                 <b>OJT assiSTI</b>

                </a>

            </div>

          </div>

        </nav>

      <!-- end: Header -->

   <div class="container-fluid mimin-wrapper">

    <!-- start:Left Menu -->

		<?php

			$query_stud_info = "SELECT a.stud_no,a.lname,a.fname,a.mname,a.gender,DATE_FORMAT(a.bday, '%m/%d/%Y') AS bday,a.email,a.mobile_no,a.tel_no,a.address,a.facebook,b.program_code, c.ojt_status, c.year_level, c.semester, d.category_description, a.imageData FROM student_info AS a INNER JOIN program_list AS b INNER JOIN student_ojt_records AS c INNER JOIN program_category_list AS d WHERE a.program_id = b.program_id AND b.program_id = d.program_id AND a.stud_no = c.stud_no AND a.stud_no='$stud_no';";

                          $result_stud_info = mysqli_query($dbc, $query_stud_info);

                          $num_rows = mysqli_num_rows($result_stud_info);



            

                        while($row = mysqli_fetch_array($result_stud_info)) {

               

                            $stud_no = $row[0];

                            $lname = $row[1];

                            $fname = $row[2];

                            $mname = $row[3];

                            $gender = $row[4];

                            $bday = $row[5];

                            $email = $row[6];

                            $mobile_no = $row[7];

                            $tel_no = $row[8];

                            $address = $row[9];

                            $facebook = $row[10];

                            $program_code = $row[11];

							$ojt_status = $row[12];

							$year_lvl = $row[13];

							$semester = $row[14];

							$ojt_category = $row[15];

							$imageData = $row[16];

						}

						$decoded_img = base64_decode($imageData);

						$f = finfo_open(); 

						$img_type = finfo_buffer($f, $decoded_img, FILEINFO_MIME_TYPE);

										

					

		?>

            <div id="left-menu">

              <div class="sub-left-menu scroll">



                    <div  style="background: linear-gradient(#ebebe0, 50%,#ebebe0);height:90px;">

                      <img src="asset/img/ojtassistilogo.png" style="padding-top:10px;margin-left:65px;width:80px;height:80px;" class="animated fadeInLeft">

                    </div>

                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:75px;">

                      <h1 class="animated fadeInLeft" style="color:gray;margin-left:30px;">

                                <?php 

                                  date_default_timezone_set("Asia/Manila");

                                  echo date("h:i A"); 

                                ?>  

                      </h1>

                       <p class="animated fadeInRight" style="color:gray;margin-left:30px;">

                               <?php

                                 echo  date("l, F j, Y"); 

                               ?>

                        </p>

                    </div>

					

					<div class="nav-side-menu">

                        <label>

                          <a href="student_home.php">

                                  <i class="fa fa-file-o"></i> &nbsp;Student Information

                                 </a>

                        </label><br>

                      </div>

					

					<div class="nav-side-menu">

                        <label>

                          <a href="student_ojt_records.php">

                                  <i class="fa fa-folder-open-o"></i> &nbsp;My OJT Records

                                 </a>

                        </label><br>

                      </div>



                      <div class="nav-side-menu">

                        <label>

                          <a href="logout_student.php">

                                  <i class="fa fa-power-off"></i> &nbsp;Log out

                                 </a>

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

                        <h1 class="animated fadeInLeft"></h1>

                        <p class="animated fadeInDown" style="padding-left:10px;color:red;">

                        </p>

                    </div>

                  </div>

              </div>

              <div class="col-md-12 padding-0">

                <div class="col-md-12">

                  <div class="panel">

                    <div class="panel-heading"><h3>STUDENT INFORMATION</h3></div>

                    <form id="defaultForm" method="post" action="student_update_register_process.php" enctype="multipart/form-data">

                      <div class="panel-body" style="padding-bottom:30px;">

                        <div class="row">

						<div class="row">

                           <div class="col-md-3"> 

                           <?php 

                             echo '<img src="data:'.$img_type.';base64,'.$imageData.'" style="height:200px;width:200px;">';

                             ?>

                           </div>

                          <div class="col-md-6">

                            <h5 style="padding-left:5px;">STUDENT PICTURE &nbsp; <i class="fa fa-camera"></i></h5>

                               <div class="form-group has-feedback">

                               <input type="file" class="form-control" name="image" placeholder="Upload Image" alt="student image"/> 

                               </div>

                          </div>

                        </div>

                        <div class="row" style="padding-left:5px;">        

                          <div class="col-md-3">

                             <h5 style="padding-left:5px;">STUDENT NUMBER</h5>

                               <div class="form-group has-feedback">

                                <h4><?php echo $stud_no; ?></h4>

                                <input type ="hidden" name ="stud_no" value ="<?php echo $stud_no; ?>" />

                               </div>

                          </div>

                         <div class="col-md-3">

                             <h5 style="padding-left:5px;">LASTNAME</h5>

                              <div class="form-group has-feedback">

                                <h4><?php echo $lname; ?></h4>

                              </div>

                          </div>

                          <div class="col-md-3">

                             <h5 style="padding-left:5px;">FIRSTNAME</h5>

                              <div class="form-group has-feedback">

                                <h4><?php echo $fname; ?></h4>

                              </div>

                          </div>

                          <div class="col-md-3">

                            <h5 style="padding-left:5px;">MIDDLENAME</h5>

                              <div class="form-group has-feedback">

                                <h4><?php echo $mname; ?></h4>

                              </div>

                          </div>                  

                        </div>

                        

                        <div class="row">

                          <div class="col-md-3">

                            <h5 style="padding-left:5px;">GENDER</h5>

                              <h4><?php echo $gender; ?></h4>

                          </div>

                           <div class="col-md-3">

                                <h5 style="padding-left:5px;">BIRTHDAY</h5>

                                  <div class="form-group">

                                  <div class="dateContainer">

                                      <h4><?php echo $bday; ?></h4>

                                  </div>

                              </div>

                           </div>

                          <div class="col-md-3">

                            <h5 style="padding-left:5px;">PROGRAM</h5>

                            <h4><?php echo $program_code; ?></h4>

                            </div>

                            <div class="col-md-3"></div>

                          </div>

                           <div class="row">

                            <h2 style="margin-left:13px;">Contact Information</h2>

                          </div>

                          <div class="row">

                            <div class="col-md-6">

                                 <h5 style="padding-left:5px;">ADDRESS</h5>

                                <div class="form-group has-feedback">

                                  <textarea rows="2" name="address" id="address" class="form-control" ><?php echo $address?></textarea>

                                </div>

                            </div>

                            <div class="col-md-3">

                               <h5 style="padding-left:5px;">EMAIL</h5>

                                <div class="form-group has-feedback">

                                  <input type="text" name="email" id="email" value="<?php echo $email?>" class="form-control"/>

                                </div>

                            </div>

                            <div class="col-md-3">

                              <h5 style="padding-left:5px;">FACEBOOK</h5>

                                <div class="form-group has-feedback">

                                  <input type="text" name="facebook" id="facebook" class="form-control" value="<?php echo $facebook?>" placeholder="(Optional)"/>

                                </div>

                            </div>

                          </div>



                          <div class="row">

                            <div class="col-md-4">

                                <h5 style="padding-left:5px;">TELEPHONE NUMBER</h5>

                                <div class="form-group has-feedback">

                                    <input type="text" name="tel_no" id="tel_no"  placeholder="(Optional)" class="form-control" value="<?php echo $tel_no?>" maxlength="7"/>

                                </div>

                            </div>

                             <div class="col-md-4">

                                  <h5 style="padding-left:5px;">MOBILE NUMBER</h5>

                                  <div class="form-group has-feedback">

                                    <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Contact Person" value="<?php echo $mobile_no?>" maxlength="11"/>

                                  </div>

                            </div>

                             <div class="col-md-4">

                            </div>

                          </div>

                         

                        <div class="row">

                            <div class="col-md-12">

                                <div class="panel-body">

                                  <div class="well well-sm">

                                      <h4><span class="glyphicon glyphicon-exclamation-sign text-warning "></span>

                                      <strong><label class="text-warning">NOTE</label></strong></h5>

                                      <h4> 

                                      &nbsp;  &nbsp;  &nbsp; Please choose a formal and updated of <strong><mark class="text-primary">picture of you.</mark></strong></h5>

                                   </div>

                                </div>  

                          </div>

                        </div>

                         <div class="row">

                            <div class="col-md-8"></div>                        

                            <div class="col-md-4">

                                 <button type="submit" class="btn btn-warning btn-block"  name="btn_student_info_update" id="btn_student_reg">

                                  <span class="icons icon-action-redo"></span> &nbsp; UPDATE

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

      <!-- start: Mobile -->

      <div id="mimin-mobile" class="reverse">

        <div class="mimin-mobile-menu-list">

            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">

               <ul class="nav nav-list">

                    <li class="ripple">

                      <a href="logout_student.php">

                                  <span class="fa fa-power-off"></span> &nbsp;CANCEL

                       </a>

                    </li>

                </ul>

            </div>

        </div>       

      </div>

      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle" style="background-color:#0d47a1;">

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



  $('#btn_student_info_update').click( function() {

    $.post( 'student_update_register_process.php');

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

            message: 'Value is not valid',

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

        address: {

                    validators: {

                        notEmpty: {

                            message: 'Address is required and can\'t be empty'

                        },

                        regexp: {

                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,

                            message: 'Invalid character'

                        }

                    }

                },

        mobile_no: {

                    validators: {

                        notEmpty: {

                            message: 'Mobile number is required and can\'t be empty'

                        },

            regexp: {

                            regexp: /[0-9]+$/,

                            message: 'Mobile number can only consist of numbers'

                        },

            stringLength: {

                            min: 11,

                            max: 11,

                            message: 'Mobile number must be 11 numbers'

                        }

                    }

                },

            tel_no: {

                    validators: {

                      regexp: {

                            regexp: /^[0-9]+$/,

                            message: 'Telephone number can only consist of numbers'

                                  },

                      stringLength: {

                                      min: 7,

                                      max: 7,

                                      message: 'Telephone number must be 7 numbers'

                                  },

                              }

                          },

            facebook: {

                    validators: {

                        regexp: {

                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,

                            message: 'Invalid character'

                        }

                    },

                },

                image: {

                  validators: {

                     file: {

                        extension: 'jpeg,jpg,png',

                        type: 'image/jpeg,image/png',

                        maxSize: 1049088,   // 1366 * 768

                        message: 'The selected file is not valid,it should be (jpeg,jpg,png) and 1 MB at maximum size'

                      }

                    }

                },

                year_level: {

                    validators: {

                        notEmpty: {

                            message: 'Year level is required and can\'t be empty'

                        },

                    }

                },

                  category_id: {

                    validators: {

                        notEmpty: {

                            message: 'Section is required and can\'t be empty'

                        },

                    }

                },

            }

          

        });

   

     

  });

</script>

<!-- end: Javascript -->

</body>

</html>