<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>APOSYS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Carlos Alvarez - Alvarez.is">

    <!-- Le styles -->
   
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

    <style type="text/css">
      body {
        padding-top: 30px;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets1/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets1/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets1/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets1/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets1/ico/apple-touch-icon-57-precomposed.png">

  	<!-- Google Fonts call. Font Used Open Sans & Raleway -->
	<link href="http://fonts.googleapis.com/css?family=Raleway:400,300" rel="stylesheet" type="text/css">
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

  	<!-- Jquery Validate Script -->
    <script type="text/javascript" src="assets/js/jquery.validate.js"></script>

  	<!-- Jquery Validate Script - Validation Fields -->
		<script type="text/javascript">
		$.validator.setDefaults({
			submitHandler: function() { window.open ('dashboard.html','_self',false) }
		});
		
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#commentForm").validate();
		
			// validate signup form on keyup and submit
			$("#signupForm").validate({
				rules: {
					firstname: "required",
					lastname: "required",
					username: {
						required: true,
						minlength: 1
					},
					password: {
						required: true,
						minlength: 1
					},
					confirm_password: {
						required: true,
						minlength: 2,
						equalTo: "#password"
					},
					email: {
						required: true,
						email: true
					},
					topic: {
						required: "#newsletter:checked",
						minlength: 2
					},
					agree: "required"
				},
				messages: {
					firstname: "Please enter your firstname",
					lastname: "Please enter your lastname",
					username: {
						required: "Please enter a username",
						minlength: "Your username must consist of at least 1 character"
					},
					password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 1 character long"
					},
					confirm_password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						equalTo: "Please enter the same password as above"
					},
					email: "Please enter a valid email address",
					agree: "Please accept our policy"
				}
			});
		
			// propose username by combining first- and lastname
			$("#username").focus(function() {
				var firstname = $("#firstname").val();
				var lastname = $("#lastname").val();
				if(firstname && lastname && !this.value) {
					this.value = firstname + "." + lastname;
				}
			});
		
			//code to hide topic selection, disable for demo
			var newsletter = $("#newsletter");
			// newsletter topics are optional, hide at first
			var inital = newsletter.is(":checked");
			var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
			var topicInputs = topics.find("input").attr("disabled", !inital);
			// show when newsletter is checked
			newsletter.click(function() {
				topics[this.checked ? "removeClass" : "addClass"]("gray");
				topicInputs.attr("disabled", !this.checked);
			});
		});
		</script>

</head>
  <body style="background-image: url('assets/img/e2efooter.jpg')">

  	<!-- NAVIGATION MENU -->



    <div class="container" >
        <div class="row" >
   		<div class="col-lg-offset-4 col-lg-4" style="margin-top:100px" >
   			<div class="block-unit" style="text-align:center; padding:8px 8px 8px 8px;" >
   				<br>
   				<br>
					<form id="login_form1" class="form-signin" method="post">
						<h3 class="form-signin-heading"><i class="icon-lock" ></i> <font color="blue"> Sign in</font></h3>
						<input type="text" class="input-block-level" id="username" minlength="4" name="username" placeholder="Student ID" required>
					</br>
					</br>
						<input type="password" class="input-block-level" id="password" minlength="4" name="password" placeholder="Middle/Surname" required>
					<td>	<button data-placement="right" title="Click Here to Sign In" id="signin" name="login" class="btn btn-info" type="submit"><i class="icon-signin icon-large"></i> Sign in</button></td>
													</br>
													
														<script type="text/javascript">
														$(document).ready(function(){
															$('#signin').tooltip('show');
															$('#signin').tooltip('hide');
														});
														</script>		
			</form>
 
						<script>
						jQuery(document).ready(function(){
						jQuery("#login_form1").submit(function(e){
								e.preventDefault();
								var formData = jQuery(this).serialize();
								$.ajax({
									type: "POST",
									url: "login23.php",
									data: formData,
									success: function(html){
									if(html=='true_adviser')
									{
									$.jGrowl("Loading File Please Wait......", { sticky: true });
									$.jGrowl("Login Successful");
									var delay = 1000;
										setTimeout(function(){ window.location = 'adviser/d_adviser.php'  }, delay);  
									}else if (html == 'true_student'){
										$.jGrowl("Login Successful");
									var delay = 1000;
										setTimeout(function(){ window.location = 'student/checker.php'  }, delay);  
									}
									else if (html == 'pending_student'){
										$.jGrowl("Login Successful");
									var delay = 1000;
										setTimeout(function(){ window.location = 'student/student_notifications.php'  }, delay);  
									}
									else if (html == 'buko'){
										$.jGrowl("Login Successful");
									var delay = 1000;
										setTimeout(function(){ window.location = 'student/choose.php'  }, delay);  
									}else if (html == 'oa'){
										$.jGrowl("Login Successful");
									var delay = 1000;
										setTimeout(function(){ window.location = 'student/student_audition.php'  }, delay);  
									}




									else if(html == 'true_admin'){
										$.jGrowl("Login Successful");
										var delay = 1000;
										setTimeout(function(){ window.location ='admin/admin_user.php'	},delay);
									}else if(html == 'true_staff'){
										$.jGrowl("Login Successful");
										var delay = 1000;
										setTimeout(function(){ window.location ='student/dashboard.php'	},delay);
									}else if(html == 'true_parent'){
										$.jGrowl("Login Successful");
										var delay = 1000;
										setTimeout(function(){ window.location ='view_grade.php'	},delay);
									}

									else
									{
									$.jGrowl("Please Check your username and Password", { header: 'Login Failed' });
									}
									}
								});
								return false;
							});
						});

						</script>
										<script type="text/javascript">
														$(document).ready(function(){
															$('#signin_student').tooltip('show'); $('#signin_student').tooltip('hide');
														});
														</script>	
														<script type="text/javascript">
														$(document).ready(function(){
															$('#signin_teacher').tooltip('show'); $('#signin_teacher').tooltip('hide');
														});
														</script>	
      
				
						
						</table>

<table align=center>
<tr>
<td><p><div id="result" style="display:none;"> </div> </td></tr>

</table>


<p>
<p>

   			</div>

   		</div>


        </div>
    </div>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    
  
</body></html>