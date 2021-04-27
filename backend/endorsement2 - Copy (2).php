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
              <!------------------------------------------------COMPANY INFORMATION------------------------------------------------------>
				<div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>ADD NEW ENDORSEMENT</h3></div>
					<div class="panel-body" style="padding-bottom:30px;">
					<?php
						if(isset($_POST['btn-ok']))
						{
							$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no_p']));
							$program_id = mysqli_real_escape_string($dbc, trim($_POST['program_id']));
							$adviser_id = mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));
							$thours = mysqli_real_escape_string($dbc, trim($_POST['thours']));
							$date_created = mysqli_real_escape_string($dbc, trim($_POST['date_created']));
							$sub_date = mysqli_real_escape_string($dbc, trim($_POST['sub_date']));
						}
						else if(isset($_POST['btn2']))
						{
							$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no_p']));
							$program_id = mysqli_real_escape_string($dbc, trim($_POST['program_id']));
							$adviser_id = mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));
							$thours = mysqli_real_escape_string($dbc, trim($_POST['thours']));
							$date_created = mysqli_real_escape_string($dbc, trim($_POST['date_created']));
							$sub_date = mysqli_real_escape_string($dbc, trim($_POST['sub_date']));
						}
					?>
				<!----------------------------------------------FORM 1--------------------------------------------------->
				
					<form method="POST" action="endorsement2.php?stud_no=<?php echo $stud_no;?>&adviser_id=<?php echo $adviser_id;?>&program_id=<?php echo $program_id?>&thours=<?php echo $thours;?>&date_created=<?php echo $date_created;?>&sub_date=<?php echo $sub_date;?>" id="form1">
                       <div class="row">
					   <div class="col-md-2">
					   <input type="hidden" name="stud_no_p" value="<?php echo $stud_no;?>"/>
					   <input type="hidden" name="program_id" value="<?php echo $program_id;?>"/>
					   <input type="hidden" name="adviser_id" value="<?php echo $adviser_id;?>"/>
					   <input type="hidden" name="thours" value="<?php echo $thours;?>"/>
					   <input type="hidden" name="date_created" value="<?php echo $date_created;?>"/>
					   <input type="hidden" name="sub_date" value="<?php echo $sub_date;?>"/></div>
						   <div class="col-md-4">

                                <h5 style="padding-left:5px;">Company name:</h5>
                                <div class="form-group has-feedback"> 
                                  <input type="text" name="comp_name" list="suggestion" id="comp_name" class="form-control" value="<?php if(isset($_POST['comp_name'])){$comp_show=$_POST['comp_name'];echo $comp_show;}?>" placeholder="Company Name"/>
								  <input type="hidden" name="btn2"/>
								  <?php
								$q_suggestion = "SELECT * FROM company_info WHERE status = 'Active' GROUP BY username";
                       
								$r_suggestion = mysqli_query($dbc, $q_suggestion);
                                $num_rows2 = mysqli_num_rows($r_suggestion);
                                
                                print'<datalist id="suggestion">';
                                
                                 while($row_pl = mysqli_fetch_array($r_suggestion)){
                                    $s_comp_id = $row_pl[0];
                                    $s_comp_name = $row_pl[1];
                                    echo "<option data-value='".$s_comp_id."'>".$s_comp_name."</option>";
                                }
                                print '</datalist>
								<input type="hidden" name="comp_name-hidden" id="comp_name-hidden"/>';
								?>
								<script>
								document.querySelector('input[list]').addEventListener('input', function(e) {
									var input = e.target,
										list = input.getAttribute('list'),
										options = document.querySelectorAll('#' + list + ' option'),
										hiddenInput = document.getElementById(input.id + '-hidden'),
										inputValue = input.value;

									hiddenInput.value = inputValue;

									for(var i = 0; i < options.length; i++) {
										var option = options[i];

										if(option.innerText === inputValue) {
											hiddenInput.value = option.getAttribute('data-value');
											break;
										}
									}
								});
								</script>

								<?php
								//$comp_id2 ='0';
								$comp_address="";
								$comp_city="";
								$contact_p="";
								$position="";
								$tel_no="";
								$email="";
								$en_count='0';
								$show="none";
								$checkersx='0';
								
								if(isset($_POST['btn2']) && isset($_GET['stud_no']))
								{
									$stud_no = $_GET['stud_no'];
									$program_id = $_GET['program_id'];
									$adviser_id = $_GET['adviser_id'];
									$thours = $_GET['thours'];
									$date_created = $_GET['date_created'];
									$sub_date = $_GET['sub_date'];
									$comp_id2=mysqli_real_escape_string($dbc, trim($_POST['comp_name-hidden']));
									$query_2="SELECT * FROM company_info WHERE comp_id='$comp_id2'";
									$result_2=mysqli_query($dbc, $query_2);
									if(mysqli_num_rows($result_2)>0)
									{
										$r2 = mysqli_fetch_assoc($result_2);
										$comp_id = $r2['comp_id'];
										$comp_address = $r2['address'];
										$comp_city = $r2['city'];
										$contact_p = $r2['contact_person'];
										$position = $r2['position'];
										$tel_no = $r2['tel_no'];
										$email = $r2['email'];
									}
									$query_3="SELECT COUNT(endorsement_id) AS en_count FROM endorsement WHERE comp_id='$comp_id2' and status='Active'";
									$result_3=mysqli_query($dbc, $query_3);
									if(mysqli_num_rows($result_3)>0)
									{
										$r3 = mysqli_fetch_assoc($result_3);
										$en_count = $r3['en_count'];
										$show="block";
									}

									$query_4x="SELECT COUNT(id) AS total FROM company_info_other_contact_person WHERE comp_id='$comp_id2'";
									$result_4x=mysqli_query($dbc, $query_4x);
									if(mysqli_num_rows($result_4x)>0)
									{
										$r4x = mysqli_fetch_assoc($result_4x);
										$checkersx = $r4x['total'];
										if($checkersx>0)
										{
											$contact_p="";
											$position="";
											$tel_no="";
											$email="";
										}		
									}		
								}
								?>
                                </div>
                           </div>
						   <div class="col-md-5">
                        <div class="panel-body">
							<div class="row">
                                <div class="col-md-12">
                                    <h4> <span class="glyphicon glyphicon-exclamation-sign text-warning ">&nbsp;NOTE:</span>
                                          &nbsp;Enter to search the<strong><mark class="text-primary"> COMPANY INFO</mark></strong>.</h4>
                                </div>
                            </div>
                        </div>  
					</div>
						   <div class="col-md-2"></div>
						   </div>
						     
						  
						   
						   
						   
						   
						   </form>
						   
				<!----------------------------------------------FORM 2--------------------------------------------------->
							<form method="POST" action="endorsement2.php?stud_no=<?php echo $stud_no;?>&adviser_id=<?php echo $adviser_id;?>&program_id=<?php echo $program_id?>&thours=<?php echo $thours;?>&date_created=<?php echo $date_created;?>&sub_date=<?php echo $sub_date;?>" id="form2">
                      
						  <!--<form id="form2" action="endorsement_process.php" enctype="multipart/form-data" method="POST">-->
								<input name="stud_no" type="hidden" value ="<?php echo $stud_no; ?>" />
								<input name="program_id" type="hidden" value ="<?php echo $program_id; ?>" />
								<input name="adviser_id" type="hidden" value ="<?php echo $adviser_id; ?>" />
								<input name="thours" type="hidden" value ="<?php echo $thours; ?>" />
								<input name="date_created" type="hidden" value ="<?php echo $date_created; ?>" />
								<input name="sub_date" type="hidden" value ="<?php echo $sub_date; ?>" />
								<input name="comp_id" type="hidden" value ="<?php echo $comp_id; ?>" />
								<input name="comp_address" type="hidden" value ="<?php echo $comp_address; ?>" />
								
						   <div class="row">
						
						   <hr>
						   
						   
						   
					<div class="col-md-2"></div>
                            <div class="col-md-4">
                                 <h5 style="padding-left:5px;">Company Address:</h5>
                                <div class="form-group has-feedback">
                                  <textarea rows ="2" name="address" id="address" class="form-control" placeholder="Address"><?php 
								  if($comp_address!="")
								  {
									echo $comp_address;
								  }
								  else{}
								  ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">City:</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="city" id="city" class="form-control" value="<?php 
								  if($comp_city!="")
								  {
									echo $comp_city;
								  }
								  else{}
								  ?>" placeholder="City"/>
                                </div>
                            </div>
							<div class="col-md-2"></div>
                          </div>

						   <div class="row">
						  <div class="col-md-2"></div>
                            <div class="col-md-4">
							 <h5 style="padding-left:5px;">Name of Host Company Representative:</h5>
                                <div class="form-group has-feedback"> 
                                  <input type="text" name="contact_person" list="suggestion2" id="contact_person" class="form-control" value="<?php 
						
								 
								  if(isset($_POST['contact_person']))
									{
									  $contact_px=$_POST['contact_person'];
									  echo $contact_px;
									  
										
					   
									}else{
										echo $contact_p;
										
									}
								  
									  
									?>" placeholder="Contact Person"/>
								  
								  <?php
								  if($checkersx>0)
								  {
								$q_suggestion = "SELECT contact_person,position,tel_no,email FROM company_info_other_contact_person WHERE comp_id ='$comp_id2' UNION ALL SELECT contact_person,position,tel_no,email FROM company_info WHERE comp_id ='$comp_id2'";
                       
								$r_suggestion = mysqli_query($dbc, $q_suggestion);
                                $num_rows2 = mysqli_num_rows($r_suggestion);
                                
                                print'<datalist id="suggestion2">';
                                
                                 while($row_pl = mysqli_fetch_array($r_suggestion)){
									 $ocpid = $row_pl[0];
                                     $ocpname = $row_pl[0];
									 $ocpposition = $row_pl[1];
                                     $ocptel_no = $row_pl[2];
									 $ocpemail = $row_pl[3];
                                   
                                    echo "<option data-value='".$ocpid."'>".$ocpname."</option>";
                                }
                                print '</datalist>
								<input type="hidden" name="contact_person-hidden" id="contact_person-hidden"/>';
								
								  }
								?>
								<script>
								document.querySelector('input[list]').addEventListener('input', function(e) {
									var input = e.target,
										list = input.getAttribute('list'),
										options = document.querySelectorAll('#' + list + ' option'),
										hiddenInput = document.getElementById(input.id + '-hidden'),
										inputValue = input.value;

									hiddenInput.value = inputValue;

									for(var i = 0; i < options.length; i++) {
										var option = options[i];

										if(option.innerText === inputValue) {
											hiddenInput.value = option.getAttribute('data-value');
											break;
										}
									}
								});
								</script>

							
                                </div>	
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">Position:</h5>
                              <div class="form-group has-feedback"> 
                                <input type="text" name="position" id="position" list="suggestion3" class="form-control" value="<?php 
							//	  if($position!="")
							//	  {
							//		echo $position;
							//	  }
							//	  else{}
							 if(isset($_POST['cposition']))
									{
									  $contact_px=$_POST['cposition'];
									  echo $contact_px;
									  
									}else{
										echo $position;
									}
								  
							
								  ?>" placeholder="Position" />
								  <?php
								 if($checkersx>0)
								  {
									    $q_suggestion2 = "SELECT contact_person,position,tel_no,email FROM company_info_other_contact_person WHERE comp_id ='$comp_id2' UNION ALL SELECT contact_person,position,tel_no,email FROM company_info WHERE comp_id ='$comp_id2'";
                       
										$r_suggestion2 = mysqli_query($dbc, $q_suggestion2);
										$num_rows22 = mysqli_num_rows($r_suggestion2);
								
                                print'<datalist id="suggestion3">';
                                
                                 while($row_pl = mysqli_fetch_array($r_suggestion2)){
									 $ocpid = $row_pl[0];
                                     $ocpname = $row_pl[0];
									 $ocpposition = $row_pl[1];
                                     $ocptel_no = $row_pl[2];
									 $ocpemail = $row_pl[3];
                                   
                                    echo "<option data-value='".$ocpposition."'>".$ocpposition."</option>";
                                }
                                print '</datalist>
								<input type="hidden" name="cposition-hidden" id="cposition-hidden"/>';
								
								  }
								?>
								<script>
								document.querySelector('input[list]').addEventListener('input', function(e) {
									var input = e.target,
										list = input.getAttribute('list'),
										options = document.querySelectorAll('#' + list + ' option'),
										hiddenInput = document.getElementById(input.id + '-hidden'),
										inputValue = input.value;

									hiddenInput.value = inputValue;

									for(var i = 0; i < options.length; i++) {
										var option = options[i];

										if(option.innerText === inputValue) {
											hiddenInput.value = option.getAttribute('data-value');
											break;
										}
									}
								});
								</script>
								  
								  
                              </div>
                            </div>
							<div class="col-md-2"></div>
							</div>
							<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-4">
                                <h5 style="padding-left:5px;">Contact number:</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="tel_no" id="tel_no" class="form-control" value="<?php 
								  if($tel_no!="")
								  {
									echo $tel_no;
								  }
								  else{}
								  ?>" placeholder="Contact number"  maxlength="11"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h5 style="padding-left:5px;">Email:</h5>
                              <div class="form-group has-feedback">
                                <input type="text" name="email" id="email" class="form-control" value="<?php 
								  if($email!="")
								  {
									echo $email;
								  }
								  else{}
								  ?>" placeholder="Email"/>
                              </div>
                            </div>
							<div class="col-md-2"></div>
                          </div>
                         
                       
						  <br>
                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
							
								<a href="#" style="display:<?php echo $show;?>" data-toggle="modal" data-target="#myModal">There are <?php echo $en_count;?> Student(s) applied in this company (Click this label to show records)</a>
							</div>
                            <div class="col-md-4">
                              <button type="submit" class="btn btn-success btn-block" name="btn-save" id="btn-save"><span class="glyphicon glyphicon-floppy-disk"></span> &nbsp;SAVE</button>
							  </div>
							  <div class="col-md-2"></div>
                              </div>
							
                        </div><!--ENd of panel body-->
                          
                          </div>
						  <!-- Modal -->
							  <div class="modal fade" id="myModal" role="dialog">
								<div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal">&times;</button>
									  <h4 class="modal-title">Endorsement</h4>
									</div>
									<div class="modal-body">
									<?php
										$query_studList = "SELECT a.stud_no, a.date_created, a.status, d.lname, d.fname, d.mname, c.program_code FROM endorsement AS a INNER JOIN adviser_info AS b INNER JOIN program_list AS c INNER JOIN student_info AS d WHERE a.comp_id='$comp_id2' AND a.adviser_id = b.adviser_id AND a.program_id = c.program_id AND a.stud_no=d.stud_no AND a.status='Active'";
										$result_studList = mysqli_query($dbc, $query_studList);
										$nr = mysqli_num_rows($result_studList);
										 
									
									  print'<div class="panel-body">

									  <div class="responsive-table">
									  <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
									  <thead>
										<tr>
											<th class="text-center">STUDENT NUMBER</th>
											<th class="text-center">FULL NAME</th>   
											<th class="text-center" >PROGRAM</th>
											<th class="text-center">DATE ISSUE</th>
											<th class="text-center">STATUS</th>                     
										</tr>
										</thead>
									  <tbody>';
									  
									  while($r_m = mysqli_fetch_array($result_studList)) {
									  
										$studNo = $r_m[0];
										$dateIssue = $r_m[1];
										$staTus = $r_m[2];
										$lname = $r_m[3];
										$fname = $r_m[4];
										$mname = $r_m[5];
										$progCode = $r_m[6];
									  
									  ?>
									  <tr>
										<td><?php echo $studNo; ?></td>
										<td><?php echo $lname.", ".$fname." ".$mname; ?></td>
										<td><?php echo $progCode; ?></td>
										<td><?php echo $dateIssue; ?></td>
										<td><?php echo $staTus; ?></td>
									  </tr>
									  </tbody>

									  <?php }?>
									 </table>
									 </div>
									 </div>
									
								  </div>
								  </div>
								  
								</div>
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
 var table = $('#datatables').DataTable();
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
                comp_name: 
				{
					validators: 
					{
                        notEmpty: {},
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
				adviser: {
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