<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
$page_title = 'OJT AssiSTI';
if(!isset($_COOKIE["uid"])) {
	header ("Location: login.php");
	exit;
}
$username = $_COOKIE["uid"];
$usertype = $_COOKIE["ut"];
if($usertype==1)
{
	 header("Location: adviser_home.php");
}
if($usertype==2)
{
  $query2 = "SELECT * from adviser_info WHERE adviser_id = '$username'";
  $result2 = mysqli_query($dbc,$query2);
    if(mysqli_num_rows($result2)>0)
    {
      $row2 = mysqli_fetch_assoc($result2);
      $fname2 = $row2["fname"];
    }
} 
if((isset($_GET['acad_year_start'])) && (isset($_GET['semester'])) && (isset($_GET['stud_no'])) && (isset($_GET['date_submitted']))) {
  
  $acad_year_start=$_GET['acad_year_start'];
  $semester=$_GET['semester'];
  $stud_no=$_GET['stud_no'];
  $date_submitted=$_GET['date_submitted'];
  $date_submitted2 = date('Y-m-d', strtotime(str_replace('-', '/', $date_submitted)));
   $query_stud_journal = "SELECT a.stud_no,a.lname,a.fname,a.mname,b.acad_year_start,b.acad_year_end,b.semester,c.category_description,d.program_code,b.section_id,e.section FROM student_info AS a INNER JOIN student_ojt_records AS b INNER JOIN program_category_list AS c INNER JOIN section_list AS e INNER JOIN program_list AS d WHERE b.section_id = e.section_id AND a.stud_no = b.stud_no and b.acad_year_start ='$acad_year_start' AND b.semester = '$semester' AND b.category_id = c.category_id AND b.stud_no = '$stud_no' AND a.program_id = d.program_id";
                 
  $result_stud_journal =  mysqli_query($dbc, $query_stud_journal);         
          if($result_stud_journal->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_stud_journal))
              {             
                            $stud_no2 = $row[0];
                            $lname = $row[1];
                            $fname = $row[2];
                            $mname = $row[3];
                            $j_acad_year_start = $row[4];
                            $j_acad_year_end = $row[5];
                            $j_semester = $row[6];
                            $j_category_description = $row[7];
                            $j_program_code = $row[8];
                            $section_id = $row[9];
                            $section_name = $row[10];
              }
           }
   $query_stud_journal_info = "SELECT journal_entry,date_submitted,skills_and_knowledge_used,type FROM journal WHERE stud_no = '$stud_no' AND semester = '$j_semester' AND acad_year_start = '$j_acad_year_start' AND date_submitted = '$date_submitted2'";
                        $result_stud_journal_info = mysqli_query($dbc,$query_stud_journal_info);
                        if($result_stud_journal_info->num_rows > 0)
                           {
                            while($row2 = mysqli_fetch_array($result_stud_journal_info))
                            {
                              $journal_entry = $row2[0];
                              $date_submitted_info = $row2[1];
                              $skills_and_knowledge_used = $row2[2];
                              $type = $row2[3];
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
<?php
	$s_id="SELECT id FROM conversations WHERE parent='$username' OR child='$username'";
				$r_id=mysqli_query($dbc, $s_id);
				if(mysqli_num_rows($r_id)>0)
				{	
					$count_conv=0;
					while($row_id = mysqli_fetch_assoc($r_id))
					{
						$idd = $row_id['id'];
						$s_conv="SELECT COUNT(conv_id) AS count FROM conversations_data WHERE id='$idd' AND sender!='$username' AND read_status='unread'";
						$r_conv=mysqli_query($dbc, $s_conv);
						if(mysqli_num_rows($r_conv)>0)
						{
							$row_conv = mysqli_fetch_assoc($r_conv);
							$count_conv += $row_conv['count'];	
						}
					}
				}
				else
				{
					$count_conv='0';
				}
               print '<li class="dropdown avatar-dropdown">
                              <br>
                               
                               <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" 
                                style="padding:1px 1px 1px 1px;">
                                    <i class="glyphicon glyphicon-envelope" style="color:white;font-size:17px;"></i>
                                    <label style="font-size:15px;padding:2px 5px 2px 5px;" class="badge badge-danger"> '.$count_conv.'</label></span>
                               <ul class="dropdown-menu user-dropdown">
							   <div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                                      <li>
                                        <a href="adviser_chat.php">
                                              <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;"><label class="text-primary"> '.$count_conv.' </label> message(s).
                                              </div>
                                      </a>
                                      </li>
                                        </div>
                       </ul></li>';
					   ?>
                <li class="dropdown avatar-dropdown">
                <br>     
                    <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:7px 10px 7px 10px">
                    <i class="fa fa-building-o" style="color:white;font-size:17px;"></i><label class="badge badge-danger" style="font-size:15px;padding:1px 10px 3px 10px;"><?php echo $unread_msg ;?></label>
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
                           <label>
                          <a href="pending_student_list.php"><i class="fa fa-list"></i>Pending Students</a>
                          </label><br>
						   <label>
                          <a href="prepare_endorsement.php"><i class="fa fa-print"></i>Print Endorsement</a>
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
                        <h1 class="animated fadeInLeft">VIEW JOURNAL</h1>
                        <p class="animated fadeInDown">
                          View and manage journals submitted by the selected student.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>JOURNAL</h3></div>
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row">
                         
                        
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
                            <h5>PROGRAM</h5>
                             <h4><?php echo $j_program_code; ?></h4>
                          </div>
                           <div class="col-md-3">
                                <h5>SECTION</h5>
                                  <div class="form-group has-feedback">
                                   <h4><?php echo $section_name; ?></h4>
                                   </div>
                            </div>
                          <div class="col-md-3">
                            <h5>SCHOOL YEAR</h5>
                            <div class="form-group has-feedback">
                               <h4><?php echo $j_acad_year_end." - ".$j_acad_year_end; ?></h4>
                              </div>
                            </div>
                            <div class="col-md-3"></div>
                          </div>
                           <div class="row">
                            <h2 style="margin-left:13px;">JOURNAL INFORMATION</h2>
                          </div>
                       <div class="row">
                        <div class="col-md-2">
                          <h5>DATE :</h5>
                        </div>
                        <div class="col-md-2">
                          <h4><?php echo $date_submitted_info; ?></h4>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-md-2">
                          <h5>TYPE :</h5>
                        </div>
                        <div class="col-md-4">
                          <h4><?php echo $type; ?></h4>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-md-4">
                          <h5>JOURNAL ENTRY:</h5>
                        </div>
                      </div>
                      <div class="row" style="padding-left:10px;">
                        <div class="col-md-12">
                          <h4><?php echo $journal_entry; ?></h4>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <h5>SKILLS AND KNOWLEDGE USED:</h5>
                        </div>
                      </div>
                      <div class="row"  style="padding-left:10px;">
                        <div class="col-md-12">
                          <h4><?php echo $skills_and_knowledge_used; ?></h4>
                        </div>
                      </div>
                      <div class="row">
                      <div class="col-md-8"></div>
                      <div class="col-md-4">
                               <a href="journal.php?acad_year_start_rd=<?php echo $acad_year_start; ?>&semester_rd=<?php echo $semester; ?>&stud_no_records=<?php echo $stud_no; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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