<?php
date_default_timezone_set('Asia/Manila');
	$user="sticaloo_e2e2";
	$pass="e2eadmin";
	$db="sticaloo_ojtassisti";
	$con=mysqli_connect('localhost',$user,$pass,$db);
	$msg = "";
	$msg2 = "";
  if(isset($_GET['msg'])){
	$msg = "A message was sent to your email. Please follow the instructions to reset your password.";
  }
  if (isset($_POST['btn_send']))  {
	$stud_id = $_POST['stud_no'];
	$msg = "";
	$msg2 = "";
  //Email information
  $admin_email = "no-reply@my.sticaloocan.edu.ph";
  //check if there is a pending request
  $q_check = "select * from forget_password_handler where user_id='$stud_id'";
  $q_check_res = $con->query($q_check);
  
  if($q_check_res->num_rows > 0){
		$check = $q_check_res->fetch_assoc();
		$existingReq = $check['link_expiry'];
		date_default_timezone_set('Asia/Manila');
		$cur_time = time();
 
		if($existingReq > $cur_time){
			// Pag nagrequest pero meron na tpos valid pa
			  $msg = "A Reset Password link is already sent to your email. Please check your email inbox";
		}else{
			//meron existing sa handler pero expired
			  $q_deleteExpired ="delete from forget_password_handler where user_id='$stud_id'";
			  $q_deleteExpired_res = $con->query($q_deleteExpired);
 
			  $q_studemail = "select * from student_info where stud_no='$stud_id'";
			  $q_studemail_res = $con->query($q_studemail);
			  if($q_studemail_res->num_rows > 0){
			  $studemail= $q_studemail_res->fetch_assoc();
			  $email = $studemail['email'];
 
			  date_default_timezone_set('Asia/Manila');
			  $request_time = time();
			  $link_expiry = $request_time + 86400;
			  $encrypted_link= rand(1000000000, 9999999999);
 
			  $q_recordrequest = "insert into forget_password_handler (user_id,encrypted_code,link_expiry) values ('$stud_id','$encrypted_link','$link_expiry')";
			  $q_recordrequest_res = $con->query($q_recordrequest);
			
			//  $msg = "A message was sent to your email. Please follow the instructions to reset your password.";
			
			header("Location: http://sticaloocan.edu.ph/ojtassisti/mail/send_mail.php?stud_forget_pass=ok&subject=$subject&email=$email&admin_email=$admin_email&encrypted_link=$encrypted_link&stud_id=$stud_id&msg=$msg");
			
 
 
			}else{
				$msg2 = "Student number does not exist.";
			}
		}
 
  }else{
 
		  $q_studemail = "select * from student_info where stud_no='$stud_id'";
		  $q_studemail_res = $con->query($q_studemail);
		  if($q_studemail_res->num_rows > 0){
		  $studemail= $q_studemail_res->fetch_assoc();
		  $email = $studemail['email'];
 
		  date_default_timezone_set('Asia/Manila');
		  $request_time = time();
		  $link_expiry = $request_time + 86400;
		  $encrypted_link= rand(1000000000, 9999999999);
 
		  $q_recordrequest = "insert into forget_password_handler (user_id,encrypted_code,link_expiry) values ('$stud_id','$encrypted_link','$link_expiry')";
		  $q_recordrequest_res = $con->query($q_recordrequest);
		  
		  $msg = "";
			
		  header("Location: http://sticaloocan.edu.ph/ojtassisti/mail/send_mail.php?stud_forget_pass=ok&subject=$subject&email=$email&admin_email=$admin_email&encrypted_link=$encrypted_link&stud_id=$stud_id&msg=$msg");
		  
 
		}else{
			//student number does not exist.
			$msg2 = "Student number does not exist.";
		}
                }
   }
 
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>OJT-assiSTI</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link rel="icon" href="assets/img/icon.png">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
 <!--main content start-->
      <section >
          <section>
		  <div style="padding-top:20px"  class="">
          	<!-- WEATHER-2 PANEL -->
						<div class="col-lg-12 col-md-12 col-sm-12 mb">
							<div class="weather-2">		
								<div style="padding-top:15px">
									<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-10 col-xs-10">
											<p style="font-size:20px;padding-top:7px;">FORGOT PASSWORD</p>
										</div>
									</div>
									</div><!-- /weather-2 header -->
								<form method="POST" id="d_form" enctype="multipart/form-data">
									<input type="hidden" name="this_stud_no" value="<?php echo $stud_no; ?>">
									<div class="row" style="padding-top:20px">
									<div class="col-md-12" name="message/error">
									   <span style="color:green;"><?php echo $msg;?></span>
									  <span style="color:red;"><?php echo $msg2;?></span>
									  </div>
									 <div class="col-md-3">
										<h5 style="padding-left:5px;">Please enter your Student number:</h5>
										<div class="form-group has-feedback">
											<input class="form-control" type="text" id="stud_no" name="stud_no"/>
										</div>
									</div>
									
									</div>
									<div class="row">
									<div class="col-md-6">
										<div class="form-group has-feedback">
											<button type="submit" name="btn_send" class="btn btn-default">Submit&nbsp;<span class="fa fa-check"></span></button>
										</div>
									</div>
									</div>
									
									
									
								</form>
							</div>
						</div><!--/col-md-4 -->
		  </div>
		</section><!--/wrapper -->
		
      </section><!--/MAIN CONTENT -->

      <!--main content end-->
      
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
	<script src="assets/js/bootstrapValidator.js"></script>
	<script src="assets/js/plugins/jquery.validate.min.js"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    <script type="text/javascript">
		$(document).ready(function(){
			$('#d_form')
			.bootstrapValidator({
            message: 'This value is not valid',
            
        fields:
		{
			stud_no:
			{
                validators:
					{
                        notEmpty:
							{},
                        regexp:
							{
								regexp: /[aA 0-9]/,
								
							},
                        stringLength:
							{
								max: 100,
							},
					}
			},
		}
			});
		});
	</script>
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
