<?php
$page_title = 'OJT AssiSTI';

if(!isset($_COOKIE["uid"])) {
	header ("Location: login.php");
	exit;
}
$username = $_COOKIE["uid"];
$usertype = $_COOKIE["ut"];
/* require the sql connection..*/
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
  if((isset($_GET['acad_year_start_rd'])) && (isset($_GET['semester_rd'])) && (isset($_GET['stud_no_records'])) 
    && (isset($_GET['comp_ojt_stud_id']))) {
  
  $acad_year_start_rd=$_GET['acad_year_start_rd'];
  $semester_rd=$_GET['semester_rd'];
  $stud_no_records=$_GET['stud_no_records'];
    $comp_ojt_stud_id=$_GET['comp_ojt_stud_id'];
    
  $query_update_stud_records ="SELECT a.stud_no,a.lname,a.fname,a.mname,b.year_level,b.acad_year_start,b.acad_year_end,b.semester,b.section_id,b.category_id,b.ojt_status,b.enrollment_status,c.program_code,c.program_id,d.category_description,e.section,f.remarks FROM student_info AS a INNER JOIN student_ojt_records as b INNER JOIN program_list as c INNER JOIN program_category_list AS d INNER JOIN section_list AS e INNER JOIN student_checklist AS f WHERE f.stud_no = a.stud_no AND b.stud_no = f.stud_no AND f.acad_year_start = '$acad_year_start_rd' AND f.semester = '$semester_rd' AND a.stud_no = b.stud_no and a.program_id = c.program_id AND b.category_id = d.category_id AND b.acad_year_start = '$acad_year_start_rd' AND b.semester =  '$semester_rd' AND a.stud_no = '$stud_no_records' AND b.section_id = e.section_id AND f.deliverable_id = '5'";
                 
  $result_update_stud_records =  mysqli_query($dbc, $query_update_stud_records);         
          if($result_update_stud_records->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_update_stud_records))
              {
                            $a_stud_no = $row[0];
                            $a_lname = $row[1];
                            $a_fname = $row[2];
                            $a_mname = $row[3];
                            $b_year_level = $row[4];
                            $b_acad_year_start = $row[5];
                            $b_acad_year_end = $row[6];
                            $b_semester = $row[7];
                            $b_section_id = $row[8];
                            $b_ojt_category = $row[9];
                            $b_ojt_status = $row[10];
                            $b_ojt_enrollment_status = $row[11];
                            $c_program_code = $row[12];
                            $c_program_id = $row[13];
                            $category_description = $row[14];
                            $section_name = $row[15]; 
                            $remarks_EL = $row[16];                  
              }
           }
date_default_timezone_set("Asia/Manila");
$date_today =  date("n/j/Y");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OJT assiSTI</title>

