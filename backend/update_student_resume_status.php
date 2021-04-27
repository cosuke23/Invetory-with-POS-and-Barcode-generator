<?php
$page_title = 'OJT AssiSTI';
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
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
if(isset($_GET['stud_no']))
{
$stud_no_2 = $_GET['stud_no'];

  
  $query_update_resume_status ="SELECT a.stud_no,a.lname,a.fname,a.mname, a.program_id,b.program_code, c.resume_status, c.resume_remarks FROM student_info AS a INNER JOIN program_list AS b INNER JOIN student_resume_data AS c WHERE a.program_id = b.program_id AND a.stud_no='$stud_no_2' AND c.stud_no = a.stud_no";
  $result_update_resume_status =  mysqli_query($dbc, $query_update_resume_status);
		if($result_update_resume_status->num_rows > 0 )
            {
			while ($row = mysqli_fetch_array($result_update_resume_status))
				{
                        $stud_no = $row[0];
                        $lname = $row[1];
                        $fname = $row[2];
                        $mname = $row[3];
                        $a_program_id= $row[4];
                        $program_code = $row[5];
            						$resume_status = $row[6];
            						$resume_remarks = $row[7];
					
						$file_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
				}
			}
}


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
  <link rel="stylesheet"  type="text/css" href="asset/css/animate.notify.css" />


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
	<style>  
	  .show{display:block;}
	  .hide{display:none;}
	 </style>
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
                        <label>
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
                        <h1 class="animated fadeInLeft">STUDENT RESUME DATA</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section will show the resume data and approve/reject resume of the selected student.
                        </p>
                    </div>
                  </div>
              </div>
               <div class="panel box-shadow-none content-header">
                  <!--<div class="panel-body">

                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">STUDENT RESUME STATUS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section will show the student records.
                        </p>
                    </div>
                  </div>-->
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
					<div class="row">
						<div class="col-md-5">
						<h3>UPDATE STUDENT RESUME STATUS </h3>
						</div>
						<br>
						<div class="col-md-4">
						</div>
						<div class="col-md-1">
							<?php
							if($resume_status == 0){
                $disabled  = "disabled";
              }else{
                 $disabled  = "";
                echo '<a href="../files/resume/'.$stud_no.'.docx" download="'.$lname.'_'.$fname.'_'.$mname.'_'.$program_code.'">';
              }
							?>
                <button type="submit" class="btn btn-primary" <?php echo $disabled; ?>>
                  <span class="glyphicon glyphicon-download-alt"></span> &nbsp;DOWNLOAD RESUME&nbsp;</button>
                </a>
						</div>		
					</div>				
					</div>
          <div class="row">
            <div class="col-md-12">
              <iframe src="http://docs.google.com/viewer?url=http://my.sticaloocan.edu.ph/ojtassisti/files/resume/<?php echo $stud_no; ?>.docx&embedded=true" 
              style="width:100%;  height:800px;" frameborder="0"></iframe>
            </div>
          </div>
            <form id="defaultForm" method="POST" action="update_student_resume_status_process.php">
					    <input type="hidden" name ="semester_rd" value="<?php echo $semester_rd; ?>" />
					   <div class="panel-body" style="padding-bottom:30px;">
                  <div class="row">
						        <div class="col-md-3">
                             <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                               <div class="form-group has-feedback">
							                    <input type="hidden" name="stud_no" id="stud_no" value="<?php echo $stud_no; ?>"/>
                                   <input type="hidden" name="lname" id="stud_no" value="<?php echo $lname; ?>"/>
                                   <input type="hidden" name="fname" id="stud_no" value="<?php echo $fname; ?>"/>
                                  <input type="hidden" name="mname" id="stud_no" value="<?php echo $mname; ?>"/>
                                <h4 style="margin-left:5px" name="stud_no" id="stud_no"/><?php echo $stud_no; ?></h4>
                               </div>
                          </div>
                         <div class="col-md-4">
                             <h5 style="padding-left:5px;">NAME</h5>
                              <div class="form-group has-feedback">
                                <h4 style="margin-left:5px" name="name" id="name"><?php echo $lname.", ".$fname." ".$mname; ?></h4>
                              </div>
                          </div>
                          
						     <div class="col-md-4">
                            <h5 style="padding-left:5px;">PROGRAM</h5>
                            <div class="form-group has-feedback">
                               <h4 style="margin-left:5px"><?php echo $program_code; ?></h4>
                              </div>
                            </div>
						<div class="col-md-3">
              <h5 style="padding-left:5px;">RESUME STATUS</h5>
              <div class="form-group has-feedback">
								<?php
								
									$hide="hide";
									$comstart0="";
									$comstart1="";
									$comstart2="";
									$comstart3="";
									$comend="-->";
									$showRemarks="none";
									
								if($resume_status == 0){
										$resume_status2="No resume";
										$comstart2="<!--";
										$comstart3="<!--";
									}									
									if($resume_status == 1){
										$resume_status2="Pending";
										$comstart1="<!--";
									}
									if($resume_status == 2){
										$resume_status2="Approved";
										$comstart2="<!--";
									}
									if($resume_status == 3){
										$resume_status2="Rejected";
										$comstart3="<!--";
										$hide="show";
										
									}
									?>
                  <select  onChange="showRemarks()" class="form control" name="resume_status" id="resume_status" placeholder="No resume">                  
									<option value="<?php 
												
												if($resume_status2 == "No resume"){
													$resume_status=0;
													echo $resume_status;
												}
                        else if($resume_status2 == "Pending"){
													$resume_status=1;
													echo $resume_status;
												}
												else if($resume_status2 == "Approved"){
													$resume_status=2; 
													echo $resume_status;
												}
												else if($resume_status2 == "Rejected"){
													$resume_status=3;
													echo $resume_status;
												}
									?>">
												<?php 
												if($resume_status == 0){
													$resume_status2="No resume";
													echo $resume_status2;
												}	
												if($resume_status == 1){
													$resume_status2="Pending";
													echo $resume_status2;
												}
												if($resume_status == 2){
													$resume_status2="Approved";
													echo $resume_status2;
												}
												if($resume_status == 3){
													$resume_status2="Rejected";
													echo $resume_status2;
												}
									?></option>
									<?php echo $comstart2 ?><option value="2" >Approved</option><?php echo $comend ?>
									<?php echo $comstart3 ?><option value="3" >Rejected</option><?php echo $comend ?>
                                    </select>
                                </div>
                            </div>
							
						          	<div class="row <?php echo $hide; ?>" id="resumeRejected" >
                            <div class="col-md-6"  >
                             <h5 style="padding-left:5px;">REMARKS</h5>
                              <div class="form-group has-feedback">
                                  <textarea rows ="3" name="resume_remarks" id="resume_remarks" class="form-control" placeholder="Type remarks here"><?php echo $resume_remarks; ?></textarea>
                              </div>
                								<script>
                									var selector = document.getElementById("resume_status");
                									var remarks = document.getElementById("resumeRejected");
                									function showRemarks(){
                											var x = selector.options[selector.selectedIndex].text;
                											if( x == "Approved"){
                												remarks.setAttribute("class","row hide");
                											}
                											if(x == "Pending"){
                												remarks.setAttribute("class","row hide");
                											}
                											if( x == "Rejected"){
                												remarks.setAttribute("class","row show");
                											}
                									}
                									
                								</script>
                            </div>
                          </div>
                     </div>
                       <div class="row">
            					  <div class="col-md-4"></div>
            					  <div class="col-md-4">
                            
							   <button id="btn_update_resume_status" name="btn_update_resume_status" type="submit" class="btn btn-info btn-block" <?php echo $disabled;?>>
							   <span class="glyphicon glyphicon-floppy-saved"> &nbsp;SAVE</span></button>
                       </div>
                      <div class="col-md-4">
                               <a href="student_resume_data.php?stud_no=<?php echo $stud_no_2; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                       </div>
                      </div>
                      </div><!--ENd of panel body-->
					  </form>
                      </div>
                     </div>
                </div>
            </div> <!-- end: content -->
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
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>

<script type="text/javascript">
$(document).ready(function(){

  $('#btn_update_resume_status').click( function() {
    $.post( 'update_student_resume_status_process.php');
});
 

  $('#datatables').DataTable();
   

   $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        fields: {
	
		
		resume_remarks: {
				validators: {
					 notEmpty: {
						message:'Please indicate the revisions needed..'
					 },
					stringLength: {
                            min: 4,
                            max: 255
                    }
				}
		}
            }
          
        });
   
     
  });
</script>
<!-- end: Javascript -->
</body>
</html>