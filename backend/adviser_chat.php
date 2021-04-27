<?php
$page_title = 'OJT AssiSTI';
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
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
	header("Location: admin_home.php");
}
else{
$query2 = "SELECT * FROM adviser_info WHERE adviser_id = '$username'";
$result2 = mysqli_query($dbc,$query2);
    if(mysqli_num_rows($result2)>0)
        {
          $row2 = mysqli_fetch_assoc($result2);
          $adviser_id = $row2["adviser_id"];
          $lname = $row2["lname"];
          $fname = $row2["fname"];
          $mname = $row2["mname"];
          $title = $row2["title"];
          $email = $row2["email"];
          $program_id = $row2["program_id"];
          $status = $row2["status"];
        }  
	}
	
	
$query_ash = "SELECT * FROM adviser_section_handled WHERE adviser_id = '$username'";
    $result_ash = mysqli_query($dbc,$query_ash);
      if($result_ash->num_rows > 0 )
            {   
              while ($row_ash = mysqli_fetch_array($result_ash))
              {                
                              $adviser_id_ash = $row_ash[0];
                              $section_id_ash = $row_ash[1];
                              $semester_ash = $row_ash[2];
                              $acad_year_start_ash = $row_ash[3];
                              $acad_year_end_ash = $row_ash[4];
                              $program_id_ash = $row_ash[5];
                              $status_ash = $row_ash[6];
                              $ash_id_ash = $row_ash[7];          
              }
           }
// check if there are unread remarks from companies
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
   $active_ash ="SELECT COUNT(status) as active_ash FROM adviser_section_handled WHERE status = 'Active' AND adviser_id ='$username'";
  $res_active_ash =  mysqli_query($dbc, $active_ash);         
          if($res_active_ash->num_rows > 0)
               {   
                while ($row_active_ash = mysqli_fetch_array($res_active_ash))
                   {
                     $count_active_ash = $row_active_ash[0];      
                    }
              }
  $not_active_ash ="SELECT COUNT(status) as active_ash FROM adviser_section_handled WHERE status = 'Not Active' AND adviser_id ='$username'";
  $res_active_ash =  mysqli_query($dbc, $not_active_ash);         
          if($res_active_ash->num_rows > 0)
               {   
                while ($row_not_active_ash = mysqli_fetch_array($res_active_ash))
                   {
                     $count_not_active_ash = $row_not_active_ash[0];      
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
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/select2.min.css"/>
  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/red.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/nouislider.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/ionrangeslider/ion.rangeSlider.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/ionrangeslider/ion.rangeSlider.skinFlat.css"/>
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
                       <label class="active">
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
            <div class="col-md-12 padding-0">
			<div class="col-md-12 padding-0" style="margin-bottom:10px;">
			<form action="search_chat_process.php" enctype="multipart/form-data" method="POST">
				<div class="col-md-3">
				<input type="text" name="search" list="suggestion" id="search" class="form-control"  placeholder="Search Advisers / Students"/>
				</div>
				<button name="btn_search" class="btn btn-info" style="width:90px;"><span class="glyphicon glyphicon-search"></span></button>
				
				<?php
					$q_student = "SELECT stud_no, fname, lname FROM student_info";
                       
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
			<div class="row">
			<div class="col-lg-4" style="padding-left:30px;">
			<section class="panel" style="height:300px;overflow:auto">
				<div class="panel-heading">
                  <div class="pull-left">Admin</div>  
                  <div class="clearfix"></div>
                </div>
				<div class="panel-body progress-panel">
				
				<div class="message-left">
				<?php
					//show all the users expect me
					$q = mysqli_query($dbc, "SELECT * FROM admin_info");
					//display all the results
					while($row = mysqli_fetch_assoc($q))
					{
						$select_id = "SELECT id FROM conversations WHERE (parent='$username' AND child='".$row['admin_id']."') OR (parent='".$row['admin_id']."' AND child='$username')";
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
							if($count==0)
							{
								if(isset($_GET['id']))
								{
									if($row['admin_id'] == $_GET['id'])
									{
										echo "<a href='adviser_chat.php?id=".$row['admin_id']."' class='form-control btn-info'>".$row['fname']." ".$row['lname']."</a>";
									}
									else
									{
										echo "<a href='adviser_chat.php?id=".$row['admin_id']."' class='form-control'>".$row['fname']." ".$row['lname']."</a>";
									}
								}
								else
								{
									echo "<a href='adviser_chat.php?id=".$row['admin_id']."' class='form-control'>".$row['fname']." ".$row['lname']."</a>";
								}
							}
							else
							{
								echo "<a href='adviser_chat.php?id=".$row['admin_id']."' class='form-control'>".$row['fname']." ".$row['lname']." <span class='badge badge-danger'>".$count."</span></a>";
							}
						}
						else
						{
							echo "ERROR: query(count_unread).";
						}
					}
					?>
					
					</div>
				</div>
			</section>
			<section class="panel" style="height:300px;overflow:auto;">
				<div class="panel-heading">
                  <div class="pull-left">Students</a></div>  
                  <div class="clearfix"></div>
                </div>
				<div class="panel-body progress-panel">
				
				<div class="message-left">
					<?php
					//show all the users expect me
					$q2 = mysqli_query($dbc, "SELECT DISTINCT a.stud_no, a.fname, a.lname FROM student_info AS a INNER JOIN student_ojt_records AS b INNER JOIN adviser_section_handled AS c INNER JOIN conversations AS d INNER JOIN conversations_data AS e WHERE a.stud_no=b.stud_no AND b.section_id=c.section_id AND c.adviser_id='$username' AND (a.stud_no=d.parent OR a.stud_no=d.child) AND d.id=e.id");
					//display all the results
					if(mysqli_num_rows($q2)>0)
					{
						while($row2 = mysqli_fetch_assoc($q2))
						{
							$select_id = "SELECT id FROM conversations WHERE (parent='$username' AND child='".$row2['stud_no']."') OR (parent='".$row2['stud_no']."' AND child='$username')";
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
									
									echo "<a href='adviser_chat.php?id=".$row2['stud_no']."' class='form-control'>".$row2['fname']." ".$row2['lname']." <span id='notif' class='badge badge-danger'>".$count."</span></a>";
								}
								else
								{
									if(isset($_GET['id']))
									{
										if($row2['stud_no'] == $_GET['id'])
										{
											echo "<a href='adviser_chat.php?id=".$row2['stud_no']."' class='form-control btn-info'>".$row2['fname']." ".$row2['lname']."</a>";
										}
										else
										{
											echo "<a href='adviser_chat.php?id=".$row2['stud_no']."' class='form-control'>".$row2['fname']." ".$row2['lname']."</a>";
										}
									}
									else
									{
										echo "<a href='adviser_chat.php?id=".$row2['stud_no']."' class='form-control'>".$row2['fname']." ".$row2['lname']."</a>";
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
						echo "<div class='text-center'>No message(s)</div>";
					}
					?>
					
					</div>
				</div>
			</section>
			</div>
			<div class="col-md-8 portlets" style="padding-left:5px">
			<div class="panel panel-default" style="height:620px;">
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
							$sqq = "SELECT * FROM admin_info WHERE admin_id='$sid'";
							$srr = mysqli_query($dbc, $sqq);
							if(mysqli_num_rows($srr)>0)
							{
								$srow=mysqli_fetch_assoc($srr);
								$sfname = $srow['fname'];
								$slname = $srow['lname'];
								
								echo "<h4>$sfname $slname</h4>";
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
                  <div class="row">
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
</body>
</html>