<link rel="shortcut icon" href="asset/img/ojtassistilogo.png">
  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker.css"/>
  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/animate.notify.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>


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
						$s_conv="SELECT COUNT(conv_id) AS count FROM conversations_data WHERE id='$idd' AND sender!='$username' AND read_status='0'";
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
				<li class="user-name"><span>&nbsp;Hi' <?php echo $fname2 ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <br>
                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="adviser_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span> My Account</a></li>
                      <li><a href=""><span class="fa fa-lock"></span>Lock Screen</a></li>
                      <li><a href="logout.php"><span class="fa fa-power-off "> Log Out</span></a></li> 
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
                      <img src="asset/img/ojtassistilogo.png" style="padding-top:10px;margin-left:65px;width:80px;height:80px;" class="animated fadeInLeft">
                    </div>
                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:75px;">
                      <h1 class="animated fadeInLeft" style="color:gray;margin-left:30px;">
                                <?php 
                                  date_default_timezone_set("Asia/Manila");
                                  echo date("h:i A"); 
                                ?>  
                      </h1>
                       <p class="animated fadeInRight" style="color:gray;margin-left:30px;">
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
                        <h1 class="animated fadeInLeft">START OJT INFORMATION</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section can manage to start ojt of the student.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>START OJT</h3></div>
                    <form id="defaultForm" method="post" action="start_ojt_process.php">
                      <div class="panel-body" style="padding-bottom:30px;">
                      <br>
                        <div class="row" style="padding-left:5px;">
                        <input name="stud_no_records" type="hidden" value ="<?php echo $a_stud_no; ?>"/>
                        <input name="acad_year_start_rd" type="hidden" value ="<?php echo $acad_year_start_rd; ?>"/>
                        <input name="acad_year_end_rd" type="hidden" value ="<?php echo $acad_year_end_rd; ?>" />
                        <input name="semester_rd" type="hidden" value ="<?php echo $semester_rd; ?>"/>
                         <input type="hidden" name = "comp_ojt_stud_id" value ="<?php echo $comp_ojt_stud_id; ?>" />

                         <div class="col-md-2">
                              <h5 >STUDENT NUMBER</h5>
                                <div class="form-group">
                                  <h5><?php echo $a_stud_no; ?></h5>
                                </div>
                          </div>
                          <div class="col-md-3">
                               <h5 >STUDENT NAME</h5>
                                <div class="form-group">
                                  <h5><?php echo $a_lname.", ".$a_fname." ".$a_mname; ?></h5>
                                </div>
                          </div>
                          <div class="col-md-2">
                               <h5>PROGRAM</h5>
                                <div class="form-group">
                                  <h5><?php echo $c_program_code; ?></h5>
                                </div>
                          </div>
                           <div class="col-md-2">
                                <h5>YEAR LEVEL</h5>
                                <div class="form-group">
                                  <h5><?php echo $b_year_level; ?></h5>
                                </div>
                          </div>
                           <div class="col-md-2"> 
                            <h5>SEMESTER</h5>
                                <div class="form-group">
                                  <h5><?php echo $b_semester; ?></h5>
                                </div>
                          </div>                    
                        </div>
                        
                        <br>

                        <div class="row" style="padding-left:5px;">
                           <div class="col-md-2"> 
                            <h5>OJT CATEGORY</h5>
                                <div class="form-group">
                                  <h5><?php echo $category_description; ?></h5>
                                </div>
                          </div>
                         <div class="col-md-2"> 
                            <h5>SCHOOL YEAR</h5>
                                <div class="form-group">
                                  <h5><?php echo $b_acad_year_start." - " .$b_acad_year_end; ?></h5>
                                </div>
                          </div>
                           <div class="col-md-1">
                             <h5>SECTION</h5>
                              <div class="form-group has-feedback">
                                <h5><?php echo $section_name; ?></h5>
                            </div>
                          </div>
                           
                           <div class="col-md-2">
                             <h5>ENROLLMENT STATUS</h5>
                              <div class="form-group has-feedback">
                                <h5><?php echo $b_ojt_enrollment_status; ?></h5>
                              </div>
                          </div>
                          <div class="col-md-2">
                             <h5>ENDORSEMENT LETTER</h5>
                              <div class="form-group has-feedback">
                                <h5><?php echo $remarks_EL; ?></h5>
                              </div>
                          </div>

                          <div class="col-md-2">
                             <h5>OJT STATUS</h5>
                              <div class="form-group has-feedback">
                              <input type="hidden" name="ojt_status" value="<?php echo $b_ojt_status; ?>" />
                                    <h5>
                                      <?php 
                                        if($b_ojt_status == "Ongoing")
                                        {
                                            echo "On going";
                                        }else{
                                          echo $b_ojt_status;

                                        }  
                                      ?>
                                      </h5>
                                    <input type="hidden" value="<?php echo $b_ojt_status; ?>">
                              </div>
                          </div>
                        </div>

                         <div class="row" style="padding-left:5px;">
                           <div class="col-md-2"> 
                            <h5>COMPANY NAME :</h5>
                          </div>
                         <div class="col-md-5"> 
                           <div class="form-group has-feedback">
						   <input type="text" list="suggestion" class="form-control" id="comp_id"/>
                              <?php
                              $query_company_list= "SELECT a.comp_id,a.comp_name FROM company_info AS a INNER JOIN company_program AS b WHERE a.comp_id = b.comp_id AND a.status = 'Active' AND b.comp_program_status = 'Active'";
                     
                              $result_company_list = mysqli_query($dbc, $query_company_list);
                              $num_rows3 = mysqli_num_rows($result_company_list);
                              
                              print'<datalist id="suggestion">';
                              
                              echo "<option value=''></option>";
                               while($row__ci = mysqli_fetch_array($result_company_list)){
                                  $comp_id = $row__ci[0];
                                  $comp_name = $row__ci[1];
                                  echo "<option data-value='".$comp_id."'>".$comp_name."</option>";    
                              }
                              ?>
							  <input type="hidden" name="comp_id-hidden" id="comp_id-hidden"/>
							  <script>
							  document.querySelector('input[list]').addEventListener('input', function(e) {
								  var input = e.target,
								  list = input.getAttribute('list'),
								  options = document.querySelectorAll('#' + list + ' option'),
								  hiddenInput = document.getElementById(input.id + '-hidden'),
								  inputValue = input.value;
								  hiddenInput.value = inputValue;
								  for(var i = 0; i < options.length; i++) {
									  var option = options[i];
									  if(option.innerText === inputValue) {
										  hiddenInput.value = option.getAttribute('data-value');
										  break;
										}
									}
								});
							</script>

                              <?php
                              print '</datalist>';

                              ?>
                            </div>
                          </div>
                          <input type="hidden" name="date_today" id="date_today" value="<?php echo $date_today; ?>" />
                          <div class="col-md-2"> 
                            <h5>DATE START:</h5>
                          </div>
                          <div class="col-md-3">
						  <div class="form-group">
						  <div class="dateContainer">
						  <div class="input-group input-append date" id="ojt_start_date">
						  <?php
						  //get endorsement date from checklist
						  $q_endorsement_date = "SELECT date_submitted from student_checklist WHERE stud_no='$a_stud_no' and category_id='$b_ojt_category'";
						  $q_endorsement_date_res = $dbc->query($q_endorsement_date);
						  $get_endorsement_date = $q_endorsement_date_res->fetch_assoc();
						  $endorsement_date = $get_endorsement_date['date_submitted'];
							if($endorsement_date == 0000-00-00){
									
									$date_display = "";
									
							}else{
								$date1 = strtotime($endorsement_date);
								$format = "m/d/Y";
								$final_date = date($format,$date1);
								
							}
						  ?>
						  <input type="text" class="form-control" name="ojt_start_date" value="<?php echo  $final_date; ?>" maxlength="10"/>
						  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						  </div>
						  </div>
						  </div>
						  </div>
                        </div>


                         <br>
                         <br>
                         <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                             <button type="submit" class="btn btn-success btn-block" name="btn_add_start_ojt" id="btn_add_start_ojt"><span class="fa fa-thumbs-o-up"></span> &nbsp; START </button>
                             </div>
                              <div class="col-md-4">
                               <a href="adviser_update_student_records.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo $stud_no_records; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                               </div>
                          </div>

                         

                       </div><!--ENd of panel body-->
                      </form>
                      </div>
                     </div>
                </div>
            </div> <!-- end: content -->
     </div>
          
      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
               <ul class="nav nav-list">
                    <li class="ripple">
                     <a href="adviser_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                    </li>
                     <li class="ripple">
                       <a href="adviser_company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Info</a>
                    </li>
                     <li class="ripple">
                      <a href="adviser_ojt_student_list.php"><i class="glyphicon glyphicon-object-align-bottom"></i> OJT Student list</a>
                    </li>
                     <li class="ripple">
                        <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Section Handled</a>
                    </li>
                    <li class="ripple">
                       <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i>Company Remarks</a>
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
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
  var table = $('#datatables').DataTable();  var startDate = new Date('01/01/2012');  var ToEndDate = new Date();  ToEndDate.setDate(ToEndDate.getDate());
  	$('#ojt_start_date')        .datepicker({            format: 'mm/dd/yyyy',			weekStart: 1,			startDate: startDate,			endDate: ToEndDate,			autoClose: true        })		 .on('changeDate', function(selected){		 /* Revalidate the start date field */           $('#defaultForm').bootstrapValidator('revalidateField', 'ojt_start_date');			        FromEndDate = new Date(selected.date.valueOf());        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));        $('.ojt_start_date').datepicker('setEndDate', FromEndDate);    });

 $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                 ojt_start_date: {                    validators: {                        notEmpty: {                            message: 'Date start is required and can\'t be empty'                        },                        date: {                            format: 'MM/DD/YYYY',                            message: 'Invalid format of date start(e.g. MM/DD/YYYY)'                        },                        date: {                            max: 'date_today',                        },                         regexp: {                            regexp: /^[0-9/]+$/,                            message: 'Invalid characters'                        },                    }                },
                comp_id: {
                    message: 'Company name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Company name is required and can\'t be empty'
                        },
                    }
                },
            }
        }) 
         .on('success.field.fv', function(e, data) {
            if (data.field === 'date_today' && !data.fv.isValidField('ojt_start_date')) {
                /* We need to revalidate the end date*/
                data.fv.revalidateField('ojt_start_date');
            }
        });
  });
</script>


</body>
</html>