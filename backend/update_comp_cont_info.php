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
  if(isset($_GET['comp_id'])) {
  
  $comp_id=$_GET['comp_id'];
  $query_comp_info = "SELECT 		a.comp_id,a.comp_name,a.comp_desc,a.address,a.city,a.contact_person,position,a.tel_no,a.fax_no,a.email,a.status,a.remarks,DATE_FORMAT(a.date_notary, '%m/%d/%Y') AS date_notary,DATE_FORMAT(a.date_expiry, '%m/%d/%Y') AS date_expiry,b.comp_id,b.program_id,c.program_code,a.username FROM company_info AS a INNER JOIN company_program AS b INNER JOIN program_list AS c  WHERE a.comp_id = b.comp_id AND b.program_id = c.program_id AND a.comp_id = '$comp_id'";
                 
  $result2 =  mysqli_query($dbc, $query_comp_info);         
          if($result2->num_rows > 0 )
            {   
				$x = 0;
              while ($row = mysqli_fetch_array($result2))
              {
                $comp_id = $row[0];
                $comp_name = $row[1];
                $comp_desc = $row[2];
                $address = $row[3];
                $city = $row[4];
                $contact_person = $row[5];
                $position = $row[6];
                $tel_no = $row[7];
                $fax_no = $row[8];
                $email = $row[9];
                $status= $row[10];
                $remarks = $row[11];
                $date_notary = $row[12];
                $date_expiry = $row[13];
                $comp_id = $row[14];
                $program_id = $row[15];
                $program_code = $row[16];
				        $comp_username = $row[17];
              }
           }
}

