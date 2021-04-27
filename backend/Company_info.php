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
      $title2 = $row2["title"];
      $fname2 = $row2["fname"];
    }
}
if($usertype!=1)
{
  header("Location: adviser_home.php");
}
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");

$close_to_expired = date("m/d/Y", strtotime('+3 months'));
$close_to_expired2 = date("Y-m-d", strtotime('+3 months'));

    $query_unread = "SELECT * FROM company_info";
    $result_unread = $dbc->query($query_unread);
    if($result_unread->num_rows > 0 ){
      while($rows_status = $result_unread->fetch_assoc()){
       $comp_id_status = $rows_status["comp_id"];
       $date_expiry_status = $rows_status["date_expiry"];
       $notify_status = $rows_status["notify_status"];

       if($date_expiry_status == $date_today && $notify_status == "none") {
          
         $q_updateStatus2 = "UPDATE company_info SET notify_status ='unread' WHERE comp_id='$comp_id_status' ";
         $result_comp_info_status2 = mysqli_query($dbc,$q_updateStatus2);     
         }
      }
    }

    $query_update_comp_data = "SELECT * FROM company_info";
    $result_update_comp_data = $dbc->query($query_update_comp_data);
    if($result_update_comp_data->num_rows > 0 ){
      while($rows_data = $result_update_comp_data->fetch_assoc()){
       $comp_id_status = $rows_data["comp_id"];
       $date_expiry_status = $rows_data["date_expiry"];
       $notify_status = $rows_data["notify_status"];

       if($date_expiry_status == $date_today) {
          
         //matic not actve ung compny ,ojt offers(Not Available) comp program not active
        $q_update_comp_info="UPDATE company_info set status='Not Active', remarks = 'expired MOA' WHERE comp_id='$comp_id_status'";
        $q_update_comp_info_res = mysqli_query($dbc,$q_update_comp_info);
        
        $q_update_comp_program ="UPDATE company_program set comp_program_status='Not Active' WHERE comp_id='$comp_id_status'";
        $q_update_comp_program_res = mysqli_query($dbc,$q_update_comp_program);
        
        $q_update_ojt_offers="UPDATE ojt_offers set status='Not Available' WHERE comp_id='$comp_id_status'";
        $q_update_ojt_offers_res = mysqli_query($dbc,$q_update_ojt_offers);
    
         }
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
  //resume pending
 $query_resume_pending ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '1'";
  $result_resume_pending =  mysqli_query($dbc, $query_resume_pending);         
          if($result_resume_pending->num_rows > 0)
               {   
                while ($row_pending = mysqli_fetch_array($result_resume_pending))
                   {
                     $count_resume_pending = $row_pending[0];      
                    }
              }
//count with moa              
$query_wm = "SELECT COUNT(remarks) as withmoa from company_info WHERE remarks = 'with MOA'";
$result_query_wm =  mysqli_query($dbc, $query_wm);         
  if($result_query_wm->num_rows > 0)
       {   
        while ($row_wm = mysqli_fetch_array($result_query_wm))
           {
             $count_wm = $row_wm[0];      
            }
      }
//count without moa              
$query_wom = "SELECT COUNT(remarks) as withmoa from company_info WHERE remarks = 'without MOA'";
$result_query_wom =  mysqli_query($dbc, $query_wom);         
  if($result_query_wm->num_rows > 0)
       {   
        while ($row_wom = mysqli_fetch_array($result_query_wom))
           {
             $count_wom = $row_wom[0];      
            }
      }
//count with hte
$query_hte = "SELECT COUNT(remarks) as hte from company_info WHERE remarks = 'with HTE Training'";
$result_query_hte =  mysqli_query($dbc, $query_hte);         
  if($result_query_hte->num_rows > 0)
       {   
        while ($row_hte = mysqli_fetch_array($result_query_hte))
           {
             $count_hte = $row_hte[0];      
            }
      }
//count with ffu
$query_ffu = "SELECT COUNT(remarks) as ffu from company_info WHERE remarks = 'for follow up'";
$result_query_ffu =  mysqli_query($dbc, $query_ffu);         
  if($result_query_ffu->num_rows > 0)
       {   
        while ($row_ffu = mysqli_fetch_array($result_query_ffu))
           {
             $count_ffu = $row_ffu[0];      
            }
      }
//count with fn
$query_fn = "SELECT COUNT(remarks) as fn from company_info WHERE remarks = 'for Notary'";
$result_query_fn =  mysqli_query($dbc, $query_fn);         
  if($result_query_fn->num_rows > 0)
       {   
        while ($row_fn = mysqli_fetch_array($result_query_fn))
           {
             $count_fn = $row_fn[0];      
            }
      }
//count with banned
$query_b = "SELECT COUNT(remarks) as bn from company_info WHERE remarks = 'Banned'";
$result_query_b =  mysqli_query($dbc, $query_b);         
  if($result_query_b->num_rows > 0)
       {   
        while ($row_b = mysqli_fetch_array($result_query_b))
           {
             $count_b = $row_b[0];      
            }
      }
//count with expired moa
$query_em = "SELECT COUNT(remarks) as em from company_info WHERE remarks = 'expired MOA'";
$result_query_em =  mysqli_query($dbc, $query_em);         
  if($result_query_em->num_rows > 0)
       {   
        while ($row_em = mysqli_fetch_array($result_query_em))
           {
             $count_em = $row_em[0];      
            }
      }
//count cte
$query_cte = "SELECT comp_id,COUNT(date_expiry) as cte from company_info WHERE date_expiry = '$close_to_expired2'";
$result_query_cte =  mysqli_query($dbc, $query_cte);         
  if($result_query_cte->num_rows > 0)
       {   
        while ($row_cte = mysqli_fetch_array($result_query_cte))
           {
            $comp_id_cte_count = $row_cte[0];
            $count_cte = $row_cte[1];
            $q_updateStatus_cte = "UPDATE company_info SET remarks ='Close to Expired MOA' WHERE comp_id='$comp_id_cte_count'";                   
            }
      }
//count cte_count
$query_cte_count = "SELECT COUNT(remarks) as cte_count from company_info WHERE remarks = 'Close to Expired MOA'";
$result_query_cte_count =  mysqli_query($dbc, $query_cte_count);         
  if($result_query_cte_count->num_rows > 0)
       {   
        while ($row_cte_count = mysqli_fetch_array($result_query_cte_count))
           {
            $comp_id_cte = $row_cte_count[0];
            }
      } 
                      
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    td.withMOA {
        font-weight: bold;
        color: #00b300;  
    }
    td.forfollowup {
        font-weight: bold;
        color: #804000;  
    }
    td.withoutMOA {
        font-weight: bold;
        color: #000000;  
    }
    td.fornotary {
        font-weight: bold;
        color: #6b6b47;  
    }
    td.withHTE {
        font-weight: bold;
        color: #ff6699;  
    }
    td.expiredMOA {
        font-weight: bold;
        color: #ff9900;  
    }
    td.closetoexpired {
        font-weight: bold;
        color: #006699;  
    }
    td.banned {
        font-weight: bold;
        color: #ff3333;  
    }
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
  <title>OJT assiSTI</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>

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
                          View and manage STI's current partner companies in this module.
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>List of all Partner Companies</h3></div>
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                         <?php
                         if(isset($_GET['success'])) 
                            {   
                            print '<div class="col-md-12">
                              <div class="alert alert-success alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp;New Company was Sucessfully Added!</strong>
                               </div></div>';
                            }
                          else if(isset($_GET['success2']) && isset($_GET['comp_name'])) {

                              $comp_name2 = $_GET['comp_name'];
                             print '<div class="col-md-12">
                              <div class="alert alert-info alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp;  '.$comp_name2.' was Sucessfully Updated!</strong>
                               </div></div>';

                          }else if(isset($_GET['offers_add']) && isset($_GET['comp_name3']) 
                              && isset($_GET['ojt_offers_id']) && isset($_GET['comp_id'])) 
                          {

                              $comp_name3 = $_GET['comp_name3'];
                                $ojt_offers_id = $_GET['ojt_offers_id'];
                                 $comp_id_view = $_GET['comp_id'];
                             print '<div class="col-md-12">
                              <div class="alert alert-success alert-dismissible fade in" role="alert">
                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp;'.$comp_name3.' Was Sucessfully Added a New OJT Offer.</strong>&nbsp;
                                    <a href="view_ojt_offers.php?comp_id='.$comp_id_view.'&ojt_offers_id='.$ojt_offers_id.'" 
                                      style="color:white;"><strong>
                                    CLICK HERE! </strong></a> <label>to view.</label>
                               </div></div>';

                          } 
                        ?>
                      </div>
                    </div>
                      <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                            <div class="col-md-2">
                                      <a href="add_comp_cont_info.php">
                                       <button class="btn btn-success btn-outline btn-block btn-sm">
											<span class="fa fa-plus"></span> &nbsp; ADD &nbsp;
                                      </button>
                                      </a>
                            </div>
							           <div class="col-md-2">
                                      <a href="endorsement.php">
                                       <button class="btn btn-primary btn-outline btn-block btn-sm">
                                            <span class="fa fa-plus"></span> &nbsp; ENDORSEMENT &nbsp;
                                      </button>
                                      </a>
                            </div>
                            <div class="col-md-4"></div>
                             <div class="col-md-4">
                             <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                          </div>
                        </div>  
                        <br>
                      <div class="col-md-12">
                      <div class="well well-lg"> 
                        <!-- start: legend -->
                      <div class="row">
                      <div class="col-md-12">
                      <div class="col-md-3" style="margin-top:10px;">
                        <span class="fa fa-check" style="font-size:20px;color:#00b300;"></span>
                        &nbsp;
                        <label style="font-size:15px;color:#6b6b47;"><strong><a href="Company_info.php?remarks=with MOA">WITH MOA</a> = <?php echo $count_wm; ?></strong></label>
                       </div>
                       <div class="col-md-3" style="margin-top:10px;">
                        <span class="fa fa-remove" style="font-size:20px;color:#000000;">
                        </span>
                        &nbsp;
                        <label style="font-size:15px;color:#6b6b47;"><strong><a href="Company_info.php?remarks=without MOA">WITHOUT MOA</a> = <?php echo $count_wom; ?></strong></label>
                       </div>
                        <div class="col-md-3" style="margin-top:10px;">
                        <span class="fa fa-building" style="font-size:20px;color:#ff6699;">
                        </span>
                        &nbsp;
                        <label style="font-size:15px;color:#6b6b47;"><strong><a href="Company_info.php?remarks=with HTE Training">WITH HTE</a> = <?php echo $count_hte; ?></strong></label>
                       </div>
                       <div class="col-md-3" style="margin-top:10px;">
                        <span class="fa fa-exclamation-triangle" style="font-size:20px;color:#006699;">
                        </span>
                        &nbsp;
                        <label style="font-size:15px;color:#6b6b47;"><strong><a href="Company_info.php?remarks=Close to Expired MOA">CLOSE TO EXPIRED MOA</a> = <?php echo $comp_id_cte; ?></strong></label>
                       </div>
                      </div> 
                    </div>

                   <!-- end: legend -->
                   <!-- start: legend2 -->
                   <?php
                   if(isset($_GET['remarks'])) {
                      $remarks_sort=$_GET['remarks'];
                  }else{
                    $remarks_sort = "ALL";
                  }
				  
				  print '<input type="hidden" name="remarks" id="remarks" value="'.$remarks_sort.'">';
                   ?>
                      <div class="row">
                      <div class="col-md-12">
                      <div class="col-md-3" style="margin-top:10px;">
                        <span class="fa fa-share-square-o" style="font-size:20px;color:#804000;"></span>
                        &nbsp;
                        <label style="font-size:15px;color:#6b6b47;"><strong><a href="Company_info.php?remarks=for follow up">FOR FOLLOW UP</a> = <?php echo $count_ffu; ?></strong></label>
                       </div>
                        <div class="col-md-3" style="margin-top:10px;">
                        <span class="fa fa-suitcase" style="font-size:20px;color:#669999;">
                        </span>
                        &nbsp;
                        <label style="font-size:15px;color:#6b6b47;"><strong><a href="Company_info.php?remarks=for Notary">FOR NOTARY</a> = <?php echo $count_fn; ?></strong></label>
                       </div>
                       <div class="col-md-3" style="margin-top:10px;">
                        <span class="fa fa-fire" style="font-size:20px;color:#ff9900;">
                        </span>
                        &nbsp;
                        <label style="font-size:15px;color:#6b6b47;"><strong><a href="Company_info.php?remarks=expired MOA">EXPIRED MOA</a> = <?php echo $count_em; ?></strong></label>
                       </div>
                       <div class="col-md-3" style="margin-top:10px;">
                        <span class="fa fa-info-circle" style="font-size:20px;color:#ff3333;">
                        </span>
                        &nbsp;
                        <label style="font-size:15px;color:#6b6b47;"><strong><a href="Company_info.php?remarks=Banned">BANNED</a> = <?php echo $count_b; ?></strong></label>
                       </div>
                      </div> 
                    </div>   
                   <!-- end: legend2 -->
				   
                   </div>
				   
				   <!--
<form action="#" method="get" onsubmit="filters()" id="defaultForm_YsANDSem1">
                                  <div class="col-md-2">
                                  <h5 style="padding-left:5px;">STATUS</h5>
                                  <div class="form-group has-feedback">
								  
                                     <select class="form-control"  name="status" id="status">
										<option value='1'>Active</option>
										<option value='2'>Not Active</option>
                                      </select>  
                                    </div>
                                  </div>
								  
								  <!--
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">REMARKS</h5>
                                    <div class="form-group has-feedback">
                                    <select class="form-control" name="remarks" id="remarks">
                                      <option value="1st Semester">All</option>
                                      <option value="2nd Semester">With MOA</option>
									  <option value="2nd Semester">With MOA</option>
									  <option value="2nd Semester">With MOA</option>
									  <option value="2nd Semester">With MOA</option>
									  <option value="2nd Semester">With MOA</option>
									  <option value="2nd Semester">With MOA</option>
									  <option value="2nd Semester">With MOA</option>
									  <option value="2nd Semester">With MOA</option>
                       
                                    </select>
                                  </div>
                                </div>
							
                       
                             <div class="col-md-3" style="padding-top:30px;">
                              <button type="submit" class="btn btn-primary btn-block">
                                <span class="fa fa-filter"></span>&nbsp; Filter</button>
                             </div>
                          </form>-->
						  
                    </div>              
                      <div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr >
                          <th>LOGO</th>	  
                          <th class="text-center col-md-2">COMPANY NAME</th>
                          <th class="text-center col-md-2">ADDRESS</th>
                          <th class="text-center">CONTACT PERSON</th>
                          <th class="text-center">STATUS</th>
                          <th class="text-center">REMARKS</th>
                          <th class="text-center col-md-1">DATE NOTARY</th>
                          <th class="text-center col-md-1">DATE EXPIRY</th>
                          <th class="text-center col-md-2">ACTION</th>
                          <th class="text-center col-md-2">COMPANY DESC</th>
                           <th class="text-center col-md-1">CITY</th>
                           <th class="text-center col-md-1">CONTACT NUMBER</th>
                           <th class="text-center col-md-1">FAX NUMBER</th> 
                           <th class="text-center col-md-1">EMAIL</th>
                           <th class="text-center col-md-1">POSITION</th> 
                           
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
					  <a href="update_semester_ay.php"><i class="fa fa-calendar-check-o"></i>Active Semester and Year</a>
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
    
//	var x = document.getElementById('status').value;
	var x = 1;
	var y = document.getElementById('remarks').value;
	
	var table = $('#datatables').DataTable({
	    
        "processing": true,
        "serverSide": true,
        "ajax": "server_processing_company.php?status="+x+"&remarks="+y,
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },
        "createdRow": function ( row, data, index ) {
             if(data[5] == "with MOA") {
                $('td', row).eq(5).addClass('withMOA');
               }
             if(data[5] == "without MOA") {
                $('td', row).eq(5).addClass('withoutMOA');
               }
             if(data[5] == "for Notary") {
                $('td', row).eq(5).addClass('fornotary');
               } 
            if(data[5] == "for follow up") {
                $('td', row).eq(5).addClass('forfollowup');
               }
            if(data[5] == "with HTE Training") {
                $('td', row).eq(5).addClass('withHTE');
               }
            if(data[5] == "Banned") {
                $('td', row).eq(5).addClass('banned');
               }  
            if(data[5] == "expired MOA") {
                $('td', row).eq(5).addClass('expiredMOA');
               }
            if(data[5] == "Close to Expired MOA") {
                $('td', row).eq(5).addClass('closetoexpired');
               }
             },
          "columnDefs": [
            {
              "targets" : [9],
              "visible" : false
            },
            {
              "targets" : [10],
              "visible" : false
            },
            {
              "targets" : [11],
              "visible" : false
            },
            {
              "targets" : [12],
              "visible" : false
            },
            {
              "targets" : [13],
              "visible" : false
            },
            {
              "targets" : [14],
              "visible" : false
            }
          ]
        });
			
		function filters() {
			//x = 1;
			x = document.getElementById('status').value;
			y = document.getElementById('remarks').value;
			$('#datatables').dataTable().fnDestroy();
			
			var table = $('#datatables').DataTable({
	    
        "processing": true,
        "serverSide": true,
        "ajax": "server_processing_company.php?status="+x+"remarks="+y,
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },
        "createdRow": function ( row, data, index ) {
             if(data[5] == "with MOA") {
                $('td', row).eq(5).addClass('withMOA');
               }
             if(data[5] == "without MOA") {
                $('td', row).eq(5).addClass('withoutMOA');
               }
             if(data[5] == "for Notary") {
                $('td', row).eq(5).addClass('fornotary');
               } 
            if(data[5] == "for follow up") {
                $('td', row).eq(5).addClass('forfollowup');
               }
            if(data[5] == "with HTE Training") {
                $('td', row).eq(5).addClass('withHTE');
               }
            if(data[5] == "Banned") {
                $('td', row).eq(5).addClass('banned');
               }  
            if(data[5] == "expired MOA") {
                $('td', row).eq(5).addClass('expiredMOA');
               }
            if(data[5] == "Close to Expired MOA") {
                $('td', row).eq(5).addClass('closetoexpired');
               }
             },
          "columnDefs": [
            {
              "targets" : [9],
              "visible" : false
            },
            {
              "targets" : [10],
              "visible" : false
            },
            {
              "targets" : [11],
              "visible" : false
            },
            {
              "targets" : [12],
              "visible" : false
            },
            {
              "targets" : [13],
              "visible" : false
            },
            {
              "targets" : [14],
              "visible" : false
            }
          ]
        });
		
		 $(document).ready(function(){
    $.fn.dataTable.ext.errMode = function(settings,helpPage,message){
    table.ajax.reload(null, false);
  }
  
    
	
   
 
   $('#datatables').DataTable();
   });
}
		
	/*	
function filters() {
    var semester1 = document.getElementById('status').value;
 
    $('#datatables').dataTable().fnDestroy();
     var table = $('#datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "server_processing_company.php?status="+semester1,
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
		oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },
        "createdRow": function ( row, data, index ) {
             if(data[5] == "with MOA") {
                $('td', row).eq(5).addClass('withMOA');
               }
             if(data[5] == "without MOA") {
                $('td', row).eq(5).addClass('withoutMOA');
               }
             if(data[5] == "for Notary") {
                $('td', row).eq(5).addClass('fornotary');
               } 
            if(data[5] == "for follow up") {
                $('td', row).eq(5).addClass('forfollowup');
               }
            if(data[5] == "with HTE Training") {
                $('td', row).eq(5).addClass('withHTE');
               }
            if(data[5] == "Banned") {
                $('td', row).eq(5).addClass('banned');
               }  
            if(data[5] == "expired MOA") {
                $('td', row).eq(5).addClass('expiredMOA');
               }
            if(data[5] == "Close to Expired MOA") {
                $('td', row).eq(5).addClass('closetoexpired');
               }
             },
          "columnDefs": [
            {
              "targets" : [9],
              "visible" : false
            },
            {
              "targets" : [10],
              "visible" : false
            },
            {
              "targets" : [11],
              "visible" : false
            },
            {
              "targets" : [12],
              "visible" : false
            },
            {
              "targets" : [13],
              "visible" : false
            },
            {
              "targets" : [14],
              "visible" : false
            }
		]
});
}
*/
 
 $(document).ready(function(){
    $.fn.dataTable.ext.errMode = function(settings,helpPage,message){
    table.ajax.reload(null, false);
  }
  
    
	
   
 
   $('#datatables').DataTable();
   
 var buttons = new $.fn.dataTable.Buttons(table, {
	                        
     buttons: [
            {
                extend: 'excelHtml5',
                title: 'Company Information',
                text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,9,2,10,3,14,11,12,4,5,6,7]
                }
            },
            {
                extend: 'print',
                title: 'Company Information',
                text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                 className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7]
                }
            },
            {
              extend:'colvis',
              text: '<i class="fa fa-eye"></i> VISIBILITY',
              className: 'btn btn-info btn-outline'
            }
        ]
    }).container().appendTo($('#buttons')); 

  });
  
  
  
  

</script>
<!-- end: Javascript -->

</body>
</html>