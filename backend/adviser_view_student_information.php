<?php
$page_title = 'OJT AssiSTI';
if(!isset($_COOKIE["uid"])) {
	header ("Location: login.php");
	exit;
}
$username = $_COOKIE["uid"];
$usertype = $_COOKIE["ut"];
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
if($usertype==1)
{
	header("Location: admin_home.php");
}
if($usertype!=1)
{
	$query2 = "SELECT * from adviser_info WHERE adviser_id = '$username'";
	$result2 = mysqli_query($dbc,$query2);
		if(mysqli_num_rows($result2)>0)
		{
			$row2 = mysqli_fetch_assoc($result2);
			$fname2 = $row2["fname"];
		}
} 
  if(isset($_GET['stud_no'])) {
  
  $stud_no=$_GET['stud_no'];
  $query_update_stud_info ="SELECT a.stud_no,a.lname,a.fname,a.mname,a.gender,DATE_FORMAT(a.bday, '%m/%d/%Y') AS bday,a.email,a.mobile_no,a.tel_no,a.address,a.facebook,a.program_id,b.program_code FROM student_info AS a INNER JOIN program_list AS b WHERE a.program_id = b.program_id and a.stud_no ='$stud_no'";
                 
  $result_update_stud_info =  mysqli_query($dbc, $query_update_stud_info);         
          if($result_update_stud_info->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_update_stud_info))
              {
                            $stud_no = $row[0];
                            $lname = $row[1];
                            $fname = $row[2];
                            $mname = $row[3];
                            $gender = $row[4];
                            $bday = $row[5];
                            $email = $row[6];
                            $mobile_no = $row[7];
                            $tel_no = $row[8];
                            $address = $row[9];
                            $facebook = $row[10];
                            $a_program_id= $row[11];
                            $program_code = $row[12];         
              }
           }
}
/// check if there are unread remarks from companies
  //COMPANY COMMENTS NOTIFICATION FIX
    $x=0;
    $q_advsec = "select distinct section_id from adviser_section_handled where adviser_id='$username' and status = 'Active'";
    $q_advsec_res = $dbc->query($q_advsec);
    if($q_advsec_res->num_rows > 0){
      while($advsec = $q_advsec_res->fetch_assoc()){
        $sec = $advsec['section_id'];
        $q_advstud = "select * from student_ojt_records where section_id = '$sec' and ojt_status='Ongoing'";
        $q_advstud_res = $dbc->query($q_advstud);
        while($advstud = $q_advstud_res->fetch_assoc()){
          $stud=$advstud['stud_no'];
          $q_compstudnt = "select * from company_ojt_student where stud_no = '$stud' and status='Ongoing'";
          $q_compstudnt_res=$dbc->query($q_compstudnt);
          while($compstudnt=$q_compstudnt_res->fetch_assoc()){
            $student = $compstudnt['stud_no'];
            $q = "select count(status) as unread_count from company_remarks where stud_no='$student' and status='unread'";
            $q_res = $dbc->query($q);
            $count= $q_res->fetch_assoc();
            $x = $x + intval($count['unread_count']);
          }
        }
      }
      $unread_msg = $x;
    }else{
      $unread_msg = '0';
    }
    //note: pakipalitan ung echo sa baba ung dating unread['num'] change to $unread_msg 
    //--end of fix
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
  <link rel="stylesheet"   type="text/css" href="asset/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" href="asset/css/datepicker.min.css" />
  <link rel="stylesheet" href="asset/css/datepicker3.min.css" />
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
                <a href="home.php" class="navbar-brand"> 
                 <b>OJT assiSTI</b>
                </a>
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="dropdown avatar-dropdown">
                <br>     
                    <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:7px 10px 7px 10px">
                    <i class="glyphicon glyphicon-envelope" style="color:white;font-size:17px;"><label class="badge badge-danger" style="font-size:15px;padding:1px 10px 3px 10px;"><?php echo $unread_msg ;?></label></i>
                    </span>
					<ul class="dropdown-menu user-dropdown">
					<div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                        <li>
                            <a href="adviser_company_remarks.php">
                            <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;">There is/are
                                <label class="text-primary"> <?php echo  $unread_msg; ?> </label> unread company comment/s.
                            </div>
                            </a>
                        </li>
                    </div>
					</ul>
				</li>
				<li class="user-name">&nbsp;<span>&nbsp;<?php echo $fname2 ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <br>
                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="adviser_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span>&nbsp;My Account</a></li>
                      <li><a href="logout.php"><span class="fa fa-power-off ">&nbsp;Log Out</span></a></li> 
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      <!-- end: Header -->
   <div class="container-fluid mimin-wrapper">
  
           <!-- start:Left Menu -->
            <div id="left-menu">
              <div class="sub-left-menu scroll">
                    <div  style="background: linear-gradient(#ebebe0, 50%,#ebebe0);height:90px;">
                      <img src="asset/img/ojtassistilogo.png" style="padding-top:10px;margin-left:35px;width:150px;height:150px;" class="animated fadeInLeft">
                    </div>
                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:100px;">
                    <br>
                       <p class="animated fadeInRight" style="color:gray;margin-left:20px;margin-top:60px;">
                               <?php
                                 echo  date("l, F j, Y"); 
                               ?>
                        </p>
                    </div>
                       <div class="nav-side-menu">
                       <label>
                          <a href="adviser_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label>
                          <a href="adviser_company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Information</a>
                        </label><br>
                        <label class="active">
                           <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;My Students</a>
                        </label><br>
                          <label>
                          <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i>Company Comments</a>
                          </label><br>
                          
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->
                <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">STUDENT INFORMATION</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                         This section will show all the student information.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE STUDENT INFORMATION</h3></div>
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row" style="padding-left:5px;">
                         <input name="stud_no" type="hidden" value ="<?php echo $stud_no; ?>"/>
                        
                          <div class="col-md-3">
                             <h5>STUDENT NUMBER</h5>
                               <div class="form-group has-feedback">
                                <h4><?php echo $stud_no; ?></h4>
                               </div>
                          </div>
                         <div class="col-md-3">
                             <h5>LASTNAME</h5>
                              <div class="form-group has-feedback">
                                <h4><?php echo $lname; ?></h4>
                              </div>
                          </div>
                          <div class="col-md-3">
                             <h5>FIRSTNAME</h5>
                              <div class="form-group has-feedback">
                                <h4><?php echo $fname; ?></h4>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <h5>MIDDLENAME</h5>
                              <div class="form-group has-feedback">
                                 <h4><?php echo $mname; ?></h4>
                              </div>
                          </div>                  
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <h5>GENDER</h5>
                             <h4><?php echo $gender; ?></h4>
                          </div>
                           <div class="col-md-3">
                                <h5>BIRTHDAY</h5>
                                  <div class="form-group has-feedback">
                                   <h4><?php echo $bday; ?></h4>
                                   </div>
                            </div>
                          <div class="col-md-3">
                            <h5>PROGRAM</h5>
                            <div class="form-group has-feedback">
                               <h4><?php echo $program_code; ?></h4>
                              </div>
                            </div>
                            <div class="col-md-3"></div>
                          </div>
                           <div class="row">
                            <h2 style="margin-left:13px;">Contact Information</h2>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                                 <h5>ADDRESS</h5>
                                <div class="form-group has-feedback">
                                   <h4><?php echo $address; ?></h4>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                           <div class="col-md-3">
                                <h5>EMAIL</h5>
                                <div class="form-group has-feedback">
                                   <h4><?php echo $email; ?></h4>
                                </div>
                            </div>
                             <div class="col-md-3">
                              <h5>FACEBOOK</h5>
                                <div class="form-group has-feedback">
                                   <h4 placeholder="facebook account is empty"><?php echo $facebook; ?></h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5>TELEPHONE NUMBER</h5>
                                <div class="form-group has-feedback">
                                    <h4 placeholder="there is no telephone number available"><?php echo $tel_no; ?></h4>
                                </div>
                            </div>
                             <div class="col-md-3">
                                  <h5>MOBILE NUMBER</h5>
                                  <div class="form-group has-feedback">
                                  <h4 placeholder="there is no mobile number available"><?php echo $mobile_no; ?></h4>
                                  </div>
                            </div>
                          </div>
                          
                          <?php 
                           $query_stud_records = "SELECT a.stud_no,a.year_level,a.semester,a.section_id,a.category_id,a.enrollment_status,a.ojt_status,a.acad_year_start,a.acad_year_end,b.category_description,c.section FROM student_ojt_records AS a INNER JOIN program_category_list AS b INNER JOIN section_list AS c WHERE a.category_id = b.category_id AND a.stud_no = '$stud_no' AND a.section_id = c.section_id";
                          $result_stud_records = mysqli_query($dbc, $query_stud_records);
                          $num_rows = mysqli_num_rows($result_stud_records);  
                          print '<div class="row">
                                  <div class="col-md-12">
                                      <h1>OJT STUDENT RECORDS</h1>
                                  </div>
							</div>';
							while($row = mysqli_fetch_array($result_stud_records)) {
                            $stud_no_records = $row[0];
                            $year_level_rd = $row[1];
                            $semester_rd = $row[2];
                            $section_id = $row[3];
                            $category_id = $row[4];
                            $enrollment_status_rd = $row[5];
                            $ojt_status_rd = $row[6];
                            $acad_year_start_rd = $row[7];
                            $acad_year_end_rd = $row[8];
                            $category_description = $row[9];
                            $section_name = $row[10];
							
								if($ojt_status_rd == "Ongoing")
								{
									$status="Ongoing";
								}
								else if($ojt_status_rd == "Finished")
								{
									$status = "Finished";
								}
								else if($ojt_status_rd == "DNA")
								{
									$status="DNA";
								}
                          
                      print '<div class="col-md-13 row" style="background-color:#0d47a1; padding-right:15px;padding-left:30px;"><h4 style="color:white;">'.$status.'</h4></div>
					  <div>
                          <div class="row">
                           <div class="col-md-2">
                              <h5>YEAR LEVEL</h5>
                                <div class="form-group">
                                  <h4>'.$year_level_rd.'</h4>
                                </div>
                           </div>
                           <div class="col-md-2">
                             <h5>SEMESTER</h5>
                                <div class="form-group">
                                  <h4>'.$semester_rd.'</h4>
                                </div>
                           </div>
                           <div class="col-md-2">
                            <h5>SECTION</h5>
                                <div class="form-group">
                                  <h4>'.$section_name.'</h4>
                                </div>
                           </div>
                           <div class="col-md-2">
                            <h5>SCHOOL YEAR</h5>
                                <div class="form-group">
                                  <h4>'.$acad_year_start_rd. ' - ' .$acad_year_end_rd.'</h4>
                                </div>
                           </div>
                          </div>
                          <div class="row">
                            <div class="col-md-2">
                              <h5>OJT CATEGORY</h5>
                                <div class="form-group">
                                  <h4>'.$category_description.'</h4>
                                </div>
                           </div>
                           <div class="col-md-2">
                              <h5>OJT STATUS</h5>
                                <div class="form-group">
                                  <h4>'.$ojt_status_rd.'</h4>
                                </div>
                           </div>
                           <div class="col-md-4">
                              <h5>ENROLLMENT STATUS</h5>
                                <div class="form-group">
                                  <h4>'.$enrollment_status_rd.'</h4>
                                </div>
                           </div>
						   
                          </div>
                       </div>';
                      }
                      ?>
                      <div class="row">
                      <div class="col-md-8"></div>
                      <div class="col-md-4">
                               <a href="adviser_student_information.php?semester=<?php echo $semester_rd; ?>&acad_year_start=<?php echo $acad_year_start_rd; ?>&acad_year_end=<?php echo $acad_year_end_rd; ?>&program_code=<?php echo $program_code; ?>&program_id=<?php echo $a_program_id; ?>&section_id=<?php echo $section_id; ?>">
                                <button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                       </div>
                      </div>
                        </div><!--ENd of panel body-->
                      </div>
                     </div>
                </div>
      </div>
     
    <!-- end: content -->
      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
               <ul class="nav nav-list">
                    <li class="ripple">
                     <a href="adviser_home.php"><i class="glyphicon glyphicon-home"></i> Home</a>
                    </li>
                     <li class="ripple">
                       <a href="adviser_company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Information</a>
                    </li>
                     <li class="ripple">
                      <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;My Students</a>
                    </li>
                     <li class="ripple">
                      <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i> Company Comments</a>
                    </li>
                    <li class="ripple">
                       <a href="pending_student_list.php"><i class="fa fa-list"></i>Pending Students</a>
                    </li>
                </ul>
            </div>
        </div>       
      </div>
      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
        <span class="fa fa-bars"></span>
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
<script src="asset/js/bootstrap-datepicker.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
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
            message: 'This value is not valid',
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
                            message: 'The student number must be 11 characters long'
                        }
                    }
                },
               lname: {
                    message: 'The lastname name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The lastname is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'The lastname must be more than 1 and less than 32 characters long'
                        },
            regexp: {
                            regexp: /^[a-zA-Z\ .]+$/,
                            message: 'The lastname can only consist of alphabetical'
                        }
                    }
                },
        fname: {
                    message: 'The firstname name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The firstname is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'The firstname must be more than 1 and less than 32 characters long'
                        },
            regexp: {
                            regexp: /^[a-zA-Z\ .]+$/,
                            message: 'The firstname can only consist of alphabetical'
                        }
                    }
                },
        mname: {
                    message: 'The middlename name is not valid. If you dont have a middle name please input "."(period)',
                    validators: {
                        notEmpty: {
                            message: 'The middlename is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'The middlename must be more than 1 and less than 32 characters long'
                        },
            regexp: {
                            regexp: /^[a-zA-Z\ .]+$/,
                            message: 'The firstname can only consist of alphabetical'
                        },
                    }
                },
                gender: {
                    validators: {
                        notEmpty: {
                            message: 'The gender is required and can\'t be empty'
                        }
                    }
                },
                bday: {
                    validators: {
                        notEmpty: {
                            message: 'The birthday is required and can\'t be empty'
                        }
                    }
                },
        year_level: {
                    validators: {
                        notEmpty: {
                            message: 'The year level is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 8,
                            message: 'The firstname must be more than 1 and less than 50 characters long'
                        }
                    }
                },
        program_id: {
                    validators: {
                        notEmpty: {
                            message: 'The program is required and can\'t be empty'
                        },
                    }
                },
        semester: {
                    validators: {
                        notEmpty: {
                            message: 'The semester is required and can\'t be empty'
                        },
                    }
                },
        email: {
                    validators: {
                        notEmpty: {
                            message: 'The email is required and can\'t be empty'
                        },
            emailAddress: {
                            message: 'The input is not a valid email address'
                        }
                    }
                },
        address: {
                    validators: {
                        notEmpty: {
                            message: 'The address is required and can\'t be empty'
                        },
                    }
                },
        mobile_no: {
                    validators: {
                        notEmpty: {
                            message: 'The mobile number is required and can\'t be empty'
                        },
            regexp: {
                            regexp: /[0-9+]+$/,
                            message: 'The mobile number can only consist of numberic characters / + sign'
                        },
            stringLength: {
                            min: 11,
                            max: 13,
                            message: 'The mobile number must be 11 and not more than 13 characters long'
                        }
                    }
                },
        tel_no: {
                    validators: {
            regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'The telephone number can only consist of number'
                        },
            stringLength: {
                            min: 7,
                            max: 7,
                            message: 'The telephone number must be 7 characters long'
                        },
                    }
                },
        facebook: {
                    validators: {
            emailAddress: {
                            message: 'The input is not a valid email address'
                        }
                    },
                },
            }
        })
  });
</script>
<!-- end: Javascript -->
</body>
</html>