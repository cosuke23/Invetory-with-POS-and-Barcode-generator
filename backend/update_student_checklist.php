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
  if((isset($_GET['acad_year_start'])) && (isset($_GET['semester'])) && (isset($_GET['deliverable_id'])) && (isset($_GET['stud_no_records'])) && (isset($_GET['category_id']))) {
  
  $deliverable_id=$_GET['deliverable_id'];
  $semester=$_GET['semester'];
  $acad_year_start=$_GET['acad_year_start'];
  $stud_no_records=$_GET['stud_no_records'];
  $category_id = $_GET['category_id'];
  $query_student_checklist= "SELECT d.stud_no,d.deliverable_id,DATE_FORMAT(d.date_submitted, '%m/%d/%Y') AS date_submitted,d.semester,d.acad_year_start,d.acad_year_end,d.remarks,e.deliverable_name,f.lname,f.fname,f.mname,h.program_code,g.section_id,m.section,f.program_id FROM student_checklist AS d INNER JOIN student_deliverables AS e INNER JOIN student_info AS f INNER JOIN  student_ojt_records AS g INNER JOIN program_list AS h INNER JOIN section_list AS m WHERE d.deliverable_id = e.deliverable_id AND f.stud_no = d.stud_no AND f.stud_no = g.stud_no AND f.program_id = h.program_id  AND d.acad_year_start = '$acad_year_start' AND g.acad_year_start = '$acad_year_start' AND g.semester = '$semester' AND d.semester = '$semester' AND d.deliverable_id = '$deliverable_id' AND d.stud_no = '$stud_no_records' AND g.section_id = m.section_id AND d.category_id='$category_id'";
                 
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
                  $program_id_moa = $row[14];   
				  
              }
           }
}
if($remarks == 'On process')
{
  $query_remarks_moa = "SELECT a.stud_no,a.comp_id,a.note,DATE_FORMAT(a.date_note, '%m/%d/%Y') AS date_note,b.comp_name,a.rmks_id FROM moa_remarks AS a INNER JOIN company_info AS b WHERE a.comp_id = b.comp_id AND a.stud_no = '$stud_no_cl' AND a.acad_year_start = '$acad_year_start' AND a.semester = '$semester'";
  $result_remarks_moa =  mysqli_query($dbc, $query_remarks_moa);         
          if($result_remarks_moa->num_rows > 0 )
            {   
              while ($row2 = mysqli_fetch_array($result_remarks_moa))
              {
                  $stud_no_moa = $row2[0];
                  $comp_id_moa = $row2[1];
                  $note_moa = $row2[2];
                  $date_note_moa = $row2[3];
                  $comp_name_moa = $row2[4];
                  $rmks_id = $row2[5];                         
              }
           }
}else{
                  $stud_no_moa = "";
                  $comp_id_moa = "";
                  $note_moa = "";
                  $date_note_moa = "";
                  $comp_name_moa = "";
                  $rmks_id = "";  
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
					   
               $query_comp_status = "SELECT comp_id,comp_name,FROM company_info where date_expiry = '$date_today' AND notify_status = 'unread'";
                 
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
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">OJT STUDENT CHECKLIST</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section can update the ojt checklist of the student.
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
                      <form id="defaultForm" method="post" action="update_student_checklist_process.php">
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row">
                          <div class="col-md-12">
                            <input name="stud_no_chklist" type="hidden" value ="<?php echo $stud_no_cl; ?>"/>
                             <input name="deliverable_id" type="hidden" value ="<?php echo $deliverable_id; ?>"/>
                             <input name="semester" type="hidden" value ="<?php echo $semester; ?>"/>
                             <input name="deliverable_name" type="hidden" value ="<?php echo $deliverable_name; ?>"/>
                             <input name="acad_year_start" type="hidden" value ="<?php echo $acad_year_start; ?>"/>
                             <input name="rmks_id" type="hidden" value ="<?php echo $rmks_id; ?>"/>
							 <input name="category_id" type="hidden" value ="<?php echo $category_id; ?>"/>
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
									<input type="hidden" name="section_id" value ="<?php echo $section_id; ?>" />
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
                                  <h4>Remarks:</h4>
                                </div>
                                <div class="col-md-5">
                                  <div class="form-group has-feedback">
                				<?php
                                  $hide="hide";
                					$comstart1="";
                					$comstart2="";
                					$comend="-->";
                										
									if($remarks=="Not yet completed")
                					{
                						$comstart1="<!--";
                					}
                					else if($remarks=="Completed")
                					{
                						$comstart2="<!--";
									}
                                    else if($deliverable_id='5')
                                    {
                                      if($remarks=="On process")
                                      {
                                        $hide="show";
                                        $comstart3="<!--";
                                      }
                                    }else if($deliverable_id='11')
                                    {
                                      if($remarks=="Form released")
                                      {
                                        $comstart4="<!--";
										$comstart3="<!--";
                                      }
                                    }
									?>
            					<select class="form-control" name="remarks" id="remarks" class="form-control" placeholder="remarks" onChange="shownote()" >
									<option value="<?php echo $remarks; ?>"><?php echo $remarks; ?></option>
									<?php echo $comstart1; ?><option value="Not yet completed">Not yet completed</option><?php echo $comend;?>
            					<?php 
                                if($deliverable_id == '5' && $remarks != "Form released"){
                                  echo $comstart3.'<option value="On process">On process</option>'.$comend;
                                }
								else if($deliverable_id == '11'){
									 if($remarks=="Not yet completed" || $remarks=="Form released")	{
										
										echo $comstart4.'<option value="Form released">Form released</option>'.$comend;
										}			
								}
                                ?>
                                <?php echo $comstart2; ?><option value="Completed">Completed</option><?php echo $comend;?>
            					</select>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                          </div>
                         <div class="row <?php echo $hide; ?>" id="comp_d">
                          <div class="col-md-2"></div>
                             <div class="col-md-2">
                               <h4>Company Name:</h4>
                             </div>
                            <div class="col-md-5">
                            <div class="form-group has-feedback">
                              <?php
                              $query_company_list= "SELECT a.comp_id,a.comp_name FROM company_info AS a INNER JOIN company_program AS b WHERE a.comp_id = b.comp_id AND a.status = 'Active' AND b.comp_program_status = 'Active' AND b.program_id = '$program_id_moa'";
                     
                              $result_company_list = mysqli_query($dbc, $query_company_list);
                              $num_rows3 = mysqli_num_rows($result_company_list);
                              
                              print'<select class="form-control"  name="comp_id" class="form-control">';
                              
                              echo "<option value='".$comp_id_moa."'>".$comp_name_moa."</option>";
                               while($row__ci = mysqli_fetch_array($result_company_list)){
                                  
                                  $comp_id = $row__ci[0];
                                  $comp_name = $row__ci[1];
                                    echo "<option value='".$comp_id."'>".$comp_name."</option>";    
                              }
                              ?>
                              <?php
                              print '</select>';
                              ?>
                            </div>
                         </div>
                         </div>
                          <div class="row <?php echo $hide; ?>" id="note_d">
                            <div class="col-md-2"></div>
                              <div class="col-md-2"><h4>Note:</h4></div>
                            <div class="col-md-5">
                              <div class="form-group has-feedback">
                                  <textarea rows ="3" name="note" class="form-control" placeholder="Type here . . ." ><?php echo $note_moa; ?></textarea>
                            </div>
                          </div>
                          </div>
                          <div class="row <?php echo $hide; ?>" id="date_note_d">
                            <div class="col-md-2"></div>
                            <div class="col-md-2"><h4>Date to submit MOA:</h4></div>
                              <div class="col-md-5">
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="date_note_picker">
                                          <input type="text" class="form-control" name="date_note_picker" maxlength="10" value="<?php echo $date_note_moa; ?>"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <script>
                          var selector = document.getElementById("remarks");
                          var note_d = document.getElementById("note_d");
                          var date_note_d = document.getElementById("date_note_d");
                          var comp_d = document.getElementById("comp_d");
                          function shownote(){
                               var x = selector.options[selector.selectedIndex].text;
                              
                              if(x == "Completed"){
                                note_d.setAttribute("class","row hide");
                                date_note_d.setAttribute("class","row hide");
                                comp_d.setAttribute("class","row hide");
                              }
                              if( x == "Not yet completed"){
                                note_d.setAttribute("class","row hide");
                                date_note_d.setAttribute("class","row hide");
                                comp_d.setAttribute("class","row hide");
                              }
							  if( x == "Form released"){
                                note_d.setAttribute("class","row hide");
                                date_note_d.setAttribute("class","row hide");
                                comp_d.setAttribute("class","row hide");
                              }
							  if( x == "On process"){
                                note_d.setAttribute("class","row show");
                                date_note_d.setAttribute("class","row show");
                                comp_d.setAttribute("class","row show");
                              }
                          }
                        </script>
                        <br>
                        <br>
                         <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                             <button type="submit" class="btn btn-info btn-block" name="btn_update_stud_chklist" id="btn_update_stud_chklist"><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE</button>
                             </div>
                              <div class="col-md-4">
                               <a href="OJT_student_checklist.php?acad_year_start_rd=<?php echo $acad_year_start ?>&semester_rd=<?php echo $semester; ?>&stud_no_records=<?php echo $stud_no_records; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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
   $('#date_submitted')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'date_submitted');
        });
    $('#date_note_picker')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'date_note_picker');
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
                date_note_picker: {
                    validators: {
                        notEmpty: {
                            message: 'The date is required and can\'t be empty'
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
                },
                comp_id: {
                    message: 'Company Name name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Company Name is required and can\'t be empty'
                        },
                    }
                },
                note: {
                    message: 'Note name is not valid',
                    validators: {
                    stringLength: {
                            min: 1,
                            max: 100,
                            message: 'Note must be more than 1 and less than 100 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                }, 
            }
        })
  });
$(function() {
  $('#date_submitted').datepicker();
});
$(function() {
  $('#date_note_picker').datepicker();
});
</script>
<!-- end: Javascript -->
</body>
</html>