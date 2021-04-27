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
                        <label>
                        <a href="e2e_company_add_applicant.php"><i class="glyphicon glyphicon-user"></i>Add Applicant</a>
                      </label><br>
                      <label class="active">
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
                        <h1 class="animated fadeInLeft">APPLICANT LIST</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;"> 
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#tabs-demo4-area1" id="tabs-demo4-1" role="tab" data-toggle="tab" aria-expanded="true">CURRENT APPLICANT LIST</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tabs-demo4-area2" role="tab" id="tabs-demo4-2" data-toggle="tab" aria-expanded="false">APPLICANT RECORDS</a>
                      </li>
                    </ul>
                    </div>
                     <br>
                    <div class="row">
                      <div class="col-md-12">

                         <?php
                         if(isset($_GET['success']) && isset($_GET['stud_no']) && isset($_GET['student_name'])) 
                            {   
                              $stud_no_up = $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                             echo '<script language = javascript>
                             swal({
                                title: "Applicant was Successfully Added to your List!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$student_name.'</strong> ",
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
                            }elseif(isset($_GET['success1']) && isset($_GET['stud_no']) && isset($_GET['student_name'])){   
                              $stud_no_up = $_GET['stud_no'];
                              $student_name = $_GET['student_name'];
                             
                            
                             echo '<script language = javascript>
                             swal({
                                title: "Applicant Info was successfully Updated!",
                                 html: true,
                                text: " <strong>Student Number : '. $stud_no_up.' <br> Student Name : '.$student_name.'</strong> ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_company_applicant_list.php";
                                }
                              });
                          </script>';
                            }
                            elseif(isset($_GET['deleted'])){   
                             echo '<script language = javascript>
                             swal({
                                title: "Student was successfully remove to your list!",
                                 html: true,
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm){
                                if (isConfirm) {
                                  window.location.href="e2e_company_applicant_list.php";
                                }
                              });
                          </script>';
                            }  
                           
                            ?>
                        </div>
                      </div>

                    <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                    <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo4-area1" aria-labelledby="tabs-demo4-area1">
						
					 <div class="row">
                          <div class="col-md-12">
                             <div class="col-md-8">
                              <?php
                                $table_em  ="event_manager";
                                $columns_em = "*";
                                $where_em = ["status"=>"Active"];
                                $q_em = $database->select($table_em,$columns_em,$where_em);
                                foreach($q_em AS $q_em_data){
                                    $event_id = $q_em_data["event_id"];
                                    $event_name = $q_em_data["event_name"];
                                    $event_date = $q_em_data["event_date"];
                                    $event_semester = $q_em_data["semester"];
                                    $acad_year_start_seminar = $q_em_data["acad_year_start_seminar"];
                                    $acad_year_end_seminar = $q_em_data["acad_year_end_seminar"];
                                    $batch_active = $q_em_data["batch_active"];
                                    $batch_no = $q_em_data["batch_no"];
                                }
                              ?>

                              <h5><b>EVENT NAME: <?php echo $event_name; ?></b></h5>
                               <h5><b>EVENT DATE: <?php echo $event_date." || Semester: ".$event_semester." || S.Y.: ".$acad_year_start_seminar." - ".$acad_year_end_seminar." || Batch Active : ".$batch_active; ?></b></h5>
                               <input type="hidden"  id = "event_name" value ="<?php echo $event_name; ?>" />
                               <input type="hidden"  id = "event_date" value ="<?php echo $event_date; ?>" />
                               <input type="hidden"  id = "sy" value ="<?php echo $acad_year_start_seminar." - ".$acad_year_end_seminar; ?>" />
                               <input type="hidden"  id = "sem" value ="<?php echo $event_semester;  ?> "> 
                               </div>
							   <div class="row">
							
							<div class="col-md-3 pull-right" style="padding-top:6px;padding-right:30px;">
								<a href="download_all_resume.php?comp_id=<?php echo $comp_id?>&event_id=<?php echo $event_id?>" target="_blank" type="submit" class="btn btn-primary btn-block" name="btn_allresumedownload" id="btn_allresumedownload">
									<span class="fa fa-download"></span>&nbsp; Download All Resume 
									</a>
							</div>
							
								
							
                            <div class="col-md-4">
                              <div id="buttons" class="pull-right" style="padding-top:6px;padding-right:5px"></div>
                            </div>
							
							
							
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
                          <th class="text-center">STUDENT NAME</th>
                          <th class="text-center">PROGRAM</th>
                          <th class="text-center">CONTACT</th>
                          <th class="text-center">REMARKS</th>
                          <th class="text-center">OTHERS</th>
                          <th class="text-center" style="width:120px;">ACTION</th>               
                        </tr>
                      </thead>
                      <tbody></tbody>
                     </table>
                      </div>
                      </div>
                     </div><!--end of div for tab 1-->
                     <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area2" aria-labelledby="tabs-demo4-area2">
                     <div class="row">
                          <div class="col-md-12">
                             <div class="col-md-8">
                               </div>
                            <div class="col-md-4">
                              <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                        </div> 
                        </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables_records"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                        <th class="col-md-1"></th>
                         <th class="text-center">STUDENT NUMBER</th>
                          <th class="text-center">STUDENT NAME</th>
                          <th class="text-center">PROGRAM</th>
                          <th class="text-center">CONTACT</th>
                          <th class="text-center">REMARKS</th>
                          <th class="text-center">OTHERS</th>
                          <th class="text-center">EVENT</th>
                          <th class="text-center">SEM & SY</th>           
                        </tr>
                      </thead>
                      <tbody></tbody>
                     </table>
                      </div>
                      </div>
                     </div>
                     </div><!--end of div for tabs-->
                  </div>
                </div>
              </div>
            </div><!-- end: content -->
			          <?php include('chat_company.php'); ?>

          <!-- start: right menu -->
            <div id="right-menu">
              
            </div>  
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
<input type="hiddent" id="cmpname" name="cmpname" value="<?php 

$query = "SELECT * FROM company_info WHERE comp_id  = ".$comp_id."";
$result = $database->query($query)->fetchAll();
	
	foreach($result AS $row){
        echo $row["comp_name"];

    }


?>"></input>
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
var event_name =   document.getElementById('cmpname').value + " "+ document.getElementById('event_name').value + " Applicant List";
var event_date = document.getElementById('event_date').value;
var sy = document.getElementById('sy').value;
var sem = document.getElementById('sem').value;
$(document).ready(function(){
  //$.fn.dataTable.ext.errMode = function(settings,helpPage,message){
    //pending_table.ajax.reload(null, false);
  //}
 $('#datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "current_company_applicant_list_processing.php",
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },
  });

 $('#datatables_records').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "applicant_records_company_applicant_list_processing.php",
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },
  });

  var table = $('#datatables').DataTable();
 var buttons = new $.fn.dataTable.Buttons(table, {

     buttons: [
            {
                extend: 'excelHtml5',
                title: event_name,    
                message: 'Date : '+event_date,     
                text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                 className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,2,3,4,5,6]
                }
            },
            {
                extend: 'print',
                title: event_name,
                message: 'Date : '+event_date+' || Semester : '+sem+' || SY : '+sy, 
                text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,2,3,4,5,6]
                }
            },
            {
                extend: 'pdf',
                title: event_name,
                message: 'Date : '+event_date+' || Semester : '+sem+' || SY : '+sy, 
                text: '<i class="glyphicon glyphicon-print"></i> PDF',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [1,2,3,4,5,6]
                }
            },
        ]
    }).container().appendTo($('#buttons')); 

 });
</script>
<!-- end: Javascript -->
</body>
</html>