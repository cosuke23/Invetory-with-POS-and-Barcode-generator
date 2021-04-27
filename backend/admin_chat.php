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

if($usertype == 1)
{
	$query2 = "SELECT * FROM admin_info WHERE admin_id = '$username'";
  $result2 = mysqli_query($dbc,$query2);
    if(mysqli_num_rows($result2)>0)
        {
          $row2 = mysqli_fetch_assoc($result2);
          $admin_id = $row2["admin_id"];
          $lname = $row2["lname"];
          $fname = $row2["fname"];
          $mname = $row2["mname"];
          $title = $row2["title"];
        }
		 
}
if($usertype != 1)
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

$active_com_stat ="SELECT COUNT(status) as active_comp FROM company_info WHERE status = 'Active'";
$resume_com_stat =  mysqli_query($dbc, $active_com_stat);         
          if($resume_com_stat->num_rows > 0)
               {   
                while ($row_act_comp = mysqli_fetch_array($resume_com_stat))
                   {
                     $count_act_comp = $row_act_comp[0];      
                    }
              }
 $not_active_com_stat ="SELECT COUNT(status) as active_comp FROM company_info WHERE status = 'Not Active'";
$result_not_active_com_stat =  mysqli_query($dbc, $not_active_com_stat);         
          if($result_not_active_com_stat->num_rows > 0)
               {   
                while ($row__not_act_comp = mysqli_fetch_array($result_not_active_com_stat))
                   {
                     $count_not_act_comp = $row__not_act_comp[0];      
                    }
              }
              
 $active_adviser_stat ="SELECT COUNT(status) as active_adv FROM adviser_info WHERE status = 'Active'";
$res_adviser_stat =  mysqli_query($dbc, $active_adviser_stat);         
          if($res_adviser_stat->num_rows > 0)
               {   
                while ($row_act_adv = mysqli_fetch_array($res_adviser_stat))
                   {
                     $count_act_adv = $row_act_adv[0];      
                    }
              }

 $not_active_adv ="SELECT COUNT(status) as not_active_adv FROM adviser_info WHERE status = 'Not Active'";
$res_not_active_adv =  mysqli_query($dbc, $not_active_adv);         
          if($res_not_active_adv->num_rows > 0)
               {   
                while ($row_not_act_comp = mysqli_fetch_array($res_not_active_adv))
                   {
                     $count_not_act_adv = $row_not_act_comp[0];      
                    }
              }  

$offers_avail ="SELECT COUNT(status) as avail_offer FROM ojt_offers WHERE status = 'Available'";
$res_offers_avail =  mysqli_query($dbc, $offers_avail);         
          if($res_offers_avail->num_rows > 0)
               {   
                while ($avail_offers = mysqli_fetch_array($res_offers_avail))
                   {
                     $count_avail_offers = $avail_offers[0];      
                    }
              }

 $not_offers_avail ="SELECT COUNT(status) as avail_offer FROM ojt_offers WHERE status = 'Not Available'";
$res_not_offers_avail =  mysqli_query($dbc, $not_offers_avail);         
          if($res_not_offers_avail->num_rows > 0)
               {   
                while ($avail_offers_not = mysqli_fetch_array($res_not_offers_avail))
                   {
                     $count_not_avail_offers = $avail_offers_not[0];      
                    }
              } 

$ongoing_stat ="SELECT COUNT(ojt_status) as ojt_status FROM student_ojt_records WHERE ojt_status = 'Ongoing'";
$res_ongoing_stat =  mysqli_query($dbc, $ongoing_stat); 
          if($res_ongoing_stat->num_rows > 0)
               {   
                while ($row_ongoing = mysqli_fetch_array($res_ongoing_stat))
                   {
                     $count_ongoing = $row_ongoing[0];      
                    }
              }

$finished_stat ="SELECT COUNT(ojt_status) as ojt_status FROM student_ojt_records WHERE ojt_status = 'Finished'";
$res_finished_stat =  mysqli_query($dbc, $finished_stat); 
          if($res_finished_stat->num_rows > 0)
               {   
                while ($row_finished = mysqli_fetch_array($res_finished_stat))
                   {
                     $count_finished = $row_finished[0];      
                    }
              }
  
  $ojt_file ="SELECT COUNT(fileID) AS file_id FROM ojt_softcopy_files";
