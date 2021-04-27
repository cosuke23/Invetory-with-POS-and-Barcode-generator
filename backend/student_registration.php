<?php



$page_title = 'OJT AssiSTI Student Registration';



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



date_default_timezone_set("Asia/Manila");

$current_year = date("Y") - 1;

$next_year = date("Y") + 1;



$stud_no= $_GET['stud_no'];

$email= $_GET['email'];



if(isset($_GET['rb']))

{

	$rb=$_GET['rb'];

}

else

{

	$rb=0;

}



$query_ol = "SELECT stud_no, lname, fname, mname, program_code FROM official_student_list WHERE stud_no='$stud_no'";

$result_ol = mysqli_query($dbc, $query_ol);

if(mysqli_num_rows($result_ol)>0)

{

	$row_ol = mysqli_fetch_assoc($result_ol);

	$stud_no_ol = $row_ol["stud_no"];

	$lname_ol = $row_ol["lname"];

	$fname_ol = $row_ol["fname"];

	$mname_ol = $row_ol["mname"];

	$program_ol = $row_ol["program_code"];

}

else

{

	echo "ERROR: query_ol";

	exit;

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



<body id="mimin" class="dashboard">

   <div class="container-fluid mimin-wrapper">

          <!-- start: Content -->

            <div>

               <div class="panel box-shadow-none content-header">

                  <div class="panel-body">

                    <div class="col-md-12">

                        <h1 class="animated fadeInLeft">STUDENT REGISTRATION</h1>

                        <p class="animated fadeInDown" style="padding-left:10px;color:red;">

                         Please fill out the form below. 

                        </p>

                    </div>

                  </div>

              </div>

              <div class="col-md-12 padding-0">

                <div class="col-md-12">

                  <div class="panel">

                    <div class="panel-heading"><h3>STUDENT INFORMATION</h3></div>

				

                    <form id="defaultForm" method="post" action="student_registration_page2.php?rb=<?php echo $rb;?>" enctype="multipart/form-data">

                      <div class="panel-body" style="padding-bottom:30px;">

                       <div class="row">

                            <div class="col-md-12">

                                <div class="panel-body">

                                  <div class="well well-sm">

                                      <h4><span class="glyphicon glyphicon-exclamation-sign text-warning ">&nbsp; NOTE</span>

									                   <div class="row">

                                        <div class="col-md-12">

                                         <h5> 

                                          &nbsp;  &nbsp;  &nbsp;Your <strong><mark class="text-primary"> STUDENT NUMBER </mark></strong> is your Default Password. Legend: (<label style="color:red;">*</label>) Required Field.</h5>

                                         

                                        </div>

                                      </div>



                                   </div>

                                </div>  

                          </div>

                        </div>

						

                    <div class="row">

                      <div class="col-md-12">

                         <?php

                         if(isset($_GET['error'])) 

                            {  

                            print '<div class="col-md-12">

                              <div class="alert alert-danger alert-dismissible fade in" role="alert">

                                     <span class="fa fa-remove"></span> &nbsp; | &nbsp;

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                        <span aria-hidden="true">×</span></button>

                                    <strong>&nbsp;Error! Invalid Birthday! You must atlest 16 years old above!</strong>

                               </div></div>';

                            }



                            ?>

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

                             <h5 style="padding-left:5px;">FULL NAME</h5>

                              <div class="form-group has-feedback">

                                <!--<input type="text" name="lname" id="lname" value="<?php //if(isset($_GET['lname'])){$lname=$_GET['lname']; echo $lname;}?>" class="form-control" maxlength="32"/>-->

								<h4><?php echo $lname_ol.", ".$fname_ol." ".$mname_ol;?></h4>

								<input type="hidden" name="lname" value="<?php echo $lname_ol?>" />

							    <input type="hidden" name="fname" value="<?php echo $fname_ol;?>"/>

								<input type="hidden" name="mname" value="<?php echo $mname_ol;?>"/>

							  </div>

                          </div>

						  

						  <div class="col-md-3">

                             <h5 style="padding-left:5px;">EMAIL</h5>

                               <div class="form-group has-feedback">

                                <h4><?php echo $email; ?></h4>

                                <input type ="hidden" name ="email" value ="<?php echo $email; ?>" />

                               </div>

                          </div>						  

                        </div>

                        

                        <div class="row">

                          <div class="col-md-3">

                            <h5 style="padding-left:5px;">GENDER&nbsp;<label style="color:red;font-size:20px;">*</label></h5>

                              <div class="form-group has-feedback">

                                   <select class="form-control" name="gender" id="gender" class="form-control" placeholder="Gender">

                                    <option value="<?php if(isset($_GET['gender'])){$gender=$_GET['gender']; echo $gender;}?>"><?php if(isset($_GET['gender'])){$gender=$_GET['gender']; echo $gender;}?></option>

                                    <option value="Male">Male</option>

                                    <option value="Female">Female</option>

                                    </select>

                              </div>

                          </div>

						  

                           <div class="col-md-3">

                                <h5 style="padding-left:5px;">BIRTHDAY&nbsp;<label style="color:red;font-size:20px;">*</label></h5>

                                  <div class="form-group">

                                  <div class="dateContainer">

                                      <div class="input-group input-append date" id="bday">

                                          <input type="text" class="form-control" name="bday" maxlength="10"/>

                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>

                                      </div>

                                  </div>

                              </div>

                           </div>

						   

                          <div class="col-md-3">

                            <h5 style="padding-left:5px;">PROGRAM</h5>

                            <div class="form-group has-feedback">

                                <h4><?php echo $program_ol;?></h4>

								

								<?php

                                /*$query_program_list = "SELECT * FROM program_list WHERE status = 'Active' ORDER BY program_id";

                       

                                $result_program_list = mysqli_query($dbc, $query_program_list);

                                $num_rows2 = mysqli_num_rows($result_program_list);

                                

                                print'<select class="form-control"  name="program_id" class="form-control"> ';

                                

                                 echo "<option value=''></option>";

                                 while($row_pl = mysqli_fetch_array($result_program_list)){

                                    $program_id2 = $row_pl[0];

                                    $program_code2 = $row_pl[1];

                                    $program_name2 = $row_pl[2]; 

                                    $counter = 0;

                                if($counter <= $program_id)

                                  {

                                      echo "<option value='".$program_id2."'>".$program_code2."</option>";

                                     $counter++;

                                  }   

                                }

                                ?>



                                <?php

                                print '</select>';*/



								//--------------------------------------------------------------------------------//

								

								$query_program_list2 = "SELECT program_id FROM program_list WHERE program_code='$program_ol'";

								$result_pl = mysqli_query($dbc, $query_program_list2);

								if(mysqli_num_rows($result_pl)>0)

								{

									$row_pl = mysqli_fetch_assoc($result_pl);

									$program_id = $row_pl["program_id"];

								}

								else

								{

									echo "ERROR: query_program_list2";

									exit;

								}

                                ?>

								<input type="hidden" name="program_id" value="<?php echo $program_id;?>"/>

                              </div>

                            </div>

                          

						  <div class="col-md-3"></div>

                          </div>

						  

                           <div class="row">

                            <h2 style="margin-left:13px;">Contact Information</h2>

                          </div>

						  

                          <div class="row">                          

						  <div class="col-md-6">

                                 <h5 style="padding-left:5px;">ADDRESS&nbsp;<label style="color:red;font-size:20px;">*</label></h5>

                                <div class="form-group has-feedback">

                                  <textarea rows="2" name="address" id="address" class="form-control" ><?php if(isset($_GET['address'])){$address=$_GET['address']; echo $address;}?></textarea>

                                </div>

                            </div>

							

                            <div class="col-md-3">

                              <h5 style="padding-left:5px;">FACEBOOK</h5>

                                <div class="form-group has-feedback">

                                  <input type="text" value="<?php if(isset($_GET['facebook'])){$facebook=$_GET['facebook']; echo $facebook;}?>" name="facebook" id="facebook" class="form-control" placeholder="(Optional)"/>

                                </div>

                            </div>

                          </div>



                          <div class="row">

                            <div class="col-md-4">

                                <h5 style="padding-left:5px;">TELEPHONE NUMBER</h5>

                                <div class="form-group has-feedback">

                                    <input type="text" value="<?php if(isset($_GET['tel_no'])){$tel_no=$_GET['tel_no']; echo $tel_no;}?>"name="tel_no" id="tel_no"  placeholder="(Optional)" class="form-control" maxlength="7"/>

                                </div>

                            </div>

                             <div class="col-md-4">

                                  <h5 style="padding-left:5px;">MOBILE NUMBER&nbsp;<label style="color:red;font-size:20px;">*</label></h5>

                                  <div class="form-group has-feedback">

                                    <input type="text" name="mobile_no" id="mobile_no" value="<?php if(isset($_GET['mobile_no'])){$mobile_no=$_GET['mobile_no']; echo $mobile_no;}?>" class="form-control" placeholder="Contact number" maxlength="11"/>

                                  </div>

                            </div>

                             <div class="col-md-4">

                            </div>

                          </div>



                         <div class="row">

                            <div class="col-md-8"></div>                        

                            <div class="col-md-4">

                                 <button type="submit" class="btn btn-info btn-block"  name="btn_student_reg" id="btn_student_reg">

                                 &nbsp; CONTINUE >>>

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



function get_value_ays(){

var selected_acad_year_start = document.getElementById("acad_year_start").value;

var x = 1;

var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);

 document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;

  document.getElementById("acad_year_end_value").value =  acad_year_end;

 }

 

 

