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
  if((isset($_GET['acad_year_start_rd'])) && (isset($_GET['semester_rd'])) && (isset($_GET['stud_no_records']))) {
  
  $acad_year_start_rd=$_GET['acad_year_start_rd'];
  $semester_rd=$_GET['semester_rd'];
  $stud_no_records=$_GET['stud_no_records'];
  $query_update_stud_records ="SELECT a.stud_no,a.lname,a.fname,a.lname,b.year_level,b.acad_year_start,b.acad_year_end,b.semester,b.section_id,b.category_id,b.ojt_status,b.enrollment_status,c.program_code,c.program_id,d.category_description,e.section FROM student_info AS a INNER JOIN student_ojt_records as b INNER JOIN program_list as c INNER JOIN program_category_list AS d INNER JOIN section_list AS e WHERE a.stud_no = b.stud_no and a.program_id = c.program_id AND b.category_id = d.category_id AND b.acad_year_start = '$acad_year_start_rd' AND b.semester =  '$semester_rd' AND a.stud_no = '$stud_no_records' AND b.section_id = e.section_id AND b.ojt_status='Ongoing'";
                 
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
  <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
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
                        <h1 class="animated fadeInLeft">OJT STUDENT RECORDS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          View OJT records of the selected student.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE OJT STUDENT RECORDS</h3></div>
					     <br>
					
                       <?php 
					   

                       if(isset($_GET['success']) && isset($_GET['comp_name_start'])) 
                        {   
                          $comp_name_start = $_GET['comp_name_start'];
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-info alert-dismissible fade in" role="alert">
                                 <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
									<strong>&nbsp;The student was Sucessfully Updated the company to '.$comp_name_start.'</strong> 
                              </div>
                          </div>
                        </div>
                      </div>';

                        }
                        else if(isset($_GET['added']) && isset($_GET['comp_name_start']) && isset($_GET['ojt_start_date'])) 
                        {   
                          $comp_name_start = $_GET['comp_name_start'];
                           $ojt_start_date = $_GET['ojt_start_date'];
                        print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;The student was successfully assigned for OJT at the company '.$comp_name_start.'. OJT start date: '.$ojt_start_date.'</strong> 
                              </div>
                          </div>
                        </div>
                      </div>';

                        }
						else if(isset($_GET['message']))
						{
							$message=$_GET['message'];   
                    print '<div class="row">
                       <div class="col-md-12">
                        <div class="col-md-12" id="success">
                         <div class="alert alert-info alert-dismissible fade in" role="alert">
                                 <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
									<strong>&nbsp;'.$message.'</strong> 
                              </div>
                          </div>
                        </div>
                      </div>';               
						      }
                        ?>
                    <form id="defaultForm" method="post" action="adviser_update_DNA_records_process.php">
                      <div class="panel-body" style="padding-bottom:30px;">
                      <br>
                        <div class="row" style="padding-left:5px;">
                        <input name="stud_no_records" type="hidden" value ="<?php echo $a_stud_no; ?>"/>
                        <input name="acad_year_start_rd" type="hidden" value ="<?php echo $acad_year_start_rd; ?>"/>
                        <input name="acad_year_end_rd" type="hidden" value ="<?php echo $acad_year_end_rd; ?>"/>
                        <input name="semester" type="hidden" value ="<?php echo $semester_rd; ?>"/>
                         <div class="col-md-2">
                              <h5 >STUDENT NUMBER</h5>
                                <div class="form-group">
                                  <h5><?php echo $a_stud_no; ?></h5>
                                </div>
                          </div>
                          <div class="col-md-3">
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
                           <div class="col-md-3"> 
                            <h5>OJT CATEGORY</h5>
                                <div class="form-group">
                                  <h5><?php echo $category_description; ?></h5>
                                </div>
                          </div>
                         <div class="col-md-2"> 
                            <h5>SCHOOL YEAR</h5>
                                <div class="form-group">
								        <input type="hidden" name="acad_year_start" value="<?php echo $b_acad_year_start; ?>"/>
								        <input type="hidden" name="acad_year_end" value="<?php echo $b_acad_year_end?>"/>
                                  <h5><?php echo $b_acad_year_start." - " .$b_acad_year_end; ?></h5>
                                </div>
                          </div>
                           <div class="col-md-2">
                             <h5>SECTION</h5>
                              <div class="form-group has-feedback">
                              <h5><?php echo $section_name; ?></h5>
                              <input type="hidden" name="section_records" value ="<?php echo $b_section_id; ?>" />
                            </div>
                          </div>
                           
                           <div class="col-md-2">
                             <h5 style="padding-left:5px;">ENROLLMENT STATUS</h5>
                              <div class="form-group has-feedback">
                                <h5 style="padding-left:5px;"><?php echo $b_ojt_enrollment_status; ?></54>
                              </div>
                          </div>

                              
							  <?php

							  if($b_ojt_status == "DNA")
							  {
								print '<div class="col-md-2">
										 <h5 style="padding-left:5px;">OJT STATUS</h5>
										 <div class="form-group has-feedback" style="padding-left:5px;">
										<h4>DNA</h4>
										</div>
										</div>';
										$disabled = "disabled";
								
							  }
							  elseif($b_ojt_status == "Incomplete")
							  {
								print '<div class="col-md-2">
										 <h5 style="padding-left:5px;">OJT STATUS</h5>
										 <div class="form-group has-feedback" style="padding-left:5px;">
										<h4>Incomplete</h4>
										</div>
										</div>';
										$disabled = "disabled";
								
							  }
							  elseif($b_ojt_status == "Ongoing")
							  {
                  $b_ojt_status2 = "On going";
								print '<div class="col-md-2">
									<h5 style="padding-left:5px;">OJT STATUS</h5>
									<div class="form-group has-feedback" style="padding-left:5px;">
									<input type="hidden" name="category_id" value="'.$b_ojt_category.'" />
                                    <select class="form-control" name="ojt_status" id="ojt_status">
									<option value="Ongoing">'.$b_ojt_status2.'</option>
									<option value="DNA">DNA</option>
									<option value="Incomplete">Incomplete</option>
									<select/>
									</div>
									</div>';
									$disabled = " ";
							  }elseif($b_ojt_status == "Finished")
                {
                    $disabled = "disabled";
                }
							  ?>
                        </div>
                    <?php 
                    $query_select_company_ojt_status2 ="SELECT a.stud_no,a.acad_year_start,a.semester,a.enrollment_status,b.remarks,c.status,c.comp_ojt_stud_id,a.ojt_status FROM student_ojt_records  AS a INNER JOIN student_checklist AS b INNER JOIN company_ojt_student AS c WHERE a.acad_year_start = c.acad_year_start AND a.semester = c.semester AND a.stud_no = c.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.acad_year_start = '$acad_year_start_rd' AND a.semester = '$semester_rd' AND  a.stud_no = b.stud_no AND b.deliverable_id = '7' AND a.stud_no = '$stud_no_records' AND a.ojt_status='Ongoing'";

                    $result_select_company_ojt_status2 =mysqli_query($dbc,$query_select_company_ojt_status2);

                    if($result_select_company_ojt_status2->num_rows> 0)
                    {
                        while($row6 = mysqli_fetch_array($result_select_company_ojt_status2))
                        {
                            $stud_no2 = $row6[0];
                            $acad_year_start2 = $row6[1];
                            $semester2 = $row6[2];
                            $enrollment_status2 = $row6[3];
                            $remarks2 = $row6[4];
                            $cos_status2 = $row6[5];
                            $comp_ojt_stud_id2 = $row6[6];
                            $ojt_status2 = $row6[7];
                        }
                    }
                    $query_select_company_ojt_status ="SELECT a.stud_no,a.acad_year_start,a.semester,a.enrollment_status,b.remarks,c.status,c.comp_ojt_stud_id,a.ojt_status,a.acad_year_end FROM student_ojt_records  AS a INNER JOIN student_checklist AS b INNER JOIN company_ojt_student AS c WHERE a.acad_year_start = c.acad_year_start AND a.semester = c.semester AND a.stud_no = c.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.acad_year_start = '$acad_year_start_rd' AND a.semester = '$semester_rd' AND  a.stud_no = b.stud_no AND b.deliverable_id = '5'  AND a.stud_no = '$stud_no_records' AND a.ojt_status='Ongoing'";

                    $result_select_company_ojt_status =mysqli_query($dbc,$query_select_company_ojt_status);

                    if($result_select_company_ojt_status->num_rows> 0)
                    {
                        while($row5 = mysqli_fetch_array($result_select_company_ojt_status))
                        {
                            $stud_no = $row5[0];
                            $acad_year_start = $row5[1];
                            $semester = $row5[2];
                            $enrollment_status = $row5[3];
                            $remarks = $row5[4];
                            $cos_status = $row5[5];
                            $comp_ojt_stud_id = $row5[6];
                            $ojt_status = $row5[7];
                            $acad_year_end = $row5[8];
                        }
                    }

                       if($enrollment_status == "Enrolled" && $remarks == "Completed" && $cos_status == "Pending" && $remarks2 == "Completed" )
                        {
                          print '<div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                      <div class="well well-sm">
                                          <h5><span class="glyphicon glyphicon-exclamation-sign text-warning"></span>
                                          <strong><label class="text-warning">NOTE</label></strong></h5>
                                          <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; This student is now ready to start his/her OJT.   
                                            <strong><mark class="text-primary">
                                              <a href="start_ojt_student.php?acad_year_start_rd='.$acad_year_start_rd.'&semester_rd='.$semester_rd.'&stud_no_records='.$stud_no_records.'&comp_ojt_stud_id='.$comp_ojt_stud_id.'">  
                                                      <span class="fa fa-thumbs-o-up"></span> START OJT!</a>            
                                            </mark></strong>.</p>
                                       </div>
                                    </div>  
                              </div>
                            </div>';
                          }
						  else if($enrollment_status == "Enrolled" && $remarks == "On process" && $cos_status == "Pending" && $remarks2 == "Completed" )
                        {
                          print '<div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                      <div class="well well-sm">
                                          <h5><span class="glyphicon glyphicon-exclamation-sign text-warning"></span>
                                          <strong><label class="text-warning">NOTE</label></strong></h5>
                                          <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; This student is now ready to start his/her OJT.   
                                            <strong><mark class="text-primary">
                                              <a href="start_ojt_student.php?acad_year_start_rd='.$acad_year_start_rd.'&semester_rd='.$semester_rd.'&stud_no_records='.$stud_no_records.'&comp_ojt_stud_id='.$comp_ojt_stud_id.'">  
                                                      <span class="fa fa-thumbs-o-up"></span> START OJT!</a>            
                                            </mark></strong>.</p>
                                       </div>
                                    </div>  
                              </div>
                            </div>';
                          }

                          elseif($cos_status == "Ongoing" AND $ojt_status == "Ongoing"){
                             print '<div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                  <div class="well well-sm">
                                      <h5><span class="glyphicon glyphicon-exclamation-sign text-warning "></span>
                                      <strong><label class="text-warning">NOTE</label></strong></h5>
                                      <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; This student was already  
                                        <strong><mark class="text-primary">started         
                                        </mark></strong> his/her OJT. Click >> <strong><mark class="text-primary">
                                              <a href="update_start_ojt_student.php?acad_year_start_rd='.$acad_year_start_rd.'&semester_rd='.$semester_rd.'&stud_no_records='.$stud_no_records.'&comp_ojt_stud_id='.$comp_ojt_stud_id.'">  
                                                      <span class="fa fa-pencil"></span> UPDATE </a>             
                                            </mark></strong> << to update the OJT company.</p>
                                   </div>
                                </div>  
                              </div>
                            </div>';
                          }
                          elseif($ojt_status == "Finished"  AND $ojt_status == "Finished"){
                             print '<div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                      <div class="well well-sm">
                                          <h5><span class="glyphicon glyphicon-exclamation-sign text-warning"></span>
                                          <strong><label class="text-warning">NOTE</label></strong></h5>
                                          <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; This&nbsp;student&nbsp;is &nbsp;<label class="text-primary"> DONE  &nbsp; <span class="fa fa-check-square-o"></span> </label> &nbsp;
                                           to &nbsp; his / her &nbsp;OJT.</p>
                                       </div>
                                    </div>  
                              </div>
                            </div>';
                          }elseif($ojt_status == "DNA"){
                             print '<div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                      <div class="well well-sm">
                                          <h5><span class="glyphicon glyphicon-exclamation-sign text-warning"></span>
                                          <strong><label class="text-warning">NOTE</label></strong></h5>
                                          <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; The OJT record of this student &nbsp;<label class="text-primary"> BATCH : '.$acad_year_start_rd.' - '.$acad_year_end.' - '.$semester_rd.' </label> &nbsp;was&nbsp; <label class="text-danger"><span class="fa fa-warning"></span> <strong>DNA.</strong> </label></p>
                                       </div>
                                    </div>  
                              </div>
                            </div>';
                          }
                          elseif($enrollment_status == "Enrolled" && $cos_status == "Pending" && $remarks == "On process")
                          {
                           print '<div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                      <div class="well well-sm">
                                          <h5><span class="glyphicon glyphicon-exclamation-sign text-warning"></span>
                                          <strong><label class="text-warning">NOTE</label></strong></h5>
                                          <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; This student is <label class="text-danger"> NOT READY </label> to
                                            <strong><mark class="text-primary">
                                           <span class="fa fa-thumbs-o-down"></span>  START OJT.</p>
                                           <label style="margin-left:30px;">The student does not have 
                                           <label class="text-primary"><strong>Endorsement letter.</strong></label></label>
                                       </div>
                                    </div>  
                              </div>
                            </div>';
                          }
						  elseif($enrollment_status == "Enrolled" && $remarks == "Completed" && $cos_status == "Pending")
                          {
                           print '<div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                      <div class="well well-sm">
                                          <h5><span class="glyphicon glyphicon-exclamation-sign text-warning"></span>
                                          <strong><label class="text-warning">NOTE</label></strong></h5>
                                          <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; This student is <label class="text-danger"> NOT READY </label> to
                                            <strong><mark class="text-primary">
                                           <span class="fa fa-thumbs-o-down"></span>  START OJT.</p>
                                           <label style="margin-left:30px;">The student does not have 
                                           <label class="text-primary"><strong>Endorsement letter.</strong></label></label>
                                       </div>
                                    </div>  
                              </div>
                            </div>';
                          }
						  elseif($enrollment_status == "Enrolled" && $remarks2 == "Completed" && $cos_status == "Pending" )
                        {
                           print '<div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                      <div class="well well-sm">
                                          <h5><span class="glyphicon glyphicon-exclamation-sign text-warning"></span>
                                          <strong><label class="text-warning">NOTE</label></strong></h5>
                                          <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; This student is <label class="text-danger"> NOT READY </label> to
                                            <strong><mark class="text-primary">
                                           <span class="fa fa-thumbs-o-down"></span>  START OJT.</p>
                                           <label style="margin-left:30px;">The student does not have 
                                           <label class="text-primary"><strong> Memorandum of Agreement (MOA).</strong></label></label>
                                       </div>
                                    </div>  
                              </div>
                            </div>';
                          }
                          else{
                            print '<div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                      <div class="well well-sm">
                                          <h5><span class="glyphicon glyphicon-exclamation-sign text-warning"></span>
                                          <strong><label class="text-warning">NOTE</label></strong></h5>
                                          <p> &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; This student is <label class="text-danger"> NOT READY </label> to
                                            <strong><mark class="text-primary">
                                           <span class="fa fa-thumbs-o-down"></span>  START OJT.</p>
                                           <label style="margin-left:30px;">It`s either the student does not have 
                                           <label class="text-primary"><strong>Endorsement Letter / Memorandum of Agreement (MOA).</strong></label></label>
                                       </div>
                                    </div>  
                              </div>
                            </div>';

                          }
                    ?>   

                         <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
							<button type="submit" class="btn btn-info btn-block" name="btn-DNA" id="btn-DNA" <?php echo $disabled;?>><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE</button>
                            </div>
                              <div class="col-md-4">
                               <a href=" adviser_student_information.php?semester=<?php echo $semester_rd; ?>&acad_year_start=<?php echo $acad_year_start_rd; ?>&acad_year_end=<?php echo $b_acad_year_end; ?>&program_code=<?php echo $c_program_code; ?>&program_id=<?php echo $c_program_id; ?>&section_id=<?php echo $b_section_id; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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
  var table = $('#datatables').DataTable();
  function FunctionDelete(){
             
              var r = confirm("Are you sure you want to delete?");
              
              if(r == true){
                  alert("Successfully deleted");
                  document.comptb.action = "delete_comp_info.php";
                  document.comptb.submit(); 
              }
              if(r == false){
                event.preventDefault();
              }
            }
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
                    message: 'The section is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The section is required and can\'t be empty'
                        },
                    }
                },
                ojt_status: {
                    validators: {
                        notEmpty: {
                            message: 'The OJT status is required and can\'t be empty'
                        },
                
                        regexp: {
                            regexp: /^[a-zA-Z \.]+$/,
                            message: 'The OJT status can only consist of alphabetical characters,'
                        }
                    }
                },
                enrollment_status: {
                    validators: {
                        notEmpty: {
                            message: 'The enrollment status is required and can\'t be empty'
                        },
            stringLength: {
                            min: 4,
                            max: 30,
                            message: 'The enrollment status must be more than 4 and less than 30 characters long'
                        },
                    }
                },
            }
        }) 
  });
</script>


</body>
</html>