$res_ojt_file =  mysqli_query($dbc, $ojt_file); 
          if($res_ojt_file->num_rows > 0)
               {   
                while ($row_file_id = mysqli_fetch_array($res_ojt_file))
                   {
                     $count_file_id = $row_file_id[0];      
                    }
              }

  $A_admin ="SELECT COUNT(deliverable_id) AS deliverable_id FROM student_deliverables WHERE authorize_by = '1'";
$res_A_admin =  mysqli_query($dbc, $A_admin); 
          if($res_A_admin->num_rows > 0)
               {   
                while ($row_A = mysqli_fetch_array($res_A_admin))
                   {
                     $row_Admin = $row_A[0];      
                    }
              }
  $A_adviser ="SELECT COUNT(deliverable_id) AS deliverable_id FROM student_deliverables WHERE authorize_by = '2'";
$res_A_adviser =  mysqli_query($dbc, $A_adviser); 
          if($res_A_adviser->num_rows > 0)
               {   
                while ($row_B = mysqli_fetch_array($res_A_adviser))
                   {
                     $row_Adviser = $row_B[0];      
                    }
              } 

 $query_resume_app ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '2'";
$result_resume_app =  mysqli_query($dbc, $query_resume_app);         
          if($result_resume_app->num_rows > 0)
               {   
                while ($row_app_resume = mysqli_fetch_array($result_resume_app))
                   {
                     $count_resume_approved = $row_app_resume[0];      
                    }
              }
$query_resume_rej ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '3'";
$result_resume_rej =  mysqli_query($dbc, $query_resume_rej);         
          if($result_resume_rej->num_rows > 0)
               {   
                while ($row_rej_resume = mysqli_fetch_array($result_resume_rej))
                   {
                     $count_rej_resume = $row_rej_resume[0];      
                    }
              } 
