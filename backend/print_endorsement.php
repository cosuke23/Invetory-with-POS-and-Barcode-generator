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
	header("Location: admin_home.php");
}
if($usertype!=1)
{
	$query2 = "SELECT * from adviser_info WHERE adviser_id = '$username'";
	$result2 = mysqli_query($dbc,$query2);
		if(mysqli_num_rows($result2)>0)
		{
			$row2 = mysqli_fetch_assoc($result2);
			$fname2 = $row2["fname"];
			$lname2 =  $row2["lname"];
			$contact_no = $row2["mobile_no"];
			$email = $row2["email"];
			$program_id = $row2["program_id"];
			//get program code
				$q_program_code = "select program_code from program_list where program_id ='$program_id'";
				$q_program_code_res = mysqli_query($dbc,$q_program_code);
				$get_program_code = mysqli_fetch_assoc($q_program_code_res);
				$program_code = $get_program_code['program_code'];
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
		
	//get info for endorsement
		$cmp_representative = $_POST['cmp_representative'];
		$cmp_rep_position = $_POST['cmp_rep_position'];
		$cmp_name = $_POST['cmp_name'];
		$cmp_address = $_POST['cmp_address'];
		$stud_name = $_POST['stud_name'];
		$ojt_hours = $_POST['ojt_hours'];
		$program_head=$_POST['program_head'];
		$program_head_position = $_POST['program_head_position'];
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <style media="print">
@media print {

  button {
    visibility: hidden;
  }
  .this {
    visibility: visible;
  }
  a{
	visibility: hidden;
  }
  .nav_bar{
	display:none;
  }
  body {
		background-color: white;
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        
        
  }
}
@page {
size:auto;
margin: 0mm;
}
</style>
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
		<style>
		.img_hidden{display:none;}
		.img_show{display:block;}
	</style>
</head>
<body id="mimin" class="dashboard">
      <!-- start: Header -->
        <nav  id="nav_bar" class="navbar navbar-custom header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
             
                <a href="home.php" class="navbar-brand"> 
                 <b>OJT assiSTI</b>
                </a>
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="dropdown avatar-dropdown">
                <br>     
                    <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:7px 10px 7px 10px">
                    <i class="glyphicon glyphicon-envelope" style="color:white;font-size:17px;"><label class="badge badge-danger" style="font-size:15px;padding:1px 10px 3px 10px;"><?php echo $unread_msg ;?></label></i>
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
				<li class="user-name">&nbsp;<span>&nbsp;<?php echo $fname2 ; ?>&nbsp;</span></li>
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
			<?php
date_default_timezone_set('Asia/Manila');
$date_now = time();
$format = "F d, Y";
$formatted_date = date($format,$date_now);

?>
<div id="this" style="margin-left:55px;margin-right:55px;font-size:14px;font-family:'Calibri';">
<br><br><br><br><br><br><br><br>
<div><?php echo $formatted_date; ?></div>
<br><br>
<div><b><?php echo $cmp_representative; ?></b></div>
<div style="padding-top:2px;"><?php echo $cmp_rep_position; ?></div>
<div style="padding-top:2px;"><?php echo $cmp_name; ?></div>
<div style="width:160px;"><?php echo $cmp_address; ?></div>
<br><br>

<div>Dear <?php echo $cmp_representative; ?>,</div>
<br>

<div>
STI, in its dedication to further enhance the development of our students, requires them to undergo the
On-the-Job Training (OJT) Program. This program aims to help our students develop competency in their
chosen field by arming them with the basic experience, knowledge, attitude essential to aid their
transition from being a student to being part of the workforce.
</div>
<br>

<div>
With this, we request your good office to be our partner in achieving this goal by agreeing to be the Host
Company for <span style="text-decoration:underline"><b><?php echo $stud_name ?></b></span>, <span style="text-decoration:underline"><b><?php echo $program_code; ?></b></span> student, for a total of <span style="text-decoration:underline"><b><?php echo $ojt_hours ?></b></span>  hours.
</div>
<br>

<div>
We believe that the experiences and learnings he/she will receive from your office will greatly complement the knowledge, skills and attitude that he/she has acquired from our school.
</div>
<br>

<div>
Should you have any questions, kindly contact me at <span><b><?php echo $contact_no; ?></b></span> and/or <span><b><?php echo $email; ?></b></span>.
</div>
<br>

<div>Thank you.</div>
<br><br>
<div>Respectfully yours,</div>
<br><br>
<div>__________________________________</div>
<div><?php echo $fname2.' '.$lname2; ?></div>
<div>OJT Adviser</div>
<br><br>
<div>Noted by:</div>
<br><br>
<div>__________________________________</div>
<div><?php echo $program_head; ?></div>
<div><?php echo $program_head_position; ?></div>
</div>
<br><br>

<form action="../backend/download_journal/download_journal_main/print_endorsement_letter.php" method="POST">
	<input type="hidden" name="adviser_id" value="<?php echo $username; ?>">
	<input type="hidden" name="cmp_representative" value="<?php echo $cmp_representative; ?>">
	<input type="hidden" name="cmp_rep_position" value="<?php echo $cmp_rep_position; ?>">
	<input type="hidden" name="cmp_name" value="<?php echo $cmp_name; ?>">
	<input type="hidden" name="cmp_address" value="<?php echo $cmp_address; ?>">
	<input type="hidden" name="stud_name" value="<?php echo $stud_name; ?>">
	<input type="hidden" name="ojt_hours" value="<?php echo $ojt_hours; ?>">
	<input type="hidden" name="program_head" value="<?php echo $program_head; ?>">
	<input type="hidden" name="program_head_position" value="<?php echo $program_head_position; ?>">
	
	<button style="margin-left:20px;margin-bottom:20px;" class="btn btn-primary" type="submit" name="btn_print">
	<i class="fa fa-print"></i>&nbsp;Print Endorsement
	</button>
	
	<a id="cancel" href="prepare_endorsement.php" style="margin-left:20px;margin-bottom:20px;" class="btn btn-default" height="70px">Cancel</a>
</form>

  
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
<script>
<!-- end: Javascript -->
</body>
</html>