<?php
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';

$current_year = date("Y")-2;
$next_year = date("Y")+1;
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="Miminium Admin Template v.1">
  <meta name="author" content="Isna Nur Azis">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E2E SYSTEM v2</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>

<!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker.css"/>
  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/animate.notify.css" />

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/red.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>
  <link href="asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/sweetalert.css"/>
  <script src="asset/js/jquery.confirm.min.js"></script>
  <script src="asset/js/jquery.confirm.js"></script>
  <script src="asset/js/sweetalert-dev.js"></script>

<link rel="shortcut icon" href="asset/img/e2elogoc.png">
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
                <a href="e2e_home.php" class="navbar-brand"> 
                 <b>E2E SYSTEM v2</b>
                </a>
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">
  
          <!-- start:Left Menu -->
            <div id="left-menu">
              <div class="sub-left-menu scroll">

                    <div  style="background: linear-gradient(#ebebe0, 50%,#ebebe0);height:90px;">
                      <img src="asset/img/e2elogoc.png" style="padding-top:4px;margin-left:1px;width:230px;height:100px;" class="animated fadeInLeft">
                    </div>
                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:70px;">
                    <br>
                       <p class="animated fadeInRight" style="color:gray;margin-left:10px;margin-top:20px;">
                               <?php
                                 echo  date("l, F j, Y"); 
                               ?>
                        </p>
                    </div>

                      <div class="nav-side-menu">
                        <label class="active">
                          <a href="student_registration.php"><i class="glyphicon glyphicon-user"></i>REGISTRATION</a>
                        </label><br>
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->
          <div class="container-fluid mimin-wrapper">
             <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">STUDENT RECORDS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                         &nbsp;
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <h3>STUDENT REGISTRATION</h3>
                    </div>
                    <div class="row">
                      <div class="col-md-12">

                         <?php
                         if(isset($_GET['success']) && isset($_GET['stud_no']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['mname'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $lname_up = $_GET['lname'];
                              $fname_up = $_GET['fname'];
                              $mname_up = $_GET['mname'];
                            echo '<script language = javascript>
                             swal({
                                title: "Successfully Registered!",
                                 html: true,
                                  text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$lname_up.', '.$fname_up.' '.$mname_up.'</strong><br> <strong>NOTE: By Default your password <br> is your MIDDLENAME</strong>",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_student_login.php";
                                }
                              });
                          </script>';
                        }elseif(isset($_GET['error']) && isset($_GET['stud_no'])) 
                            {   
                             
                            echo '<script language = javascript>
                             swal({
                                title: "Error!",
                                 html: true,
                                  text: " <strong>Invalid Birthday! You must atlest 16 years old above!</strong>",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              }
                              );
                          </script>';
                        }
                          ?>
                          </div>
                       </div>
                    <?php
                      if(isset($_GET['stud_no'])) { 
                        $stud_no=$_GET['stud_no'];
                      }
                      ?>
                    <form id="defaultForm" method="post" action="add_Student_records_process_2.php" enctype="multipart/form-data">
                      <div class="panel-body" style="padding-bottom:30px;">
                         
                        <div class="row">
                           <div class="col-md-3"> 
                           </div>
                          <div class="col-md-6" style="display:none;">
                            <h5>STUDENT PICTURE &nbsp; <i class="fa fa-camera"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="stud_dp" placeholder="Upload Image" alt="student image"/> 
                               </div>
                          </div>
                        </div>
                        
                        <div class="row">
                         <input name="stud_no" type="hidden" value ="<?php echo $stud_no; ?>"/>
                          <div class="col-md-3">
                             <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                               <div class="form-group has-feedback">
                                <input type="text" name="stud_no" id="stud_no" class="form-control"  maxlength="12" disabled value= "<?php echo  $stud_no; ?>"/>
                               </div>
                          </div>
                         <div class="col-md-3">
                             <h5 style="padding-left:5px;">LASTNAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="lname" id="lname" class="form-control" />
                              </div>
                          </div>
                          <div class="col-md-3">
                             <h5 style="padding-left:5px;">FIRSTNAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="fname" id="fname" class="form-control"  maxlength="32"/>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">MIDDLENAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="mname" id="mname" class="form-control" maxlength="32"/>
                              </div>
                          </div>                  
                        </div>
                        
                        <div class="row">
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">GENDER</h5>
                              <div class="form-group has-feedback">
                                
                                  <select class="form-control" name="gender" id="gender" class="form-control" placeholder="Gender">
                                    <option value=""></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    </select>
                              </div>
                          </div>
                           <div class="col-md-3">
                                <h5 style="padding-left:5px;">BIRTHDAY</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="bday">
                                          <input type="text" class="form-control" name="bday"  maxlength="10"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                            <h5 style="padding-left:5px;">Year</h5>
                              <div class="form-group has-feedback">
                                   
                                  <select class="form-control" name="year" id="year" class="form-control" placeholder="Year">
                                    <option value=""></option>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                    <option value="3rd">3rd</option>
                                    <option value="4th">4th</option>
                                    <option value="5th">5th</option>
                                    </select>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">PROGRAM</h5>
                            <div class="form-group has-feedback">
                                <?php
                                $table_pl = "program_list";
                                $columns_pl = "*";
                                $where_pl = ["status" => 'Active'];
                                $q_pl =$database->select($table_pl,$columns_pl,$where_pl);
                                
                                print'<select class="form-control"  name="program_id" class="form-control">';
                                
                                 echo "<option value='".$stud_program_id."'>".$program_code."</option>";

                                 foreach($q_pl as $q_pl_data){
                   
                                    $program_id2 = $q_pl_data['program_id'];
                                    $program_code2 = $q_pl_data['program_code'];
                                    $counter = 0;
                                if($counter <= $program_id2)
                                  {
                                      echo "<option value='".$program_id2."'>".$program_code2."</option>";
                                     $counter++;
                                  }   
                                }
                                ?>
                                <?php
                                print '</select>';
                                ?>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                            <h5 style="padding-left:5px;">SEMESTER</h5>
                              <div class="form-group has-feedback">
                                  
                                  <select class="form-control" name="semester" id="semester" class="form-control" placeholder="Year">
                                    <option value=""></option>
                                    <option value="1st Semester">1st Semester</option>
                                    <option value="2nd Semester">2nd Semester</option>
                                    <option value="Summer">Summer</option>
                                    </select>

                                    
                              </div>
                          </div>
                          <div class="col-md-3">
                             <input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>"/>
                            <input type="hidden" name="next_year" id="next_year" value="<?php echo $next_year; ?>"/>
                                  <h5 style="padding-left:5px;">ACADEMIC YEAR START</h5>
                                 <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date">
                                          <input type="text" class="form-control" name="acad_year_start" placeholder="(e.g.YYYY)" id="acad_year_start" onchange="get_value_ays()" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                              
                            </div>
                             <div class="col-md-3">
                                <h5 style="padding-left:5px;">ACADEMIC YEAR END</h5>
                                  <div>
                                   <input type="hidden" id="acad_year_end_value" name="acad_year_end" />
                                   <h4 id ="acad_year_start_show"></h4>
                                   </div>
                                    
                             </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <h2 style="padding-left:5px;">CONTACT INFORMATION</h2>
                            </div>
                          </div>

                           <div class="row">
                            <div class="col-md-12">
                                 <h5 style="padding-left:5px;">ADDRESS</h5>
                                <div class="form-group has-feedback">
                                  <textarea rows="2" name="address" id="address" class="form-control"></textarea>
                                </div>
                            </div>
                          </div>

                          <div class="row">
                             <div class="col-md-4">
                               <h5 style="padding-left:5px;">EMAIL</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="email" id="email" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">FACEBOOK</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="fb_link" id="fb_link" class="form-control"  placeholder="(Optional)"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">CONTACT NUMBER</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="contact_no" id="contact_no" class="form-control"  maxlength="11"/>
                                </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <h2 style="padding-left:5px;">RESUME INFO</h2>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4" style="display:none;">
                              <h5 style="padding-left:5px;">RESUME LINK</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="resume_link" id="resume_link" class="form-control" placeholder="(e.g. example.jobs.street.com)" />
                                </div>
                            </div>
                             <div class="col-md-6" style="display:none;">
                            <h5>RESUME DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="resume_data" placeholder="Upload Resume" alt="resume data"/> 
                               </div>
                          </div>
                          </div>
                         <br>

                       <div class="row">
                        <div class="col-md-4"></div>
                         
                        <div class="col-md-4">
                             <button type="submit" class="btn btn-ripple btn-raised btn-block btn-success"  name="btn_add_stud_info_2" id="btn_add_stud_info_2">
                              <span class="fa fa-plus-square"></span> &nbsp;Register
                             </button>
                         </div>
                          <div class="col-md-4">
                           <a href="student_logout.php"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                          </div>
                      </div>
                         
                      </div><!--ENd of panel body-->
                      </form>
                      </div>
                     </div>
                </div>
           </div>
     
    <!-- end: content -->
          </div>
        
      </div>
      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="e2e_home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; REGISTRATION</a>
                      
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
function get_value_ays(){
var selected_acad_year_start = document.getElementById("acad_year_start").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
 document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;
 }

$(document).ready(function(){
  $('#bday')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'bday');
        });
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

  $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                stud_program_id: {
                    message: 'Program is invalid',
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
                    },
                },
                acad_year_start: {
                    validators: {
                        notEmpty: {
                            message: 'Academic year start is required and can\'t be empty'
                        },
                        
                         regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Invalid characters'
                        },
                        callback: {
                        message: 'Date is not in the range',
                        callback: function(value, validator) {
                            var m = new moment(value, 'YYYY', true);
                            var cy = document.getElementById("current_year").value;
                             var ny = document.getElementById("next_year").value;
                            if (!m.isValid()) {
                                return false;
                            }
                            return m.isAfter(cy) && m.isBefore(ny);
                        }
                       },
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
                            message: 'Lastname must be more than 1 and less than 32 letters'
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
                            message: 'Firstname must be more than 1 and less than 32 letters'
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
                            message: 'Middlename is required and can\'t be empty. If the student does not have middlename please input. "."(period)'
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
                    }     
                },
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
                        },
                        stringLength: {
                            min: 10,
                            max: 64,
                            message: 'Email must be more than 10 and less than 64 characters long'
                        },
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
        contact_no: {
                    validators: {
                        notEmpty: {
                            message: 'Contact number is required and can\'t be empty'
                        },
            regexp: {
                            regexp: /[0-9]+$/,
                            message: 'Contact number can only consist of numbers'
                        },
            stringLength: {
                            min: 11,
                            max: 11,
                            message: 'Contact number must be 11 numbers'
                        }
                    }
                },
                fb_link: {
                    validators: {
                          regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    },
                },
                resume_link: {
                    validators: {
                          regexp: {
                            regexp: /^['~a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    },
                },
                stud_dp: {
                  validators: {
                    notEmpty: {
                            message: 'Formal Picture is required and can\'t be empty'
                        },
                      file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 512000,   // 500kb
                        message: 'The selected file is not valid,it should be (jpeg,jpg,png) and 500KB at maximum size'
                      }
                    }
                },
                year: {
                    validators: {
                        notEmpty: {
                            message: 'Year level is required and can\'t be empty'
                        },
                    },
                },
                program_id: {
                    validators: {
                        notEmpty: {
                            message: 'Program code is required and can\'t be empty'
                        },
                    },
                },
                resume_data: {
                    validators: {
                      notEmpty: {
                            message: 'Resume is required and can\'t be empty'
                        },
                          file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: 1048576, // 1mb
                            message: 'The selected file is not valid,it should be (pdf) and 1MB at maximum size'
                          }
                    }
                }
            }
        }) 
  });
</script>
<!-- end: Javascript -->
</body>
</html>