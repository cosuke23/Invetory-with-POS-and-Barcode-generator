<!DOCTYPE html>
<html lang="en">
  <head>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';

		if(isset($_GET['stud_no']))
		{
			$stud_no = $_GET['stud_no'];
			
			$q_check = "SELECT * FROM official_student_list WHERE stud_no='$stud_no' AND status='Approved'";
			$r_check = mysqli_query($dbc, $q_check);
			if(mysqli_num_rows($r_check)>0)
			{
				$q_check2 = "SELECT * FROM student_info WHERE stud_no='$stud_no'";
				$r_check2 = mysqli_query($dbc, $q_check2);
				if(mysqli_num_rows($r_check2)>0)
				{
					header("Location: login.php?error3=1");
					exit;
				}
			}
			else
			{
				header("Location: login.php?error3=1");
				exit;
			}
		}
		
	?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>OJT-assiSTI - Registration</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
        
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
      
      <!--header start-->
      <header class="header black-bg">
            <!--logo start-->
            <a href="#" class="logo"><b>OJT-assiSTI</b></a>
            <!--logo end-->
         </header>
      <!--header end-->
      
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="">
          <section class="wrapper">
          	<!-- INLINE FORM ELELEMNTS -->
          	<div class="row">
          		<div class="col-lg-12">
				<h3><b>Student Registration</b></h3>
          			<div class="form-panel">
                      <form class="form-inline" role="form" id="dForm" name="dForm" method="POST" action="email_validator_process.php">    
						
					<div class="form-group">
                              <h4>Email Address:</h4>
							    <?php 
								if(isset($_GET['error']))
								{
									print '<div><label style="font-size:14px;color:red;">&nbsp;<b>Email address exists.</b></label></div>';
								}
								?>
							  <input type="text" class="form-control" id="email" name="email"/>
							  <input type="hidden" name="stud_no" value="<?php echo $stud_no;?>"/>
                          </div>
                          <div>
						  <button type="submit" name="btn_email" class="btn btn-theme">Validate</button>
						  </div>
					  </form>
          			</div><!-- /form-panel -->
          		</div><!-- /col-lg-12 -->
          	</div><!-- /row -->
          	
          	
		</section><!-- /wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2016 - OJT-assiSTI
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
	
	<script src="assets/js/plugins/jquery.validate.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrapValidator.js"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

	<!--custom switch-->
	<script src="assets/js/bootstrap-switch.js"></script>
	
	<!--custom tagsinput-->
	<script src="assets/js/jquery.tagsinput.js"></script>
	
	<!--custom checkbox & radio-->
	
	<script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	<script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
	
	
	<script src="assets/js/form-component.js"></script>    

<script type="text/javascript">
$(document).ready(function(){
$('#dForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            
        fields: {
        email: {
            validators:{
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
