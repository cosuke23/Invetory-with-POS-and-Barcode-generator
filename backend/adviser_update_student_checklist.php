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
  if((isset($_GET['acad_year_start'])) && (isset($_GET['semester'])) && (isset($_GET['deliverable_id'])) && (isset($_GET['stud_no_records']))) {

  
  $deliverable_id=$_GET['deliverable_id'];
  $semester=$_GET['semester'];
  $acad_year_start=$_GET['acad_year_start'];
  $stud_no_records=$_GET['stud_no_records'];

  $query_student_checklist= "SELECT d.stud_no,d.deliverable_id,DATE_FORMAT(d.date_submitted, '%m/%d/%Y') AS date_submitted,d.semester,d.acad_year_start,d.acad_year_end,d.remarks,e.deliverable_name,f.lname,f.fname,f.mname,h.program_code,g.section_id,m.section FROM student_checklist AS d INNER JOIN student_deliverables AS e INNER JOIN student_info AS f INNER JOIN  student_ojt_records AS g INNER JOIN program_list as h INNER JOIN section_list AS m WHERE d.deliverable_id = e.deliverable_id and f.stud_no = d.stud_no and f.stud_no = g.stud_no and f.program_id = h.program_id  and d.acad_year_start = ' $acad_year_start' and g.acad_year_start = ' $acad_year_start' and g.semester = '$semester' and d.semester = '$semester' and d.deliverable_id = '$deliverable_id' AND d.stud_no = '$stud_no_records' AND g.section_id = m.section_id";
                 
   $result_stud_checklist2 =  mysqli_query($dbc, $query_student_checklist);         
          if($result_stud_checklist2->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_stud_checklist2))
              {
                  $stud_no_cl = $row[0];
                  $deliverable_id = $row[1];
                  $date_submitted = $row[2];
                  $semester = $row[3];
                  $acad_year_start = $row[4];
                  $acad_year_end = $row[5];
                  $remarks = $row[6];
                  $deliverable_name = $row[7];
                  $lname = $row[8];
                  $fname = $row[9];;
                  $mname = $row[10];
                  $program_code = $row[11];
                  $section_id = $row[12];
				  $section_name = $row[13];
                 
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
  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />



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
						  
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->
       

            <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">OJT STUDENT CHECKLIST</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          Update checklist information of the selected student here.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                    
                      <div class="row">
                      <div class="col-md-8">
                        <h3>Update <?php echo $deliverable_name; ?> of <label style="color:black;"><?php echo $lname." , ".$fname." ".$mname."."; ?></label></h3>
                      </div>
                       <div class="col-md-4"> </div>
                      </div>
                    </div>

                      <form id="defaultForm" method="post" action="update_student_checklist_adviser_process.php">
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row">
                          <div class="col-md-12">
                            <input name="stud_no_chklist" type="hidden" value ="<?php echo $stud_no_cl; ?>"/>
                             <input name="deliverable_id" type="hidden" value ="<?php echo $deliverable_id; ?>"/>
                             <input name="semester" type="hidden" value ="<?php echo $semester; ?>"/>
                             <input name="acad_year_start" type="hidden" value ="<?php echo $acad_year_start; ?>"/>
                             <input name="deliverable_name" type="hidden" value ="<?php echo $deliverable_name; ?>"/>
                            <div class="row">
                             <div class="col-md-2">
                              <h5>STUDENT NUMBER</h5>
                                <div class="form-group">
                                  <h5><?php echo $stud_no_cl; ?></h5>
                                </div>
                              </div>
                              <div class="col-md-2">
                              <h5>PROGRAM</h5>
                                <div class="form-group">
                                  <h5><?php echo $program_code; ?></h5>
                                </div>
                              </div>
                              <div class="col-md-2">
                              <h5>SEMESTER</h5>
                                <div class="form-group">
                                  <h5><?php echo $semester; ?></h5>
                                </div>
                              </div>
                              <div class="col-md-2">
                              <h5>SECTION</h5>
                                <div class="form-group">
                                  <h5><?php echo $section_name; ?></h5>
                                </div>
                              </div>
                              <div class="col-md-2">
                              <h5>SCHOOL YEAR</h5>
                                <div class="form-group">
                                  <h5><?php echo $acad_year_start." - " .$acad_year_end; ?></h5>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                               <div class="col-md-2"></div>
                                <div class="col-md-2">
                                  <label></label>
                                  <h4>Date Submitted:</h4>
                                </div>
                                <br>
                                <div class="col-md-5">
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="date_submitted">										
									  <?php	
										if($date_submitted == 0000-00-00){
											$date_now = time();
											$format = "m/d/Y";
											$final_date = date($format, $date_now);	
											$date_submitted = $final_date;	
											}
										elseif($date_submitted == "01/01/1970"){
											$date_now = time();
											$format = "m/d/Y";
											$final_date = date($format, $date_now);	
											$date_submitted = $final_date;	
											}
										?>
                                          <input type="text" class="form-control" name="date_submitted" value="<?php echo $date_submitted; ?>" maxlength="10"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>

                            <div class="row">
                               <div class="col-md-2"></div>
                                <div class="col-md-2">
                                  <label></label>
                                  <h4>Remarks:</h4>
                                </div>
                                <div class="col-md-5">
                                     <br>
                                      <div class="form-group has-feedback">
                                         <select class="form-control" name="remarks" id="remarks" class="form-control" placeholder="remarks">
                                            <option value="<?php 
											if($remarks == "Not yet completed")
											{
												$comstart="<!--";
												$comend="-->";
												echo $remarks; 
											}
											if($remarks == "Completed")
											{
												$comstart2="<!--";
												$comend2="-->";
												echo $remarks; 
											}
											?>"><?php echo $remarks; ?></option>
                                           <?php echo $comstart;?><option value="Not yet completed">Not yet completed</option><?php echo $comend;?>
                                            <?php echo $comstart2;?><option value="Completed">Completed</option><?php echo $comend2;?>
                                          </select>
                                     </div>
                                <div class="col-md-4"></div>
                            </div>
                          </div>

                          <br>
                        <br>
                         <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                             <button type="submit" class="btn btn-info btn-block" name="btn_update_stud_chklist_adv" id="btn_update_stud_chklist"><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE</button>
                             </div>
                              <div class="col-md-4">
                               <a href="adviser_OJT_student_checklist.php?acad_year_start_rd=<?php echo $acad_year_start ?>&semester_rd=<?php echo $semester; ?>&stud_no_records=<?php echo $stud_no_records; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                               </div>
                          </div>
                        </div>
                        </div><!--ENd of panel body-->
                          </div>
                        </form>
                     </div>
                </div>
              </div>  
            </div>
          </div>
          <!-- end: content -->
          
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
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script src="asset/js/bootstrap-datepicker.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
   $('#date_submitted')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'date_submitted');
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
        date_submitted: {
                    validators: {
                        notEmpty: {
                            message: 'The date subbmitted is required and can\'t be empty'
                        },
                         date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date subbmitted(e.g. MM/DD/YYYY)'
                        },
                    }
                },
              remarks: {
                    message: 'Remarks name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Remarks is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 100,
                            message: 'Remarks must be more than 1 and less than 100 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                } 
            }
        })
  });
$(function() {
  $('#bday').datepicker();
});
$(function() {
  $('#date_submitted').datepicker();
});
</script>
<!-- end: Javascript -->
</body>
</html>