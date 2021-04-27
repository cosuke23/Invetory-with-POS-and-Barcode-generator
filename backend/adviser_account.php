<?php

$page_title = 'OJT AssiSTI';

if(!isset($_COOKIE["uid"])) {
	header ("Location: login.php");
	exit;
}
$username = $_COOKIE["uid"];

// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

$query_adviser_profile = "SELECT * FROM adviser_info WHERE adviser_id = '$username'";
$result_adviser_profile = mysqli_query($dbc,$query_adviser_profile);
    if(mysqli_num_rows($result_adviser_profile)>0)
        {
          $row2 = mysqli_fetch_assoc($result_adviser_profile);
          $fname2 = $row2["fname"];
        }

if(isset($_GET['username'])) {
  
  $username_get=$_GET['username'];
  $query_admin_info ="SELECT a.adviser_id,a.lname,a.fname,a.mname,a.title,a.email,a.program_id,a.status,b.program_code,a.mobile_no FROM adviser_info AS a INNER JOIN program_list AS b WHERE a.program_id = b.program_id AND a.adviser_id = '$username_get'";
                 
  $result_admin_info =  mysqli_query($dbc, $query_admin_info);         
          if($result_admin_info->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_admin_info))
              {
                            $adviser_id = $row[0];
                            $lname = $row[1];
                            $fname = $row[2];
                            $mname = $row[3];
                            $title = $row[4];
                            $email = $row[5];
                            $program_id = $row[6];
                            $status = $row[7];
                            $program_code = $row[8];
                            $mobile_no = $row[9];
     
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

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/red.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>
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
				<li class="user-name">&nbsp;<span>&nbsp;<?php echo $fname ; ?>&nbsp;</span></li>
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
                        <label>
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
                        <h1 class="animated fadeInLeft">MY ACCOUNT</h1>
                        <p class="animated fadeInDown">
                         This section can update the adviser information.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE ADVISER INFORMATION</h3></div>

                    <form id="defaultForm" method="post" action="update_adviser_info_process.php" enctype="multipart/form-data">
                      <div class="panel-body" style="padding-bottom:30px;">

                         <div class="row">
                          <div class="col-md-3">
                            <h5>PROFILE PICTURE &nbsp; <i class="fa fa-camera"></i></h5>
                               <div class="form-group has-feedback">
                               <input type="file" class="form-control" name="profileData" placeholder="Upload Image" alt="Profile Picture"/> 
                               </div>
                          </div>
                        </div>

                        <div class="row">
                        
                          <div class="col-md-2">
                             <h5 style="padding-left:5px;">HONORIFICS</h5>
                               <div class="form-group has-feedback">
							   <?php
							   if($title == "Mr.")
							   {
								   $comstart="<!--";
								   $comend="-->";
								}
								if($title == "Mrs.")
								{
									$comstart2="<!--";
									$comend2 = "-->";
								}
								if($title == "Ms.")
								{
									$comstart3="<!--";
									$comend3="-->";
								}
								?>
                                   <select class="form-control" name="title" id="title" class="form-control" placeholder="Honorifics">
								   <option value="<?php echo $title;?>"><?php echo $title;?></option>
                                    <?php echo $comstart;?><option value="Mr.">Mr.</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Mrs.">Mrs.</option><?php echo $comend2;?>
									<?php echo $comstart3;?><option value="Mr.">Ms.</option><?php echo $comend3;?>
                                    </select>
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
                          <div class="col-md-5">
                               <h5 style="padding-left:5px;">EMAIL</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="email" id="email" class="form-control" value ="<?php echo $email; ?>"  maxlength="=32"/>
                                </div>                  
                            </div>

                            <div class="col-md-3">
                            <h5 style="padding-left:5px;">CONTACT NUMBER</h5>
                              <div class="form-group has-feedback">
                                  <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="adviser mobile number"  value ="<?php echo $mobile_no; ?>" maxlength="11"/>
                              </div>
                          </div>
                        </div>

                        <div class="row">
                             <div class="col-md-3">
                               <h5 style="padding-left:5px;">USERNAME</h5>
                                <div class="form-group has-feedback">
                                  <h4><?php echo $adviser_id; ?></h4>
                                  <input type="hidden" name="adviser_id" value="<?php echo $adviser_id; ?>"/>
                                </div>                  
                            </div>
                             <div class="col-md-3">
                               <h5 style="padding-left:5px;">NEW PASSWORD</h5>
                                <div class="form-group has-feedback">
                                  <input type="password" name="new_pass" id="new_pass" class="form-control" maxlength="=40" />
                                </div>                  
                            </div>
                             <div class="col-md-3">
                               <h5 style="padding-left:5px;">CONFIRM PASSWORD</h5>
                                <div class="form-group has-feedback">
                                  <input type="password" name="confirm_pass" id="confirm_pass" class="form-control"  maxlength="=40"/>
                                </div>                  
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-md-8"></div>
                             
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-info btn-block"  name="btn_update_adviser_info" 
                                 id="btn_update_adviser_info">
                                  <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                 </button>
                             </div>
                          </div>

                      </div><!--ENd of panel body-->
                      </form>
                      </div>
                     </div>
                </div>
                <div class="panel box-shadow-none content-header">
                  <div class="panel-body">

                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">CONSULTATION HOURS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section will show the information regarding to your consultation hours.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>LIST OF YOUR CONSULTATION HOURS</h3></div>

                      <div class="panel-body">
                      <div class="row" style="padding-top:10px;">
                      <div class="col-md-2">
                          <a href="add_consultation_hours.php?adviser_id=<?php echo $username_get; ?>" class="btn btn-success btn-outline btn-sm btn-block"  name ="btn_add_consultation_hours" id="btn_add_consultation_hours">
                                    <span class="glyphicon glyphicon-plus"></span> &nbsp; ADD &nbsp;
                                </a> 
                      </div>
                      <div class="col-md-8">
                      </div>
                      <div class="col-md-2">   
                              <button type="submit" class="btn btn-danger btn-outline btn-sm btn-block"  name ="btn_remove" id="btn_remove">
                                    <span class="glyphicon glyphicon-trash"></span>&nbsp; Remove&nbsp;
                                </button> 
                            </div>
                      </div>
                        <div class="row">
                        <?php 
                           $query_consultation_hours = "SELECT * FROM adviser_consultation_hours WHERE adviser_id = '$username_get'";
                          $result_consultation_hours = mysqli_query($dbc, $query_consultation_hours);
                          $num_rows = mysqli_num_rows($result_consultation_hours);
            
            
                          
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables" class="display table table-striped table-bordered table-condensed" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                            <th></th>
                             <th class="text-center">DAY</th>
                             <th class="text-center">HOUR START</th>
                             <th class="text-center">HOUR END</th>
                             <th class="text-center" style="width:100px;">ACTION</th>
                            </tr>
                          </thead>
                          <tbody>';
                        while($row = mysqli_fetch_array($result_consultation_hours)) {
               
                            $adviser_id = $row[0];
                            $day = $row[1];
                            $hour_start = $row[2];
                            $hour_end = $row[3];
                            $ach_id = $row[4];

                      ?>
                      <tr id="<?php echo $ach_id; ?>"> 
                      <?php
                      if($hour_start == "7"){
                                        $hour_start2 = "7:00 AM";
                                      }
                                      else if($hour_start == "8"){
                                        $hour_start2 = "7:30 AM";
                                      }
                                      else if($hour_start == "9"){
                                        $hour_start2 = "8:00 AM";
                                      }
                                      else if($hour_start == "10"){
                                        $hour_start2 = "8:30 AM";
                                      }
                                      else if($hour_start == "11"){
                                        $hour_start2 = "9:00 AM";
                                      }
                                      else if($hour_start == "12"){
                                        $hour_start2 = "9:30 AM";
                                      }
                                      else if($hour_start == "13"){
                                        $hour_start2 = "10:00 AM";
                                      }
                                      else if($hour_start == "14"){
                                        $hour_start2 = "10:30 AM";
                                      }
                                      else if($hour_start == "15"){
                                        $hour_start2 = "11:00 AM";
                                      }
                                       else if($hour_start == "16"){
                                        $hour_start2 = "11:30 AM";
                                      }
                                       else if($hour_start == "17"){
                                        $hour_start2 = "12:00 PM";
                                      }
                                       else if($hour_start == "18"){
                                        $hour_start2 = "12:30 PM";
                                      }
                                      else if($hour_start == "19"){
                                        $hour_start2 = "1:00 PM";
                                      }
                                      else if($hour_start == "20"){
                                        $hour_start2 = "1:30 PM";
                                      }
                                      else if($hour_start == "21"){
                                        $hour_start2 = "2:00 PM";
                                      }
                                      else if($hour_start == "22"){
                                        $hour_start2 = "2:30 PM";
                                      }
                                      else if($hour_start == "23"){
                                        $hour_start2 = "3:00 PM";
                                      }
                                      else if($hour_start == "24"){
                                        $hour_start2 = "3:00 PM";
                                      }
                                      else if($hour_start == "25"){
                                        $hour_start2 = "3:30 PM";
                                      }
                                       else if($hour_start == "26"){
                                        $hour_start2 = "4:00 PM";
                                      }
                                       else if($hour_start == "27"){
                                        $hour_start2 = "4:30 PM";
                                      }
                                       else if($hour_start == "28"){
                                        $hour_start2 = "5:00 PM";
                                      }
                                       else if($hour_start == "29"){
                                        $hour_start2 = "5:30 PM";
                                      }
                                       else if($hour_start == "30"){
                                        $hour_start2 = "6:00 PM";
                                      }
                                       else if($hour_start == "31"){
                                        $hour_start2 = "6:30 PM";
                                      }
                                       else if($hour_start == "32"){
                                        $hour_start2 = "7:00 PM";
                                      }

                                      if($hour_end == "7"){
                                        $hour_end2 = "7:00 AM";
                                      }
                                      else if($hour_end == "8"){
                                        $hour_end2 = "7:30 AM";
                                      }
                                      else if($hour_end == "9"){
                                        $hour_end2 = "8:00 AM";
                                      }
                                      else if($hour_end == "10"){
                                        $hour_end2 = "8:30 AM";
                                      }
                                      else if($hour_end == "11"){
                                        $hour_end2 = "9:00 AM";
                                      }
                                      else if($hour_end == "12"){
                                        $hour_end2 = "9:30 AM";
                                      }
                                      else if($hour_end == "13"){
                                        $hour_end2 = "10:00 AM";
                                      }
                                      else if($hour_end == "14"){
                                        $hour_end2 = "10:30 AM";
                                      }
                                      else if($hour_end == "15"){
                                        $hour_end2 = "11:00 AM";
                                      }
                                       else if($hour_end == "16"){
                                        $hour_end2 = "11:30 AM";
                                      }
                                       else if($hour_end == "17"){
                                        $hour_end2 = "12:00 PM";
                                      }
                                       else if($hour_end == "18"){
                                        $hour_end2 = "12:30 PM";
                                      }
                                      else if($hour_end == "19"){
                                        $hour_end2 = "1:00 PM";
                                      }
                                      else if($hour_end == "20"){
                                        $hour_end2 = "1:30 PM";
                                      }
                                      else if($hour_end == "21"){
                                        $hour_end2 = "2:00 PM";
                                      }
                                      else if($hour_end == "22"){
                                        $hour_end2 = "2:30 PM";
                                      }
                                      else if($hour_end == "23"){
                                        $hour_end2 = "3:00 PM";
                                      }
                                      else if($hour_end == "24"){
                                        $hour_end2 = "3:00 PM";
                                      }
                                      else if($hour_end == "25"){
                                        $hour_end2 = "3:30 PM";
                                      }
                                       else if($hour_end == "26"){
                                        $hour_end2 = "4:00 PM";
                                      }
                                       else if($hour_end == "27"){
                                        $hour_end2 = "4:30 PM";
                                      }
                                       else if($hour_end == "28"){
                                        $hour_end2 = "5:00 PM";
                                      }
                                       else if($hour_end == "29"){
                                        $hour_end2 = "5:30 PM";
                                      }
                                       else if($hour_end == "30"){
                                        $hour_end2 = "6:00 PM";
                                      }
                                       else if($hour_end == "31"){
                                        $hour_end2 = "6:30 PM";
                                      }
                                       else if($hour_end == "32"){
                                        $hour_end2 = "7:00 PM";
                                      }
                                ?> 
                                <td>
                                  <div class="form-group form-animate-checkbox">
                                   <input name="checkbox[]" class="checkbox" type="checkbox" value="<?php echo $ach_id; ?>" />
                                  </div> 
                                </td>      
                                <td><?php echo $day; ?></td> 
                                <td><?php echo $hour_start2; ?></td>
                                <td><?php echo $hour_end2; ?></td>
                              <td>
                                  <a href="update_consultation_hours.php?adviser_id=<?php echo $adviser_id; ?>&ach_id=<?php echo $ach_id; ?>">
                                  <button type="submit" class=" btn btn-outline btn-primary btn-block btn-sm">
                                  <span class="glyphicon glyphicon-pencil"></span> &nbsp;&nbsp; Update &nbsp; &nbsp;</button>
                                  </a>
                              </td>
                            
                      </tr>
                      <?php 
                     }
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?> 
                     </div>      
                      </div><!--ENd of panel body-->
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
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>

<script type="text/javascript">
$(document).ready(function(){

  $('#btn_update_stud_info').click( function() {
    $.post( 'update_Student_information_process.php');
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
                title: {
                    message: 'Honorifics is not valid.',
                    validators: {
                        notEmpty: {
                            message: 'Honorifics is required and can\'t be empty'
                        },
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
                            message: 'The lastname can only consist of letters'
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
                            message: 'Middlename is required and can\'t be empty. If you dont have a middle name please input. "."(period)'
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
                    }
                },
                new_pass: {
                  validators: {
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        },
                        stringLength: {
                            min: 6,
                            max: 32,
                            message: 'Password must be more than 6 and less than 32 characters long'
                        },
                    }
                },
              confirm_pass: {
                  validators: {
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        },
                        identical: {
                          field:'new_pass',
                          message: 'Confirm password did not match'
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

            }
        });
  $('#btn_remove').click(function(){  
           if(confirm("Are you sure you want to remove?"))  
           {  
                var ach_id = [];  
                $(':checkbox:checked').each(function(i){  
                     ach_id[i] = $(this).val();
                });  
                if(ach_id.length === 0) //tell you if the array is empty  
                {  
                     alert("Please Select atleast one checkbox");  
                }  
                else  
                {  
                     $.ajax({  
                          url:'delete_consultation_hours_process.php',  
                          method:'POST',  
                          data:{ach_id:ach_id},  
                          success:function()  
                          {  
                               for(var i=0; i<ach_id.length; i++)  
                               {  
                                    $('tr#'+ach_id[i]+'').css('background-color', '#ccc');  
                                    $('tr#'+ach_id[i]+'').fadeOut('slow');
                               }  
                          }  
                     });  
                }  
           }  
           else  
           {  
                return false;  
           }  
      }); 
    

  });
</script>
<!-- end: Javascript -->
</body>
</html>