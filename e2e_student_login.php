<?php
// Start the session..
//session_start();
$page_title = 'E2E Login Page';
if(isset($_COOKIE["sid"])) {
  header ("Location: find_cookie_location.php");
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
  <title>E2E SYSTEM V2</title>
  <!-- start: Css -->
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
    
    <?php
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
    ?>
    <style type="text/css">
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button{
        -webkit-appearance: none;
        margin-0;
      }
    </style>
    </head>

    <body id="mimin" class="dashboard form-signin-wrapper2">
      <div class="container" style="margin-top:20px;">
        <div  class="form-signin">
          <div class="panel2 periodic-login">
              <span class="atomic-number">WELCOME!</span>
              <div class="panel-body text-center">
                  <div>
                  <img src="asset/img/e2elogoc.png" alt="e2e Logo" style="height:100px;">
                   </div>
                   <br>
                 <div id="error">
                 </div>         
             <?php
             if(isset($_POST["btn-login"])) {
            sleep(2);
            $username = $_POST["validate_username"];
            $password = $_POST["validate_password"];
    
        $table = "student_info";
        $columns = ["si_id","stud_no","password"];
        $where = ["AND"=>
                [
                 "stud_no"=>$username,
                 "password"=>$password
                ]
            ];

             $sqlcu=$database->select($table,$columns,$where);
            
             foreach ($sqlcu as $sqlcu_data)

              $si_id =$sqlcu['si_id'];
             {
              if($sqlcu_data["si_id"]==$si_id)
              { 
                setcookie('stud_no',$sqlcu_data["stud_no"],time() + 86400);
                header ("Location: e2e_student_home.php?stud_no=$username");
                exit;
              }
            else {
              setcookie('error','1',time() + 86400);
              header ("Location: e2e_student_login.php");
              exit;   
            }
          }
        }
            ?> 
             
                  <form id="signupForm" method="POST" class="form-signin">
              <div class="form-group form-animate-text" style="margin-top:40px !important;" >
                            
                            <input type="number" class="form-text" id="validate_username" name="validate_username" maxlength="11" 
                             >
                              <span class="bar"></span>
                              <label class="customlabel">Student Number:</label>
                            </div>
                            <div class="form-group form-animate-text" style="margin-top:40px !important;">
                              <input type="password" class="form-text" id="validate_password" name="validate_password" maxlength="32">
                              <span class="bar"></span>
                              <label class="customlabel">Password: (<b style="">Middlename</b>)</label>
                            </div>                     
                             <button type="submit" class="btn btn-primary btn-info btn-lg btn-block" name="btn-login" id="btn-login">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                            </button> 
                      </form>
              </div>
                <div class="text-center">
                <h4 style="color:white;margin-top:-10px;" id="check_student_number"> Not yet registered ? Click here! </h4>
                </div>
        
          </div>
        </div>
      </div>
      <!-- end: Content -->
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
          
        },
        validate_username: {
          required: true,
          minlength: 11
        }
    },
      messages: {
        validate_username: {
          required: "Please enter a Student Number",
          minlength: "Your Student Number must be consist of 11 numbers"
        },
        validate_password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 4 characters long"
        }
      },
     submitHandler: submitForm
    });

   function submitForm()
     {    
      var data = $("#signupForm").serialize();
      var error  ="Incorrect usernname or password";
      $.ajax({    
      type : 'POST',
      url  : 'student_login_process.php',
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
            setTimeout('window.location.href = "e2e_student_home.php"; ',1000);
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
   $('#check_student_number').click(function(){
    swal({
  title: "CHECK STUDENT NUMBER",
  text: "Type Your New Student Number:",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  inputPlaceholder: "Type your New Student Number here..",
  showLoaderOnConfirm: true,

},
  function(inputValue){
    var regex = /^[0-9]+$/;
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("You need to write something!");
      return false;
    }
    if (!inputValue.match(regex)) {
      swal.showInputError("Student Number only consist of numbers!");
      return false;
    }
    if (inputValue.length !== 11) {
    swal.showInputError("Student Number must be 11 numbers!");
    return false;
    }
    else{
        $.ajax({
          method:'GET',
          url: 'check_student_number.php?inputValue='+inputValue,
          success : function(response){
            if(response=="ok"){
              swal.showInputError("Student Number already exist!");
            }else{
              setTimeout(function(){
                 window.location.href="student_registration_2.php?stud_no="+inputValue;  
                //swal("Ajax request finished!");
              }, 1200);      
            }
          }
        });
        return false;
     //end of function student number   
      }  
    });
  });
});
     </script>
     <!-- end: Javascript -->
   </body>
   </html>