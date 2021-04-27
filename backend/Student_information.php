
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
if($usertype==2)
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

          $query_student_pendings ="SELECT count(stud_no) FROM student_checklist  WHERE remarks = 'Completed' and deliverable_id=7";
$result_student_pendings =  mysqli_query($dbc, $query_student_pendings);         
          if($result_student_pendings->num_rows > 0)
               {   
                while ($row_pendings = mysqli_fetch_array($result_student_pendings))
                   {
                     $query_student_pending ="SELECT count(stud_no),date_submitted FROM student_checklist  WHERE remarks = 'On process' and deliverable_id=5 ";
$result_student_pending =  mysqli_query($dbc, $query_student_pending);
$row_pending = mysqli_fetch_array($result_student_pending);

$day=$row_pending['date_submitted'];


$date=date("Y-m-d");
                     $query_student_pendingx ="SELECT a.stud_no,a.fname,a.mname,a.lname,mr.date_note,mr.stud_no from moa_remarks as mr left join student_info as a  on a.stud_no=mr.stud_no left join student_checklist as sc on sc.stud_no=mr.stud_no   where  
              mr.date_note <='$date' and  sc.remarks='On process' group by a.stud_no ";
$result_student_pendingx =  mysqli_query($dbc, $query_student_pendingx);
$row_pendingx = mysqli_fetch_array($result_student_pendingx);
$num_row=mysqli_num_rows($result_student_pendingx);


                      
                    }
              }
               print '<li class="dropdown avatar-dropdown">
                              <br>
                               
                              
                                                                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" 
                                style="padding:1px 1px 1px 1px;">
                                    <i class="glyphicon glyphicon-user" style="color:white;font-size:17px;"></i>
                                    <label style="font-size:15px;padding:2px 5px 2px 5px;" class="badge badge-danger"> '.$num_row.'</label></span>
                               <ul class="dropdown-menu user-dropdown">
                 <div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                                      <li>
                                        <a href="student_moa.php">
                                            There is/are  <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;"><label class="text-primary">  '.$num_row.' </label> Late M.O.A .
                                              </div>
                                      </a>
                                      </li>
                                        </div>
                       </ul></li>';

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
                        <h1 class="animated fadeInLeft">OJT STUDENTS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                           View and manage the students currently enrolled in an OJT course.
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>List of all Student</h3></div>
                     
                    <div class="row">
					
                      <div class="col-md-12">
					  
					  
					  
					  

                         <?php
                         if(isset($_GET['success2']) && isset($_GET['stud_no']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['mname'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $lname_up = $_GET['lname'];
                              $fname_up = $_GET['fname'];
                              $mname_up = $_GET['mname'];
                            print '<div class="col-md-12">
                              <div class="alert alert-info alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp; Student Number : '. $stud_no_up.' Student Name : '.$lname_up.', '.$fname_up.' '.$mname_up.' &nbsp; was Sucessfully Updated!</strong>
                               </div></div>';
                            }
                            if(isset($_GET['success']) && isset($_GET['stud_no']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['mname'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $lname_up = $_GET['lname'];
                              $fname_up = $_GET['fname'];
                              $mname_up = $_GET['mname'];
                            print '<div class="col-md-12">
                              <div class="alert alert-info alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp; Student Number : '. $stud_no_up.' Student Name : '.$lname_up.', '.$fname_up.' '.$mname_up.' &nbsp; was Sucessfully Updated!</strong>
                               </div></div>';
                            }
							else if(isset($_GET['registered']) && isset($_GET['stud_no']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['mname'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $lname_up = $_GET['lname'];
                              $fname_up = $_GET['fname'];
                              $mname_up = $_GET['mname'];
                            print '<div class="col-md-12">
                              <div class="alert alert-info alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp; Student Number : '. $stud_no_up.' Student Name : '.$lname_up.', '.$fname_up.' '.$mname_up.' &nbsp; is Sucessfully added!</strong>
                               </div></div>';
                            }
							else if(isset($_GET['registered2']) && isset($_GET['stud_no'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              
                            print '<div class="col-md-12">
                              <div class="alert alert-info alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp; Student Number : '. $stud_no_up.' &nbsp; is Sucessfully added!</strong>
                               </div></div>';
                            }
							$q_active_acad_smstr="SELECT * FROM active_semester_acad_year";
							$r_active_acad_smstr=mysqli_query($dbc, $q_active_acad_smstr);
							if(mysqli_num_rows($r_active_acad_smstr)>0)
							{
								$aas_row=mysqli_fetch_assoc($r_active_acad_smstr);
								$active_smstr = $aas_row['active_semester'];
								$active_acad_start = $aas_row['active_acad_year_start'];
								$active_acad_end = $aas_row['active_acad_year_end'];
							}
							/*---------------------------COUNT FOR BSIT--------------------------------------------*/
							$q_bsit="SELECT COUNT(*) AS bsit FROM student_info AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='1' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
							$r_bsit=mysqli_query($dbc,$q_bsit);
							if(mysqli_num_rows($r_bsit)>0)
							{
								$bsit_row=mysqli_fetch_assoc($r_bsit);
								$bsit = $bsit_row['bsit'];
							}
							/*---------------------------COUNT FOR BSCS--------------------------------------------*/
							$q_bscs="SELECT COUNT(*) AS bscs FROM student_info AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='22' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
							$r_bscs=mysqli_query($dbc,$q_bscs);
							if(mysqli_num_rows($r_bscs)>0)
							{
								$bscs_row=mysqli_fetch_assoc($r_bscs);
								$bscs = $bscs_row['bscs'];
							}
							/*---------------------------COUNT FOR BSAT--------------------------------------------*/
							$q_bsat="SELECT COUNT(*) AS bsat FROM student_info AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='5' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
							$r_bsat=mysqli_query($dbc,$q_bsat);
							if(mysqli_num_rows($r_bsat)>0)
							{
								$bsat_row=mysqli_fetch_assoc($r_bsat);
								$bsat = $bsat_row['bsat'];
							}
							/*---------------------------COUNT FOR BSTM--------------------------------------------*/
							$q_bstm="SELECT COUNT(*) AS bstm FROM student_info AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='4' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
							$r_bstm=mysqli_query($dbc,$q_bstm);
							if(mysqli_num_rows($r_bstm)>0)
							{
								$bstm_row=mysqli_fetch_assoc($r_bstm);
								$bstm = $bstm_row['bstm'];
							}
							/*---------------------------COUNT FOR BSHRM--------------------------------------------*/
							$q_bshrm="SELECT COUNT(*) AS bshrm FROM student_info AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='3' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
							$r_bshrm=mysqli_query($dbc,$q_bshrm);
							if(mysqli_num_rows($r_bshrm)>0)
							{
								$bshrm_row=mysqli_fetch_assoc($r_bshrm);
								$bshrm = $bshrm_row['bshrm'];
							}
							/*---------------------------COUNT FOR BSBM--------------------------------------------*/
							$q_bsbm="SELECT COUNT(*) AS bsbm FROM student_info AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='2' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
							$r_bsbm=mysqli_query($dbc,$q_bsbm);
							if(mysqli_num_rows($r_bsbm)>0)
							{
								$bsbm_row=mysqli_fetch_assoc($r_bsbm);
								$bsbm = $bsbm_row['bsbm'];
							}
							/*---------------------------COUNT FOR BSCPE--------------------------------------------*/
							$q_bscpe="SELECT COUNT(*) AS bscpe FROM student_info AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='8' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
							$r_bscpe=mysqli_query($dbc,$q_bscpe);
							if(mysqli_num_rows($r_bscpe)>0)
							{
								$bscpe_row=mysqli_fetch_assoc($r_bscpe);
								$bscpe = $bscpe_row['bscpe'];
							}
							/*---------------------------COUNT FOR ABCOM--------------------------------------------*/
							$q_abcom="SELECT COUNT(*) AS abcom FROM student_info AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='9' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
							$r_abcom=mysqli_query($dbc,$q_abcom);
							if(mysqli_num_rows($r_abcom)>0)
							{
								$abcom_row=mysqli_fetch_assoc($r_abcom);
								$abcom = $abcom_row['abcom'];
							}
							
							/*---------------------------COUNT FOR BSIT--------------------------------------------*/
							$enq_bsit="SELECT COUNT(*) AS bsit FROM endorsement AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='1' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end' AND a.status = 'Active'";
							$enr_bsit=mysqli_query($dbc,$enq_bsit);
							if(mysqli_num_rows($enr_bsit)>0)
							{
								$enbsit_row=mysqli_fetch_assoc($enr_bsit);
								$enbsit = $enbsit_row['bsit'];
							}
							/*---------------------------COUNT FOR BSCS--------------------------------------------*/
							$enq_bscs="SELECT COUNT(*) AS bscs FROM endorsement AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='22' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end' AND a.status = 'Active'";
							$enr_bscs=mysqli_query($dbc,$enq_bscs);
							if(mysqli_num_rows($enr_bscs)>0)
							{
								$enbscs_row=mysqli_fetch_assoc($enr_bscs);
								$enbscs = $enbscs_row['bscs'];
							}
							/*---------------------------COUNT FOR BSAT--------------------------------------------*/
							$enq_bsat="SELECT COUNT(*) AS bsat FROM endorsement AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='5' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end' AND a.status = 'Active'";
							$enr_bsat=mysqli_query($dbc,$enq_bsat);
							if(mysqli_num_rows($enr_bsat)>0)
							{
								$enbsat_row=mysqli_fetch_assoc($enr_bsat);
								$enbsat = $enbsat_row['bsat'];
							}
							/*---------------------------COUNT FOR BSTM--------------------------------------------*/
							$enq_bstm="SELECT COUNT(*) AS bstm FROM endorsement AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='4' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end' AND a.status = 'Active'";
							$enr_bstm=mysqli_query($dbc,$enq_bstm);
							if(mysqli_num_rows($enr_bstm)>0)
							{
								$enbstm_row=mysqli_fetch_assoc($enr_bstm);
								$enbstm = $enbstm_row['bstm'];
							}
							/*---------------------------COUNT FOR BSHRM--------------------------------------------*/
							$enq_bshrm="SELECT COUNT(*) AS bshrm FROM endorsement AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='3' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end' AND a.status = 'Active'";
							$enr_bshrm=mysqli_query($dbc,$enq_bshrm);
							if(mysqli_num_rows($enr_bshrm)>0)
							{
								$enbshrm_row=mysqli_fetch_assoc($enr_bshrm);
								$enbshrm = $enbshrm_row['bshrm'];
							}
							/*---------------------------COUNT FOR BSBM--------------------------------------------*/
							$enq_bsbm="SELECT COUNT(*) AS bsbm FROM endorsement AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='2' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end' AND a.status = 'Active'";
							$enr_bsbm=mysqli_query($dbc,$enq_bsbm);
							if(mysqli_num_rows($enr_bsbm)>0)
							{
								$enbsbm_row=mysqli_fetch_assoc($enr_bsbm);
								$enbsbm = $enbsbm_row['bsbm'];
							}
							/*---------------------------COUNT FOR BSCPE--------------------------------------------*/
							$enq_bscpe="SELECT COUNT(*) AS bscpe FROM endorsement AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='8' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end' AND a.status = 'Active'";
							$enr_bscpe=mysqli_query($dbc,$enq_bscpe);
							if(mysqli_num_rows($enr_bscpe)>0)
							{
								$enbscpe_row=mysqli_fetch_assoc($enr_bscpe);
								$enbscpe = $enbscpe_row['bscpe'];
							}
							/*---------------------------COUNT FOR ABCOM--------------------------------------------*/
							$enq_abcom="SELECT COUNT(*) AS abcom FROM endorsement AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no=b.stud_no AND program_id='9' AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end' AND a.status = 'Active'";
							$enr_abcom=mysqli_query($dbc,$enq_abcom);
							if(mysqli_num_rows($enr_abcom)>0)
							{
								$enabcom_row=mysqli_fetch_assoc($enr_abcom);
								$enabcom = $enabcom_row['abcom'];
							}
							
							/*---------------------------COUNT FOR BSIT FINISHED--------------------------------------------*/
							$fiq_bsit="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '1' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Finished' AND A.enrollment_status = 'Enrolled'";
							$fir_bsit=mysqli_query($dbc,$fiq_bsit);
							if(mysqli_num_rows($fir_bsit)>0)
							{
								$fibsit_row=mysqli_fetch_assoc($fir_bsit);
								$finish_BSIT = $fibsit_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSCS FINISHED--------------------------------------------*/
							$fiq_bscs="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '2' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Finished' AND A.enrollment_status = 'Enrolled'";
							$fir_bscs=mysqli_query($dbc,$fiq_bscs);
							if(mysqli_num_rows($fir_bscs)>0)
							{
								$fibscs_row=mysqli_fetch_assoc($fir_bscs);
								$finish_BSCS = $fibscs_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSAT FINISHED--------------------------------------------*/
							$fiq_bsat="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '3' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Finished' AND A.enrollment_status = 'Enrolled'";
							$fir_bsat=mysqli_query($dbc,$fiq_bsat);
							if(mysqli_num_rows($fir_bsat)>0)
							{
								$fibsat_row=mysqli_fetch_assoc($fir_bsat);
								$finish_BSAT = $fibsat_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSTM FINISHED--------------------------------------------*/
							$fiq_bstm="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '4' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Finished' AND A.enrollment_status = 'Enrolled'";
							$fir_bstm=mysqli_query($dbc,$fiq_bstm);
							if(mysqli_num_rows($fir_bstm)>0)
							{
								$fibstm_row=mysqli_fetch_assoc($fir_bstm);
								$finish_BSTM = $fibstm_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSHRM FINISHED--------------------------------------------*/
							$fiq_bshrm="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '5' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Finished' AND A.enrollment_status = 'Enrolled'";
							$fir_bshrm=mysqli_query($dbc,$fiq_bshrm);
							if(mysqli_num_rows($fir_bshrm)>0)
							{
								$fibshrm_row=mysqli_fetch_assoc($fir_bshrm);
								$finish_BSHRM = $fibshrm_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSBM FINISHED--------------------------------------------*/
							$fiq_bsbm="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '6' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Finished' AND A.enrollment_status = 'Enrolled'";
							$fir_bsbm=mysqli_query($dbc,$fiq_bsbm);
							if(mysqli_num_rows($fir_bsbm)>0)
							{
								$fibsbm_row=mysqli_fetch_assoc($fir_bsbm);
								$finish_BSBM = $fibsbm_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSCPE FINISHED--------------------------------------------*/
							$fiq_bscpe="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '7' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Finished' AND A.enrollment_status = 'Enrolled'";
							$fir_bscpe=mysqli_query($dbc,$fiq_bscpe);
							if(mysqli_num_rows($fir_bscpe)>0)
							{
								$fibscpe_row=mysqli_fetch_assoc($fir_bscpe);
								$finish_BSCPE = $fibscpe_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR ABCOM FINISHED--------------------------------------------*/
							$fiq_abcom="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '8' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Finished' AND A.enrollment_status = 'Enrolled'";
							$fir_abcom=mysqli_query($dbc,$fiq_abcom);
							if(mysqli_num_rows($fir_abcom)>0)
							{
								$fiabcom_row=mysqli_fetch_assoc($fir_abcom);
								$finish_ABCOM = $fiabcom_row['finishOJT'];
							}
							
								/*---------------------------COUNT FOR BSIT ONGOING--------------------------------------------*/
							$ofiq_bsit="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '1' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Ongoing' AND A.enrollment_status = 'Enrolled'";
							$ofir_bsit=mysqli_query($dbc,$ofiq_bsit);
							if(mysqli_num_rows($ofir_bsit)>0)
							{
								$ofibsit_row=mysqli_fetch_assoc($ofir_bsit);
								$ofinish_BSIT = $ofibsit_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSCS ONGOING--------------------------------------------*/
							$ofiq_bscs="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '2' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Ongoing' AND A.enrollment_status = 'Enrolled'";
							$ofir_bscs=mysqli_query($dbc,$ofiq_bscs);
							if(mysqli_num_rows($ofir_bscs)>0)
							{
								$ofibscs_row=mysqli_fetch_assoc($ofir_bscs);
								$ofinish_BSCS = $ofibscs_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSAT ONGOING--------------------------------------------*/
							$ofiq_bsat="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '3' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Ongoing' AND A.enrollment_status = 'Enrolled'";
							$ofir_bsat=mysqli_query($dbc,$ofiq_bsat);
							if(mysqli_num_rows($ofir_bsat)>0)
							{
								$ofibsat_row=mysqli_fetch_assoc($ofir_bsat);
								$ofinish_BSAT = $ofibsat_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSTM ONGOING--------------------------------------------*/
							$ofiq_bstm="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '4' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Ongoing' AND A.enrollment_status = 'Enrolled'";
							$ofir_bstm=mysqli_query($dbc,$ofiq_bstm);
							if(mysqli_num_rows($ofir_bstm)>0)
							{
								$ofibstm_row=mysqli_fetch_assoc($ofir_bstm);
								$ofinish_BSTM = $ofibstm_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSHRM ONGOING--------------------------------------------*/
							$ofiq_bshrm="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '5' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Ongoing' AND A.enrollment_status = 'Enrolled'";
							$ofir_bshrm=mysqli_query($dbc,$ofiq_bshrm);
							if(mysqli_num_rows($ofir_bshrm)>0)
							{
								$ofibshrm_row=mysqli_fetch_assoc($ofir_bshrm);
								$ofinish_BSHRM = $ofibshrm_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSBM ONGOING--------------------------------------------*/
							$ofiq_bsbm="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '6' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Ongoing' AND A.enrollment_status = 'Enrolled'";
							$ofir_bsbm=mysqli_query($dbc,$ofiq_bsbm);
							if(mysqli_num_rows($ofir_bsbm)>0)
							{
								$ofibsbm_row=mysqli_fetch_assoc($ofir_bsbm);
								$ofinish_BSBM = $ofibsbm_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR BSCPE ONGOING--------------------------------------------*/
							$ofiq_bscpe="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '7' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Ongoing' AND A.enrollment_status = 'Enrolled'";
							$ofir_bscpe=mysqli_query($dbc,$ofiq_bscpe);
							if(mysqli_num_rows($ofir_bscpe)>0)
							{
								$ofibscpe_row=mysqli_fetch_assoc($ofir_bscpe);
								$ofinish_BSCPE = $ofibscpe_row['finishOJT'];
							}
							
							/*---------------------------COUNT FOR ABCOM ONGOING--------------------------------------------*/
							$ofiq_abcom="SELECT COUNT(*) AS finishOJT FROM student_ojt_records AS A JOIN student_info AS D WHERE D.stud_no = A.stud_no AND D.program_id = '8' AND A.acad_year_start = '$active_acad_start' AND A.acad_year_end = '$active_acad_end' AND A.semester = '$active_smstr' AND A.ojt_status = 'Ongoing' AND A.enrollment_status = 'Enrolled'";
							$ofir_abcom=mysqli_query($dbc,$ofiq_abcom);
							if(mysqli_num_rows($ofir_abcom)>0)
							{
								$ofiabcom_row=mysqli_fetch_assoc($ofir_abcom);
								$ofinish_ABCOM = $ofiabcom_row['finishOJT'];
							}
							
					
                            ?>
<!--PANEL -->
				<div id="tabsDemo4Content" class="tab-content tab-content-v3">
				
                    <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
                  
					<ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3 " role="tablist">
                        <li role="presentation" class="active">
                          <a href="#tabs-demo3-area1" id="tabs-demo3-1" role="tab" data-toggle="tab" aria-expanded="true">REGISTERED</a>
                        </li>
                        <li role="presentation" class="">
                          <a href="#tabs-demo3-area2" role="tab" id="tabs-demo3-2" data-toggle="tab" aria-expanded="false">ENDORSED</a>
                        </li>
						 <li role="presentation" class="">
                          <a href="#tabs-demo3-area4" role="tab" id="tabs-demo3-4" data-toggle="tab" aria-expanded="false">ONGOING</a>
                        </li>
						 <li role="presentation" class="">
                          <a href="#tabs-demo3-area3" role="tab" id="tabs-demo3-3" data-toggle="tab" aria-expanded="false">FINISHED</a>
                        </li>
						
                    </ul>
					
                      <div id="tabsDemo3Content" class="tab-content tabs-content-v2">
                        
						<div role="tabpanel" class="tab-pane fade active in" id="tabs-demo3-area1" aria-labelledby="tabs-demo3-area1">
                          <div class="panel box-v7">
                            <div class="panel-body">
                              
									<div class="row" style="padding-top:20px;">
						<div class="col-md-12">
						<h4 class="text-center"><strong>NUMBER OF REGISTERED STUDENTS (<?php echo $active_smstr." ".$active_acad_start."-".$active_acad_end;?>)</strong></h4>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"><h4><strong>BSIT: <?php echo $bsit;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSCS: <?php echo $bscs;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSAT: <?php echo $bsat;?></strong></h4></div>
						<div class="col-md-2"><h4><strong>BSTM: <?php echo $bstm;?></strong></h4></div>
						<!--
						<div class="col-md-3"><h4><a href="#" data-toggle="modal" data-target="#showStudentModal" data-idtrig="1" data-course="1"><strong>BSIT: <?php echo $bsit;?></strong></h4></a></div>
						<div class="col-md-3"><h4><a href="#" data-toggle="modal" data-target="#showStudentModal" data-idtrig="1" data-course="2"><strong>BSCS: <?php echo $bscs;?></strong></h4></a></div>
						<div class="col-md-3"><h4><a href="#" data-toggle="modal" data-target="#showStudentModal" data-idtrig="1" data-course="3"><strong>BSAT: <?php echo $bsat;?></strong></h4></a></div>
						<div class="col-md-2"><h4><a href="#" data-toggle="modal" data-target="#showStudentModal" data-idtrig="1" data-course="4"><strong>BSTM: <?php echo $bstm;?></strong></h4></a></div>
						-->
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"><h4><strong>BSHRM: <?php echo $bshrm;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSBM: <?php echo $bsbm;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSCPE: <?php echo $bscpe;?></strong></h4></div>
						<div class="col-md-2"><h4><strong>ABCOMM: <?php echo $abcom;?></strong></h4></div>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"></div>
						<div class="col-md-6">
						<h4><strong>
						<!--<a href="#" data-toggle="modal" data-target="#ShowRegisteredStudent">Show all registered student</a>-->
						</strong></hr>
						</div>
						
						<div class="modal fade" id="ShowRegisteredStudent" role="dialog">
							<div class="modal-dialog modal-lg">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Registered Student</h4>
									</div>
									<div class="modal-body">
										
										<div class="panel-body">

										  <div class="responsive-table">
										  <table id="registedStudentAll" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
										  <thead>
											<tr>
												<th class="text-center">STUDENT NUMBER</th>
												<th class="text-center">FULL NAME</th>   
												<th class="text-center">PROGRAM</th>
											                   
											</tr>
											</thead>
										  <tbody>
									
										<?php
									//	$query_studList = "SELECT a.stud_no AS stud_no, CONCAT(a.lname,', ',a.fname,' ',a.mname) AS fullname,c.program_code AS course FROM student_info AS a INNER JOIN student_ojt_records AS b INNER JOIN program_list AS c WHERE c.program_id = a.program_id AND a.stud_no=b.stud_no AND b.semester='$active_smstr' AND b.acad_year_start='$active_acad_start' AND b.acad_year_end='$active_acad_end'";
													
									//	$result_studList = mysqli_query($dbc, $query_studList);
									//	$nr = mysqli_num_rows($result_studList);
											 
									//	print'';
									//	  
									//	  while($r_m = mysqli_fetch_array($result_studList)) {
										  
									//		$studno = $r_m[0];
									//		$fullname = $r_m[1];
									//		$course = $r_m[2];
											
										
										  ?>
										  <tr>
											<td><?php //echo $studno; ?></td>
											<td><?php //echo $fullname ?></td>
											<td><?php// echo $course; ?></td>
											
										  </tr>
										  </tbody>

										  <?php// }?>
										 </table>
										 </div>
										 </div>
									
									</div>
								 </div>
								  
							</div>
						</div>
						
						<!--
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						-->
						<h4 class="col-md-2"><strong>TOTAL: <?php $TOTALREGISTERED = $bsit + $bscs + $bsat + $bstm + $bshrm + $bsbm + $bscpe + $abcom ; echo $TOTALREGISTERED;  ?></strong></h4>
						</div>
						</div>

                            </div>
                          </div>
                        </div>
						
                        <div role="tabpanel" class="tab-pane fade" id="tabs-demo3-area2" aria-labelledby="tabs-demo3-area2">
                          <div class="panel box-v7">
                            <div class="panel-body">
                         
									<div class="row" style="padding-top:20px;">
						<div class="col-md-12">
						<h4 class="text-center"><strong>NUMBER OF ENDORSED STUDENTS (<?php echo $active_smstr." ".$active_acad_start."-".$active_acad_end;?>)</strong></h4>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"><h4><strong>BSIT: <?php echo $enbsit;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSCS: <?php echo $enbscs;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSAT: <?php echo $enbsat;?></strong></h4></div>
						<div class="col-md-2"><h4><strong>BSTM: <?php echo $enbstm;?></strong></h4></div>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"><h4><strong>BSHRM: <?php echo $enbshrm;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSBM: <?php echo $enbsbm;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSCPE: <?php echo $enbscpe;?></strong></h4></div>
						<div class="col-md-2"><h4><strong>ABCOMM: <?php echo $enabcom;?></strong></h4></div>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<h4 class="col-md-2"><strong>TOTAL: <?php $TOTALen = $enbsit + $enbscs + $enbsat + $enbstm + $enbshrm + $enbsbm + $enbscpe + $enabcom ; echo $TOTALen;  ?></strong></h4>
						
						</div>
                              </div>
                            </div>
                          </div>
                        </div>
						
						<div role="tabpanel" class="tab-pane fade" id="tabs-demo3-area3" aria-labelledby="tabs-demo3-area3">
                          <div class="panel box-v7">
                            <div class="panel-body">
                              
									<div class="row" style="padding-top:20px;">
						<div class="col-md-12">
						<h4 class="text-center"><strong>NUMBER OF FINISHED STUDENTS (<?php echo $active_smstr." ".$active_acad_start."-".$active_acad_end;?>)</strong></h4>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"><h4><strong>BSIT: <?php echo $finish_BSIT;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSCS: <?php echo $finish_BSCS;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSAT: <?php echo $finish_BSAT;?></strong></h4></div>
						<div class="col-md-2"><h4><strong>BSTM: <?php echo $finish_BSTM;?></strong></h4></div>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"><h4><strong>BSHRM: <?php echo $finish_BSHRM;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSBM: <?php echo $finish_BSBM;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSCPE: <?php echo $finish_BSCPE;?></strong></h4></div>
						<div class="col-md-2"><h4><strong>ABCOMM: <?php echo $finish_ABCOM;?></strong></h4></div>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<h4 class="col-md-2"><strong>TOTAL: <?php $TOTALFINISHED = $finish_BSIT + $finish_BSCS + $finish_BSAT + $finish_BSTM + $finish_BSHRM + $finish_BSBM + $finish_BSCPE + $finish_ABCOM ; echo $TOTALFINISHED;  ?></strong></h4>
						</div>
						</div>
							</div>
							</div>
						</div>
						
						<div role="tabpanel" class="tab-pane fade" id="tabs-demo3-area4" aria-labelledby="tabs-demo3-area4">
                          <div class="panel box-v7">
                            <div class="panel-body">
                              
														<div class="row" style="padding-top:20px;">
						<div class="col-md-12">
						<h4 class="text-center"><strong>NUMBER OF ONGOING STUDENTS (<?php echo $active_smstr." ".$active_acad_start."-".$active_acad_end;?>)</strong></h4>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"><h4><strong>BSIT: <?php echo $ofinish_BSIT;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSCS: <?php echo $ofinish_BSCS;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSAT: <?php echo $ofinish_BSAT;?></strong></h4></div>
						<div class="col-md-2"><h4><strong>BSTM: <?php echo $ofinish_BSTM;?></strong></h4></div>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"><h4><strong>BSHRM: <?php echo $ofinish_BSHRM;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSBM: <?php echo $ofinish_BSBM;?></strong></h4></div>
						<div class="col-md-3"><h4><strong>BSCPE: <?php echo $ofinish_BSCPE;?></strong></h4></div>
						<div class="col-md-2"><h4><strong>ABCOMM: <?php echo $ofinish_ABCOM;?></strong></h4></div>
						</div>
						<div class="col-md-12">
						<div class="col-md-1"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<h4 class="col-md-2"><strong>TOTAL: <?php $TOTALONGOING = $ofinish_BSIT + $ofinish_BSCS + $ofinish_BSAT + $ofinish_BSTM + $ofinish_BSHRM + $ofinish_BSBM + $ofinish_BSCPE + $ofinish_ABCOM ; echo $TOTALONGOING;  ?></strong></h4>
						</div>
						</div>
									
							</div>
							</div>
						</div>
					
					
                      </div>
                    </div>
                    
					
                  </div><!-- panel -->
				  
				  <div id="showStudentModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>


	 <div class="modal-body">
			<input type="text" name="kurso" id ="kurso" ></input>
	 
	 
	 
		<?php
		echo $kurso;
		
		
		
									//	$query_studList = "SELECT a.stud_no, a.date_created, a.status, d.lname, d.fname, d.mname, c.program_code FROM endorsement AS a JOIN adviser_info AS b JOIN program_list AS c JOIN student_info AS d JOIN student_ojt_records as E WHERE a.comp_id='$comp_id2' AND b.adviser_id = a.adviser_id AND c.program_id = a.program_id AND d.stud_no=a.stud_no AND a.status='Active' AND a.stud_no = e.stud_no AND e.ojt_status='Ongoing' GROUP BY a.stud_no";
									/*
									$query_studList = "SELECT a.stud_no, a.date_created, a.status, d.lname, d.fname, d.mname, c.program_code FROM endorsement AS a JOIN adviser_info AS b JOIN program_list AS c JOIN student_info AS d JOIN student_ojt_records as Ee WHERE a.comp_id='$comp_id2' AND b.adviser_id = a.adviser_id AND c.program_id = a.program_id AND d.stud_no=a.stud_no AND a.status='Active' AND a.stud_no = Ee.stud_no AND Ee.ojt_status='Ongoing' GROUP BY a.stud_no";
																			
									$result_studList = mysqli_query($dbc, $query_studList);
										$nr = mysqli_num_rows($result_studList);
										 
									
									  print'<div class="panel-body">

									  <div class="responsive-table">
									  <table id="showStudentDATATABLES" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
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
									  */
									  ?>
							<!--		  <tr>
									<td><?php echo $studNo; ?></td>
										<td><?php echo $lname.", ".$fname." ".$mname; ?></td>
										<td><?php echo $progCode; ?></td>
										<td><?php echo $dateIssue; ?></td>
										<td><?php echo $staTus; ?></td>
									  </tr>
									  </tbody>
-->
									  <?php //}?>
									 <!--</table>
									 </div>
									 </div>-->
		
		
	  </div>
      
      <div class="modal-footer">
			<button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

				  
                            

                        </div>
						
						
						
                        </div>
						
		
						<div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                            <div class="col-md-2">
                                      <a href="check_student_number.php">
                                       <button class="btn btn-success btn-outline btn-block btn-sm">
                                            <span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                      </button>
                                      </a>
                            </div>
							<div class="col-md-2">
                                      <a href="student_resume_data.php">
                                       <button class="btn btn-primary btn-outline btn-block btn-sm">
                                            <span class="fa fa-file-word-o"></span> &nbsp; RESUME &nbsp;
                                      </button>
                                      </a>
                            </div>
							<div class="col-md-2">
                                      <a href="student_master_list.php">
                                       <button class="btn btn-warning btn-outline btn-block btn-sm">
                                            <span class="glyphicon glyphicon-tasks"></span> &nbsp; RECORDS &nbsp;
                                      </button>
                                      </a>
                            </div>
							<div class="col-md-2">
                                      <a href="student_ojt_master_list.php">
                                       <button class="btn btn-danger btn-outline btn-block btn-sm">
                                            <span class="fa fa-server"></span> &nbsp; PROGRESS &nbsp;
                                      </button>
                                      </a>
                                   
                            </div>
  <div class="col-md-2">
                                      <a href="student_to_finish.php">
                                       <button class="btn btn-warning btn-outline btn-block btn-sm">
                                            <span class="glyphicon glyphicon-tasks"></span> &nbsp; TO FINISHED &nbsp;
                                      </button>
                                      </a>
                                         <?php include('legend.php');   ?>
                            </div>
                            <div class="col-md-2"></div>
                             <div class="col-md-4">
                             <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>							
                          </div>						  
                        </div>						
                      <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                               <div class="col-md-8"></div>
                             <div class="col-md-4">
                             <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                          </div>
                        </div>           
                      
                     <div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                         <th class="col-md-1"></th>
                         <th class="text-center">STUDENT NUMBER</th>
                         <th class="text-center">LAST NAME</th>
                         <th class="text-center">FIRST NAME</th>
                         <th class="text-center">MIDDLE NAME</th> 
                         <th class="text-center" style="width:120px;">ACTION</th> 
                        </tr>
                      </thead>
                      <tbody>
					  </tbody>
                     </table>
                     </div>
                     </div>
                  </div>
                </div>
              </div>
            </div><!-- end: content -->
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
$('#showStudentModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) ;
  var idtrig = button.data('idtrig') ;
  var course = button.data('course') ;
  var modal = $(this);
 // modal.find('.modal-title').text('Lead Number ' + id);
 
 var program = "";
	if(course == 1)
	{
		program = "BSIT";
	}else if(course == 2)
	{
		program = "BSCS";
	}else if(course == 3)
	{
		program = "BSAT";
	}else if(course == 4)
	{
		program = "BSTM";
	}else if(course == 5)
	{
		program = "BSHRM";
	}else if(course == 6)
	{
		program = "BSBM";
	}else if(course == 7)
	{
		program = "BSCPE";
	}else if(course == 8)
	{
		program = "ABCOMM";
	}
 
 var title = "";
	if(idtrig == 1)
	{
		title = "List of Registered Student ("+program+")"; 
	}else if(idtrig == 2)
	{
		title = "List of Endorsed Student ("+ program+")"; 
	}else if(idtrig == 3)
	{
		title = "List of Finished OJT ("+ program+")"; 
	}else if(idtrig == 4)
	{
		title = "List of Ongoing OJT ("+ program+")"; 
	}
 
  modal.find('.modal-title').text(title);
  modal.find('#kurso').val(course);
  
  $kurso = course;
  
})



  $(document).ready(function(){
	  
	var registedStudentAlxl = $('#registedStudentAll').DataTable();
    var table = $('#datatables').DataTable({
       "processing": true,
        "serverSide": true,
        "ajax": "server_processing_student_info.php",
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        }
    });
    $.fn.dataTable.ext.errMode = function(settings,helpPage,message){
    table.ajax.reload(null, false);
	
  }
  });
</script>
<!-- end: Javascript -->

</body>
</html>