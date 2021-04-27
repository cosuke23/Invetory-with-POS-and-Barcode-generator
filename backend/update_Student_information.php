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
                         &nbsp;
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE STUDENT INFORMATION</h3>
					<ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                        <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-user"></span> STUDENT INFO</a>
                      </li>
					    <li role="presentation">
                        <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-sticky-note"></span> INCIDENT REPORT</a>
                      </li>
                     </ul>
					
					
					</div>
		<div id="tabsDemo5Content" class="tab-content tab-content-v3">
			<div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
                    <div class="row">
                      <div class="col-md-12">
                         <?php
                          if(isset($_GET['success']) && isset($_GET['stud_no']) && isset($_GET['fname'])
                            && isset($_GET['mname']) && isset($_GET['lname']) && isset($_GET['program_code']))
                          {
                            $stud_no = $_GET['stud_no'];
                            $fname = $_GET['fname'];
                            $mname = $_GET['mname'];
                            $lname = $_GET['lname'];
                            $program_code = $_GET['program_code'];
                              print '<div class="col-md-12">
                              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                     <span class="fa fa-remove"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp; '.$lname. ", ".$fname. " ".$mname.' with student number of '.$stud_no.' was successfully added in the student official list!</strong>
                               </div></div>';
                          }
                          ?>
                        </div>
                    </div>
                    <form id="defaultForm" method="post" action="update_Student_information_process.php" enctype="multipart/form-data">
                      <div class="panel-body" style="padding-bottom:30px;">
                         <div class="row">
                           <div class="col-md-3"> 
                           <?php 
                             echo '<img src="../files/student_pics/' . $stud_no. '.jpg" style="height:200px;width:200px;">';
                             ?>
                           </div>
                          <div class="col-md-6">
                            <h5>STUDENT PICTURE &nbsp; <i class="fa fa-camera"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="image" placeholder="Upload Image" alt="student image"/> 
                               </div>
                          </div>
                        </div>
                        <div class="row">
                         <input name="stud_no" type="hidden" value ="<?php echo $stud_no; ?>"/>
                          <div class="col-md-3">
                             <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                               <div class="form-group has-feedback">
                                <input type="text" name="stud_no" id="stud_no" class="form-control" value ="<?php echo $stud_no; ?>" maxlength="11" disabled/>
                               </div>
                          </div>
                         <div class="col-md-3">
                             <h5 style="padding-left:5px;">LASTNAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="lname" id="lname" class="form-control" value ="<?php echo $lname; ?>" maxlength="32"/>
                              </div>
                          </div>
                          <div class="col-md-3">
                             <h5 style="padding-left:5px;">FIRSTNAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="fname" id="fname" class="form-control" value ="<?php echo $fname; ?>" maxlength="32"/>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">MIDDLENAME</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="mname" id="mname" class="form-control" value ="<?php echo $mname; ?>" maxlength="32"/>
                              </div>
                          </div>                  
                        </div>
                        
                        <div class="row">
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">GENDER</h5>
                              <div class="form-group has-feedback">
                                   <?php
								   $comstart1="";
								   $comstart2="";
								   $comend="-->";
								   if($gender=="Male")
								   {
									$comstart1="<!--";
								   }
								   else if($gender=="Female")
								   {
									$comstart2="<!--";
								   }
								   ?>
								   <select class="form-control" name="gender" id="gender" class="form-control" placeholder="Gender">
                                    <option><?php echo $gender; ?></option>
                                    <?php echo $comstart1;?><option value="Male">Male</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Female">Female</option><?php echo $comend;?>
                                    </select>
                              </div>
                          </div>
                           <div class="col-md-3">
                                <h5 style="padding-left:5px;">BIRTHDAY</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="bday">
                                          <input type="text" class="form-control" name="bday" value="<?php echo $bday; ?>" maxlength="10"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                           </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">PROGRAM</h5>
                            <div class="form-group has-feedback">
                                <?php
                                $query_program_list = "SELECT * FROM program_list WHERE status = 'Active' ORDER BY program_id";
                       
                                $result_program_list = mysqli_query($dbc, $query_program_list);
                                $num_rows2 = mysqli_num_rows($result_program_list);
                                
                                print'<select class="form-control"  name="program_id" class="form-control"> ';
                                
                                 echo "<option value='".$a_program_id."'>".$program_code."</option>";
                                 while($row_pl = mysqli_fetch_array($result_program_list)){
                                    $program_id2 = $row_pl[0];
                                    $program_code2 = $row_pl[1];
                                    $program_name2 = $row_pl[2]; 
                                    $counter = 0;
									
									$comstart3="";
									if($program_code==$program_code2)
									{
										$comstart3="<!--";
									}
                                if($counter <= $program_id)
                                  {
                                      echo $comstart3."<option value='".$program_id2."'>".$program_code2."</option>".$comend;
                                     $counter++;
                                  }   
                                }
                                ?>
                                <?php
                                print '</select>';
                                ?>
                              </div>
                            </div>
                            <div class="col-md-3"></div>
                          </div>
                           <div class="row">
                            <h2 style="margin-left:13px;">Contact Information</h2>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                                 <h5 style="padding-left:5px;">ADDRESS</h5>
                                <div class="form-group has-feedback">
                                  <textarea rows="2" name="address" id="address" class="form-control" ><?php echo $address ; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                               <h5 style="padding-left:5px;">EMAIL</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="email" id="email" class="form-control" value ="<?php echo $email; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                              <h5 style="padding-left:5px;">FACEBOOK</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="facebook" id="facebook" class="form-control"  value ="<?php echo $facebook; ?>" placeholder="(Optional)"/>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                                <h5 style="padding-left:5px;">TELEPHONE NUMBER</h5>
                                <div class="form-group has-feedback">
                                    <input type="text" name="tel_no" id="tel_no"  placeholder="(Optional)" class="form-control"value ="<?php echo $tel_no; ?>" maxlength="7"/>
                                </div>
                            </div>
                             <div class="col-md-4">
                                  <h5 style="padding-left:5px;">MOBILE NUMBER</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Contact Person" value ="<?php echo $mobile_no ; ?>" maxlength="11"/>
                                  </div>
                            </div>
                             <div class="col-md-4">
                            </div>
                          </div>
                         <div class="row">
                            <div class="col-md-4"></div>
                             
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-info btn-block"  name="btn_update_stud_info" id="btn_update_stud_info">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                 </button>
                             </div>
                              <div class="col-md-4">
                               <a href="Student_information.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                       </div>
                          </div>
                      </div><!--ENd of panel body-->
                      </form>
                      </div>
					  
					 	  <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">
						  <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">      
                            <div class="col-md-12">
                              <h4 style="color:white;"><b>STUDENT NAME:  <?php echo $lname .", " .$fname. " ".$mname ; ?></b></h4>
                            </div>
                          </div>
                        </div>
						
						<div class="row">
                            <div class="col-md-8">
                              <h2 style="padding-left:5px;">INCIDENT REPORT</h2>
                            </div>
							   <div class="col-md-4">
							   <br>
                               <button id="btnToggleForm" name="btnToggleForm" class="btn btn-success btn-outline btn-block btn-sm">
											<span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                      </button>
                            </div>
                          </div>
						  
					<div class="row">
					<div class="reportForm" style="display:none;">
						<form id="defaultForm3" method="post" action="add_stud_incident_report_process.php"  enctype="multipart/form-data">     
						<input type="hidden" name="stud_no" value="<?php echo $stud_no; ?>">
						<div class="col-md-12">
						
							<div class="row">
												<div class="col-md-5">
                            <h5> &nbsp; UPLOAD DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="student_report" placeholder="Upload Incident Report" alt="Incident Report"/>
                               </div>
                          </div>
						  
						  
							<div class="col-md-3">
							</div>
							
							
												<div class="col-md-4">
													  <h5 style="padding-left:5px;">DATE</h5>
													  <div class="form-group">
													  <div class="dateContainer">
														  <div class="input-group input-append date" id="date_today">
															  <input type="text" class="form-control" name="date_today" value="<?php
                                 echo  date("m/d/Y"); 
                               ?>" maxlength="10"/>
															  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
														  </div>
													  </div>
												  </div>
												</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
													  <h5 style="padding-left:5px;">CASE</h5>
													     <div class="form-group has-feedback">
													<textarea type="text" name="remarksreport" id="remarksreport" class="form-control" placeholder="Description of Incident Report" rows="3"></textarea>
													</div>
													  </div>
								</div>
								
								
								<div class="row">
								<div class="col-md-4">
								</div>
									<div class="col-md-4">
								</div>
								<div class="col-md-4">
							   
									<button type="submit" id="btnAddIncidentReport" name="btnAddIncidentReport" class="btn btn-success btn-block">
											<span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                      </button>
                            </div>
							
								</div>
							
							</div>
						</form>			

								<div class="row">	<div class="col-md-12"><div class="col-md-4">
								</div>	<div class="col-md-4">
								</div>
								<div class="col-md-4">
							   <br>
                               <button id="btnToggleCloseForm" name="btnToggleCloseForm" class="btn btn-default btn-block">
											<span class="fa fa-times"></span> &nbsp; CANCEL &nbsp;
                                      </button>
                            </div>
								</div>
					</div>
					
					
					
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables2"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>                                                  
                          <th class="text-center" width="25px">ID</th>
                          <th class="text-center">CASE DESCRIPTION</th>                          
                          <th class="text-center" width="150px">DATE</th>
                          <th class="text-center" width="50px">FILE</th>              
						  <th class="text-center" width="50px">ACTION</th>    						  
                          </tr>
                          </thead>
                          <tbody>
						  <?php
							$result = mysqli_query($dbc,"SELECT id,remarks,DATE_FORMAT(date, '%M %e,%Y') as date,filename FROM student_report WHERE stud_no = '$stud_no'");
								
							
							
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td><center>" . $row['id'] . "</center></td>";
  echo "<td>" ;

