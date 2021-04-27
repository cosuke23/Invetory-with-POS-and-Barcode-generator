<?php
$page_title = 'OJT AssiSTI Student Registration';
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$current_year = date("Y") - 1;
$next_year = date("Y") + 1;
if(isset($_GET['rb']))
{
	$rb=$_GET['rb'];
}
else
{
	$rb=0;
}
 
 if(isset($_POST['btn_student_reg']))
{
    $stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
    $lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));
    $fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
    $mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));
    $gender =  mysqli_real_escape_string($dbc, trim($_POST['gender']));
    $bday =  mysqli_real_escape_string($dbc, trim($_POST['bday']));
    $program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));
    $email =  mysqli_real_escape_string($dbc, trim($_POST['email']));
    $mobile_no =  mysqli_real_escape_string($dbc, trim($_POST['mobile_no']));
    $tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));
    $address =  mysqli_real_escape_string($dbc, trim($_POST['address']));
    $facebook =  mysqli_real_escape_string($dbc, trim($_POST['facebook']));
    $bday2 = date('Y-m-d', strtotime(str_replace('-', '/', $bday)));
    $bday3 = strtotime($bday2);
    $valid = "968774400";
    if($bday3 > $valid){
      header("Location: student_registration.php?error=1&stud_no=$stud_no&email=$email&lname=$lname&mname=$mname&fname=$fname&gender=$gender&mobile_no=$mobile_no&tel_no=$tel_no&address=$address&facebook=$facebook&rb=$rb");
    }
	
	//$q_email = $dbc->query("SELECT email FROM student_info WHERE email='$email'");
	//if($q_email->num_rows != 0) {
		//$r_email= $q_email->fetch_assoc();
		//if($r_email['email'] == $email)
		//{
			
			
			//header("Location: email_validator.php?stud_no=$stud_no&email=$email");
			//exit;
		//}
	//}
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
                     <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                  <div class="well well-sm">
                                      <h4><span class="glyphicon glyphicon-exclamation-sign text-warning "> NOTE</span>
                                     <div class="row">
                                        <div class="col-md-12">
                                         <h5> 
                                          &nbsp;  &nbsp;  &nbsp; Your <strong><mark class="text-primary"> ACADEMIC YEAR START and SEMESTER </mark></strong> must varies to start of your OJT.Legend: (<label style="color:red;">*</label>) Required Field.</h5>
                                        </div>
                                      </div>
                                   </div>
                                </div>  
                          </div>
                        </div>
				
                    <form id="defaultForm" method="post" action="student_registration_process.php?rb=<?php echo $rb;?>" enctype="multipart/form-data">
                     <div class="panel-body" style="padding-bottom:30px;">
                                <input type ="hidden" name ="stud_no" value ="<?php echo $stud_no; ?>" />
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
                            
                         <div class="row">
                            <h2 style="margin-left:13px;">OJT RECORDS INFORMATION</h2>
                          </div>
                        <div class="row">
                           <div class="col-md-2">
                              <h5 style="padding-left:5px;">Enrolled Status</h5>
                              <div class="form-group has-feedback">
                                <h4 style="padding-left:5px;">Not Enrolled</h4>
                                <input type="hidden" name="enrollment_status" value="Not Enrolled"/>
                              </div>
                            </div>
                             <div class="col-md-3">
                                <h5 style="padding-left:5px;">OJT STATUS</h5>
                                   <input name="ojt_status" type="hidden" value ="Ongoing"/>
                                   <h4 style="padding-left:5px;">Ongoing</h4>
                             </div>
							<?php
								$query_act="SELECT * FROM active_semester_acad_year where status='Active'";
								$result_act=mysqli_query($dbc, $query_act);
								if(mysqli_num_rows($result_act)>0)
								{
									$row_act = mysqli_fetch_assoc($result_act);
									$semester_act = $row_act['active_semester'];
									$acad_year_start_act = $row_act['active_acad_year_start'];
									$acad_year_end_act = $row_act['active_acad_year_end'];
								}
								
								$query_ongoing="SELECT * FROM active_semester_acad_year where status='Ongoing'";
								$result_ongoing=mysqli_query($dbc, $query_ongoing);
								if(mysqli_num_rows($result_act)>0)
								{
									$row_ongoing = mysqli_fetch_assoc($result_ongoing);
									$semester_ongoing = $row_ongoing['active_semester'];
									$acad_year_start_ongoing = $row_ongoing['active_acad_year_start'];
									$acad_year_end_ongoing = $row_ongoing['active_acad_year_end'];
								}
							?>
							<div class="col-md-3">
                              <h5 style="padding-left:5px;">SEMESTER&nbsp;<label style="color:red;font-size:20px;">*</label></h5>
                              <div class="form-group has-feedback">
                                  
								   
								   <select name="semester_ay">
										<option value="<?php echo $semester_act.'|'.$acad_year_start_act; ?>" ><?php echo $semester_act.' '.$acad_year_start_act.' - '.$acad_year_end_act; ?></option>
										<option value="<?php echo $semester_ongoing.'|'.$acad_year_start_ongoing; ?>" ><?php echo $semester_ongoing.' '.$acad_year_start_ongoing.' - '.$acad_year_end_ongoing; ?></option>
									</select>
                              </div>
                            </div>
                           
                        </div>  
                        <div class="row">
                            <div class="col-md-4">
                             <h5 style="padding-left:5px;">OJT CATEGORY&nbsp;<label style="color:red;font-size:20px;">*</label></h5>
                              <div class="form-group has-feedback">
							  
                              <?php
								$query_ojt_status = "SELECT category_id FROM student_ojt_records WHERE stud_no='$stud_no'";
								$result_ojt_status = mysqli_query($dbc, $query_ojt_status);
								if(mysqli_num_rows($result_ojt_status)>0)
								{
									$row_os = mysqli_fetch_assoc($result_ojt_status);
									$category_id = $row_os["category_id"];
								
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
								
								
                              /*
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
									*/
                              ?>
                            </div>
                          </div>
                            <div class="col-md-1"></div>
							<div class="col-md-2">
                              <h5 style="padding-left:5px;">YEAR LEVEL&nbsp;<label style="color:red;font-size:20px;">*</label></h5>
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
							
                        </div>
                       
                         <div class="row">
                            <div class="col-md-8"></div>                        
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-info btn-block"  name="btn_student_reg2" id="btn_student_reg2">
                                  <span class="icons icon-note"></span> &nbsp; REGISTER
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
                        between:{             
                        min: 7,
                        max: 'hour_end',
                        message: 'Invalid end of time'
                        },
                    }     
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
                        }
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
                },
                image: {
                  validators: {
                     file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 102400,   // 100kb
                        message: 'The selected file is not valid,it should be (jpeg,jpg,png) and 100KB at maximum size'
                      }
                    }
                },
                year_level: {
                    validators: {
                        notEmpty: {
                            message: 'Year level is required and can\'t be empty'
                        },
                    }
                },
                  category_id: {
                    validators: {
                        notEmpty: {
                            message: 'Section is required and can\'t be empty'
                        },
                    }
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
                        message: 'The date is not in the range',
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
            }
        })
	/*function submitForm()
	   {		
			var data = $("#defaultForm").serialize();
				
			$.ajax({		
			type : 'POST',
			url  : 'student_registration_process.php',
			data : data,
			
			success :  function(response)
			   {						
					if(response=="This email already exist!"){
						$("#error").fadeIn(1000, function(){						
							$("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
											$("#btn-student-reg").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
									});
					}
				}
			  });
				return false;
		}*/	
  });
</script>
<!-- end: Javascript -->
</body>
</html>