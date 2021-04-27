<?php
ob_start("ob_gzhandler");
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';

$rnd_ai = (mt_rand(1000,10000));
$year = date('Y');
$interviewer_user = 'CMI'.$year.$rnd_ai ;
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
  <script src="asset/js/sweetalert-dev.js"></script>
  <link rel="shortcut icon" href="asset/img/e2elogoc.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                       <p class="animated fadeInRight" style="color:gray;margin-left:10px;margin-top:20px;text-align:center;">
                               <?php
                                 echo  date("l, F j, Y"); 
                               ?>
                        </p>
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
                        <h1 class="animated fadeInLeft">Inteviewer Registration</h1>
                    </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                 <?php
                 if(isset($_GET['success'])) 
                    {           
                     echo '<script language = javascript>
                     swal({
                        title: "Successfully Registered!",
                         html: true,
                        type: "success",
                        showCancelButton: false,
                        
                        confirmButtonText: "OK",
                        closeOnConfirm: false,
                        closeOnCancel: false
                      },
                      function(isConfirm){
                        if (isConfirm) {
                          window.location.href="e2e_company_mi_login.php";
                        }
                      });
                  </script>';
                    } 
                  ?>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-body">
                      <form method="post" action="e2e_interviewer_reg_process.php" id="reg" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-5">
                            <h5 style="padding-left:5px;">YOUR USERNAME & PASSWORD</h5>
                            <input type="hidden" name="interviewer_user" value="<?php echo $interviewer_user; ?>" />
                            <h4 style="padding-left:5px;font-size:25px;font-weight:bold;"><?php echo $interviewer_user; ?></h4>
                          </div>
                          <div class="col-md-7"> 
                            <h5>COMPANY NAME</h5>
                            <div class="form-group has-feedback">
                              <input type="text" list="suggestion" class="form-control" name="comp_name" id="event_name"/>
                                <?php
                                  $query_nmi_list=$database->query("SELECT * FROM nop_mock_interview");
                                  print'<datalist id="suggestion">';      
                                  foreach($query_nmi_list  AS $query_nmi_list_data){
                                    $comp_id = $query_nmi_list_data["comp_id"];

                                    $table = "company_info";
                                    $columns = "*";
                                    $where = ["comp_id" => $comp_id];
                                    $q_company = $database->select($table,$columns,$where);
                                    foreach($q_company  AS $q_company_data){
                                      $comp_id = $q_company_data["comp_id"];
                                      $comp_name = $q_company_data["comp_name"];
                                      echo "<option data-value='".$comp_id."'>".$comp_name."</option>";
                                    } 
                                  }
                                ?>
                                <input type="hidden" name="event_name-hidden" id="event_name-hidden"/>
                                <script>
                                  document.querySelector('input[list]').addEventListener('input', function(e) {
                                    var input = e.target,
                                    list = input.getAttribute('list'),
                                    options = document.querySelectorAll('#' + list + ' option'),
                                    hiddenInput = document.getElementById(input.id + '-hidden'),
                                    inputValue = input.value;
                                    hiddenInput.value = inputValue;
                                    for(var i = 0; i < options.length; i++) {
                                      var option = options[i];
                                      if(option.innerText === inputValue) {
                                        hiddenInput.value = option.getAttribute('data-value');
                                        break;
                                      }
                                    }
                                  });
                                </script>
                                <?php
                                  print '</datalist>';
                                ?>
                              </div>
                            </div> 
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <h5>LAST NAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="lname" class="form-control" placeholder="Last Name" />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <h5>FIRST NAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="fname" class="form-control" placeholder="First Name" />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <h5>POSITION</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="position" class="form-control" placeholder="Position" />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                              <h5>CONTACT NUMBER</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="contact_no" class="form-control" placeholder="Contact Number" />
                              </div>
                            </div>
                            <div class="col-md-5">
                              <h5>EMAIL</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="email" class="form-control" placeholder="Email" />
                              </div>
                            </div>
                            <div class="col-md-1"></div>
                          </div>
                          <div class="row"><br><br>
                          <div class="col-md-6"></div>
                          <div class="col-md-3">
                            <button type="submit" class="btn btn-success btn-block" name="btn_reg" id="btn-add"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button>
                          </div>
                          <div class="col-md-3">
                              <a href="e2e_company_mi_login.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- end: content --> 
      </div>
    </div>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft"></div>
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
<script src="asset/js/plugins/nouislider.min.js"></script>
<script src="asset/js/plugins/jquery.validate.min.js"></script>

<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#reg')
    .bootstrapValidator({
      message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                comp_name: {
                    validators: {
                        notEmpty: {
                            message: 'Company name is required and can\'t be empty'
                        }
                    }
                }, 
                lname: {
                    message: 'Last name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Last name is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 2,
                            max: 30,
                            message: 'Last name must be more than 2 and less than 30 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                fname: {
                    message: 'First name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'First name is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 2,
                            max: 30,
                            message: 'First name must be more than 2 and less than 30 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                position: {
                    message: 'Position is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Position is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 2,
                            max: 30,
                            message: 'Position must be more than 2 and less than 30 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z 0-9 /]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                email: {
                    message: 'Email is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Email is required and can\'t be empty'
                        },
                    emailAddress:{
                            message: 'Incorrect email'
                        },
                    }
                },          
            }
      })
  });
</script>

<!-- custom -->
<script src="asset/js/main.js"></script>
</body>
</html>