$string = strip_tags($row['remarks']);

if (strlen($string) > 500) {

    // truncate string
    $stringCut = substr($string, 0, 500);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a role="button" data-toggle="modal" data-target="#viewMoreModal" data-id="'.$row['remarks'] .'">Read More</button>'; 
}
echo $string;





   
  echo "</td>";
  echo "<td><center>" . $row['date'] . "</center></td>";
  echo "<td>";
  
    $btn_download = '<a role="button" href="../files/student_report/'.$row['filename'] .'" download="'.$row['id'] .'.pdf" target="_blank" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Download Incident Report"><span class="fa fa-download">
                  </span> &nbsp;  Download File</a>';
  
	if($row['filename'] == "")
	{
			echo "<center>No File</center>";
	}
	else
	{
			echo $btn_download;
	}
  
  echo "</td>";
  
    echo "<td><center><button type='button' class='btn btn-outline btn-primary' data-toggle='modal' data-target='#editIncidentReport' data-id='".$row['id'] ."' data-remarks='".$row['remarks']."'><span class='glyphicon glyphicon-pencil'></span>&nbsp;  Edit</button></center></td>";
	echo "</tr>";
}

?>

<div id="editIncidentReport" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Updating Incident Report</h4>
      </div>


	 <div class="modal-body">
	 <form id="defaultForm4" method="post" action="update_stud_incident_report_process.php"  enctype="multipart/form-data"> 
						<input type="hidden" name="stud_no" value="<?php echo $stud_no; ?>">
						<input type="hidden" id="incident_id" name="incident_id">
						
							<div class="row">
												<div class="col-md-5">
                            <h5> &nbsp; UPLOAD DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="student_report" placeholder="Upload Incident Report" alt="Incident Report" accept="application/pdf"/>
                               </div>
                          </div>
						  
						  
							<div class="col-md-3">
							</div>
							
							
												<div class="col-md-4">
													  <h5 style="padding-left:5px;">DATE</h5>
													  <div class="form-group">
													  <div class="dateContainer">
														  <div class="input-group input-append date" id="date_today2">
															  <input type="text" class="form-control" name="date_today2" value="<?php
                                 echo  date("m/d/Y"); 
                               ?>" maxlength="10" readonly/>
															  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
														  </div>
													  </div>
												  </div>
												</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
													  <h5 style="padding-left:5px;">CASE</h5>
													     <div class="form-group has-feedback">
													<textarea type="text" name="remarksreport" id="remarksreport" class="form-control" placeholder="Description of Incident Report" rows="6"></textarea>
													</div>
													  </div>
								</div>
		
				
						
		
		
		
		  </div>
      
      <div class="modal-footer">
					<button type="submit" name="btnupdateincidentreport" id ="btnupdateincidentreport" class="btn btn-block btn-success">Save</button>
					</form>	
					<button type="button" class="btn btn-block btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>


