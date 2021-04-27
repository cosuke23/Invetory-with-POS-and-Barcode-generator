<?php
	$user="sticaloo_e2e2";
	$pass="e2eadmin";
	$db="sticaloo_ojtassisti";
	$con=mysqli_connect('localhost',$user,$pass,$db);
	$msg = " ";
	$msg2 = " ";
//if "email" variable is filled out, send email
if(isset($_GET['msg'])){
	$msg = "A message was sent to your email. Please follow the instructions to reset your password.";
  }
  if (isset($_REQUEST['username']))  {
	$username = $_POST['username'];
	
  //Email information
  $admin_email = "no-reply@my.sticaloocan.edu.ph";
  //check if there is a pending request
  $q_check = "select * from forget_password_handler where user_id='$username'";
  $q_check_res = $con->query($q_check);
  if($q_check_res->num_rows > 0){
		
		$check = $q_check_res->fetch_assoc();
		$existingReq = $check['link_expiry'];
		date_default_timezone_set('Asia/Manila');
		$cur_time = time();
		
		if($existingReq > $cur_time){
			  $msg = "A Reset Password link is already sent to your email. Please check your email inbox";
		}else{
			  $q_deleteExpired ="delete from forget_password_handler where user_id='$username'";
			  $q_deleteExpired_res = $con->query($q_deleteExpired);
		
			 //get user type to know what table we will fetch the email 
		  $q_usertype = "select * from user where username='$username'";
		  $q_usertype_res = $con->query($q_usertype);
		  if($q_usertype_res->num_rows > 0){
		  $usertype = $q_usertype_res->fetch_assoc();
		  $type = $usertype['usertype'];
		  
		  if($type == 1){
			  $q_useremail = "select * from admin_info where admin_id='$username'";
			  $q_useremail_res = $con->query($q_useremail);
			  $useremail= $q_useremail_res->fetch_assoc();
			  $email = $useremail['email'];
		  }
		  if($type == 2){
			  $q_useremail = "select * from adviser_info where adviser_id='$username'";
			  $q_useremail_res = $con->query($q_useremail);
			  $useremail= $q_useremail_res->fetch_assoc();
			  $email = $useremail['email'];
		  }
		  
		  date_default_timezone_set('Asia/Manila');
		  $request_time = time();
		  $link_expiry = $request_time + 86400;
		  $encrypted_link= rand(1000000000, 9999999999);
		  
		  $q_recordrequest = "insert into forget_password_handler (user_id,encrypted_code,link_expiry) values ('$username','$encrypted_link','$link_expiry')";
		  $q_recordrequest_res = $con->query($q_recordrequest);
		  
		 header("Location: http://sticaloocan.edu.ph/ojtassisti/mail/send_mail.php?user_forget_pass=ok&subject=$subject&email=$email&admin_email=$admin_email&encrypted_link=$encrypted_link&username=$username&msg=$msg");
		  
		  //Email response
		  $msg = "A message was sent to your email. Please follow the instructions to reset your password.";
		  }else{
			//invalid username
			$msg2 = "Invalid username!";
			}
		}
		
		
  }else{
		  //get user type to know what table we will fetch the email 
		  $q_usertype = "select * from user where username='$username'";
		  $q_usertype_res = $con->query($q_usertype);
		  if($q_usertype_res->num_rows > 0){
		  $usertype = $q_usertype_res->fetch_assoc();
		  $type = $usertype['usertype'];
		  
		  if($type == 1){
			  $q_useremail = "select * from admin_info where admin_id='$username'";
			  $q_useremail_res = $con->query($q_useremail);
			  $useremail= $q_useremail_res->fetch_assoc();
			  $email = $useremail['email'];
		  }
		  if($type == 2){
			  $q_useremail = "select * from adviser_info where adviser_id='$username'";
			  $q_useremail_res = $con->query($q_useremail);
			  $useremail= $q_useremail_res->fetch_assoc();
			  $email = $useremail['email'];
		  }
		  
		  date_default_timezone_set('Asia/Manila');
		  $request_time = time();
		  $link_expiry = $request_time + 86400;
		  $encrypted_link= rand(1000000000, 9999999999);
		  
		  $q_recordrequest = "insert into forget_password_handler (user_id,encrypted_code,link_expiry) values ('$username','$encrypted_link','$link_expiry')";
		  $q_recordrequest_res = $con->query($q_recordrequest);
		  
		  
		  header("Location: http://sticaloocan.edu.ph/ojtassisti/mail/send_mail.php?user_forget_pass=ok&subject=$subject&email=$email&admin_email=$admin_email&encrypted_link=$encrypted_link&username=$username&msg=$msg");

		  //Email response
		  $msg = "A message was sent to your email. Please follow the instructions to reset your password.";
		  }else{
			//invalid username
			$msg2 = "Invalid username!";
		}
		}
  }
 
?>
 
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

<body class="dashboard">
      <!-- start: Header -->		 
        <nav class="navbar navbar-custom header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
              
                <a href="#" class="navbar-brand"> 
                 <b>OJT assiSTI</b>
                </a>
            </div>
          </div>
        </nav>
      <!-- end: Header -->
          <!-- start: Content -->
           <div style="padding-top:50px;">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">FORGOT PASSWORD</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;color:red;">
                         
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                
                  <div class="panel">
                    <div class="panel-heading"><h3>CHANGE PASSWORD</h3></div>
					
                    <form id="defaultForm" method="post">
					<div class="panel-body" style="padding-bottom:30px;">
                      	<div class="row">
                      		<div class="col-md-3"></div>
                      		<div class="col-md-6">
							</div>
                      	</div>
                      	<br>
                        <div class="row" style="padding-left:5px;">
                        
						<div class="col-md-4">
                        	 <h4 style="padding-left:5px;">PLEASE ENTER YOUR USERNAME</h4>
                        </div>
						
                          <div name="message/error">
						   <span style="color:green;"><?php echo $msg;?></span>
						  <span style="color:red;"><?php echo $msg2;?></span>
						  </div>
						  <div class="col-md-3">
                               <div class="form-group has-feedback">
                                <input type="text" name="username" id="username" class="form-control"/>
								
						   </div>
                          </div> 						  
                        </div>
                         <div class="row">
                            <div class="col-md-5"></div>                       
                            <div class="col-md-1">
                                 <button type="submit" class="btn btn-warning btn-block"  name="btn_reset" id="btn_reset">
                                  Submit
                                 </button>
                             </div>
                          </div>

                      </div><!--ENd of panel body-->
                      </form>
                      </div>
                     </div>
					 </div>
             <!-- end: content -->
      
      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
              
            </div>
        </div>       
      </div>
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

   $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        fields: {
        username: {
            validators: {
                        notEmpty: {
                            message: 'Required field'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z 0-9]+$/,
                            message: 'Invalid character'
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