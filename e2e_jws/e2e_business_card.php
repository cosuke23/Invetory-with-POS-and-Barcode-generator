<?php
  ob_start("ob_gzhandler");
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
            <li class="user-name"><span>&nbsp; Hi'
              <?php echo  $title." ".$fname ; ?>&nbsp;</span>
            </li>
            <li class="dropdown avatar-dropdown">
              <?php
                echo '<img src="data:'.$img_type_profile.';base64,'.$profileData.'" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
              ?>
              <ul class="dropdown-menu user-dropdown">
                <li><a href="my_account.php"><span class="fa fa-user"></span> My Profile</a></li>
                <li><a href="logout.php"><span class="fa fa-power-off"></span> Log out</a></li>
              </ul>
            </li>
             <!--START: COUNT MESSAGE-->
               <li><a href="#" class="opener-right-menu"><span class="fa fa-weixin"></span>
                  <?php
                  $c_unread_chat = $database->count("messenger",["AND"=>["receiver" => $sender_user,"message_status"=>'unread']]);
                  if($c_unread_chat == 0){
                    echo "";
                  }
                  else{
                    echo '<div class="badge" style="background:red;">'.$c_unread_chat.'</div>';
                  }
                  ?>
                </a></li>
					<!--END: COUNT MESSAGE-->
          </ul>
        </div>
      </div>
    </nav>
    <!-- end: Header -->
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
                          <a href="e2e_admin_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label><a href="e2e_student_records.php">
                          <i class="glyphicon glyphicon-tasks"></i>Student Records</a>
                        </label><br>
                        <label><a href="e2e_company_records.php">
                          <i class="glyphicon fa fa-building-o"></i>Company Records</a>
                        </label><br>
                        <label><a href="e2e_reports.php">
                          <i class="glyphicon fa fa-thumbs-o-up"></i>Reports</a>
                        </label><br>
                        <label><a href="e2e_grad_id.php">
                          <i class="glyphicon fa fa-smile-o"></i>Graduating ID Card</a>
                        </label><br>
                        <label class="active"><a href="e2e_business_card.php">
                          <i class="glyphicon icons icon-credit-card"></i>Business Card</a>
                        </label><br>
                        <label><a href="e2e_event_manager.php">
                          <i class="glyphicon glyphicon-list-alt"></i>Event Manager</a>
                        </label><br>
                        <?php
                        if($usertype == 1){
                          echo '<label><a href="e2e_user_account.php">
                          <i class="glyphicon fa fa-user"></i>User Account</a>
                        </label><br>';
                        echo '<label><a href="audit_trail.php">
                          <i class="glyphicon fa fa-folder-open"></i> Audit Trail</a>
                        </label><br>';
                        }
                        ?>
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->

    <!-- start: Content -->
    <div class="container-fluid mimin-wrapper">
      <div id="content">

        <div class="panel box-shadow-none content-header">
          <div class="panel-body">
            <div class="col-md-12">
              <h1 class="animated fadeInLeft">BUSINESS CARD</h1>
              <p class="animated fadeInDown" style="padding-left:10px;">
                Print copies of student business cards.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-12 padding-0"><!-- Yow -->

          <div class="col-md-12">
            <div class="panel">
              <div class="panel-heading"><h3>GENERATE BUSINESS CARD</h3>
              </div>
              <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
                <li role="presentation" class="active">
                  <a href="#tab_sa1" id="tabs_sa1" role="tab" data-toggle="tab" aria-expanded="false">
                    <span class="fa fa-credit-card"></span> Generate Business Card
                  </a>
                </li>
              </ul>
              <div id="tabsDemo4Content" class="tab-content tab-content-v4">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_sa1" aria-labelledby="tab_sa1">
                  <div class="panel-body">
                    <form action="grad_id/grad_data/generate_b_card.php" method="post" id="defaultForm">

                      <div class="row">
                        <div class="col-md-12">
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="stud_no" id="stud_no" class="form-control" maxlength="11" placeholder="Type student Number..."/>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row"><!--Select Theme-->
                        <div class="col-md-12">
                          <h5 style="padding-left:20px;">SELECT THEME</h5>

                          <div class="col-md-3">
                            <input type="radio" name="b_card_theme" id="b_card_theme_a" value="puzzle" checked="true">
                            <img src="asset/img/puzzle_theme_select.png" style="width:200px;height:100px;border:1px solid #666666" onclick="try{document.getElementById('b_card_theme_a').checked=true;}catch(e){};return true;" ><br><br>
                            <div class="centerBlock" style="display: table; margin: auto;">
                              <p style="">Puzzle</p>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <input type="radio" name="b_card_theme" id="b_card_theme_b" value="box">
                            <img src="asset/img/box_theme_select.png" style="width:200px;height:100px;border:1px solid #666666" onclick="try{document.getElementById('b_card_theme_b').checked=true;}catch(e){};return true;" ><br><br>
                            <div class="centerBlock" style="display: table; margin: auto;">
                              <p style="">Box</p>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <input type="radio" name="b_card_theme" id="b_card_theme_c" value="abstract">
                            <img src="asset/img/abstract_theme_select.png" style="width:200px;height:100px;border:1px solid #666666" onclick="try{document.getElementById('b_card_theme_c').checked=true;}catch(e){};return true;" ><br><br>
                            <div class="centerBlock" style="display: table; margin: auto;">
                              <p style="">Abstract</p>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <input type="radio" name="b_card_theme" id="b_card_theme_d" value="colorful_box">
                            <img src="asset/img/colorful_box_theme_select.png" style="width:200px;height:100px;border:1px solid #666666" onclick="try{document.getElementById('b_card_theme_d').checked=true;}catch(e){};return true;" ><br><br>
                            <div class="centerBlock" style="display: table; margin: auto;">
                              <p style="">Colorful Box</p>
                            </div>
                          </div>
                        </div>
                      </div> <!--end Select Theme-->

                      <div class="row">
                        <div class="col-md-12">
                          <div class="col-md-8"></div>
                          <div class="col-md-4">
                            <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary"  name="btn_gen_data" id="btn_gen_data">
                              <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;GENERATE CARDS
                            </button>
                          </div>
                        </div>
                      </div><br>
                    </form>
                  </div><!--end of panel body1-->
                </div><!--end of tab1-->
              </div>
            </div><!--end of main div of tab-->
          </div><!--end of check grad id table div 1-->

          <!--start of check grad id table-->
          <div class="panel box-shadow-none content-header">
          </div><!--end of check grad id table div 2-->

          <div class="col-md-12 padding-0">
            <div class="col-md-12">
              <div class="panel">
                <div class="panel-heading"><h3>CHECK BUSINESS CARD ISSUANCE</h3>
                </div>
                <div class="panel-body">
                  <div class="responsive-table">
                    <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th class="col-md-1"></th>
                          <th class="text-center" style="width:150px;">STUDENT NUMBER</th>
                          <th class="text-center">LASTNAME</th>
                          <th class="text-center">FIRSTNAME</th>
                          <th class="text-center">MIDDLENAME</th>
                          <th class="text-center" style="width:230px;"># OF PRINT</th>
                          <th class="text-center" style="width:20px;"></th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div><!--end of check grad id table div 3-->

        </div><!-- end: Yow -->

      </div><!-- end: content -->
	    
    </div>

   <!-- START: RIGHT MENU-->
          <?php
            require ("chat.php");
          ?>
		  <!-- END: RIGHT MENU-->

    <!-- start: Mobile -->
    <div id="mimin-mobile" class="reverse">
      <div class="mimin-mobile-menu-list">
        <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
          <ul class="nav nav-list">
            <li class="ripple">
              <a href="e2e_home.php"><i class="glyphicon glyphicon-home"></i>
                &nbsp; Home</a>
              <a href="e2e_student_records.php"><i class="glyphicon glyphicon-tasks"></i>
                &nbsp; Student Records</a>
              <a href="e2e_company_records.php"><i class="glyphicon fa fa-building-o"></i>
                &nbsp; Company Records</a>
              <a href="*"><i class="glyphicon fa fa-thumbs-o-up"></i>
                &nbsp; OJT Endorsement</a>
              <a href="*"><i class="glyphicon fa fa-user-secret"></i>
                &nbsp; Check Attire</a>
              <a href="*"><i class="glyphicon fa fa-smile-o"></i>
                &nbsp; Graduating ID Card</a>
              <a href="*"><i class="glyphicon icons icon-credit-card"></i>
                &nbsp; Business Card</a>
              <a href="e2e_event_manager.php"><i class="glyphicon glyphicon-list-alt"></i>
                &nbsp; Event Manager</a>
              <a href="*"><i class="glyphicon fa fa-user"></i>
                &nbsp; User Account</a>
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
    <script>
      $(document).ready(function(){
        $('#datatables').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": "e2e_student_b_card_processing.php",
          lengthMenu: [[10, 50, -1], [10, 50, "All"]],

        });

        $('#defaultForm').bootstrapValidator({
          message: 'This value is invalid',
          feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid:'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            stud_no: {
              validators: {
                notEmpty: {
                  message: 'Student number is required and can\'t be empty'
                },
                regexp: {
                  regexp: /[0-9]+$/,
                  message: 'Student number can only consist of numbers'
                },
                stringLength: {
                  min: 11,
                  max: 11,
                  message: 'Student number must be 11 numbers'
                }
              }
            }
          }
        });
      });
    </script><!-- end: Javascript -->

  </body>
</html>
