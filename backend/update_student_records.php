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
  if((isset($_GET['acad_year_start_rd'])) && (isset($_GET['semester_rd'])) && (isset($_GET['stud_no_records']))&& (isset($_GET['category_id']))) {
  
  $acad_year_start_rd=$_GET['acad_year_start_rd'];
  $semester_rd=$_GET['semester_rd'];
  $stud_no_records=$_GET['stud_no_records'];
  $category_id = $_GET['category_id'];
  $query_update_stud_records ="SELECT a.stud_no,a.lname,a.fname,a.mname,b.year_level,b.acad_year_start,b.acad_year_end,b.semester,b.section_id,b.ojt_status,b.enrollment_status,c.program_code,c.program_id,d.category_description,e.section FROM student_info AS a INNER JOIN student_ojt_records as b INNER JOIN program_list as c INNER JOIN program_category_list AS d INNER JOIN section_list AS e WHERE a.stud_no = b.stud_no and a.program_id = c.program_id AND  d.category_id='$category_id' AND b.acad_year_start = '$acad_year_start_rd' AND b.semester =  '$semester_rd' AND a.stud_no = '$stud_no_records' AND b.section_id = e.section_id AND b.category_id = '$category_id'";
                 
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
                            $b_ojt_category = $category_id;
                            $b_ojt_status = $row[9];
                            $b_ojt_enrollment_status = $row[10];
                            $c_program_code = $row[11];
                            $c_program_id = $row[12];
                            $category_description = $row[13];
                            $section_name = $row[14];          
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
					   
               $query_comp_status = "SELECT comp_id,comp_name,img_data FROM company_info where date_expiry = '$date_today' AND notify_status = 'unread'";
                 
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
                               $img_count = $row_count[2];
                               $counter = 0;
                                
                                
                            if($counter <= $date_expiry_status2)
                            {
                              $decoded_img_count = base64_decode($img_count);
                                 $f = finfo_open(); 
                                 $img_type = finfo_buffer($f, $decoded_img_count, FILEINFO_MIME_TYPE); 
                                echo '<div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                                      <li>
                                        <a href="update_comp_cont_info.php?comp_id='.$comp_id_count.'">
                                          <img src="data:'.$img_type.';base64,'.$img_count.'" style="height:50px;width:50px;margin-top:5px;margin-left:10px;">
                                          <div style="font-size:12px; margin-left:2px; margin-right:2px; margin-top:2px; margin-bottom:2px;"><label class="text-primary">'.$comp_name2.'</label> has already expired the date notary.
                                         </div>
                                      </a>
                                      </li>
                                        </div>
                                        
                                        ';
                               $counter++;
                             }
                            } 
                            
                          print '</ul></li>';
              ?>
              <?php
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
                        <h1 class="animated fadeInLeft">OJT STUDENT RECORDS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          &nbsp;
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE OJT STUDENT RECORDS</h3></div>
                    <form id="defaultForm" method="post" action="update_student_records_process.php">
                      <div class="panel-body" style="padding-bottom:30px;">
                      <br>
                        <div class="row" style="padding-left:5px;">
                        <input name="stud_no_records" type="hidden" value ="<?php echo $a_stud_no; ?>"/>
                        <input name="acad_year_start_rd" type="hidden" value ="<?php echo $acad_year_start_rd; ?>"/>
                        <input name="semester" type="hidden" value ="<?php echo $semester_rd; ?>"/>
                        <input name="lname" type="hidden" value ="<?php echo $a_lname; ?>"/>
                        <input name="fname" type="hidden" value ="<?php echo $a_fname; ?>"/>
                        <input name="mname" type="hidden" value ="<?php echo $a_mname; ?>"/>
						<input name="category_id" type="hidden" value ="<?php echo $category_id; ?>"/>
                         <div class="col-md-2">
                              <h5 >STUDENT NUMBER</h5>
                                <div class="form-group">
                                  <h5><?php echo $a_stud_no; ?></h5>
								  
                                </div>
                          </div>
                          <div class="col-md-3">
                               <h5 >STUDENT NAME</h5>
                                <div class="form-group">
                                  <h5><?php echo $a_lname." , ".$a_fname." ".$a_mname; ?></h5>
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
                                  <input type="hidden" name="category_description" value="<?php echo $category_description; ?>"/>
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
								if($b_ojt_enrollment_status == "Not Enrolled"){
									echo '<h5>NO SECTION</h5>';
								}else{
                              $query_section_handled = "SELECT section_id,program_id,section FROM section_list WHERE status = 'Active' AND program_id = '$c_program_id' AND section_id != '1'";
                     
                              $result_section_handled = mysqli_query($dbc, $query_section_handled);
                              $num_rows2 = mysqli_num_rows($result_section_handled);
                              
                              print'<select class="form-control"  name="section_records" class="form-control">';
                              
                              echo "<option value='".$b_section_id."'>".$section_name."</option>";
                               while($row_pl = mysqli_fetch_array($result_section_handled)){
                                  
                                $section_id = $row_pl[0];
                                $program_code2 = $row_pl[1];
                                $section= $row_pl[2];
								
								$comstart1="";
								$comend="-->";
								
								if($section==$section_name)
								{
									$comstart1="<!--";
								}
								
                                echo $comstart1."<option value='".$section_id."'>".$section."</option>".$comend;    
                              }
                              ?>
                              <?php
                              print '</select>';
							  }
                              ?>
                            </div>
                          </div>
                           <div class="col-md-3">
                            <h5 style="padding-left:5px;">OJT STATUS</h5>
                           <?php
								   $query_all_completed ="SELECT remarks FROM student_checklist WHERE stud_no = '$stud_no_records' AND acad_year_start = '$acad_year_start_rd' AND semester = '$semester_rd' AND remarks = 'Not yet Completed'"; 
								   $result_all_completed =  mysqli_query($dbc, $query_all_completed);
								   $Ongoing = "Ongoing";
								   $Finished = "Finished";
                   $DNA = "DNA";             
									if($result_all_completed->num_rows > 0)
										 {   
										  while ($row_completed = mysqli_fetch_array($result_all_completed))
											 {
											   $result_all_remarks = $row_completed[0];      
											  }
                      if($b_ojt_status == "Ongoing"){
                        $new_ojt_status = "Ongoing";
                      }
                      elseif($b_ojt_status == "Finished"){
                        $new_ojt_status = "Finished";
                      }elseif($b_ojt_status == "DNA"){
                        $new_ojt_status = "DNA";
                      }
									   print '<h4>'.$new_ojt_status.'</h4>
											   <input type="hidden" name="ojt_status" value='.$b_ojt_status.'>';
										}else{
										   
											$comstart2="";
											$comstart3="";
											
											if($b_ojt_status==$Ongoing)
											{
												$comstart2="<!--";
											}
											else if($b_ojt_status==$Finished)
											{
												$comstart2="<!--";
											}else if($b_ojt_status==$DNA)
											{
												$comstart4="<!--";
											}
											 print '<div class="form-group has-feedback">
											<select class="form-control" name="ojt_status" id="ojt_status" class="form-control" placeholder="ojt status">';
												echo  "<option value='".$b_ojt_status."'>".$b_ojt_status."</option>";
												echo  $comstart2."<option value='".$Ongoing."'>".$Ongoing."</option>".$comend;
												echo  $comstart3."<option value='".$Finished."'>".$Finished."</option>".$comend;
											print '</select>
									  </div>';
										}
                           ?>
                            
                             
                          </div>
                           <div class="col-md-3">
                             <h5>ENROLLMENT STATUS</h5>
                              <div class="form-group has-feedback">
                              <input type="hidden" name="enrollment_status" value="<?php echo $b_ojt_enrollment_status; ?>" />
                                <h4><?php echo $b_ojt_enrollment_status; ?></h4>
                              </div>
                          </div>
                        </div>
                        <br>
                        <br>
                         <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                             <button type="submit" class="btn btn-info btn-block" name="btn_update_stud_records" id="btn_update_stud_records"><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE</button>
                             </div>
                              <div class="col-md-4">
                               <a href="student_ojt_details.php?stud_no=<?php echo $a_stud_no; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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
                stringLength: {
                            min: 1,
                            max: 30,
                            message: 'The  OJT status must be more than 6 and less than 30 characters long'
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