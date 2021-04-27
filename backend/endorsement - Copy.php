<?php
session_start();
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
//generate comp user name and password
$rnd_ai = (mt_rand(1000,10000));
$year = date('Y');
$cmp_user = 'CMP'.$year.$rnd_ai ;

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
                
                  
                  <li class="user-name"><span>&nbsp; Hi' <?php echo  $title2." ".$fname2; ?>&nbsp;</span></li>
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
                        <label class="active">
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
                         <a href="student_resume_data.php"><i class="fa fa-file-word-o"></i>Student Resume</a>
                        </label><br>
                         <label>
                          <a href="student_master_list.php"><i class="glyphicon glyphicon-tasks"></i>Student OJT Records</a>
                          </label><br>
                           <label>
                          <a href="student_ojt_master_list.php"><i class="fa fa-server"></i>OJT Students' Progress</a>
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
                        <h1 class="animated fadeInLeft">APPROVED FOR COMPANY ENDORSEMENT</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          &nbsp;
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>ADD NEW ENDORSEMENT</h3></div>
					<div class="panel-body" style="padding-bottom:30px;">

				<!----------------------------------------------FORM 1--------------------------------------------------->
				
					<form id="form1" method="POST">
					<?php if(isset($_GET['success'])) 
                        {   

                        print '<div class="row">
                       <div class="col-md-12">
					   <div class="col-md-2">
							  </div>
                        <div class="col-md-6" id="success">
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                                 <span class="fa fa check-square-o"></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong>&nbsp;Sucessfully Added!</strong>
                              </div>
                          </div>
                        </div>
                      </div>';

                        } ?>
					<div class="row">
					 <div class="col-md-2"></div>
					 <div class="col-md-4">
                        <h5 style="padding-left:5px;">Student Number:</h5>
						 <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="stud_no" name="stud_no" value="<?php if(isset($_POST['stud_no'])){$stud2 = $_POST['stud_no']; echo $stud2;}?>" maxlength="11"/>
						<input type="hidden" name="btn" style="height:30px;width:30px;"/>
						</div>
					</div>
                    <div class="col-md-5">
                        <div class="panel-body">
							<div class="row">
                                <div class="col-md-12">
                                    <h4> <span class="glyphicon glyphicon-exclamation-sign text-warning ">&nbsp;NOTE:</span>
                                          &nbsp;Enter to search the<strong><mark class="text-primary"> STUDENT NUMBER</mark></strong>.</h4>
                                </div>
                            </div>
                        </div>  
					</div>
				<div class="col-md-1"></div>
						<?php
						$lname ="";
						$fname ="";
						$mname ="";
						$program ="";
						$program_id ="";
							if(isset($_POST['btn']))
							{
								$stud_no = mysqli_real_escape_string($dbc,trim($_POST['stud_no']));
								
								$query = "SELECT a.stud_no, a.lname, a.fname, a.mname, a.program_id, b.program_code, c.ojt_hours FROM student_info AS a INNER JOIN program_list AS b INNER JOIN program_category_list AS c WHERE a.stud_no='$stud_no' AND a.program_id=b.program_id AND a.program_id=c.program_id";
								$result = mysqli_query($dbc, $query);
								if(mysqli_num_rows($result)>0)
								{
									$r = mysqli_fetch_assoc($result);
									$stud = $r['stud_no'];
									$lname = $r['lname'];
									$fname = $r['fname'];
									$mname = $r['mname'];
									$program_id = $r['program_id'];
									$program = $r['program_code'];
									$ojt_hours = $r['ojt_hours'];
								}
								
							}
						?>
                       
						</div>
						</form>
						
						<!----------------------------------------------FORM 2--------------------------------------------------->
				
                      <form id="form2" method="POST" action="endorsement2.php" enctype="multipart/form-data">
						<!------------------------------------------------STUDENT INFORMATION------------------------------------------------------>
                       <div class="row">
					   <hr>
                          <div class="col-md-2"></div>
						  <div class="col-md-4">
                            <h5 style="padding-left:5px;">Student Name: &nbsp; </h5>
                               <div class="form-group has-feedback">
							   <input type="hidden" name="stud_no_p" value="<?php echo $stud;?>"/>
                               <input type="text" id="full_name" name="full_name" class="form-control" value="<?php 
							   if($lname!=""&&$fname!=""&&$mname!="")
							    {
									echo $fname.' '.$mname.' '.$lname;
								}else{}
								?>"/> 
                               </div>
                          </div>
						  <div class="col-md-4">
							<h5 style="padding-left:5px;">Program / Course: &nbsp; </h5>
                               <div class="form-group has-feedback">
								<input type="text" id="program" name="program" class="form-control" value="<?php 
							   if($program!="")
							    {
									echo $program;
								}else{}
								?>"/>
								<input type="hidden" name="program_id" value="<?php echo $program_id;?>"/>
							   </div>
						  </div>
						  </div>
						  <div class="row">
						  <div class="col-md-2"></div>
                            <div class="col-md-4">
                            <h5 style="padding-left:5px;">OJT Adviser:</h5>
                            <div class="form-group has-feedback">
                                <?php
                                $query_program_list = "SELECT adviser_id, lname, fname, mname, title FROM adviser_info WHERE status = 'Active' AND program_id='$program_id'";
                       
                                $result_program_list = mysqli_query($dbc, $query_program_list);
                                $num_rows2 = mysqli_num_rows($result_program_list);
                                
                                print'<select class="form-control" id="adviser_id" name="adviser_id" class="form-control"> ';
                                
                                 echo "<option value=''></option>";
                                 while($row_pl = mysqli_fetch_array($result_program_list)){
                                    $adviser_id = $row_pl[0];
                                    $lname = $row_pl[1];
                                    $fname = $row_pl[2];
									$mname = $row_pl[3];
									$title = $row_pl[4];
                                    echo "<option value='".$adviser_id."'>".$title." ".$fname." ".$mname." ".$lname."</option>";
                                }
                                print '</select>';

                                ?>
                              </div>
                           </div>
						   <div class="col-md-4">
                            <h5 style="padding-left:5px;">Number of Training Hours:</h5>
								<div class="form-group has-feedback">
									<input type="number" class="form-control" value="<?php echo $ojt_hours;?>" id="thours" name="thours"/>
								</div>
							</div>
							<div class="col-md-2"></div>
							</div>
							<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-4">
                                  <h5 style="padding-left:5px;">Date:</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="date_created">
                                          <input type="text" class="form-control" name="date_created" value="<?php $date_now = date("m/d/Y"); echo $date_now;?>" placeholder="(e.g. MM/DD/YYYY)"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                             <div class="col-md-4">
                                <h5 style="padding-left:5px;">Submission Date:</h5>
                                <div class="form-group">
                                <div class="dateContainer">
                                    <div class="input-group input-append date" id="sub_date">
                                        <input type="text" class="form-control" name="sub_date" placeholder="(e.g. MM/DD/YYYY)"/>
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            </div>
							<div class="col-md-2"></div>
							</div>
							<br>
                          <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-4"><button type="submit" class="btn btn-success btn-block" name="btn-ok" id="btn-ok">NEXT&nbsp;<span class="glyphicon glyphicon-arrow-right"></span></button></div>
                            <div class="col-md-2"></div>
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
                      <a href="student_resume_data.php"><i class="fa fa-file-word-o"></i>&nbsp;Student Resume</a>
                    </li>
                     <li class="ripple">  
                    <a href="student_master_list.php"><i class="glyphicon glyphicon-tasks"></i>&nbsp; Student OJT Records</a>
                    </li>
                    <li class="ripple">  
                     <a href="student_ojt_master_list.php"><i class="fa fa-server"></i>OJT Students' Progress</a>
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
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#date_created')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#form2').bootstrapValidator('revalidateField', 'date_created');
        });

    $('#sub_date')
        .datepicker({
            format: 'mm/dd/yyyy'
        })
        .on('changeDate', function(e) {
            $('#form2').bootstrapValidator('revalidateField', 'sub_date');
        });
		$('#form1')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                stud_no: 
				{
					validators: 
					{
                        notEmpty: {},
						regexp: {
                            regexp: /^[0-9]+$/,
                        },
						stringLength: {
                            min: 11,
							max: 11,
							message: 'Invalid Student Number'
                        },
					}
				}
				}
				});
        $('#form2')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                
                full_name: {
                    validators: {
					notEmpty: {},
                        stringLength: {
                            min: 2,
                            max: 255,
                        },
                         regexp: {
                            regexp: /^[a-zA-Z-. ,/?]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
				program: {
                    validators: {
						notEmpty: {},
                         regexp: {
                            regexp: /^[a-zA-Z-.,/?]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
				adviser_id: {
                    validators: {
						notEmpty: {},
                    }
                },
				thours: {
                    validators: {
						notEmpty: {},
                    }
                },
              address: {
                    validators: {
                       notEmpty: {
                            message: 'Company address is required and can\'t be empty'
                        },
                    stringLength: {
                            min: 5,
                            max: 255,
                            message: 'Address must be more than 5 and less than 255 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,`/? 0-9]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                city: {
                    validators: {
                        notEmpty: {
                            message: 'City is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 4,
                            max: 50,
                            message: 'City must be more than 4 and less than 50 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
            status: {
                    validators: {
                        notEmpty: {
                            message: 'Status is required and can\'t be empty'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
             remarks: {
                    validators: {
                        notEmpty: {
                            message: 'Remarks is required and can\'t be empty'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        },
                         stringLength: {
                            min: 5,
                            max: 50,
                            message: 'Remarks must be more than 5 and less than 50 characters long'
                        },
                    }
                },
            position: {
                    validators: {
                        
                   regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/`? 0-9]+$/,
                            message: 'Position can only consist of letters,'
                        },
                    stringLength: {
                            min: 5,
                            max: 50,
                            message: 'Position must be more than 5 and less than 50 characters long'
                        },
                    }
                },
            contact_person: {
                    validators: {
               regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Contact Person may only consist of letters'
                        },
               stringLength: {
                            min: 5,
                            max: 50,
                            message: 'Contact Person must be more than 5 and less than 50 characters long'
                        },
                    },
                },
            tel_no: {
                    validators: {
                        
            regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Telephone number may only consist of numbers'
                        },
            stringLength: {
                            min: 7,
                            max: 11,
                            message: 'Contact number must be 7-11 numbers'
                        },
                    }
                },
            fax_no: {
              validators: {
                   regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Fax number may only consist of numbers'
                        },
               stringLength: {
                            min: 7,
                            max: 12,
                            message: 'Fax number must be altleast 7 - 12 numbers'
                        },
                    }
                },
              email: {
                    validators: {

                         regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        }
                    },
                }, 
                date_created: {
                    validators: {
                        notEmpty: {},
                        date: {
                            max: 'sub_date',
                            message: 'Date notary is invalid'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date notary(e.g. MM/DD/YYYY)'
                        },
                         regexp: {
                            regexp: /^[0-9/]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                sub_date: {
                    validators: {
                        notEmpty: {},
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date expiry(e.g. MM/DD/YYYY)'
                        },
                        date: {
                            min: 'date_created',
                            message: 'Invalid date expiry'
                        },
                         regexp: {
                            regexp: /^[0-9/]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                program_id: {
                    message: 'Program is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Program is required and can\'t be empty'
                        },
                    }
                },
                image: {
                  validators: {
                      file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 51200,   // 50kb
                        message: 'The selected file is invalid,it should be (jpeg,jpg,png) and 50KB at maximum size'
                      }
                    }
                }
            }
        })
        .on('success.field.fv', function(e, data) {
            if (data.field === 'date_notary' && !data.fv.isValidField('date_expiry')) {
                // We need to revalidate the end date
                data.fv.revalidateField('date_expiry');
            }

            if (data.field === 'date_expiry' && !data.fv.isValidField('date_notary')) {
                // We need to revalidate the start date
                data.fv.revalidateField('date_notary');
            }
        });
  });

</script>
<!-- end: Javascript -->

</body>
</html>