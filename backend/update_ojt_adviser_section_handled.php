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
  if((isset($_GET['acad_year_start'])) && (isset($_GET['semester'])) && (isset($_GET['adviser_id'])) && (isset($_GET['section_id'])) ) {
  
  $acad_year_start=$_GET['acad_year_start'];
  $semester=$_GET['semester'];
  $adviser_id=$_GET['adviser_id'];
  $section_id=$_GET['section_id'];
  $query_update_OJT_adviser_section_handled ="SELECT a.adviser_id,a.lname,a.fname,a.mname,a.title,a.program_id,b.semester,b.section_id,b.acad_year_start,b.acad_year_end,c.section,d.program_code,b.status,b.ash_id FROM adviser_info AS a INNER JOIN adviser_section_handled AS b INNER JOIN section_list AS c INNER JOIN program_list AS d WHERE a.adviser_id = b.adviser_id AND a.program_id = d.program_id AND b.section_id = c.section_id AND b.acad_year_start = '$acad_year_start' AND b.adviser_id = '$adviser_id' AND b.semester = '$semester' AND b.section_id = '$section_id'";
                 
  $result_update_OJT_adviser_section_handled =  mysqli_query($dbc, $query_update_OJT_adviser_section_handled);         
          if($result_update_OJT_adviser_section_handled->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_update_OJT_adviser_section_handled))
              {
                       $adviser_id = $row[0];
                       $lname = $row[1];
                       $fname = $row[2];
                       $mname = $row[3];
                       $title = $row[4];
                       $program_id = $row[5];
                       $semester_ash = $row[6];
                       $section_id = $row[7];
                       $acad_year_start = $row[8];
                       $acad_year_end = $row[9];
                       $section  = $row[10];
                       $program_code = $row[11];
                       $status_ash = $row[12];
                       $ash_id = $row[13];
                                        
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
                        <label class="active">
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
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->
       
        <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">SECTION HANDLED</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section can update the section handled.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>UPDATE SECTION HANDLED </h3></div>
                    <form id="defaultForm" method="post" action="update_ojt_adviser_section_handled_process.php">
                      <div class="panel-body" style="padding-bottom:30px;">
                      <?php
                      if(isset($_GET['error1'])) {
                              
                             print '<div class="col-md-12" id="success">
                                     <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                   <span class="fa fa-remove"></span> &nbsp; | &nbsp;
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span></button>
                                  <strong>&nbsp;Error!</strong> The Selected Section Already Assigned And Already Active!
                            </div>';
                          }
                      else if(isset($_GET['error2'])) {
                              
                             print '<div class="col-md-12" id="success">
                                     <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                   <span class="fa fa-remove"></span> &nbsp; | &nbsp;
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span></button>
                                  <strong>&nbsp;Error!</strong> The Selected Section Already Assigned And Already Not Active!
                            </div>';
                          }
                      
                      ?>
                      <br>
                        <div class="row" style="padding-left:5px;">
                        <input name="adviser_id" type="hidden" value ="<?php echo $adviser_id; ?>"/>
                        <input name="acad_year_start" type="hidden" value ="<?php echo $acad_year_start; ?>"/>
                        <input name="semester_ash" type="hidden" value ="<?php echo $semester_ash; ?>"/>
                        <input name="ash_id" type="hidden" value ="<?php echo $ash_id; ?>"/>
                         <div class="col-md-3">
                              <h5 >ADVISER NUMBER</h5>
                                <div class="form-group">
                                  <h5><?php echo $adviser_id; ?></h5>
                                </div>
                          </div>
                          <div class="col-md-3">
                               <h5 >ADVISER NAME</h5>
                                <div class="form-group">
                                  <h5><?php echo $lname." , ".$fname." ".$mname."."; ?></h5>
                                </div>
                          </div>
                           <div class="col-md-3"> 
                              <h5>SCHOOL YEAR</h5>
                                <div class="form-group">
                                  <h5><?php echo $acad_year_start." - " .$acad_year_end; ?></h5>
                                </div>
                          </div>
                          <div class="col-md-3"> </div>                    
                        </div>
                        
                        <br>
                        <div class="row" style="padding-left:5px;">
                          <div class="col-md-3"> 
                              <h5>PROGRAM</h5>
                                <div class="form-group">
                                  <h5><?php echo $program_code; ?></h5>
                                </div>
                          </div>
                               <div class="col-md-3">
                                <h5 style="padding-left:5px;">SEMESTER</h5>
                                <div class="form-group has-feedback">
								<?php
									$comstart1="";
									$comstart2="";
									$comstart3="";
									$comend="-->";
									
									if($semester=="1st Semester")
									{
										$comstart1="<!--";
									}
									else if($semester=="2nd Semester")
									{
										$comstart2="<!--";
									}
									else if($semester=="Summer")
									{
										$comstart3="<!--";
									}
								?>
                                   <select class="form-control" name="semester" id="semester" class="form-control" placeholder="Semester">
                                    <option value ="<?php echo $semester; ?>"><?php echo $semester; ?></option>
                                    <?php echo $comstart1;?><option value="1st Semester">1st Semester</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="2nd Semester">2nd Semester</option><?php echo $comend;?>
                                    <?php echo $comstart3?><option value="Summer">Summer</option><?php echo $comend;?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            $query_update_ojt_section_handled_status = "SELECT a.ojt_status FROM student_ojt_records AS a INNER JOIN adviser_section_handled AS b WHERE a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.section_id = b.section_id AND b.adviser_id = '$adviser_id' AND a.semester = '$semester_ash' AND a.acad_year_start = '$acad_year_start' AND a.section_id = '$section_id' AND b.semester = '$semester_ash' AND b.acad_year_start = '$acad_year_start' AND b.section_id = '$section_id' AND a.ojt_status = 'Ongoing'";
                            $result_update_ojt_section_handled_status = mysqli_query($dbc,$query_update_ojt_section_handled_status);
                            if($result_update_ojt_section_handled_status->num_rows>0){
                              while($row3 = mysqli_fetch_array($result_update_ojt_section_handled_status)){
                                $ojt_status2 = $row3[0];
                              }
                              print '<div class="col-md-3">   
                                <h5 style="padding-left:5px;">STATUS</h5>
                                <div class="form-group has-feedback">
                                  <h4>'.$status_ash.'</h4>
                                  <input type="hidden" name="status_ash" value='.$status_ash.'>
                                </div>
                            </div>';
                          }
                          else{
                             $Active = "Active";
                             $Not_Active = "Not Active";
							$comstart4="";
							$comstart5="";
							
							if($status_ash==$Active)
							{
								$comstart4="<!--";
							}
							else if($status_ash==$Not_Active)
							{
								$comstart5="<!--";
							}
                            print '<div class="col-md-3">   
                                <h5 style="padding-left:5px;">STATUS</h5>
                                <div class="form-group has-feedback">
                                   <select class="form-control" name="status_ash" id="status_ash" class="form-control" placeholder="Status">';
                                  
                                    echo  "<option value='".$status_ash."'>".$status_ash."</option>";
                                    echo  $comstart4."<option value='".$Active."'>".$Active."</option>".$comend;
                                    echo  $comstart5."<option value='".$Not_Active."'>".$Not_Active."</option>".$comend;
                                     print '</select>
                                </div>
                            
                           </div>';
                              
                            }
                            ?>
                           <div class="col-md-3">
                             <h5 style="padding-left:5px;">SECTION</h5>
                              <div class="form-group has-feedback">
                              <?php
                              $query_section_handled = "SELECT section_id,program_id,section FROM section_list WHERE status = 'Active' AND program_id = '$program_id' AND section_id != '1'";
                     
                              $result_section_handled = mysqli_query($dbc, $query_section_handled);
                              $num_rows2 = mysqli_num_rows($result_section_handled);
                              
                              print'<select class="form-control"  name="section_id" class="form-control">';
                              
                              echo "<option value='".$section_id."'>".$section."</option>";
                               while($row_pl = mysqli_fetch_array($result_section_handled)){
                                  
                                $section_id2 = $row_pl[0];
                                $program_code2 = $row_pl[1];
                                $section2= $row_pl[2];
								
								$comstart6="";
								if($section2==$section)
								{
									$comstart6="<!--";
								}
								
                                echo $comstart6."<option value='".$section_id2."'>".$section2."</option>".$comend;    
                              }
                              ?>
                              <?php
                              print '</select>';
                              ?>
                            </div>
                          </div>
                        </div>
                        <br>
                        <br>
                        
                         <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                             <button type="submit" class="btn btn-info btn-block" name="btn_update_ojt_adviser_section_handled" id="btn_update_ojt_adviser_section_handled"><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE</button>
                             </div>
                              <div class="col-md-4">
                               <a href="section_handled.php?adviser_id=<?php echo $adviser_id; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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
 $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                program_id: {
                    message: 'Program is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Program is required and can\'t be empty'
                        },
                    }
                },
                section_ard: {
                    validators: {
                        notEmpty: {
                            message: 'Section is required and can\'t be empty'
                        },
                    }
                },
                semester: {
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        },
                    },
                },
                 status_ash: {
                    validators: {
                        notEmpty: {
                            message: 'Status is required and can\'t be empty'
                        },
                    },
                },
            }
        }) 
  });
</script>
</body>
</html>