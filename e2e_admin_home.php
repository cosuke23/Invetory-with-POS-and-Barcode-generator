<?php
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'assets/connection/mysqli_dbconnection.php';
if(!isset($_COOKIE["sid"])) {
  header ("Location: login.php");
  exit;
}
$stud_no=$_COOKIE['sid'];
//get student info
$q_studinfo ="select * from student_info where stud_no='$stud_no'";
$q_studinfo_res = $dbc->query($q_studinfo);
$studinfo = $q_studinfo_res->fetch_assoc();
$studname= $studinfo['fname']. ' ' .$studinfo['lname'];
//get student course
$stud_program_id = $studinfo['course'];
if($stud_program_id==1){

  $stud_course='BSIT';
}else if($stud_program_id==2){

  $stud_course='BSHRM';
}else if($stud_program_id==3){

  $stud_course='BSHRM';
}else if($stud_program_id==4){

  $stud_course='BSHRM';
}else if($stud_program_id==5){

  $stud_course='BSAT';
}else if($stud_program_id==6){

  $stud_course='BSTM';
}else if($stud_program_id==7){

  $stud_course='BSTM';
}else if($stud_program_id==8){

  $stud_course='BSIT';
}else if($stud_program_id==9){

  $stud_course='BSIT';
}else if($stud_program_id==10){

  $stud_course='BSIT';
}else if($stud_program_id==11){

  $stud_course='BSIT';
}else if($stud_program_id==12){

  $stud_course='BSIT';
}else{
  $stud_course='NONE';
}


    
    
///end of COOKIE CODES
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="Miminium Admin Template v.1">
  <meta name="author" content="Isna Nur Azis">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E2E INVENTORY</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="asset1/css/buttons.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset1/css/dataTables.bootstrap4.min.css"/>

<!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset1/css/bootstrap.min.css">
  <link rel="stylesheet"  type="text/css" href="asset1/css/datepicker.css"/>
  <link rel="stylesheet"  type="text/css" href="asset1/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset1/css/datepicker.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset1/css/datepicker3.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset1/css/animate.notify.css" />

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset1/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset1/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset1/css/plugins/animate.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset1/css/plugins/icheck/skins/flat/red.css"/>
  <link rel="stylesheet" type="text/css" href="asset1/css/plugins/simple-line-icons.css"/>
  <link href="asset1/css/style.css" rel="stylesheet">
  <!-- end: Css -->
  <link rel="stylesheet" type="text/css" href="asset1/css/sweetalert.css"/>
  <script src="asset1/js/jquery.confirm.min.js"></script>
  <script src="asset1/js/jquery.confirm.js"></script>
  <script src="asset1/js/sweetalert-dev.js"></script>

