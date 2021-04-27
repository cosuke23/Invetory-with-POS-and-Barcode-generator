<?php
ob_start("ob_gzhandler");
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
   <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>

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
  <link rel="stylesheet" type="text/css" href="asset/css/sweetalert.css"/>
  <script src="asset/js/jquery.confirm.min.js"></script>
  <script src="asset/js/sweetalert-dev.js"></script>
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
                     <li><a href="m#"><span class="fa fa-user"></span> My Profile</a></li>
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
                        <label>
                          <a href="e2e_company_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label class="active">
                        <a href="e2e_company_add_applicant.php"><i class="glyphicon glyphicon-user"></i>Add Applicant</a>
                      </label><br>
                      <label>
                        <a href="e2e_company_applicant_list.php"><i class="fa fa-paste"></i>Applicant(s) List</a>
                      </label><br>       
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->
          <div class="container-fluid mimin-wrapper">
          <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">ADD APPLICANT</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;"> 
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      
                      <!--start of tabs-->
                    
                     <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#tabs-demo4-area1" id="tabs-demo4-1" role="tab" data-toggle="tab" aria-expanded="true">RESUME DATA</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tabs-demo4-area2" role="tab" id="tabs-demo4-2" data-toggle="tab" aria-expanded="false">ADD TO YOUR APPLICANT LIST</a>
                      </li>
                    </ul>
                    </div>
                    <div class="row">
                      <div class="col-md-12">

                         <?php
                         if(isset($_GET['success']) && isset($_GET['stud_no']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['mname'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $lname_up = $_GET['lname'];
                              $fname_up = $_GET['fname'];
                              $mname_up = $_GET['mname'];
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Applicant Successfully Added to your List!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$lname_up.', '.$fname_up.' '.$mname_up.'<br> was Sucessfully Updated!</strong> ",
                                type: "success",
                                showCancelButton: false,
                                
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_company_add_applicant.php";
                                }
                              });
                          </script>';
                            }  
                           
                            ?>
                        </div>
                      </div>

                    <div class="panel-body">
                        <?php
                        if(isset($_GET['stud_no'])){
                          $stud_no = $_GET['stud_no'];
                          $q_data = $database->query("SELECT a.lname,a.fname,a.mname,.a.stud_dp,b.program_code,a.contact_no,a.address,a.email FROM student_info AS a INNER JOIN program_list AS b  where a.stud_no = '$stud_no' AND a.program_id = b.program_id");
                          foreach($q_data AS $q_Data){
                            $lname = $q_Data['lname'];
                            $fname = $q_Data['fname'];
                            $mname = $q_Data['mname'];
                            $stud_dp = $q_Data['stud_dp'];
                            $program_code = $q_Data['program_code'];
                            $contact_no = $q_Data['contact_no'];
                            $address = $q_Data['address'];
                            $email = $q_Data['email'];
                          }
                          $tbl_res = "resume_data";
                          $columns_res = "*";
                          $where_res = ["stud_no"=>$stud_no];
                          $q_resume = $database->select($tbl_res,$columns_res,$where_res);

                          foreach($q_resume as $q_res_data){
                            $resume_id = $q_res_data["resume_id"];
                            $file_name = $q_res_data["file_name"];
                          }
                         }

                         $q_data_applicant_jf = $database->query("SELECT a.job_fair_id,a.event_id FROM nop_job_fair AS a INNER JOIN event_manager AS b WHERE a.comp_id = '$comp_id' AND a.event_id = b.event_id AND b.status = 'Active'");
                         foreach($q_data_applicant_jf AS $q_Data_jf){
                          $job_fair_id = $q_Data_jf['job_fair_id'];
                          $event_id = $q_Data_jf['event_id'];

                        
                          $table = "applicant_list_jf";
                          $columns  = "*";
                          $where = ["AND"=>["stud_no"=>$stud_no,"event_id"=>$event_id,"comp_id"=>$comp_id]];

                          $q_data_app_jf_check = $database->count($table,$columns,$where);
                          if($q_data_app_jf_check == ""){
                            $show = "";
                            $value = 4;
                            $based_status = 0;
                          }elseif($q_data_app_jf_check != ""){
                            $show = "none";
                            $value = 8;
                            $based_status = 1;
                          }
                         }
                        ?>

                    <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                    <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo4-area1" aria-labelledby="tabs-demo4-area1">
                        <div class="col-md-12">
                            <iframe height="750px" width="100%" src="asset/resume_data/<?php echo $file_name; ?>"
                            frameborder="0"></iframe>
                          </div>

                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area2" aria-labelledby="tabs-demo4-area2">
                      <?php
                      if($based_status == 1){
                          echo '<div class="row" style="background-color:orange;">
                          <div class="col-md-12">
                            <div class="col-md-6">
                               <h4 style="color:white;"><b>THIS STUDENT ALREADY IN YOUR LIST</b></h4>
                            </div>
                            
                          </div>
                        </div><br>';
                      }
                      ?>

                            <div class="row">
                           <div class="col-md-3"> 
                           <?php 
                             echo '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="border:1px;height:200px;width:200px;">';
                             ?>
                           </div>
                           <div class="col-md-3">
                              <h4>PROGRAM : <?php echo $program_code; ?></h4>
                           </div>
                           <div class="col-md-9">
                              <h4>CONTACT NUMBER : <?php echo $contact_no; ?></h4>
                           </div>
                           <div class="col-md-9">
                              <h4>ADDRESS : <?php echo $address; ?></h4>
                           </div>
                           <div class="col-md-9">
                              <h4>EMAIL : <?php echo $email; ?></h4>
                           </div>
                        </div>
                        <br>
                       <div class="row" style="background-color:#3385ff;">
                          <div class="col-md-12">
                            <div class="col-md-6">
                               <h4 style="color:white;"><b>STUDENT NAME:  <?php echo $lname. " ".$fname.", ".$mname; ?></b></h4>
                            </div>
                            <div class="col-md-6">
                               <h4 style="color:white;"><b>STUDENT NUMBER: <?php echo $stud_no; ?></b></h4>
                            </div>
                          </div>
                        </div>
                       
                        <form action="e2e_company_add_applicant_student_process.php" id="defaultForm" method="POST">
                          <input type="hidden" name="stud_no" value="<?php echo $stud_no; ?>"/>
                          <input type="hidden" name="job_fair_id" value="<?php echo $job_fair_id; ?>"/>
                          <input type="hidden" name="comp_id" value="<?php echo $comp_id; ?>"/>
                          <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                          <input type="hidden" name="student_name" value="<?php echo $lname.", ".$fname." ".$mname; ?>">
                          <div class="row" style="display:<?php echo $show; ?>">
                            <div class="col-md-12" >
                              <div class="col-md-5">
                              <h5 style="padding-left:5px;">REMARKS</h5>
                              <div class="form-group has-feedback">
                                  <select class="form-control" name="remarks">
                                    <option value=""></option>
                                    <option value="For Second Interview">For Second Interview</option>
                                    <option value="For Final Interview">For Final Interview</option>
                                    <option value="For Examination">For Examination</option>
                                    <option value="For Requirements">For Requirements</option>
                                    <option value="Hired on the spot">Hired on the spot</option>
                                    <option value="Failed">Failed</option>
                                    <option value="Others">Others</option>                            
                                </select>
                              </div>

                              </div>
                              <div class="col-md-5">
                                <h5 style="padding-left:5px;">OTHERS</h5>
                                <div class="form-group has-feedback">
                                  <input type="text" name="others" id="others" class="form-control" maxlength="200" placeholder="specify remarks" />
                                </div>
                               </div>
                              </div>
                              
                            </div>
                            <br>
                             <div class="row">
                            <div class="col-md-<?php echo $value; ?>"></div>
                            <div class="col-md-4" style="display:<?php echo $show; ?>">
                                 <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_add_applicant" id="btn_add_applicant">
                                  <span class="glyphicon glyphicon-plus"></span> &nbsp;ADD
                                 </button>
                             </div>
                              <div class="col-md-4">
                               <a href="e2e_company_add_applicant.php"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                             </div>
                          </div>
                        </form>
                      </div>
                    </div>
                 
                     </div>
                  </div>
                </div>
              </div>
            </div><!-- end: content -->
			
          <!-- start: right menu -->
          <?php include('chat_company.php'); ?>
          <!-- end: right menu -->
          
      </div>

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
<script src="asset/js/plugins/moment.min.js"></script>
<script src="asset/js/plugins/jquery.datatables.min.js"></script>
<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>

<script src="asset/js/plugins/jquery.knob.js"></script>
<script src="asset/js/plugins/ion.rangeSlider.min.js"></script>
<script src="asset/js/plugins/bootstrap-material-datetimepicker.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>
<script src="asset/js/plugins/jquery.mask.min.js"></script>
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
  $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                remarks: {
                    message: 'Remarks is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Remarks is required and can\'t be empty'
                        },
                    }
                },
              }
        }) 
});
</script>
<!-- end: Javascript -->
</body>
</html>