$query_resume_no ="SELECT COUNT(resume_status) as resume_status FROM student_resume_data WHERE resume_status = '0'";
$result_resume_no =  mysqli_query($dbc, $query_resume_no);         
          if($result_resume_no->num_rows > 0)
               {   
                while ($row_resume_no = mysqli_fetch_array($result_resume_no))
                   {
                     $count_no_resume = $row_resume_no[0];      
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
			  
               $query_comp_status = "SELECT comp_id,comp_name,img_data FROM company_info where date_expiry = '$date_today' AND notify_status = 'unread'";
                 
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
                               $img_count = $row_count[2];
                               $counter = 0;

                                
                                
                            if($counter <= $date_expiry_status2)
                            {
                              $decoded_img_count = base64_decode($img_count);
                                 $f = finfo_open(); 
                                 $img_type = finfo_buffer($f, $decoded_img_count, FILEINFO_MIME_TYPE); 
                                echo '<div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                                      <li>
                                        <a href="update_comp_cont_info.php?comp_id='.$comp_id_count.'">
                                          <img src="data:'.$img_type.';base64,'.$img_count.'" style="height:50px;width:50px;margin-top:5px;margin-left:10px;">
                                          <div style="font-size:12px; margin-left:2px; margin-right:2px; margin-top:2px; margin-bottom:2px;"><label class="text-primary">'.$comp_name2.'</label> has already expired the date notary.
                                         </div>
                                      </a>
                                      </li>
                                        </div>
                                        
                                        ';
                               $counter++;
                             }
                            } 
                            
                          print '</ul></li>
						  
						  <li class="dropdown avatar-dropdown">
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
                
                  
                  <li class="user-name"><span>&nbsp;<?php echo  $title." ".$fname ; ?>&nbsp;</span></li>
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
		  <?php
			if(isset($_GET['id']))
			{
				
				$select_id="SELECT id FROM conversations WHERE (parent='$username' AND child='".$_GET['id']."') OR (parent='".$_GET['id']."' AND child='$username')";
				$result_id=mysqli_query($dbc, $select_id);
				if(mysqli_num_rows($result_id)>0)
				{
					$s_row = mysqli_fetch_assoc($result_id);
					$s_id = $s_row['id'];
				}
				$qread="UPDATE conversations_data SET read_status='read' WHERE id='$s_id' AND sender!='$username'";
				$rread=mysqli_query($dbc, $qread);
				if($rread==false)
				{
					echo "ERROR: query(qread)";
					exit;
				}
			}
		  ?>
            <!-- start: Content -->
			<br>
          <div id="content">
            <div class="col-md-12 padding-0" style="margin-bottom:10px;">
			<form action="search_chat_process.php" enctype="multipart/form-data" method="POST">
				<div class="col-md-3">
				<input type="text" name="search" list="suggestion" id="search" class="form-control"  placeholder="Search Advisers / Students"/>
				</div>
				<button name="btn_search2" class="btn btn-info" style="width:90px;"><span class="glyphicon glyphicon-search"></span></button>
				
				<?php
					$q_student = "SELECT stud_no, fname, lname FROM student_info UNION SELECT adviser_id AS stud_no, fname, lname FROM adviser_info";
                       
                    $r_student = mysqli_query($dbc, $q_student);
                    $num_rows2 = mysqli_num_rows($r_student);

                    print'<datalist id="suggestion">';
 
                    while($row_s = mysqli_fetch_array($r_student))
					{
                        $stud_no = $row_s[0];
                        $fnames = $row_s[1];
						$lnames = $row_s[2];
                        echo "<option data-value='".$stud_no."'>".$fnames." ".$lnames." -- ".$stud_no."</option>";
                    }
                    print '</datalist>
					<input type="hidden" name="search-hidden" id="search-hidden"/>';
					?>
					<script>
					document.querySelector('input[list]').addEventListener('input', function(e) 
					{
					var input = e.target,
					list = input.getAttribute('list'),
					options = document.querySelectorAll('#' + list + ' option'),
					hiddenInput = document.getElementById(input.id + '-hidden'),
					inputValue = input.value;

					hiddenInput.value = inputValue;

						for(var i = 0; i < options.length; i++) 
						{
							var option = options[i];
							if(option.innerText === inputValue)
							{
								hiddenInput.value = option.getAttribute('data-value');
								break;
							}
						}
					});
					</script>
					</form>
					</div>
            <div class="col-md-12 padding-0">
			<div class="row">
			<div class="col-lg-4" style="padding-left:30px;">
			<div class="panel-heading">
                <div class="pull-left">Students</div>
                <div class="clearfix"></div>
            </div>
			
			<section class="panel" style="height:300px;overflow:auto">
				<div class="panel-body progress-panel">
				
				<div id="stud_list" class="message-left">
		<?php
		//show all the users expect me
	$q = mysqli_query($dbc, "SELECT DISTINCT a.stud_no, a.fname, a.lname FROM student_info AS a INNER JOIN conversations AS b INNER JOIN conversations_data AS c WHERE (a.stud_no=b.parent OR a.stud_no=b.child) AND b.id=c.id");
	//display all the results
	if(mysqli_num_rows($q)>0)
	{
		while($row = mysqli_fetch_assoc($q))
		{
			$select_id = "SELECT id FROM conversations WHERE (parent='".$row['stud_no']."' AND child='$username') OR (parent='$username' AND child='".$row['stud_no']."')";
			$result_id = mysqli_query($dbc, $select_id);
			if(mysqli_num_rows($result_id)>0)
			{
				$id_row = mysqli_fetch_assoc($result_id);
				$cid = $id_row['id'];
			}
			else
			{
				$cid = 0;
			}
			$count_unread="SELECT COUNT(conv_id) AS count FROM conversations_data WHERE read_status='unread' AND id='$cid' AND sender!='$username'";
			$result_count=mysqli_query($dbc, $count_unread);
			if(mysqli_num_rows($result_count)>0)
			{
				$count_row = mysqli_fetch_assoc($result_count);
				$count = $count_row['count'];
				if($count!=0)
				{
					//echo "<a href='admin_chat.php?id=".$row['stud_no']."' class='form-control'>".$row['fname']." ".$row['lname']."</a>";
					echo "<a href='admin_chat.php?id=".$row['stud_no']."' class='form-control'>".$row['fname']." ".$row['lname']." <span class='badge badge-danger'>".$count."</span></a>";
				}
				else
				{
					if(isset($_GET['id']))
					{
						if($row['stud_no'] == $_GET['id'])
						{
							echo "<a href='admin_chat.php?id=".$row['stud_no']."' class='form-control btn-info'>".$row['fname']." ".$row['lname']."</a>";
						}
						else
						{
							echo "<a href='admin_chat.php?id=".$row['stud_no']."' class='form-control'>".$row['fname']." ".$row['lname']."</a>";
						}
					}
					else
					{
						echo "<a href='admin_chat.php?id=".$row['stud_no']."' class='form-control'>".$row['fname']." ".$row['lname']."</a>";
					}
				}
				
			}
			else
			{
				echo "ERROR: query(count_unread).";
			}
		}
	}
	else
	{
		echo "<div class='text-center' style='margin-top:100px;'>No message(s)</div>";
	}
	?>
				</div>
				
				</div>
			</section>
			<div class="panel-heading">
                  <div class="pull-left">Advisers</div>  
                  <div class="clearfix"></div>
                </div>
				
				<section class="panel" style="height:300px;overflow:auto;">
				
				<div class="panel-body progress-panel">
				
				<div class="message-left">
				
				<?php
					//show all the users expect me
					$q2 = mysqli_query($dbc, "SELECT DISTINCT a.adviser_id, a.fname, a.lname FROM adviser_info AS a INNER JOIN conversations AS b INNER JOIN conversations_data AS c WHERE (a.adviser_id=b.parent OR a.adviser_id=b.child) AND b.id=c.id");
					//display all the results
					if(mysqli_num_rows($q2)>0)
					{
						while($row2 = mysqli_fetch_assoc($q2))
						{
							$select_id = "SELECT id FROM conversations WHERE (parent='".$row2['adviser_id']."' AND child='$username') OR (parent='$username' AND child='".$row2['adviser_id']."')";
							$result_id = mysqli_query($dbc, $select_id);
							if(mysqli_num_rows($result_id)>0)
							{
								$id_row = mysqli_fetch_assoc($result_id);
								$cid = $id_row['id'];
								
								$count_unread="SELECT COUNT(conv_id) AS count FROM conversations_data WHERE read_status='unread' AND id='$cid' AND sender!='$username'";
								$result_count=mysqli_query($dbc, $count_unread);
								if(mysqli_num_rows($result_count)>0)
								{
									$count_row = mysqli_fetch_assoc($result_count);
									$count = $count_row['count'];
									
									if($count!=0)
									{
										echo "<a href='admin_chat.php?id=".$row2['adviser_id']."' class='form-control'>".$row2['fname']." ".$row2['lname']." <span class='badge badge-danger'>".$count."</span></a>";
									}
									else
									{
										if(isset($_GET['id']))
										{
											if($row2['adviser_id'] == $_GET['id'])
											{
												echo "<a href='admin_chat.php?id=".$row2['adviser_id']."' class='form-control btn-info'>".$row2['fname']." ".$row2['lname']."</a>";
											}
											else
											{
												echo "<a href='admin_chat.php?id=".$row2['adviser_id']."' class='form-control'>".$row2['fname']." ".$row2['lname']."</a>";
											}
										}
										else
										{
											echo "<a href='admin_chat.php?id=".$row2['adviser_id']."' class='form-control'>".$row2['fname']." ".$row2['lname']."</a>";
										}
									}
								}
								else
								{
									echo "ERROR: query(count_unread).";
								}
							}
							else
							{
								echo "<a href='admin_chat.php?id=".$row2['adviser_id']."' class='form-control'>".$row2['fname']." ".$row2['lname']."</a>";
							}
							
						}
					}
					else
					{
						echo "<div class='text-center' style='margin-top:100px;'>No message(s)</div>";
					}
					?>
					
					</div>
				</div>
			</section>
			
			</div>
		
			<div class="col-md-8 portlets">
			<div class="panel panel-default" style="height:677px;">
				<div class="panel-heading">
                  <div class="pull-left">
				  <?php
					if(isset($_GET['id']))
					{
						$sid = $_GET['id'];
						$sq = "SELECT * FROM student_info WHERE stud_no='$sid'";
						$sr = mysqli_query($dbc, $sq);
						if(mysqli_num_rows($sr)>0)
						{
							$srow=mysqli_fetch_assoc($sr);
							$sfname = $srow['fname'];
							$slname = $srow['lname'];
							
							echo "<h4>$sfname $slname</h4>";
						}
						else
						{
							$sqq = "SELECT * FROM adviser_info WHERE adviser_id='$sid'";
							$srr = mysqli_query($dbc, $sqq);
							if(mysqli_num_rows($srr)>0)
							{
								$srow=mysqli_fetch_assoc($srr);
								$sfname = $srow['fname'];
								$slname = $srow['lname'];
								
								echo "<h4>$sfname $slname</h4>";
							}
							else
							{
								echo "<h4>Message</h4>";
							}
						}
					}
					else
					{
						echo "<h4>Message</h4>";
					}
				  ?>
				  </div> 
                  <div class="clearfix"></div>
                </div>
				<div class="panel-body">
                  <!-- Widget content -->
                  <div id="focus" class="chats">
                  <?php
					
						//check $_GET['id'] is set
						if(isset($_GET['id']))
						{
							$user_2 = $_GET['id'];
							//check $user_2 is valid from advisers
							$q3 = mysqli_query($dbc, "SELECT username FROM user WHERE username='$user_2'");
							//valid $user_2
							if(mysqli_num_rows($q3)> 0)
							{
								//check $username and $user_2 has conversation or not if no start one
								$conver = mysqli_query($dbc, "SELECT * FROM conversations WHERE (parent='$username' AND child='$user_2') OR (parent='$user_2' AND child='$username')");
								
								//they have a conversation
								if(mysqli_num_rows($conver)>0)
								{
									//fetch the converstaion id
									$fetch = mysqli_fetch_assoc($conver);
									$conv_id = $fetch['id'];
								}
								else
								{
									//they do not have a conversation
									//start a new converstaion and fetch its id
									$q4 = mysqli_query($dbc, "INSERT INTO conversations(parent, child) VALUES ('$username','$user_2')");
									$conv_id = mysqli_insert_id($dbc);
									
								}
							}
							else
							{
								//check $user_2 is valid from students
								$q3 = mysqli_query($dbc, "SELECT stud_no FROM student_info WHERE stud_no='$user_2'");
								
								//valid $user_2
								if(mysqli_num_rows($q3)> 0)
								{
									//check $username and $user_2 has conversation or not if no start one
									$conver = mysqli_query($dbc, "SELECT * FROM conversations WHERE (parent='$username' AND child='$user_2') OR (parent='$user_2' AND child='$username')");		 
									
									//they have a conversation
									if(mysqli_num_rows($conver)>0)
									{
										//fetch the converstaion id
										$fetch = mysqli_fetch_assoc($conver);
										$conv_id = $fetch['id'];
									}
									else
									{
										//they do not have a conversation
										//start a new converstaion and fetch its id
										$q4 = mysqli_query($dbc, "INSERT INTO conversations(parent, child) VALUES ('$username','$user_2')");
										$conv_id = mysqli_insert_id($dbc);
									}
								}
								else
								{
									echo "Invalid ID";
								}
							}
						}
						else
						{
							die("No conversation.");
						}
					?>
                  </div>
                  <!-- Widget footer -->
                  <div class="row" style="margin-top:50px;">
				  <div class="widget-foot">
					  <div class="col-md-12">
						<div class="form-group  col-md-10">
							<input type="hidden" id="id" value="<?php echo $conv_id;?>"/>
							<input type="hidden" id="user" value="<?php echo $username?>"/>
							<input type="text" class="form-control" id="message" name="message" placeholder="Type your message here...">
						</div>
						<div class="form-group col-md-2">
						<button type="submit" class="btn btn-info" id="btn-send">Send</button>
						<span id="error" style="color:green;"></span>
						<span id="error2" style="color:red;"></span>
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
                      <a href="ojtsoftcopy.php"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; OJT Softcopy Files
                      </a>
                    </li>
                     <li class="ripple">
                       <a href="program_category_list.php"><i class="glyphicon glyphicon-th-list"></i>&nbsp; OJT Category List</a>
                      </a>
                    </li>
                      <li class="ripple">
                        <a href="student_deliverables.php"><i class="fa fa-folder"></i>&nbsp;Student Deliverables</a>
                    </li>
                     </li>
                      <li class="ripple">
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
<script src="asset/js/messaging-post-get.js"></script>

<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript"></script>
<!-- end: Javascript -->
</body>
</html>