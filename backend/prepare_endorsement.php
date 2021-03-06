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
		<style>
		.img_hidden{display:none;}
		.img_show{display:block;}
	</style>
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
                        <label>
                           <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;My Students</a>
                        </label><br>
                          <label >
                          <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i>Company Comments</a>
                          </label><br>
                           <label>
                          <a href="pending_student_list.php"><i class="fa fa-list"></i>Pending Students</a>
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
                        <h1 class="animated fadeInLeft">PRINT ENDORSEMENT</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                           Print company endorsements for your students in this module.
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Fill out the required<i style="color:red;">*</i> information below:</h3></div>
                      <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                               <div class="col-md-8"> </div>
                             <div class="col-md-4">
                             <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                          </div>
                        </div>
						<?php
						if(isset($_GET['stud_no']))
						{
							$getStud = $_GET['stud_no'];
							$q_endorsement="SELECT comp_id, training_hours FROM endorsement WHERE stud_no='$getStud' AND status='Active'";
							$r_endorsement=mysqli_query($dbc, $q_endorsement);
							if(mysqli_num_rows($r_endorsement)>0)
							{
								$re = mysqli_fetch_assoc($r_endorsement);
								$en_comp_id = $re['comp_id'];
								$en_thours = $re['training_hours'];
							}
							else
							{
								echo "Error: q_endorsement";
							}
							
							$q_info = "SELECT a.contact_person, a.position, a.comp_name, a.address, b.fname, b.mname, b.lname FROM company_info AS a INNER JOIN student_info AS b WHERE a.comp_id='$en_comp_id' AND b.stud_no='$getStud'";
							$r_info = mysqli_query($dbc, $q_info);
							if(mysqli_num_rows($r_info)>0)
							{
								$ri = mysqli_fetch_assoc($r_info);
								$cont_person = $ri['contact_person'];
								$position = $ri['position'];
								$comp_name = $ri['comp_name'];
								$comp_address = $ri['address'];
								$stud_fname = $ri['fname'];
								$stud_mname = $ri['mname'];
								$stud_lname = $ri['lname'];
							}
						}
						?>
						<div class="row">
							<div class="col-md-8" style="padding-bottom:15px;">
								<form id="defaultForm" action="print_endorsement.php" method="POST" enctype="multipart/form-data">
									<div class="form-group has-feedback" style="padding-left:15px;font-size:17px;color:#58666e;" ><span>Company Representative:<i style="color:red;">*</i></span><br>
										<input id="cmp_representative" type="text" name="cmp_representative" value="<?php echo $cont_person;?>" class="form-control" />
									</div>
									<div class="form-group has-feedback" style="padding-left:15px;font-size:17px;color:#58666e;" ><span>Position:<i style="color:red;">*</i></span><br>
										<input id="cmp_rep_position" type="text" name="cmp_rep_position" value="<?php echo $position;?>"class="form-control" />
									</div>
									
									<div class="form-group has-feedback" style="padding-left:15px;font-size:17px;color:#58666e;" ><span>Company Name:<i style="color:red;">*</i></span><br>
										<!--<input id="cmp_name" type="text" name="cmp_name" class="form-control" />-->
										 <input type="text" name="cmp_name" id="comp_name" class="form-control" value="<?php echo $comp_name;?>" />
										<div class="form-group has-feedback" style="font-size:17px;color:#58666e;" ><span>Company Address:<i style="color:red;">*</i></span><br>
											<textarea class="form-control" rows=2 type="text" name="cmp_address" id="comp_name-hidden"><?php echo $comp_address;?></textarea>
										</div>
									</div>
								
									</br>
									<div class="form-group has-feedback" style="padding-left:15px;font-size:17px;color:#58666e;" ><span>OJT Student Name:<i style="color:red;">*</i></span><br>
										<input id="stud_name" type="text" name="stud_name" value="<?php echo $stud_fname.' '.$stud_mname.' '.$stud_lname;?>" class="form-control" />
									</div>
									<div class="form-group has-feedback" style="padding-left:15px;font-size:17px;color:#58666e;" ><span>Total OJT Hours:<i style="color:red;">*</i></span><br>
										<input id="ojt_hours" type="text" name="ojt_hours" value="<?php echo $en_thours;?>" class="form-control" />
									</div>
									<br>
									<div class="form-group has-feedback" style="padding-left:15px;font-size:17px;color:#58666e;" ><span>Program Head:<i style="color:red;">*</i></span><br>
										<input id="program_head" type="text" name="program_head" class="form-control" />
									</div>
									<div class="form-group has-feedback" style="padding-left:15px;font-size:17px;color:#58666e;" ><span>Designation/Position:<i style="color:red;">*</i></span><br>
										<input id="program_head_position" type="text" name="program_head_position" class="form-control" />
									</div>
									<div style="padding-left:15px;">
										<input type="submit" class="btn btn-primary" value="Print Endorsement" name="btn_print" id="btn_print"> &nbsp;&nbsp;&nbsp;
										<a href="adviser_home.php" class="btn btn-default">Cancel</a>
									</div>
								</form>
							</div>
						</div>
                  </div>
                </div>
              </div>
            </div><!-- end: content -->
     </div>
          
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
      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle"  style="background-color:#0d47a1;">
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
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
  $('#datatables').DataTable();
  
        $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            
            fields: {
				honorifics: {
					validators: {
						notEmpty: {
							message: 'Select a value'
						}
					},
				},
                cmp_representative: {
                    message: 'Company Representative is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Company Representative is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: 'Company Representative must be more than 2 and less than 255 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z???? \-.`'/]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                cmp_rep_position: {
                    validators: {
					 notEmpty: {
                            message: 'Company Representative position is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 1000,
                            message: 'Company Representative position must be more than 2 and less than 1000 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z???? \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
				cmp_name: {
                    validators: {
					 notEmpty: {
                            message: 'Company Name is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 5,
                            max: 1000,
                            message: 'Company name must be more than 5 and less than 1000 characters long'
                        }
                         
                    }
                },
				
				cmp_address: {
                    validators: {
					 notEmpty: {
                            message: 'Company Address is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 5,
                            max: 1000,
                            message: 'Company Address must be more than 5 and less than 1000 characters long'
                        }
                        
                    }
                },
				stud_name: {
                    validators: {
					 notEmpty: {
                            message: 'Student name is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 5,
                            max: 150,
                            message: 'Student name must be more than 5 and less than 150 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z???? \-./]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
				
				ojt_hours: {
                    validators: {
					 notEmpty: {
                            message: 'OJT hours is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 2,
                            max: 5,
                            message: 'OJT hours must be more than 1 digit and less than 5 digits long'
                        },
                         regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
				
				program_head: {
                    validators: {
					 notEmpty: {
                            message: 'Program Head is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 150,
                            message: 'Program Head name must be more than 4 and less than 150 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z???? \-./]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
				
				program_head_position: {
                    validators: {
					 notEmpty: {
                            message: 'Program Head Designation/Position is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 150,
                            message: 'Program Head name must be more than 4 and less than 150 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z???? \-./]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
            }
        })
});
</script>
<!-- end: Javascript -->
</body>
</html>