<div id="viewMoreModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Incident Report</h4>
      </div>


	<div class="modal-body">
		<textarea type="text" name="readmore" id="readmore" class="form-control" placeholder="Description of Incident Report" rows="15" readonly></textarea>									
	</div>
      
      <div class="modal-footer">
					<button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


						
						
							</tbody>
							</table>
						</div>
						</div>
						
						</div>
					</div>
					</div>
						
						
						
						
						
						</div>
						
                      
						</div>
					  </div>
					  </div>
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
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $("#btnToggleForm").click(function(){
		$(".reportForm").toggle();
		$("#btnToggleForm").toggle();
  });
  
  $("#btnToggleCloseForm").click(function(){
		$(".reportForm").toggle();
		$("#btnToggleForm").toggle();
  });
  
  
$('#editIncidentReport').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) ;
  var id = button.data('id') ;
  var remarks = button.data('remarks') ;
  var modal = $(this);
 // modal.find('.modal-title').text('Lead Number ' + id);
  modal.find('#incident_id').val(id);
  modal.find('#remarksreport').val(remarks);
 //$(".modal-body #incident_ir").val(id);
 // modal.find('.modal-body input').val(recipient)
})
$('#viewMoreModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) ;
  var id = button.data('id') ;
  var modal = $(this);
 // modal.find('.modal-title').text('Lead Number ' + id);
  modal.find('#readmore').val(id);
 //$(".modal-body #incident_ir").val(id);
 // modal.find('.modal-body input').val(recipient)
})
  
