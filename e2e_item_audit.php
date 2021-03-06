<?php
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';

///COOKIE CODES
if(!isset($_COOKIE["uid"])) {
  header ("Location: e2e_login.php");
  exit;
}
$user_id = $_COOKIE["uid"];

    $table = "user_info";
    $columns = "*";
    $where = ["user_id" => $user_id];

    $q_user_info =$database->select($table,$columns,$where);

    foreach ($q_user_info as $q_user_info_data)
    {
          $lname = $q_user_info_data["lname"];
          $fname = $q_user_info_data["fname"];
          $mname = $q_user_info_data["mname"];
          $title = $q_user_info_data["title"];
          $profileData = $q_user_info_data["profileData"];
          $coverData = $q_user_info_data["coverData"];
          $usertype =  $q_user_info_data["usertype"];
		    $sender_user = $q_user_info_data["username"];

         $decoded_img_profile = base64_decode($profileData);
         $f = finfo_open();
         $img_type_profile = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);

         $decoded_img_cover = base64_decode($coverData);
         $f = finfo_open();
         $img_type_cover = finfo_buffer($f, $decoded_img_cover, FILEINFO_MIME_TYPE);

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
                 <b>E2E INVENTORY</b>
                </a>
				
				<ul class="nav navbar-nav navbar-right user-nav">
			  
                <li class="animated fadeInRight" style="color:white;margin-left:10px;margin-top:20px;">
				<span>                        
						<?php 
							echo  date("l, F j, Y -|-  h:i:sa"); 
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
                       echo '<img src="data:' .$img_type_profile.';base64,'.$profileData.'"style="height:100%;" class="img-responsive">';
                       ?> 
					<div class="panel panel-default">
					<div class="panel-body"><h5>&nbsp; Hi' <?php echo  $title." ".$fname." ".$mname." ".$lname ?>&nbsp;</h5></div> 
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
                        <label><a href="#">
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
		  
          <div class="container-fluid mimin-wrapper">
          <!-- start: Content -->

            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">ITEM AUDIT TRAIL</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;" >
                           View the audit trail of items.
                        </p>                                                        
              
                    <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                        <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-list-alt"></span> AVAILABLE STOCKS</a>
                      </li>
                         
                    </ul>  
                      </div><!-- col-md-12 -->
                </div><!-- panel-body -->
              </div><!-- panel box-shadow-none -->                                      
                                

								
								
				<!-- Javascript -->
				
                      <?php
                      if(isset($_GET['delete_item'])&&isset($_GET['username'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Deleted Item!",
                            html: true,
                           text: "<strong> Deleted Item with ID:'. $_GET['username'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_stocks.php";
                           }
                         });
                     </script>';
                      }

                      if(isset($_GET['delete_cancelled'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Deleted Item Cancelled!",
                            html: true,
                           text: "<strong> Deletion of Item is Cancelled.</strong>",
                           type: "success",
                           showCancelButton: false,
                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_stocks.php";
                           }
                         });
                     </script>';
                      }
					  
					  
					  /* JAVASCRIPT FOR ADD
					  
                      if(isset($_GET['add_event'])&&isset($_GET['event_name'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Added Event!",
                            html: true,
                           text: "<strong> Added Event Name: '. $_GET['event_name'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager.php";
                           }
                         });
                     </script>';
                      }
					  
					  */
					  

                      if(isset($_GET['change_batch'])&&isset($_GET['active_date'])&&isset($_GET['active_batch'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Updated Item!",
                            html: true,
                           text: "<strong> Event Date: '. $_GET['active_date'] .' - Batch Active: '. $_GET['active_batch'] .'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_stocks.php";
                           }
                         });
                     </script>';
                      }
					  
					 
                      ?>

				
					<!-- End Javascript -->				  
					  
					  
					  
					  
                      <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-body">
                      <div class="col-md-12">
                       <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                       
                      <!-- First Tab (Available Stocks) -->
                      <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-4" align="center">
                              <?php
                                $table_em  ="audit_trails";
                                $columns_em = "*";
								$where_em = ["date"=>"1"];
                                $q_em = $database->select($table_em,$columns_em,$where_em);
                                foreach($q_em AS $q_em_data){
								 
								  $audit_id = $item_data['audit_id'];
								  $date = $item_data['date'];
								  $actiontaken = $item_data['actiontaken'];
								  $user = $item_data['user'];
								  $module = $item_data['module'];
								
								
                                }    
								
								
                              

                              ?>
                            </div>
                          </div>
                        </div>
                        
				
						
						<?php
                          $table = "audit_trails";
                          $columns = "*";
                          $q_item_audit =$database->select($table,$columns);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="text-center">ITEM NUMBER</th>
                          <th class="text-center">AUDIT DATE</th>
                          <th class="text-center">ACTION TAKEN</th>
                          <th class="text-center">USER</th>
						  <th class="text-center">MODULE</th>
						  </tr>
                          </thead>
                          <tbody>';

                          foreach($q_item_audit as $item_data){
                          $audit_id = $item_data['audit_id'];
                          $date = $item_data['date'];
                          $actiontaken = $item_data['actiontaken'];
						  $user = $item_data['user'];
						  $module = $item_data['module'];
                          ?>    						  
						  
                          <tr>
                          <td><?php echo $audit_id; ?></td>
                          <td><?php echo $date; ?></td>
                          <td><?php echo $actiontaken; ?></td>
                          <td><?php echo $user; ?></td>
                          <td><?php echo $module; ?></td>
                          </tr>
						
                          <?php
                          }
                          print '</tbody>
                          </table>
                          </div>
                          </div>';
                        ?>
                      </div>
					  
                  </div>

                  </div>
                </div>
              </div>
              </div>
              </div>




            </div><!-- end: content -->
            </div>

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
                      <a href="*"><i class="glyphicon fa fa-smile-o"></i>&nbsp; Graduating ID Card</a>
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

<<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
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
<script type="text/javascript">
  $(document).ready(function(){
 var js_event_dates = document.getElementById('event_dates');
 var table = $('#datatables').DataTable();
 var table = $('#datatables1').DataTable();
 var table = $('#datatables2').DataTable();
 });
</script>
<!-- end: Javascript -->
</body>
</html>