$(document).ready(function(){



 $('#acad_year_start')

        .datepicker({

            format: "yyyy",

            viewMode: "years", 

            minViewMode: "years",

            autoClose: true

        }).on('changeDate', function(e) {

            // Revalidate the start date field

            $('#defaultForm').bootstrapValidator('revalidateField', 'acad_year_start');

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

        stud_no: {

                    validators: {

                        notEmpty: {

                            message: 'The student number is required and can\'t be empty'

                        },

            regexp: {

                            regexp: /[0-9]+$/,

                            message: 'The student number can only consist of numberic characters'

                        },

            stringLength: {

                  min: 11,

                  max:11,

                            message: 'Student number must be 11 numbers'

                        }

                    }

                },

               lname: {

                    message: 'Lastname name is not valid',

                    validators: {

                        notEmpty: {

                            message: 'Lastname is required and can\'t be empty'

                        },

            stringLength: {

                            min: 1,

                            max: 32,

                            message: 'Lastname must be more than 1 and less than 32 characters long'

                        },

                 regexp: {

                            regexp: /^[a-zA-Z\ ]+$/,

                            message: 'Lastname can only consist of letters'

                        }

                    }

                },

        fname: {

                    message: 'Firstname name is not valid',

                    validators: {

                        notEmpty: {

                            message: 'Firstname is required and can\'t be empty'

                        },

            stringLength: {

                            min: 1,

                            max: 32,

                            message: 'Firstname must be more than 1 and less than 32 characters long'

                        },

            regexp: {

                            regexp: /^[a-zA-Z\ ]+$/,

                            message: 'Firstname can only consist of letters'

                        }

                    }

                },

            mname: {

                    message: 'Middlename name is not valid.',

                    validators: {

                        notEmpty: {

                            message: 'Middlename is required and can\'t be empty. If you dont have a middle name please input. "."(period)'

                        },

            stringLength: {

                            min: 1,

                            max: 32,

                            message: 'Middlename must be more than 1 and less than 32 characters long'

                        },

                regexp: {

                            regexp: /^[a-zA-Z\ .]+$/,

                            message: 'Middlename can only consist of letters'

                        },

                    }

                },

                gender: {

                    validators: {

                        notEmpty: {

                            message: 'Gender is required and can\'t be empty'

                        }

                    }

                },

                bday: {

                    validators: {

                        notEmpty: {

                            message: 'Birthday is required and can\'t be empty'

                        },

                        date: {

                            format: 'MM/DD/YYYY',



                            message: 'Invalid format of birthday(e.g. MM/DD/YYYY)'

                        },

                        

                    },

                     

                },

        program_id: {

                    validators: {

                        notEmpty: {

                            message: 'Program is required and can\'t be empty'

                        },

                    }

                },

        semester: {

                    validators: {

                        notEmpty: {

                            message: 'Semester is required and can\'t be empty'

                        },

                    }

                },

        /*email: {

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

                },*/

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

                }

          

            }

        })

	

});



 

</script>

<!-- end: Javascript -->

</body>

</html>