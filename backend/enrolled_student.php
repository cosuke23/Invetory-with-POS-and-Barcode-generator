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
if($usertype==2)
{
  $query2 = "SELECT * from adviser_info WHERE adviser_id = '$username'";
  $result2 = mysqli_query($dbc,$query2);
    if(mysqli_num_rows($result2)>0)
    {
      $row2 = mysqli_fetch_assoc($result2);
      $fname2 = $row2["fname"];
      $program_id_adv = $row2["program_id"];
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
  if((isset($_GET['acad_year_start_rd'])) && (isset($_GET['semester_rd'])) && (isset($_GET['stud_no_records']))) {
  
  $acad_year_start_rd=$_GET['acad_year_start_rd'];
  $semester_rd=$_GET['semester_rd'];
  $stud_no_records=$_GET['stud_no_records'];
  $query_update_stud_records ="SELECT a.stud_no,a.lname,a.fname,a.mname,b.year_level,b.acad_year_start,b.acad_year_end,b.semester,b.section_id,b.category_id,b.ojt_status,b.enrollment_status,c.program_code,c.program_id,d.category_description,e.section FROM student_info AS a INNER JOIN student_ojt_records as b INNER JOIN program_list as c INNER JOIN program_category_list AS d INNER JOIN section_list AS e WHERE a.stud_no = b.stud_no and a.program_id = c.program_id AND b.category_id = d.category_id AND b.acad_year_start = '$acad_year_start_rd' AND b.semester =  '$semester_rd' AND a.stud_no = '$stud_no_records' AND b.section_id = e.section_id AND b.enrollment_status = 'Not Enrolled'";
                 
  $query_update_stud_records =  mysqli_query($dbc, $query_update_stud_records);         
          if($result2->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($query_update_stud_records))
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
              }
           }
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
  <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>
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
                          <label>
                          <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i>Company Comments</a>
                          </label><br>
                           <label class="active">
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
                        <h1 class="animated fadeInLeft">ENROLL OJT STUDENT</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section will allow you to enroll students.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>STUDENT INFORMATION</h3></div>
                    <form id="defaultForm" method="post" action="enroll_student_process.php">
                      <div class="panel-body" style="padding-bottom:30px;">
                      <br>
                        <div class="row" style="padding-left:5px;">
                        <input name="stud_no_records" type="hidden" value ="<?php echo $a_stud_no; ?>"/>
                        <input name="acad_year_start_rd" type="hidden" value ="<?php echo $acad_year_start_rd; ?>"/>
                        <input name="semester" type="hidden" value ="<?php echo $semester_rd; ?>"/>
						 <input name="category_id" type="hidden" value ="<?php echo $b_ojt_category; ?>"/>						 
                         <div class="col-md-2">
                              <h5 >STUDENT NUMBER</h5>
                                <div class="form-group">
                                  <h5><?php echo $a_stud_no; ?></h5>
                                </div>
                          </div>
                          <div class="col-md-2">
                               <h5 >STUDENT NAME</h5>
                                <div class="form-group">
                                  <h5><?php echo $a_lname." , ".$a_fname." ".$a_mname."."; ?></h5>
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
                           <div class="col-md-2">
                             <h5 style="padding-left:5px;">SECTION</h5>
                              <div class="form-group has-feedback">
                              <?php
                              $query_section_handled = "SELECT a.section_id,a.program_id,a.section FROM section_list AS a INNER JOIN adviser_section_handled AS b WHERE a.status = 'Active' AND b.status = 'Active' AND a.section_id = b.section_id AND a.program_id = '$c_program_id' AND a.section_id != '1' AND b.adviser_id = '$username'";
                     
                              $result_section_handled = mysqli_query($dbc, $query_section_handled);
                              $num_rows2 = mysqli_num_rows($result_section_handled);
                              if(mysqli_num_rows($result_section_handled)>0)
							  {
                              print'<select class="form-control"  name="section_records">';
                              
                              
                               while($row_pl = mysqli_fetch_array($result_section_handled)){
                                  
                                  $section_id = $row_pl[0];
                                  $program_code2 = $row_pl[1];
                                  $section= $row_pl[2];
                                    echo "<option value='".$section_id."'>".$section."</option>";    
                              }
							  print '</select>';
                              
                              }
							  else
							  {
								print'<select class="form-control"  name="section_records">
								<option></option>
								</select>';
                                
							  }
							  ?>
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
                          <div class="col-md-3">
                             <h5>ENROLLMENT STATUS</h5>
                              <div class="form-group has-feedback">
								<input type="hidden" name="enrollment_status" value="Enrolled"/>
								<h4>Not Enrolled</h4>
                              </div>
                          </div>
                          </div>
                        <br>
                        <br>
                         <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                             <button type="submit" class="btn btn-info btn-block" name="btn_enrolled_stud" id="btn_enrolled_stud"><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;ENROLL</button>
                             </div>
                              <div class="col-md-4">
                               <a href="pending_student_list.php?stud_no=<?php echo $a_stud_no; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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
	  $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                 section_records: {
                    validators: {
                        notEmpty: {}
					}
				 }
			}
  });
  });
  </script>
<!-- end: Javascript -->
</body>
</html>