$(document).ready(function(){
 var table = $('#datatables2').DataTable();
  $('#btn_update_stud_info').click( function() {
    $.post( 'update_Student_information_process.php');
	
	
});

		$('#date_today')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm3').bootstrapValidator('revalidateField', 'date_today');
        });
		
  $("#added").on("click", function() {
              $.notify({
          // options
          icon: 'glyphicon glyphicon-warning-sign',
          title: 'Bootstrap notify',
          message: 'Turning standard Bootstrap alerts into "notify" like notifications',
          target: '_blank'
        },{
          // settings
          element: 'body',
          position: null,
          type: "info",
          allow_dismiss: true,
          newest_on_top: false,
          showProgressbar: false,
          placement: {
            from: "top",
            align: "right"
          },
          offset: 20,
          spacing: 10,
          z_index: 1031,
          delay: 5000,
          timer: 1000,
          url_target: '_blank',
          mouse_over: null,
          animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
          },
          onShow: null,
          onShown: null,
          onClose: null,
          onClosed: null,
          icon_type: 'class',
          template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
              '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
          '</div>' 
        });
    });
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
                            message: 'Student number can only consist of numberic characters'
                        },
            stringLength: {
                  min: 11,
                  max:11,
                            message: 'Student number must be 11 numbers'
                        }
                    }
                },
               lname: {
                    message: 'Lastname name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Lastname is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Lastname must be more than 1 and less than 32 letters'
                        },
                 regexp: {
                            regexp: /^[a-zA-Z\ ]+$/,
                            message: 'Lastname can only consist of letters'
                        }
                    }
                },
        fname: {
                    message: 'Firstname name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Firstname is required and can\'t be empty'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Firstname must be more than 1 and less than 32 letters'
                        },
            regexp: {
                            regexp: /^[a-zA-Z\ ]+$/,
                            message: 'Firstname can only consist of letters'
                        }
                    }
                },
            mname: {
                    message: 'Middlename name is not valid.',
                    validators: {
                        notEmpty: {
                            message: 'Middlename is required and can\'t be empty. If the student does not have middlename please input. "."(period)'
                        },
            stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Middlename must be more than 1 and less than 32 letters'
                        },
                regexp: {
                            regexp: /^[a-zA-Z\ .]+$/,
                            message: 'Middlename can only consist of letters'
                        },
                    }
                },
                gender: {
                    validators: {
                        notEmpty: {
                            message: 'Gender is required and can\'t be empty'
                        }
                    }
                },
                bday: {
                    validators: {
                        notEmpty: {
                            message: 'Birthday is required and can\'t be empty'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of birthday(e.g. MM/DD/YYYY)'
                        },
                    }     
                },
        program_id: {
                    validators: {
                        notEmpty: {
                            message: 'Program is required and can\'t be empty'
                        },
                    }
                },
        semester: {
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        },
                    }
                },
        email: {
                    validators: {
                        notEmpty: {
                            message: 'Email is required and can\'t be empty'
                        },
            emailAddress: {
                            message: 'Invalid email address'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        },
                        stringLength: {
                            min: 10,
                            max: 64,
                            message: 'Email must be more than 10 and less than 64 characters long'
                        },
                    }
                },
        address: {
                    validators: {
                        notEmpty: {
                            message: 'Address is required and can\'t be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    }
                },
        mobile_no: {
                    validators: {
                        notEmpty: {
                            message: 'Mobile number is required and can\'t be empty'
                        },
            regexp: {
                            regexp: /[0-9]+$/,
                            message: 'Mobile number can only consist of numbers'
                        },
            stringLength: {
                            min: 11,
                            max: 11,
                            message: 'Mobile number must be 11 numbers'
                        }
                    }
                },
        tel_no: {
                    validators: {
            regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Telephone number can only consist of numbers'
                        },
            stringLength: {
                            min: 7,
                            max: 7,
                            message: 'Telephone number must be 7 numbers'
                        },
                    }
                },
            facebook: {
                    validators: {
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    },
                },
                image: {
                  validators: {
                      file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 102400,   // 100kb
                        message: 'The selected file is not valid,it should be (jpeg,jpg,png) and 100KB at maximum size'
                      }
                    }
                }
            }
          
        });
		 $('#defaultForm3')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                student_report: {
                    validators: {
                          file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: 5242880,   // 5mb
                            message: 'The selected file is not valid,it should be (pdf,docx,doc) and 5MB at maximum size'
                          }
                    }
                },
				date_today: {
                    validators: {
                        
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date of expiry(e.g. MM/DD/YYYY)'
                        },
                         regexp: {
                            regexp: /^[0-9/]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
				remarksreport: {
                    validators: {
                        notEmpty: {
                            message: 'Case Description is required and can\'t be empty'
                        },
                    }
                },
            }
        })
   
  });
</script>
<!-- end: Javascript -->
</body>
</html>