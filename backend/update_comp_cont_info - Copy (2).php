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
                    <div class="panel-heading"><h3>UPDATE PARTNER COMPANY</h3></div>
                    <br>
                    <?php
                         if(isset($_GET['resend'])) 
                            {   
                            print '<div class="col-md-12">
                              <div class="alert alert-success alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
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
                                  <h5 style="padding-left:5px;">DATE NOTARY</h5>
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
                                 <h5 style="padding-left:5px;">DATE EXPIRY</h5>
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
						  
						  <?php
						  /*
							$query_comp_info_other_contact = "
	SELECT 	a.id,
			a.contact_person,
			a.position,
			a.email,
			a.tel_no,
			a.fax_no		
	FROM company_info_other_contact_person as a
	WHERE a.comp_id = '$comp_id'";
                 
	$resulta =  mysqli_query($dbc, $query_comp_info_other_contact);         
          if($resulta->num_rows > 0 )
            {   
					print "<div class='row'>
                            <h2 style='margin-left:13px;'>Other Contact Info</h2>
                          </div>";
					
              while ($row = mysqli_fetch_array($resulta))
              {
				  $x++;
				  $ids[$x]=$row[0];
				  
				  print "<div class='row'>
                            <div class='col-md-4'>
                                <h5 style='padding-left:5px;'>CONTACT PERSON $x</h5>
                                <div class='form-group has-feedback'>
                                  <input type='text' name='contact_personocp[$x]' id='contact_personocp[$x]' class='form-control' placeholder='Contact Person' value ='$row[1]' maxlength='50'/>
                                </div>
                            </div>";
               
				  print "<div class='col-md-4'>
                              <h5 style='padding-left:5px;'>POSITION</h5>
                              <div class='form-group has-feedback'> 
                                <input type='text' name='positionocp[]' id='positionocp[]' class='form-control' placeholder='Position' value ='$row[2]'/>
                              </div>
                            </div>";
							
				  print "<div class='col-md-4'>
                              <h5 style='padding-left:5px;'>EMAIL</h5>
                              <div class='form-group has-feedback'>
                                <input type='text' name='emailocp[]' id='emailocp[]' class='form-control' placeholder='Email'  value ='$row[3]'/>
                              </div>
                            </div>
                          </div>";	

				  print "<div class='row'>
                            <div class='col-md-6'>
                                <h5 style='padding-left:5px;'>CONTACT NUMBER</h5>
                                <div class='form-group has-feedback'>
                                  <input type='text' name='tel_noocp[]' id='tel_noocp[]' class='form-control' placeholder='Contact Number' value ='$row[4]' maxlength='11'/>
                                </div>
                            </div>";
				  
				  print "<div class='col-md-6'>
                                <h5 style='padding-left:5px;'>FAX NUMBER</h5>
                                <div class='form-group has-feedback'>
                                  <input type='text' name='fax_noocp[]' id='fax_noocp[]' class='form-control' placeholder='(Optional) Fax Number' value ='$row[5]' maxlength='12'/>
                                </div>
                            </div>
                          </div><hr>";
							
							
              }
           }
						  
						  
						  
						*/    
?>

					
					
                      <div class="responsive-table">
                      <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr >
                          <th class="text-center col-md-1">Contact Name</th>	  
                          <th class="text-center col-md-1">Position</th>
                          <th class="text-center col-md-1">Contact Number</th>
                          <th class="text-center col-md-1">Fax Number</th>
                          <th class="text-center col-md-1">Email</th>
  �                       <th class="text-center col-md-1">ACTION</th>    
                        </tr>
                      </thead>
                        
                      <tbody>
                        
                      </tbody>
                     </table>
                     </div>
                   
                          

                            
  
                        <br>
                        <br>
                          <div class="row">
                            <div class="col-md-4"></div>
                             <div class="col-md-4">
                             <button type="submit" class="btn btn-info btn-block" name="btn-update" id="btn-update"><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE</button>
                             </div>
                             <div class="col-md-4">
                               <a href="Company_info.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#date_notary')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'date_notary');
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
                date_expiry: {
                    validators: {
                        
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date expiry(e.g. MM/DD/YYYY)'
                        },
                        date: {
                            min: 'date_notary',
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
  
	var x = document.getElementById('defaultForm').elements[0].value;
	$(document).ready(function() {
    $('#datatables').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "update_comp_cont_info_ssp.php?comp_id="+x,
		lengthMenu: [[5, 10, -1], [5, 10, "All"]],
		oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        }
    } );
} );
	
</script>
<!-- end: Javascript -->

</body>
</html>
