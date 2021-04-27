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
          $profileData = $row2["profileData"];
          $coverData = $row2["coverData"];
        }  
         $decoded_img_profile = base64_decode($profileData);
         $f = finfo_open(); 
         $img_type_profile = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);

         $decoded_img_cover = base64_decode($coverData);
         $f = finfo_open(); 
         $img_type_cover = finfo_buffer($f, $decoded_img_cover, FILEINFO_MIME_TYPE);    
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
						  <label>
                          <a href="prepare_endorsement.php"><i class="fa fa-print"></i>Print Endorsement</a>
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
                        <h1 class="animated fadeInLeft">OJT MONITORING REPORT</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                         
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Send an OJT Monitoring Report</h3></div>
                    <form id="defaultForm" method="post" action="send_report_process.php" enctype="multipart/form-data">
                      <div class="panel-body" style="padding-bottom:30px;">

                     <?php
						$query_admin="SELECT lname, fname, mname, title FROM admin_info";
						$result_admin = mysqli_query($dbc, $query_admin);
						if(mysqli_num_rows($result_admin)>0)
						{
							$row_admin = mysqli_fetch_assoc($result_admin);
							$lname = $row_admin['lname'];
							$fname = $row_admin['fname'];
							$mname = $row_admin['mname'];
							$title = $row_admin['title'];
						}
					 ?> 
					 <div class="row">
                            <div class="col-md-8">
                                <div class="panel-body">
                                  <div class="well well-sm">
                                      <h4><span class="glyphicon glyphicon-exclamation-sign text-warning"> NOTE</span>
									    <div class="row">
                                        <div class="col-md-12">
                                         <h5> 
                                          &nbsp;  &nbsp;  &nbsp;Please make sure that your file is <strong><mark class="text-primary"> PDF </mark></strong> format.</h5>
                                        </div>
                                      </div>
                                   </div>
                                </div>  
                          </div>
                        </div>
					 <?php
						if(isset($_GET['success'])){
									echo '<div class="alert alert-success">
										<span>Sent Successfully.</span>
									</div>';
								}if(isset($_GET['error'])){
									echo '<div class="alert alert-danger">
										<span>There was no file selected.</span>
									</div>';
								}
								?>
						
						<div class="row">
                          <div class="col-md-3">
                             <div class="form-group has-feedback">
                               <h5 style="padding-left:5px;"><b>To:</b></h5>
                               <h4 style="padding-left:5px;"><?php echo $title.". ".$fname." ".$mname." ".$lname; ?></h4>
                               </div>
                          </div>
						  <div class="col-md-3">
                             <div class="form-group has-feedback">
                               <h5 style="padding-left:5px;"><b>File name:</b></h5>
                               <input type="text" class="form-control" id="file_name" name="file_name"/>
                               </div>
                          </div>
						  <div class="col-md-3">
                              <div class="form-group has-feedback">
								 <h5 style="padding-left:5px;"><b>Send File:</b></h5>
								 <input type="file" name="report_file" id="report_file" accept=".pdf" class="form-control"/>
								 <input type="hidden" name="adviser_id" value="<?php echo $adviser_id;?>"/>
                              </div>
                          </div>
                        </div>
						
							
						 <div class="row">
                            <div class="col-md-8"></div>
							
                              <div class="col-md-4">
                               <input type="submit" class="btn btn-primary btn-block" value="Send" name="btn_report" id="btn_comp_remarks"/>
                               </div>
							   
                          </div>
                      </div><!--ENd of panel body-->
                      </form>
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
  $('#datatables').DataTable();
$('#defaultForm')
	.bootstrapValidator({
		fields:
		{
			file_name:
			{
				validators:
				{
					notEmpty:{},
				}
			},
			
			report_file:
			{
				validators:
				{
					notEmpty:{},
					file:
					{
						extension: 'pdf',
						type: 'application/pdf',
						message: 'Please choose a PDF file',
					}
				}
			}
		}
	});
});
</script>
<!-- end: Javascript -->
</body>
</html>