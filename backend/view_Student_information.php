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
	$query2 = "SELECT * from admin_info WHERE admin_id = '$username'";
	$result2 = mysqli_query($dbc,$query2);
		if(mysqli_num_rows($result2)>0)
		{
			$row2 = mysqli_fetch_assoc($result2);
			$fname2 = $row2["fname"];
      $title2 = $row2["title"];
		}
}
if($usertype!=1)
{
	header("Location: adviser_home.php");
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
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
    $query_unread = "SELECT * FROM company_info";
    $result_unread = $dbc->query($query_unread);
    if($result_unread->num_rows > 0 ){
      while($rows_status = $result_unread->fetch_assoc()){
       $comp_id_status = $rows_status["comp_id"];
       $date_expiry_status = $rows_status["date_expiry"];
       $notify_status = $rows_status["notify_status"];
       if($date_today == $date_expiry_status && $notify_status == "none") {
          
         $q_updateStatus2 = "UPDATE company_info SET notify_status ='unread' WHERE comp_id='$comp_id_status'";
         $result_comp_info_status2 = mysqli_query($dbc,$q_updateStatus2); 
         }
      }
    }
 //dapat mging status unread ung expired today
    $q_notifystatus = "select * from company_info where date_expiry='$date_today'";
    $q_notifystatus_res = $dbc->query($q_notifystatus);
    if($q_notifystatus_res->num_rows > 0 ){
      while($comp_notif = $q_notifystatus_res->fetch_assoc()){
        $cmpexp_id = $comp_notif['comp_id'];
        
        //matic not actve ung compny ,ojt offers(Not Available) comp program not active
        $q_update_comp_info="update company_info set status='Not Active' where comp_id='$cmpexp_id'";
        $q_update_comp_info_res = $dbc->query($q_update_comp_info);
        
        $q_update_comp_program ="update company_program set comp_program_status='Not Active' where comp_id='$cmpexp_id'";
        $q_update_comp_program_res = $dbc->query($q_update_comp_program);
        
        $q_update_ojt_offers="update ojt_offers set status='Not Available' where comp_id='$cmpexp_id'";
        $q_update_ojt_offers_res = $dbc->query($q_update_ojt_offers);
      }
    }
   $query_comp_status2 = "SELECT COUNT(date_expiry) AS date_expiry_status FROM company_info where date_expiry = '$date_today' AND notify_status = 'unread'";             
   $result_comp_status2 =  mysqli_query($dbc, $query_comp_status2);
   if($result_comp_status2->num_rows > 0 )
         {   
          while ($row = mysqli_fetch_array($result_comp_status2))
              {
                 $date_expiry_status2 = $row[0];
                }
          }
     $query_count_comp = "SELECT COUNT(*) FROM company_info";
     $result_count_comp =  mysqli_query($dbc, $query_count_comp);         
          if($result_count_comp->num_rows > 0)
               {   
                while ($row3 = mysqli_fetch_array($result_count_comp))
                   {
                     $count_comp_id = $row3[0];      
                    }
              }
$query_resume_pending ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '1'";
$result_resume_pending =  mysqli_query($dbc, $query_resume_pending);         
          if($result_resume_pending->num_rows > 0)
               {   
                while ($row_pending = mysqli_fetch_array($result_resume_pending))
                   {
                     $count_resume_pending = $row_pending[0];      
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
          <div class="col-md-12">
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
                                        <a href="admin_chat.php">
                                              <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;"><label class="text-primary"> '.$count_conv.' </label> message(s).
                                              </div>
                                      </a>
                                      </li>
                                        </div>
                       </ul></li>';
					   
                $query_comp_status = "SELECT comp_id,comp_name FROM company_info where date_expiry = '$date_today' AND notify_status = 'unread'";
                 
                $result_comp_status =  mysqli_query($dbc, $query_comp_status);

                 
                  print '<li class="dropdown avatar-dropdown">
                              <br>
                               
                               <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" 
                                style="padding:1px 1px 1px 1px;">
                                    <i class="glyphicon glyphicon-globe" style="color:white;font-size:15px;"></i>
                                    <label style="font-size:15px;padding:2px 5px 2px 5px;" class="badge badge-danger">'.$date_expiry_status2.'</label></span>
                               <ul class="dropdown-menu user-dropdown">';

                     
                            while ($row_count = mysqli_fetch_array($result_comp_status))
                            {
                             
                               $comp_id_count = $row_count[0];
                               $comp_name2 = $row_count[1];
                               $counter = 0;

                                
                                
                            if($counter <= $date_expiry_status2)
                            {
                                echo '<div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                                      <li>
                                        <a href="update_comp_cont_info.php?comp_id='.$comp_id_count.'">
                                          <div style="font-size:12px; margin-left:2px; margin-right:2px; margin-top:2px; margin-bottom:2px;"><label class="text-primary">'.$comp_name2.'</label> has already expired the date notary.
                                         </div>
                                      </a>
                                      </li>
                                  </div>
								  <hr>';
                                
                               $counter++;
                             }
                            } 
                            
                          print '</ul></li>';
               print '<li class="dropdown avatar-dropdown">
                              <br>
                               
                               <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" 
                                style="padding:1px 1px 1px 1px;">
                                    <i class="fa fa-file-word-o" style="color:white;font-size:17px;"></i>
                                    <label style="font-size:15px;padding:2px 5px 2px 5px;" class="badge badge-danger">'.$count_resume_pending.'</label></span>
                               <ul class="dropdown-menu user-dropdown">';
                     
                          
                                echo '<div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                                      <li>
                                        <a href="student_resume_data.php">
                                              <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;">There is/are
                                                    <label class="text-primary"> '.$count_resume_pending.' </label> 
                                                         student resume pending.
                                              </div>
                                      </a>
                                      </li>
                                        </div>
                                        ';
                            
                          print '</ul></li>';
              ?>
                
                  
                  <li class="user-name"><span>&nbsp; Hi' <?php echo  $title2." ".$fname2 ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <br>
                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="admin_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span> My Account</a></li>
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
                          <a href="home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label>
                          <a href="Company_info.php"><i class="glyphicon glyphicon-globe"></i>Partner Companies</a>
                        </label><br>
                         <label>
                          <a href="ojt_offers_masterlist.php"><i class="fa fa-briefcase"></i>OJT Offers List</a>
                        </label><br>
                        <label>
                          <a href="OJT_adviser.php"><i class="glyphicon glyphicon-user"></i>OJT Advisers</a>
                        </label><br>
                        <label class="active">
                         <a href="Student_information.php"><i class="glyphicon glyphicon-info-sign"></i>OJT Students</a>
                        </label><br>
                         
                         <label>
                           <a href="Manage_course.php"><i class="glyphicon glyphicon-list-alt"></i>Manage Programs</a>
                         </label><br>
                         <label>
                          <a href="ojtsoftcopy.php"><i class=" glyphicon glyphicon-folder-open"></i>OJT Softcopy Files</a>
                         </label><br>
                          <label>
                          <a href="program_category_list.php"><i class="glyphicon glyphicon-th-list"></i>OJT Category List</a>
                          </label><br>
                         <label>
                          <a href="student_deliverables.php"><i class="fa fa-folder"></i>Student Deliverables</a>
                          </label><br>                 
							<label>
                          <a href="upload.php"><i class="fa fa-file-excel-o"></i>Official Students</a>
                          </label><br>						  
						  <label>
                          <a href="update_semester_ay.php"><i class="fa fa-calendar-check-o"></i>Active Semester and Year</a>
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
                         This section will show the student information.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>VIEW STUDENT INFORMATION</h3>
					<?php
					$q_stud_resume = "select * from student_resume_data where stud_no='$stud_no'";
					$q_stud_resume_res = $dbc->query($q_stud_resume);
					$resume_res = $q_stud_resume_res->fetch_assoc();
					if($resume_res['resume_status'] == 2){
						echo '<div class="col-md-9"></div>
						<a href="../files/resume/'.$stud_no.'.docx" download="'.$lname.'_'.$fname.'_'.$mname.'_'.$program_code.'" style="" class="btn btn-primary">Download Student Resume&nbsp;<i class="glyphicon glyphicon-download-alt"></i></a>';
						}
						?>
						</div>
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row" style="padding-left:5px;">
                         <input name="stud_no" type="hidden" value ="<?php echo $stud_no; ?>"/>
                        <div class="row">

                           <div class="col-md-3"> 

                            <?php
                            
							echo '<img src="../files/student_pics/'.$stud_no.'.jpg" style="height:200px;width:200px;">';
							?>
							</div>
						</div>
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
                           <div class="col-md-4">
                                <h5>EMAIL</h5>
                                <div class="form-group has-feedback">
                                   <h4><?php echo $email; ?></h4>
                                </div>
                            </div>
                             <div class="col-md-4">
                              <h5>FACEBOOK</h5>
                                <div class="form-group has-feedback">
                                   <h4 placeholder="facebook account is empty"><?php echo $facebook; ?></h4>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <h5>TELEPHONE NUMBER</h5>
                                <div class="form-group has-feedback">
                                    <h4 placeholder="there is no telephone number available"><?php echo $tel_no; ?></h4>
                                </div>
                            </div>
                             <div class="col-md-2">
                                  <h5>MOBILE NUMBER</h5>
                                  <div class="form-group has-feedback">
                                  <h4 placeholder="there is no mobile number available"><?php echo $mobile_no; ?></h4>
                                  </div>
                            </div>
                          </div>
                          </div>
                          </div>
                          </div>
                           <!--Company program lisr-->
              <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">STUDENT OJT RECORDS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section will OJT Record/s of the student.
                        </p>
                    </div>
                  </div>
              </div>
               <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>LIST OF OJT Record/s</h3></div>
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row" style="padding-left:5px;">
                            
                        </div>
                        <div class="row">
                         <?php 
                           $query_stud_records = "SELECT a.stud_no,a.year_level,a.semester,a.section_id,a.category_id,a.enrollment_status,a.ojt_status,a.acad_year_start,a.acad_year_end,b.category_description,c.section FROM student_ojt_records AS a INNER JOIN program_category_list AS b INNER JOIN section_list AS c WHERE a.category_id = b.category_id AND a.stud_no = '$stud_no' AND a.section_id = c.section_id";
                          $result_stud_records = mysqli_query($dbc, $query_stud_records);
                          $num_rows = mysqli_num_rows($result_stud_records);  
                          
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                            <tr> 
                             <th class="text-center">YEAR LEVEL</th>
                             <th class="text-center">SEMESTER</th>
                             <th class="text-center">SECTION</th>
                             <th class="text-center">SCHOOL YEAR</th>
                             <th class="text-center">OJT CATEGORY</th>
                              <th class="text-center">OJT STATUS</th>
                              <th class="text-center">ENROLLMENT STATUS</th>
                            </tr>
                          </thead>
                          <tbody>';
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
                      ?>
                      <tr >      
                                <td><?php echo $year_level_rd; ?></td>
                                <td><?php echo $semester_rd; ?></td>
                                <td><?php echo $section_name; ?></td>
                                <td><?php echo $acad_year_start_rd." - ".$acad_year_end_rd; ?></td>
                                <td><?php echo $category_description; ?></td>
                                <td><?php echo $ojt_status_rd; ?></td>
                                <td><?php echo $enrollment_status_rd; ?></td>
                                
                      </tr>
                      <?php 
                     }
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?> 
                     </div>
                          <br>
                          <div class="row">
                            <div class="col-md-8"></div>
                             <div class="col-md-4">
                               <a href="Student_information.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                          </div>
                            </div>
                </div>
                            
                      </div><!--ENd of panel body-->
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
                      <a href="home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                    </li>
                     <li class="ripple">
                      <a href="Company_info.php"><i class="glyphicon glyphicon-globe"></i>&nbsp; Partner Companies</a>
                    </li>
                    <li class="ripple">
                      <a href="ojt_offers_masterlist.php"><i class="fa fa-briefcase"></i>OJT Offers List</a>
                    </li>
                     <li class="ripple">
                      <a href="OJT_adviser.php"><i class="glyphicon glyphicon-user"></i>&nbsp; OJT Adviser</a>
                    </li>
                     <li class="ripple">
                      <a href="Student_information.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp; OJT Students</a>
                    </li>
                     
                     <li class="ripple">
                     <a href="Manage_course.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Manage Programs</a>
                    </li>
                     <li class="ripple">
                      <a href="ojtsoftcopy.php"><i class=" glyphicon glyphicon-folder-open"></i>&nbsp; OJT Softcopy Files
                      </a>
                    </li>
                     <li class="ripple">
                       <a href="program_category_list.php"><i class="glyphicon glyphicon-th-list"></i>&nbsp; OJT Category List</a>
                      </a>
                    </li>
                      <li class="ripple">
                        <a href="student_deliverables.php"><i class="fa fa-folder"></i>&nbsp;Student Deliverables</a>
                    </li>
					<li>
					<a href="upload.php"><i class="fa fa-file-excel-o"></i>Official Students</a>
					</li>
                     <li>
					<a href="upload_semester_ay.php"><i class="fa fa-calendar-check-o"></i>Active Semester and Year</a>
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