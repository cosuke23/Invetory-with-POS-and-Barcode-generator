<?php
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
date_default_timezone_set('Asia/Manila');
if(isset($_POST['btn_reg']))
{
    $stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
    $lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));
    $fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
    $mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));
    $gender =  mysqli_real_escape_string($dbc, trim($_POST['gender']));
    $bday =  mysqli_real_escape_string($dbc, trim($_POST['bday']));
    $program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

    $email =  mysqli_real_escape_string($dbc, trim($_POST['email']));
    $mobile_no =  mysqli_real_escape_string($dbc, trim($_POST['mob_no']));
    $tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));
    $address =  mysqli_real_escape_string($dbc, trim($_POST['address']));
    $facebook =  mysqli_real_escape_string($dbc, trim($_POST['facebook']));
    $bday2 = date('Y-m-d', strtotime(str_replace('-', '/', $bday)));

    $bday3 = strtotime($bday2);
    $valid = "968774400";
    if($bday3 > $valid){
      header("Location: web_registration.php?error=1&stud_no=$stud_no&email=$email&lname=$lname&mname=$mname&fname=$fname&gender=$gender&mob_no=$mobile_no&tel_no=$tel_no&address=$address&facebook=$facebook");
    }
}
if(isset($_GET['stud_no']))
		{
			$stud_no = $_GET['stud_no'];
			$email = $_GET['email'];
			
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
<!DOCTYPE html>
<html lang="en">
  <head>
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
                      <form role="form" id="dForm" name="dForm" method="POST" action="web_registration_process.php">    
						<h3><b>OJT Records Information <?php echo $stud_no;?></b></h3>
								<input type="hidden" name ="stud_no" value ="<?php echo $stud_no; ?>" />
                                <input type="hidden" value="<?php echo $lname;?>" name="lname" id="lname"/>
                                <input type="hidden" value="<?php echo $fname;?>" name="fname" id="fname"/>
                                <input type="hidden" value="<?php echo $mname;?>" name="mname" id="mname"/>
                                <input type="hidden" value="<?php echo $gender;?>" name="gender" id="gender"/>
                                <input type="hidden" value="<?php echo $bday2;?>" name="bday" id="bday"/>
                                <input type="hidden" value="<?php echo $program_id;?>" name="program_id" id="program_id"/>
                                <input type="hidden" value="<?php echo $address;?>" name="address" id="address"/>
								<input type="hidden" value="<?php echo $email;?>" name="email" id="email"/>
                                <input type="hidden" value="<?php echo $facebook;?>" name="facebook" id="facebook"/>
                                <input type="hidden" value="<?php echo $tel_no;?>" name="tel_no" id="tel_no"/>
                                <input type="hidden" value="<?php echo $mobile_no;?>" name="mobile_no" id="mobile_no"/>
                            
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
							
							$q_say = "SELECT * FROM active_semester_acad_year";
							$r_say = mysqli_query($dbc, $q_say);
							if(mysqli_num_rows($r_say)>0)
							{
								$rw_say = mysqli_fetch_assoc($r_say);
								$semester = $rw_say['active_semester'];
								$acad_year_start = $rw_say['active_acad_year_start'];
								$acad_year_end = $rw_say['active_acad_year_end'];
							}
						?>							   
						<div class="form-group">
                            <h4>Enrolled Status:</h4>
							<h5><b>Not Enrolled</b></h5>
							<input type="hidden" name="enrollment_status" value="Not Enrolled"/>
                        </div>
						
						<div class="form-group">
							<h4>OJT Status:</h4>
							<h5><b>Ongoing</b></h5>
							<input type="hidden" name="ojt_status" value="Ongoing" />
						</div>
						
						<div class="form-group">
                            <h4>Semester:</h4>
							<h5><b><?php echo $semester;?></b></h5>
							<input type="hidden" name="semester" value="<?php echo $semester;?>" />
						</div>
						
						<div class="form-group">
                            <h4>Academic year:</h4>
							<h5><b><?php echo $acad_year_start."-".$acad_year_end;?></b></h5>
							<input type="hidden" name="acad_year_start" value="<?php echo $acad_year_start;?>"/>
							<input type="hidden" name="acad_year_end" value="<?php echo $acad_year_end;?>"/>
						</div>
						
						<div class="form-group">
							<h4>OJT Category:<span style="color:red;">*</span></h4>
							<?php
								$query_ojt_status = "SELECT category_id FROM student_ojt_records WHERE stud_no='$stud_no'";
								$result_ojt_status = mysqli_query($dbc, $query_ojt_status);
								if(mysqli_num_rows($result_ojt_status)>0)
								{
									$row_os = mysqli_fetch_assoc($result_ojt_status);
									$category_id = $row_os["category_id"];
								
									$query_ojt_category = "SELECT program_id, category_id, category_description, ojt_hours FROM program_category_list WHERE program_id ='$program_id' AND status='Active' AND category_id>'$category_id'";
									
									$result_ojt_category = mysqli_query($dbc, $query_ojt_category);
									$num_rows2 = mysqli_num_rows($result_ojt_category);
									
										print'<select class="form-control"  name="category_id" class="form-control">';
									
										echo "<option value=''></option>";
										while($row_pl = mysqli_fetch_array($result_ojt_category)){
										
											$program_id = $row_pl[0];
											$category_id = $row_pl[1];
											$category_description= $row_pl[2];
											
											echo "<option value='".$category_id."'>".$category_description."</option>";    
									}
									  
									print '</select>';
								}
								
								else
								{
									$query_ojt_category = "SELECT program_id, category_id, category_description, ojt_hours FROM program_category_list WHERE program_id ='$program_id' AND status='Active'";
							 
									$result_ojt_category = mysqli_query($dbc, $query_ojt_category);
									$num_rows2 = mysqli_num_rows($result_ojt_category);
									  
										print'<select class="form-control"  name="category_id" class="form-control">';
									  
										echo "<option value=''></option>";
										while($row_pl = mysqli_fetch_array($result_ojt_category)){
										  
											$program_id = $row_pl[0];
											$category_id = $row_pl[1];
											$category_description= $row_pl[2];

											echo "<option value='".$category_id."'>".$category_description."</option>";    
										}
										
									print '</select>';
								}	  

								?>

                        </div>
						
						<div class="form-group">
							<h4>Year level:<span style="color:red;">*</span></h4>
							<?php
								$comstart1="";
								$comstart2="";
								$comstart3="";
								$comstart4="";
								$comstart5="";
								$comend="-->";
								
								if($program_id == 1)
								{
									$comstart1="<!--";
									$comstart2="<!--";
									$comstart3="<!--";
									$comstart5="<!--";
								}
								if($program_id == 2)
								{
									$comstart1="<!--";
									$comstart2="<!--";
									$comstart3="<!--";
									$comstart5="<!--";
								}
								if($program_id == 3)
								{
									$comstart1="<!--";
									$comstart5="<!--";
								}
								if($program_id == 4)
								{
									$comstart1="<!--";
									$comstart5="<!--";
								}
								if($program_id == 5)
								{
									$comstart1="<!--";
									$comstart2="<!--";
									$comstart3="<!--";
									$comstart5="<!--";
								}
								if($program_id == 6)
								{
									$comstart1="<!--";
									$comstart2="<!--";
									$comstart3="<!--";
									$comstart5="<!--";
								}
								if($program_id == 8)
								{
									$comstart1="<!--";
									$comstart2="<!--";
									$comstart3="<!--";
								}
								if($program_id == 9)
								{
									$comstart1="<!--";
									$comstart2="<!--";
									$comstart3="<!--";
									$comstart5="<!--";
								}
								
							  ?>
                              <div class="form-group has-feedback">
                                   <select class="form-control" name="year_level" id="year_level" class="form-control" placeholder="Year Level">
                                    <option value=""></option>
                                    <?php echo $comstart1;?><option value="1st Year">1st Year</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="2nd Year">2nd year</option><?php echo $comend;?>
                                    <?php echo $comstart3;?><option value="3rd Year">3rd year</option><?php echo $comend;?>
                                    <?php echo $comstart4;?><option value="4th Year">4th year</option><?php echo $comend;?>
                                    <?php echo $comstart5;?><option value="5th Year">5th year</option><?php echo $comend;?>
                                    </select>
                              </div>
                        </div>
						  
						  <div class="form-group">
						  <button type="submit" name="btn_reg2" class="btn btn-theme">Register</button>
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
		mob_no: {
			validators: {
				notEmpty:{},
			},
		},
		category_id: {
			validators: {
				notEmpty:{},
			},
		},
		year_level: {
			validators: {
				notEmpty: {},
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
