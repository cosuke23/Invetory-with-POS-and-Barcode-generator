<?php
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';
require 'default_cover.php';
///COOKIE CODES 
if(!isset($_COOKIE["cid"])) {
  header ("Location: e2e_company_login.php");
  exit;
}
$comp_id = $_COOKIE["cid"];

    $table = "company_info";
    $columns = "*";
    $where = ["comp_id" => $comp_id];

    $q_comp_info =$database->select($table,$columns,$where);

    foreach ($q_comp_info as $q_comp_infoD)
    {
          $comp_name = $q_comp_infoD["comp_name"];
          $comp_logo = $q_comp_infoD["comp_logo"];
          $sender_user = $q_comp_infoD["username"];  
    } 
        $decoded_img_profile = base64_decode($comp_logo);
         $f = finfo_open(); 
         $img_type_profile = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);

         $decoded_img_cover = base64_decode($default_cover);
         $f = finfo_open(); 
         $img_type_cover = finfo_buffer($f, $decoded_img_cover, FILEINFO_MIME_TYPE);
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
  <title>E2E SYSTEM v2</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

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

<link rel="shortcut icon" href="asset/img/e2elogoc.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                 <b>E2E SYSTEM v2</b>
                </a>
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span>&nbsp; <?php echo  $comp_name; ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <?php 
                       echo '<img src="data:'.$img_type_profile.';base64,'.$comp_logo.'" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
                  ?>
                  
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="#"><span class="fa fa-user"></span> My Profile</a></li>
                     <li><a href="company_logout.php"><span class="fa fa-power-off"></span> Log out</a></li>
                  </ul>
                </li>
				<!--count data of chat-->	
                <li>
					<a href="#" class="opener-right-menu"><span class="fa fa-weixin"></span>
                  <?php
                  $c_unread_chat = $database->count("messenger",["AND"=>["receiver" => $sender_user,"message_status"=>'unread']]);
                  if($c_unread_chat == 0){
                    echo "";
                  }
                  else{
                    echo '<div class="badge" style="background:red;">'.$c_unread_chat.'</div>';
                  }
                  ?>
					</a>
				</li>
				<!--end of data of chat-->
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
                      <img src="asset/img/e2elogoc.png" style="padding-top:4px;margin-left:1px;width:230px;height:100px;" class="animated fadeInLeft">
                    </div>
                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:70px;">
                    <br>
                       <p class="animated fadeInRight" style="color:gray;margin-left:10px;margin-top:20px;">
                               <?php
                                 echo  date("l, F j, Y"); 
                               ?>
                        </p>
                    </div>

                      <div class="nav-side-menu">
                        <label class="active">
                          <a href="e2e_company_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label >
                        <a href="e2e_company_add_applicant.php"><i class="glyphicon glyphicon-user"></i>Add Applicant</a>
                      </label><br>
                      <label>
                        <a href="e2e_company_applicant_list.php"><i class="fa fa-paste"></i>Applicant(s) List</a>
                      </label><br>       
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->


          <!-- start: Content -->
          <div id="content" class="profile-v1">
             <div class="col-md-12 col-sm-12 profile-v1-wrapper" style="height:420px;">
                <div class="col-md-12  profile-v1-cover-wrap" style="padding-right:0px;">
                    <div class="profile-v1-pp">
                      <?php 
                       echo '<img src="data:'.$img_type_profile.';base64,'.$comp_logo.'">';
                       ?>
                      <h4 style="color:white;padding-left:40px;"><?php echo $comp_name; ?></h4>
                      <h5 style="color:white;padding-left:40px;">COMPANY NAME</h5>
                    </div>
                    <div class="col-md-12 profile-v1-cover">
                       <?php 
                       echo '<img src="data:'.$img_type_cover.';base64,'.$default_cover.'" style="height:400px;" class="img-responsive">';
                       ?>
                    </div>
                </div>     
             </div>
			 <div class="row">
				<div class="col-md-12">
					<div class="col-md-4">
						<a href="e2e_company_home.php" class="btn btn-primary"><span class="fa fa-refresh"></span> REFRESH</a>
					</div>
				</div>
			 </div>
			 <br>
             <div class="col-md-12">
                  <div class="row">
                  <?php
                  
                    $q_nop_jf = $database->query("SELECT a.*,c.* FROM company_info AS a INNER JOIN nop_job_fair AS b INNER JOIN event_manager AS c WHERE a.comp_id = b.comp_id AND b.event_id = c.event_id AND c.status = 'Active' ORDER BY b.total_attendees DESC")->fetchAll();
                    foreach($q_nop_jf AS $nop_data){
                        $event_id_nop = $nop_data["event_id"];
                        $comp_id_nop =  $nop_data["comp_id"];
                        $comp_name_nop = $nop_data["comp_name"];
                        $comp_logo_nop = $nop_data["comp_logo"];  
                        $comp_city_nop = $nop_data["comp_city"];

                        //count remarks
                        //count hots 
                        $t_hots = "applicant_list_jf";
                        $c_hots = "*";
                        $w_hots = ["AND"=>["comp_id"=>$comp_id_nop,"event_id"=>$event_id_nop,"remarks"=>"Hired on the spot"]];
                        $q_hots = $database->count($t_hots,$c_hots,$w_hots);

                        //count exam 
                        $t_exam = "applicant_list_jf";
                        $c_exam = "*";
                        $w_exam = ["AND"=>["comp_id"=>$comp_id_nop,"event_id"=>$event_id_nop,"remarks"=>"For Examination"]];
                        $q_exam = $database->count($t_exam,$c_exam,$w_exam);

                         //count ffi 
                        $t_ffi = "applicant_list_jf";
                        $c_ffi = "*";
                        $w_ffi = ["AND"=>["comp_id"=>$comp_id_nop,"event_id"=>$event_id_nop,"remarks"=>"For Final Interview"]];
                        $q_ffi = $database->count($t_ffi,$c_ffi,$w_ffi);

                        //count fsi
                        $t_fsi = "applicant_list_jf";
                        $c_fsi = "*";
                        $w_fsi = ["AND"=>["comp_id"=>$comp_id_nop,"event_id"=>$event_id_nop,"remarks"=>"For Second Interview"]];
                        $q_fsi = $database->count($t_fsi,$c_fsi,$w_fsi);

                         //count fr
                        $t_fr = "applicant_list_jf";
                        $c_fr = "*";
                        $w_fr = ["AND"=>["comp_id"=>$comp_id_nop,"event_id"=>$event_id_nop,"remarks"=>"For Requirements"]];
                        $q_fr = $database->count($t_fr,$c_fr,$w_fr);

                         //count f
                        $t_f = "applicant_list_jf";
                        $c_f = "*";
                        $w_f = ["AND"=>["comp_id"=>$comp_id_nop,"event_id"=>$event_id_nop,"remarks"=>"Failed"]];
                        $q_f = $database->count($t_f,$c_f,$w_f);

                         //count o
                        $t_o = "applicant_list_jf";
                        $c_o = "*";
                        $w_o = ["AND"=>["comp_id"=>$comp_id_nop,"event_id"=>$event_id_nop,"remarks"=>"Others"]];
                        $q_o = $database->count($t_o,$c_o,$w_o);

                        //count all
                        $t_total = "applicant_list_jf";
                        $c_total = "*";
                        $w_total = ["AND"=>["comp_id"=>$comp_id_nop,"event_id"=>$event_id_nop]];
                        $q_total = $database->count($t_total,$c_total,$w_total);

                        $decoded_img_profile_nop = base64_decode($comp_logo_nop);
                        $f = finfo_open(); 
                        $img_type_profile_nop = finfo_buffer($f, $decoded_img_profile_nop, FILEINFO_MIME_TYPE);

                        echo '<div class="col-sm-6 col-md-3 product-grid">
                              <div class="thumbnail">
                                <div class="product-location">
                                  <span class="fa-map-marker fa"></span><b> '.$comp_city_nop.'</b>
                                  </div>                                  
                                    <img src="data:'.$img_type_profile_nop.';base64,'.$comp_logo_nop.'" style="width:100px;height:200px;border-style:solid;border-color:black;border-width:2px;">
                              
                                <div style="background-color:#8a8a5c;margin-top:5px;padding-top:3px;padding-bottom:3px;">
                                    <h4 style="color:white;font-size:11px;">&nbsp;'.$comp_name_nop.'</h4>
                                </div>
                                <h4>&nbsp;Total Attendees :&nbsp; '.$q_total.'</h4> 
                                <div class="caption"> 

                                  <p>Hired On the Spot : <label class="pull-right" style="padding-right:75px;">'.$q_hots.' </label>
                                  </p>
                                  <p>For Final Interview : 
                                      <label class="pull-right" style="padding-right:75px;">'.$q_ffi.' </label>
                                  </p>
                                  <p>For Second Interview : 
                                      <label class="pull-right" style="padding-right:75px;">'.$q_fsi.' </label>
                                  </p>
                                  <p>For Examination : 
                                      <label class="pull-right" style="padding-right:75px;">'.$q_exam.' </label>
                                  </p>
                                  <p>For requirements : 
                                      <label class="pull-right" style="padding-right:75px;">'.$q_fr.' </label>
                                  </p>
                                  <p>For Failed : 
                                    <label class="pull-right" style="padding-right:75px;"> '.$q_f.' </label>
                                  </p>
                                  <p>Others : 
                                    <label class="pull-right" style="padding-right:75px;"> '.$q_o.' </label>
                                  </p>
                                </div>
                              </div>
                            </div>';
                    }
                  
                  ?>

                    </div>
                  </div>
              </div>

            </div>
          <!-- end: content -->
          <?php include('chat_company.php'); ?>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="e2e_company_home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                      <a href="e2e_company_add_applicant.php"><i class="glyphicon glyphicon-user"></i>&nbsp; Add Applicant</a>
                      <a href="e2e_company_applicant_list.php"><i class="fa fa-paste"></i>&nbsp; Applicant(s) list</a>
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

<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script src="asset/js/plugins/chart.min.js"></script>
<!-- custom -->
<script src="asset/js/plugins/holder.min.js"></script>
<script src="asset/js/main.js"></script>

<!-- end: Javascript -->
</body>
</html>