if($status =="Active"){
  $q_updateStatus = "UPDATE company_info SET notify_status ='none' WHERE comp_id='$comp_id'";
 $result_comp_info_status = mysqli_query($dbc,$q_updateStatus);   
}else{
   $q_updateStatus = "UPDATE company_info SET notify_status ='read' WHERE comp_id='$comp_id'";
    $result_comp_info_status = mysqli_query($dbc,$q_updateStatus);   
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
    $q_notifystatus = "select * from company_info where date_expiry='$date_today' AND notify_status='unread'";
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
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />
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
		
		<!-- Added by Errik for Modal/Pop-up -->
	
	<!--<script src="asset/js/jquery.min.js"></script>
	<script src="asset/js/bootstrap.min.js" ></script>-->
		<!--
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
-->
<!--
<script type="text/javascript">
$(document).ready(function(){
	$('#btndelete').click(function(){
		$("#myModal").modal('show');	
	});
});
</script>
-->
<!--
<script>

$('#btndelete').click(function(){
    swal({
  title: "CHECK STUDENT NUMBER",
  text: "Type Student Number:",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  inputPlaceholder: "Type Student Number here..",
  showLoaderOnConfirm: true,
}
</script>
-->
<style type="text/css">
    .bs-example{
    	margin: 20px;
    }
</style>
		
		<!-- Added by Errik for Modal/Pop-up -->
		
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
                        <h1 class="animated fadeInLeft">PARTNER COMPANIES</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                         &nbsp;
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE PARTNER COMPANY</h3>
					<ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                        <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-building"></span> COMPANY INFO</a>
                      </li>
					    <li role="presentation">
                        <a href="#tab4" id="tabs4" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-users"></span> COMPANY OJT STUDENT</a>
                      </li>
                      <li role="presentation">
                        <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-file"></span> MOA</a>
                      </li>
					   <li role="presentation">
                        <a href="#tab3" id="tabs3" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-sticky-note"></span> INCIDENT REPORT</a>
                      </li>
					  
					
                    
                      </ul>
					</div>
					      <div id="tabsDemo5Content" class="tab-content tab-content-v3">
					<!--Added by Errik -->
					<?php 
          
                             $spc = "SELECT COUNT(*) AS count FROM company_ojt_student WHERE comp_id='$comp_id'";
							$rspc = mysqli_query($dbc, $spc);
							if($rspc==true)
							{
								$r = mysqli_fetch_assoc($rspc);
								$stud_count = $r['count'];
							}
							
							$sic = "SELECT a.lname, a.fname, a.mname, a.stud_no FROM student_info AS a INNER JOIN company_ojt_student AS b WHERE a.stud_no=b.stud_no AND b.comp_id = '$comp_id'";
							$rsic = mysqli_query($dbc, $sic);
							
							?>
							<div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
							<h5 style ="border-bottom: 6px solid red; background-color: lightgrey; text-align: center; color: black; font-size: 200%;"><?php echo $stud_count;?> Student(s) in this Company</h5>
							
							<!--Added by Errik -->
                    <br>
                    <?php
                         if(isset($_GET['resend'])) 
                            {   
                            print '<div class="col-md-12">
                              <div class="alert alert-success alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">??</span></button>
                                    <strong>&nbsp;The password has been reset to default and has been resent to the company`s email</strong>
                               </div></div>';
                            }
                  ?>
                         
                     <form id="defaultForm" method="post" action="update_comp_cont_info_process.php" enctype="multipart/form-data">
                       <div class="panel-body" style="padding-bottom:30px;">
                        <input name="comp_id" type="hidden" value ="<?php echo $comp_id ?>"/>
                       
                        <div class="row">
                           <div class="col-md-3"> 
                           <?php 
                             echo '<img src="../files/company/'.$comp_id.'.jpg" style="height:200px;width:200px;">';
                             ?>
                           </div>
							
                          <div class="col-md-6">
                            <h5 style="padding-left:5px;">COMPANY PICTURE &nbsp; <i class="fa fa-camera"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="image" id= "image" placeholder="Upload Image" alt="company image"/> 
                               </div>
							         <br>
									  <!--Added by errik -->
									 <input type="hidden" name="comp_username" id="comp_username" class="form-control" placeholder="Company User Name" value ="<?php echo $comp_username ; ?>"/>
							         <!--Added by errik -->
							         <h4>USERNAME: <?php echo $comp_username; ?></h4>
                       <a href="comp_reset_resend_password.php?username=<?php echo $comp_username; ?>&comp_id=<?php echo $comp_id; ?>"  class="btn btn-warning">Reset and Resend Default Password</a>
                          </div>
						 
                        </div>
                        <div class="row">
                          <div class="col-md-8">                          
                                <h5 style="padding-left:5px;">COMPANY NAME</h5>
                                <div class="form-group has-feedback"> 
                                  <input type="text" name="comp_name" id="comp_name" class="form-control" placeholder="Company Name" value ="<?php echo $comp_name ; ?>"/>
                                </div>
                           </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <h5 style="padding-left:5px;">COMPANY DESCRIPTION</h5>
                              <div class="form-group has-feedback">
                                  <textarea rows ="2" name="comp_desc" id="comp_desc" class="form-control" placeholder="(Optional)Company Description"><?php echo $comp_desc; ?> </textarea>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-8">
                                 <h5 style="padding-left:5px;">ADDRESS</h5>
                                <div class="form-group has-feedback">
                                  <textarea rows ="2" name="address" id="address" class="form-control" placeholder="Company Address" ><?php echo $address; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">CITY</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="city" id="city" class="form-control" placeholder="City" value ="<?php echo $city; ?>" maxlength="50"/>
                                </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-3">
                                <h5 style="padding-left:5px;">STATUS</h5>
                                <div class="form-group has-feedback">
								<?php
									$comstart1="";
									$comstart2="";
									$comend="-->";
									
									if($status=="Active")
									{
										$comstart1="<!--";
									}
									else if($status=="Not Active")
									{
										$comstart2="Not Active";
									}
								?>
                                   <select class="form-control" name="status" id="status" class="form-control" placeholder="Status">
                                    <option><?php echo $status; ?></option>
                                    <?php echo $comstart1;?><option value="Active">Active</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Not Active">Not Active</option><?php echo $comend;?>
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-3">
                                  <h5 style="padding-left:5px;">REMARKS</h5>
                                  <div class="form-group has-feedback">
								  <?php
									$comstart3="";
									$comstart4="";
									$comstart5="";
									$comstart6="";
									$comstart7="";
									$comstart8="";
									$comstart9="";
									
									if($remarks=="with MOA")
									{
										$comstart3="<!--";
									}
									else if($remarks=="without MOA")
									{
										$comstart4="<!--";
									}
									else if($remarks=="for follow up")
									{
										$comstart5="<!--";
									}
									else if($remarks=="expired MOA")
									{
										$comstart6="<!--";
									}
									else if($remarks=="with HTE MOA")
									{
										$comstart7="<!--";
									}
									else if($remarks=="Banned")
									{
										$comstart8="<!--";
									}
									else if($remarks=="for Notary")
									{
										$comstart9="<!--";
									}else if($remarks=="Close to Expired MOA")
									{
										$comstart10="<!--";
									}else if($remarks=="others")
                  {
                    $comstart10="<!--";
                  }
								  ?>
                     <select class="form-control" name="remarks" id="remarks" class="form-control" placeholder="remarks">
                      <option><?php echo $remarks; ?></option>
                      <?php echo $comstart3;?><option value="with MOA">with MOA</option><?php echo $comend;?>
                      <?php echo $comstart4;?><option value="without MOA">without MOA</option><?php echo $comend;?>
                      <?php echo $comstart5;?><option value="for follow up">for follow up</option><?php echo $comend;?>
                      <?php echo $comstart6;?><option value="expired MOA">expired MOA</option><?php echo $comend;?>
                      <?php echo $comstart7;?><option value="with HTE Training">with HTE MOA</option><?php echo $comend;?>
                      <?php echo $comstart8;?><option value="Banned">Banned</option><?php echo $comend;?>
                      <?php echo $comstart9;?><option value="for Notary">for Notary</option><?php echo $comend;?>
                      <?php echo $comstart10;?><option value="Close to Expired MOA">Close to Expired MOA</option><?php echo $comend;?>
					            <?php echo $comstart11;?><option value="others">others</option><?php echo $comend;?>
                      </select>
                    </div>
                    
                            </div>
                             <div class="col-md-3">
                                  <h5 style="padding-left:5px;">DATE OF NOTARY</h5>
                                  <div class="form-group">
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="date_notary">
                                          <input type="text" class="form-control" name="date_notary" value="<?php echo $date_notary; ?>" maxlength="10"/>
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                             <div class="col-md-3">
                                 <h5 style="padding-left:5px;">DATE OF EXPIRY</h5>
                                <div class="form-group">
                                <div class="dateContainer">
                                    <div class="input-group input-append date" id="date_expiry">
                                        <input type="text" class="form-control" name="date_expiry" value="<?php echo $date_expiry; ?>" maxlength="10"/>
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                          </div>

                           
                          
						   <div class="row">
						
								<div class="col-md-4">
								<h2>Contact Info:</h2>
								</div>
							   
								<div class="col-md-5 pull-right" >
								<br>
										  				   
									<a href="add_comp_contact_person.php?comp_id=<?php echo $comp_id?>">
										  <div type="submit" class="btn btn-success btn-outline btn-block btn-sm" name="btn-add" id="btn-add">
												<span class="fa fa-plus"></span> &nbsp; ADD CONTACT PERSON &nbsp;
										  </div>
										 </a>
								</div>
							
							</div>
						
							
                          <div class="row">
                            <div class="col-md-4">
                                <h5 style="padding-left:5px;">CONTACT PERSON</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Contact Person" value ="<?php echo $contact_person ; ?>" maxlength="50"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">POSITION</h5>
                              <div class="form-group has-feedback"> 
                                <input type="text" name="position" id="position" class="form-control" placeholder="Position" value ="<?php echo $position; ?>"/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">EMAIL</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email"  value ="<?php echo $email; ?>"/>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                                <h5 style="padding-left:5px;">CONTACT NUMBER</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="tel_no" id="tel_no" class="form-control" placeholder="Contact Number" value ="<?php echo $tel_no; ?>" maxlength="11"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 style="padding-left:5px;">FAX NUMBER</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="fax_no" id="fax_no" class="form-control" placeholder="(Optional) Fax Number" value ="<?php echo $fax_no; ?>" maxlength="12"/>
                                </div>
                            </div>
                          </div>
						  
						  
			
                      <div class="responsive-table">
                      <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr >
                          <th class="text-center col-md-2">Contact Name</th>	  
                          <th class="text-center col-md-1">Position</th>
                          <th class="text-center col-md-1">Contact Number</th>
                         <!-- <th class="text-center col-md-1">Fax Number</th>-->
                          <th class="text-center col-md-1">Email</th>
						  <th class="text-center col-md-1">Status</th>
						  <th class="text-center col-md-1">Remarks</th> 
						  <th class="text-center col-md-2">Date Notary / Date Expiry</th>  
  ?                       <th class="text-center col-md-1">ACTION</th>   
						
                        </tr>
                      </thead>
                        
                      <tbody>
                        
                      </tbody>
                     </table>
                     </div>
                   
                          

                            
  
                        <br>
                        <br>
                          <div class="row">
						  
						   <!--Added by errik -->
							
							<div class="col-md-4">
					
							 
                        <!--   <button type="submit" class="btn btn-danger btn-block" name="btn-delete" id="btn-delete"  data-target="#company_delete" href="#company_delete" data-toggle="modal"  <?php if ($status=='Active' || $stud_count>0){?> disabled <?php } ?> ><span class="glyphicon glyphicon-remove"></span> &nbsp;Delete Company</button> -->
                               <button  href="#myModal" id="btndelete" class="btn btn-danger btn-block" onclick="myFunction"  <?php if ($status=='Active' || $stud_count>0){?> disabled <?php } ?> ><span class="glyphicon glyphicon-remove"></span> &nbsp;Delete Company</button> 
                           
							 </div>

					
   
	 <!--Added by errik -->
                           
                             <div class="col-md-4">
                             <button type="submit" class="btn btn-info btn-block" name="btn-update" id="btn-update"><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE</button>
                             </div>
                             <div class="col-md-4">
                               <a href="Company_info.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                          </div>
                            </div>
							<div class="bs-example">
    <!-- Button HTML (to Trigger Modal) -->
 <!--   <a href="#" class="btn btn-lg btn-primary">Launch Demo Modal</a>  -->
    
    <!-- Modal HTML -->
    <div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="update_comp_cont_info.php?comp_id=<?php echo $comp_id?>"> <button type="button" class="close">&times;</button></a>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p><b><big>Do you want to delete this company?</big></b></p>
                    <p class="text-warning"><small>It will be deleted permanently!</small></p>
                </div>
                <div class="modal-footer">
                 <!--   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  -->
                 <!--   <button type="button" class="btn btn-primary">Save changes</button>  -->
				  <button type="submit" class="btn btn-danger btn-block" name="btn-delete" id="btn-delete"  data-target="#company_delete" href="#company_delete" ><span class="glyphicon glyphicon-remove"></span> &nbsp;Delete Company</button> <br>
                  <a href="update_comp_cont_info.php?comp_id=<?php echo $comp_id?>">  <button type="button" class="btn btn-warning btn-block" aria-label="Close"><span class="glyphicon glyphicon-ban-circle"></span>&nbsp;CANCEL</button></a>
				 
                </div>
            </div>
        </div>
    </div>
</div>

                       </div><!--ENd of panel body-->
                      </form>
					  </div>
					  <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">
					  <form id="defaultForm2" method="post" action="update_company_record_process.php" enctype="multipart/form-data">
                    <input type="hidden" name="comp_id" value="<?php echo $comp_id; ?>"/>
                    <!--start of panel body 2-->
                      <div class="panel-body" style="padding-bottom:30px;">
                        <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">      
                            <div class="col-md-12">
                              <h4 style="color:white;"><b>COMPANY NAME:  <?php echo $comp_name; ?></b></h4>
                            </div>
                          </div>
                        </div>
                        <?php
                         
							$moa1 = "SELECT * FROM company_record WHERE comp_id='$comp_id'";
							$moaresult = mysqli_query($dbc, $moa1);
							$counter = "NO";
							if(mysqli_num_rows($moaresult) > 0)
							{
								$q_res_data = mysqli_fetch_assoc($moaresult);
								$id = $q_res_data["id"];
								$comp_id = $q_res_data["comp_id"];
								$filename = $q_res_data["filename"];
								$filefolder = $q_res_data["filefolder"];
								$counter = "YES";
							}else
							{
								$filename = "NO MOA.pdf";
							}
                          ?>
						    <input type="hidden" name="comp_name" value="<?php echo $comp_name; ?>">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="comp_id" value="<?php echo $comp_id; ?>">
							<input type="hidden" name="filename" value="<?php echo $filename; ?>">
							<input type="hidden" name="filefolder" value="<?php echo $filefolder; ?>">
							<input type="hidden" name="counter" value="<?php echo $counter; ?>">

                          <div class="row">
                            <div class="col-md-8">
                              <h2 style="padding-left:5px;">MEMORANDUM OF AGREEMENT</h2>
                            </div>
							   <div class="col-md-4">
							   <br>
                              <h5 style="padding-left:5px;">CLEARBOOK #</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="filefolder" id="filefolder" class="form-control" placeholder="Clearbook Number"  value ="<?php if($counter=="YES"){echo $filefolder;} ?>(Jane Sexy)"/>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-5">
                            <h5> &nbsp; UPLOAD DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="company_record" placeholder="Upload Record" alt="Company Record"/>
                               </div>
                          </div>
                          <br><br>
                          <div class="col-md-3"></div>
                          <div class="col-md-4">
                                 <button type="submit" class="btn btn-info btn-block"   name="btn_update_company_records" id="btn_update_company_records">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                 </button>
                             </div>
                         <br>
                         </div>
                        </div><!--ENd of panel body 2-->
                        </form>
                        <br>
                         <div class="row">
                            <div class="col-md-12">
							<?php if($counter == "YES" && $filename != "")
							{
						?>
                                <iframe src="../files/company_record/<?php echo $filename; ?>" id="xD" height="750px" width="100%"
                                frameborder="0">#document</iframe>
							<!--	<input type="hidden" name="linked" id="linked" value="../files/company_record/<?php echo $filename; ?>">-->
								<script>
								document.getElementById('xD').contentWindow.location.reload();
					
								
								//	$linked =  document.getElementById("linked").value;
								var _theframe = document.getElementById("xD");
								_theframe.contentWindow.location.href = _theframe.src;
						//_theframe.src = $linked;
</script>
								
								<?php }else{?>
								<center><H3>No Records Found</H3></center>
								<?php } ?>
												
                           </div>
                          </div>
						  <Br>
                       </div><!--end of tab of tab 2-->
					   
					   <!------------Akin to ------------------------>
					   
					   	<div role="tabpanel" class="tab-pane fade" id="tab4" aria-labelledby="tab4">
						
                     
                        
					  	<div class="row">
						<div class="col-md-12">
							<div class="panel-body">
							 <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">      
                            <div class="col-md-12">
                              <h4 style="color:white;"><b>COMPANY NAME:  <?php echo $comp_name; ?></b></h4>
                            </div>
                          </div>
                        </div>
						<div class="row">
                            <div class="col-md-8">
                              <h2 style="padding-left:5px;">LIST OF STUDENT</h2>
                            </div>
							
                          </div>
						<br>
                          <div class="responsive-table">
                          <table id="datatableserrik"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>                                                  
                          <th class="text-center" width="75px">STUDENT NO</th>
                          <th class="text-center" width="120px">LAST NAME</th>
						  <th class="text-center" width="120px">FIRST NAME</th> 
						  <th class="text-center" width="120px">MIDDLE NAME</th>                           
                          <th class="text-center" width="100px">OJT START DATE</th>
                          <th class="text-center" width="75px">STATUS</th>              
						  <th class="text-center" width="75px">SEMESTER</th> 
						  <th class="text-center" width="75px">S.Y.</th>    						  
                          </tr>
                          </thead>
                          <tbody>
						  <?php
							$result = mysqli_query($dbc,"SELECT student_info.stud_no,student_info.lname,student_info.fname,student_info.mname, company_ojt_student.status, DATE_FORMAT(company_ojt_student.ojt_start_date, '%M %e, %Y') AS ojt_start_date,company_ojt_student.status,company_ojt_student.semester,company_ojt_student.acad_year_start ,company_ojt_student.acad_year_end  
														FROM student_info JOIN company_ojt_student ON company_ojt_student.stud_no=student_info.stud_no where comp_id='$comp_id' ORDER BY student_info.lname");
								
							
							
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td><center>" . $row['stud_no'] . "</center></td>";
    echo "<td><center>" . $row['lname'] . "</center></td>";
    echo "<td><center>" . $row['fname'] . "</center></td>";
	 echo "<td><center>" . $row['mname'] . "</center></td>";
	  echo "<td><center>" . $row['ojt_start_date'] . "</center></td>";
	   echo "<td><center>" . $row['status'] . "</center></td>";
	    echo "<td><center>" . $row['semester'] . "</center></td>";
		 echo "<td><center>" . $row['acad_year_start'] . " - " . $row['acad_year_end'] . "</center></td>";
echo "</tr>";
}

?>
										
							</tbody>
							</table>
						</div>
						</div>
						
						</div>
					</div>
					  					   
					   
					   
					   
					   </div>
					   
					    <!------------Akin to ------------------------>
					
					   
					   	<div role="tabpanel" class="tab-pane fade" id="tab3" aria-labelledby="tab3">
						<div class="panel-body" style="padding-bottom:30px;">
                        <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">      
                            <div class="col-md-12">
                              <h4 style="color:white;"><b>COMPANY NAME:  <?php echo $comp_name; ?></b></h4>
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
						<form id="defaultForm3" method="post" action="add_comp_incident_report_process.php"  enctype="multipart/form-data">     
						<input type="hidden" name="comp_id" value="<?php echo $comp_id; ?>">
						<div class="col-md-12">
						
							<div class="row">
												<div class="col-md-5">
                            <h5> &nbsp; UPLOAD DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="company_report" placeholder="Upload Incident Report" alt="Incident Report"/>
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
							$result = mysqli_query($dbc,"SELECT id,remarks,DATE_FORMAT(date, '%M %e,%Y') as date,filename FROM company_report WHERE comp_id = '$comp_id'");
								
							
							
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
  
    $btn_download = '<a role="button" href="../files/company_report/'.$row['filename'] .'" download="'.$row['id'] .'.pdf" target="_blank" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Download Incident Report"><span class="fa fa-download">
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
	 <form id="defaultForm4" method="post" action="update_comp_incident_report_process.php"  enctype="multipart/form-data"> 
						<input type="hidden" name="comp_id" value="<?php echo $comp_id; ?>">
						<input type="hidden" id="incident_id" name="incident_id">
						
							<div class="row">
												<div class="col-md-5">
                            <h5> &nbsp; UPLOAD DATA &nbsp; <i class="fa fa-file-pdf-o"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="company_report" placeholder="Upload Incident Report" alt="Incident Report" accept="application/pdf"/>
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
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">

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
    var tableerrik = $('#datatableserrik').DataTable();
	
	var x = document.getElementById('defaultForm').elements[0].value;

    $('#datatables').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "update_comp_cont_info_ssp.php?comp_id="+x,
		lengthMenu: [[5, 10, -1], [5, 10, "All"]],
		oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        }
    } );
	
	
  var x = 0;
   $("#btnToggleForm").click(function(){
 //  if(x ==0)
  // {
    $(".reportForm").toggle();
	//x=1;
//	 $("#btnToggleForm").html('<span class="fa fa-times"></span> &nbsp; CANCEL &nbsp;')
	 $("#btnToggleForm").toggle();
	//}
//	else
	//{
	//x= 0;
	// $(".reportForm").toggle();
//	 $("#btnToggleForm").html('<span class="fa fa-plus"></span> &nbsp; ADD &nbsp;')
	//}
  });
  
  $("#btnToggleCloseForm").click(function(){
    $(".reportForm").toggle();
	 $("#btnToggleForm").toggle();
  });
  
  $('#btndelete').click(function(){
		$("#myModal").modal('show');	
	});
      $('#date_notary')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'date_notary');
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
		
		

    $('#date_expiry')
        .datepicker({
            format: 'mm/dd/yyyy'
        })
        .on('changeDate', function(e) {
            $('#defaultForm').bootstrapValidator('revalidateField', 'date_expiry');
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
                comp_name: {
                    message: 'Company name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Company name is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 2,
                            max: 255,
                            message: 'Company name must be more than 2 and less than 255 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,`/? 0-9]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                comp_desc: {
                    validators: {
                        stringLength: {
                            min: 1,
                            max: 1000,
                            message: 'Company description must be more than 1 and less than 1000 characters long'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:;,`/? \n 0-9]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
              address: {
                    validators: {
                       notEmpty: {
                            message: 'Company address is required and can\'t be empty'
                        },
                    stringLength: {
                            min: 5,
                            max: 100,
                            message: 'Address must be more than 5 and less than 100 characters long'
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
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Position can only consist of letters,'
                        },
                    stringLength: {
                            min: 2,
                            max: 50,
                            message: 'Position must be more than 2 and less than 50 characters long'
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
                date_notary: {
                    validators: {
                        
                        date: {
                            max: 'date_expiry',
                            message: 'Date of notary is invalid'
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
                date_expiry: {
                    validators: {
                        
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date of expiry(e.g. MM/DD/YYYY)'
                        },
                        date: {
                            min: 'date_notary',
                            message: 'Date of expiry is invalid'
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
                
            }
        })
		 $('#defaultForm2').bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                company_record: {
                    validators: {

                          file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: 5242880,   // 5mb
                            message: 'The selected file is not valid,it should be (pdf) and 5MB at maximum size'
                          }
                    }
                },
                resume_link: {
                    validators: {
                          regexp: {
                            regexp: /^['~a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    },
                }
            }
        })
		 $('#defaultForm3')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                company_report: {
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
		$('#defaultForm4').formValidation({
		framework: 'bootstrap',
        excluded: ':disabled',
          icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
            fields: {
                company_report: {
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
                        
                         stringLength: {
                            min: 5,
                            max: 255,
                            message: 'Case Description must be more than 5 and less than 255 characters long'
                        },
                    }
                },
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
