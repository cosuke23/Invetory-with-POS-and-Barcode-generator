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
			$email = $_GET['email'];
			
			$q_check = "SELECT * FROM official_student_list WHERE stud_no='$stud_no' AND status='Approved'";
			$r_check = mysqli_query($dbc, $q_check);
			if(mysqli_num_rows($r_check)>0)
			{
				$row_ol = mysqli_fetch_assoc($r_check);
				$stud_no_ol = $row_ol["stud_no"];
				$lname_ol = $row_ol["lname"];
				$fname_ol = $row_ol["fname"];
				$mname_ol = $row_ol["mname"];
				$program_ol = $row_ol["program_code"];

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
                      <form role="form" id="dForm" name="dForm" method="POST" enctype="multipart/form-data" action="web_registration2.php">    
						<div class="alert alert-success">
						<h4>Note: Required field (<span style="color:red;">*</span>)</h4>
						</div>
						<?php
							if(isset($_GET['error']))
							{
								print '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                                     <span class="fa fa-remove"></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>Invalid Birthday!<br>You must atleast 16 years old above.</strong>
                               </div>';
							}
						?>							   
						<div class="form-group">
                            <h4>Student number:</h4>
							<h5><b><?php echo $stud_no;?></b></h5>
							<input type="hidden" name="stud_no" value="<?php echo $stud_no;?>"/>
                        </div>
						
						<div class="form-group">
							<h4>Full name:</h4>
							<h5><b><?php echo $lname_ol.", ".$fname_ol." ".$mname_ol;?></b></h5>
							<input type="hidden" name="lname" value="<?php echo $lname_ol;?>" />
							<input type="hidden" name="fname" value="<?php echo $fname_ol;?>"/>
							<input type="hidden" name="mname" value="<?php echo $mname_ol;?>"/>
							  
						</div>
						
						<div class="form-group">
                            <h4>Email address:</h4>
							<h5><b><?php echo $email;?></b></h5>
							<input type="hidden" name="email" value="<?php echo $email;?>" />
						</div>
						
						<div class="form-group">
                            <h4>Gender:<span style="color:red;">*</span></h4>
							<select class="form-control" name="gender">
								<option value="<?php if(isset($_GET['gender'])){$gender=$_GET['gender']; echo $gender;}?>"><?php if(isset($_GET['gender'])){$gender=$_GET['gender']; echo $gender;}?></option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div>
						
						<div class="form-group">
							<h4>Birthday:<span style="color:red;">*</span></h4>
							<input type="date" name="bday" id="bday" class="form-control" value="<?php if(isset($_GET['bday'])){$bday=$_GET['bday']; echo $bday;}?>"/>
                        </div>
						
						<div class="form-group">
							<h4>Program:</h4>
							<h5><b><?php echo $program_ol;?></b></h5>
							<?php
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
							<input type="hidden" name="program_id" id="program_id" value="<?php echo $program_id;?>"/>
                        </div>
						
						<h3><b>Contact Information</b></h3>
						  
						  <div class="form-group">
							<h4>Address:<span style="color:red;">*</span></h4>
							<textarea type="address" name="address" id="address" class="form-control"><?php if(isset($_GET['address'])){$address=$_GET['address']; echo $address;}?></textarea>
                        </div>
						
						  <div class="form-group">
							<h4>Facebook:</h4>
							<input type="text" name="facebook" id="facebook" class="form-control" placeholder="(Optional)" value="<?php if(isset($_GET['facebook'])){$facebook=$_GET['facebook']; echo $facebook;}?>"/>
                        </div>
						
						<div class="form-group">
							<h4>Telephone number:</h4>
							<input type="text" name="tel_no" id="tel_no" class="form-control" placeholder="(Optional)" value="<?php if(isset($_GET['tel_no'])){$tel_no=$_GET['tel_no']; echo $tel_no;}?>" maxlength="7"/>
                        </div>
						
						<div class="form-group">
							<h4>Mobile number:<span style="color:red;">*</span></h4>
							<input type="text" name="mob_no" id="mob_no" class="form-control" value="<?php if(isset($_GET['mob_no'])){$mob_no=$_GET['mob_no']; echo $mob_no;}?>" maxlength="11"/>
                        </div>
						  
						  <div class="form-group">
						  <button type="submit" name="btn_reg" class="btn btn-theme">Continue >>></button>
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
		gender: {
                    validators: {
                        notEmpty: {}
                    }
                },
        email: {
            validators:{
                        notEmpty: {},
            emailAddress: {
							
                            message: 'Invalid email address'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    }
                },
		bday: {
			validators:{
				notEmpty:{},
			}
		},
		address: {
			validators:{
				notEmpty:{},
				
			}
		},
		tel_no:{
			validators:{
				stringLength: {
								min: 7,
								max: 7,
							},
					regexp: {
								regexp: /[0-9]+$/,
								message: 'Mobile number can only consist of numbers'
							},
			}
		},
		mob_no: {
			validators: {
				notEmpty:{},
				stringLength: {
                            min: 11,
                            max: 11,
                        },
				regexp: {
                            regexp: /[0-9]+$/,
                            message: 'Mobile number can only consist of numbers'
                        },
			},
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