<link rel="shortcut icon" href="asset/img/e2elogoc.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style type="text/css">
    hr {
    color:black;display: block;
    height: 2px;
    border: 0;
    border-top: 2px solid #ccc;
    margin: 1em 0;
    padding: 0;
    }

  </style>
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
                <a href="e2e_home.php" class="navbar-brand">
                 <b>E2E INVENTORY</b>
                </a>
				
				<ul class="nav navbar-nav navbar-right user-nav">
			  
                <li class="animated fadeInRight" style="color:white;margin-left:10px;margin-top:20px;">
				<span>                        
						<?php 
						date_default_timezone_set("Asia/Manila");
							echo  date("D, m d, Y -|-  h:i:sa"); 
                        ?> &nbsp; &nbsp; &nbsp; &nbsp;
				</span>
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

                    <div class="profile-v1-pp">					
                      <?php
                
                       echo '<img src="../files/student_pics/'.$stud_no.'.jpg;"style="height:100%;" class="img-responsive">';
                       ?> 
					<div class="panel panel-default">
					<div class="panel-body"><h5>&nbsp; Hi' <?php echo $studname ?>&nbsp;</h5></div> 
					<div class="panel-footer" align="center"><strong>Administrator</strong></div>
					</div>
					</div>
					
                      <div class="nav-side-menu">
                        <label class="active">
                          <a href="e2e_admin_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label><a href="#">
                          <i class="glyphicon fa fa-user"></i>My Profile</a>
                        </label><br>
                        <label><a href="e2e_item_audit.php">
                          <i class="glyphicon glyphicon-list-alt"></i>Transactions</a>
                        </label><br>
                       
                        <?php
                        if($usertype == 1){
                          echo '<label><a href="e2e_user_account.php">
                          <i class="glyphicon fa fa-group"></i>User Account</a>
                        </label><br>';
                        echo '<label><a href="#">
                          <i class="glyphicon fa fa-folder-open"></i> Audit Trail</a>
                        </label><br>';
                        }
                        ?>
						
						<label><a href="logout.php">
                          <i class="glyphicon fa fa-power-off"></i>Logout</a>
                        </label><br>
						
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->


          <!-- start: Content -->
          <div id="content" class="profile-v1">
             <div class="col-md-12 col-sm-12 profile-v1-wrapper" style="height:420px;">
                <div class="col-md-12  profile-v1-cover-wrap" style="padding-right:0px;">

                    <div class="col-md-12 profile-v1-cover">
                       <?php
                       echo '<img src="data:'.$img_type_cover.';base64,'.$coverData.'" style="height:400px;" class="img-responsive">';
                       ?>
                    </div>
                </div>
             </div>
             <div class="col-md-12">
                
            <div class="row">
             <div class="col-md-12">
                    <div class="col-md-12 tabs-area">
                     <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#tabs-demo4-area1" id="tabs-demo4-1" role="tab" data-toggle="tab" aria-expanded="true">MENU</a>
                      </li>
                    </ul>
                    <div id="tabsDemo4Content" class="tab-content tab-content-v3">
						<div role="tabpanel" class="tab-pane fade active in" id="tabs-demo4-area1" aria-labelledby="tabs-demo4-area1">
                      <!--count Data -->
                        
					<div class="row">

                            <div align="center" class="col-md-12" style="padding-top:50px;padding-bottom:50px;padding-left:150px;">
									
									<a href="e2e_consume.php" style="margin-left:20px;margin-right:20px;" class="col-md-2 btn btn-success btn-outline btn-lg">
                                            <span class="glyphicon glyphicon-share"></span> &nbsp; Consumable &nbsp;
									</a>							
									
									<a href="e2e_stocks.php" style="margin-left:20px;margin-right:20px;" class="col-md-2 btn btn-danger btn-outline btn-lg">
                                            <span class="glyphicon glyphicon-inbox"></span> &nbsp; Stocks &nbsp;
									</a>
									
									<a href="e2e_borrow.php" style="margin-left:20px;margin-right:20px;" class="col-md-3 btn btn-primary btn-outline btn-lg">
											<span class="glyphicon glyphicon-refresh"></span> &nbsp; Non-Consumable &nbsp;
									</a>
									
									<a href="e2e_view_items.php" style="margin-left:20px;margin-right:20px;" class="col-md-2 btn btn-warning btn-outline btn-lg">
											<span class="glyphicon glyphicon-eye-open"></span> &nbsp; View Items &nbsp;
									</a><br><br><br>
									
										
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

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="e2e_home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                      <a href="e2e_student_records.php"><i class="glyphicon glyphicon-tasks"></i>&nbsp; Student Records</a>
                      <a href="e2e_company_records.php"><i class="glyphicon fa fa-building-o"></i>&nbsp; Company Records</a>
                      <a href="*"><i class="glyphicon fa fa-thumbs-o-up"></i>&nbsp; OJT Endorsement</a>
                      <a href="*"><i class="glyphicon fa fa-user-secret"></i>&nbsp; Check Attire</a>
                      <a href="e2e_grad_id.php"><i class="glyphicon fa fa-smile-o"></i>&nbsp; Graduating ID Card</a>
                      <a href="*"><i class="glyphicon icons icon-credit-card"></i>&nbsp; Business Card</a>
                      <a href="e2e_event_manager.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Event Manager</a>
                      <a href="*"><i class="glyphicon fa fa-user"></i>&nbsp; User Account</a>
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
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script src="asset/js/jquery.confirm.min.js"></script>
<script src="asset/js/jquery.confirm.js"></script>
<script src="asset/js/sweetalert-dev.js"></script>
<script src="asset/js/plugins/chart.min.js"></script>
<!-- end: Javascript -->
</body>
</html>
