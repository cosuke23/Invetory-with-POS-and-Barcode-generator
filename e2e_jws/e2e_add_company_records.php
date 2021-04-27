<?php
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
require 'asset/connection/mysqli_dbconnection.php';
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

$rnd_ai = (mt_rand(1000,10000));
$year = date('Y');
$comp_user = 'CMP'.$year.$rnd_ai ;

$current_year = date("Y") - 1;
$next_year = date("Y")+1;

$current_year_jf = date("Y") - 1;
$next_year_jf = date("Y")+1;
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
                <li class="user-name"><span>&nbsp; Hi' <?php echo  $title." ".$fname; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <?php
                       echo '<img src="data:'.$img_type_profile.';base64,'.$profileData.'" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
                  ?>

                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="my_account.php"><span class="fa fa-user"></span> My Profile</a></li>
                     <li><a href="logout.php"><span class="fa fa-power-off"></span> Log out</a></li>
                  </ul>
                </li>
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
                          <a href="e2e_admin_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label><a href="e2e_student_records.php">
                          <i class="glyphicon glyphicon-tasks"></i>Student Records</a>
                        </label><br>
                        <label><a href="e2e_company_records.php">
                          <i class="glyphicon fa fa-building-o"></i>Company Records</a>
                        </label><br>
                        <label  class="active"><a href="e2e_reports.php">
                          <i class="glyphicon fa fa-thumbs-o-up"></i>Reports</a>
                        </label><br>
                        <label><a href="e2e_grad_id.php">
                          <i class="glyphicon fa fa-smile-o"></i>Graduating ID Card</a>
                        </label><br>
                        <label><a href="e2e_business_card.php">
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
          <div class="container-fluid mimin-wrapper">
          <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">COMPANY RECORDS</h1>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>ADD NEW COMPANY RECORDS</h3></div>
                    <br>
                    <form method="post" action="e2e_add_company_records_process.php" id="add_company" enctype="multipart/form-data">
                      <div class="panel-body" style="padding-bottom:30px;">
                         <input name="comp_id" type="hidden" value ="<?php echo $comp_id ?>"/>
                      <div class="row">
                        <div class="col-md-3">
                            <h5 style="padding-left:5px;">COMPANY USERNAME</h5>
                              <input type="hidden" name="comp_user" value="<?php echo $comp_user; ?>" />
                              <h4 style="padding-left:5px;"><?php echo $comp_user; ?></h4>
                        </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">COMPANY PICTURE &nbsp; <i class="fa fa-camera"></i> </h5>
                            <div class="form-group has-feedback">
                               <input type="file" name="comp_logo" class="form-control"  placeholder="Upload Image(Optional)"/>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <h5 style="padding-left:5px;">STATUS</h5>
                            <div class="form-group has-feedback">
                              <select class="form-control" name="status_company" class="form-control">
                                <option disabled selected>Select status</option>
                                <option value="Active">Active</option>
                                <option value="Not Active">Not Active</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                          <h5 style="padding-left:5px;">NATURE OF PARTNERSHIP</h5>
                          <div class="form-group has-feedback">
                            <div class="form-group has-feedback">
                              <select class="form-control" id="nop" name="nop" class="form-control">
                                <option disabled selected>Select NOP</option>
                                <option value="Job Fair">Job Fair</option>
                                <option value="Mock Interview">Mock Interview</option>
                                <option value="Seminar">Seminar</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <input name="comp_id" type="hidden" value ="<?php echo $comp_id; ?>"/>
                        <div class="col-md-7">
                          <h5 style="padding-left:5px;">COMPANY NAME</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="comp_name" class="form-control" placeholder="Company Name"/>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <h5 style="padding-left:5px;">DEPARTMENT</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="comp_dept" class="form-control" placeholder="Department"/>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <h5 style="padding-left:5px;">COMPANY DESCRIPTION</h5>
                          <div class="form-group has-feedback">
                            <textarea rows ="2" name="comp_desc" class="form-control" placeholder="(Optional) Company Description"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-8">
                          <h5 style="padding-left:5px;">COMPANY ADDRESS</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="comp_address" class="form-control" placeholder="Company Address"/>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">CITY</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="comp_city" class="form-control" placeholder="City"/>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <h5 style="padding-left:5px;">CONTACT PERSON</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="contact_person" class="form-control" placeholder="Contact Person" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <h5 style="padding-left:5px;">POSITION</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="position" class="form-control" placeholder="Position"/>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <h5 style="padding-left:5px;">CONTACT NUMBER</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="contact_no" class="form-control" placeholder="Contact Number"/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <h5 style="padding-left:5px;">EMAIL</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="email" class="form-control" placeholder="Email"/>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-7">
                          <h5 style="padding-left:5px;">TYPE OF INDUSTRY</h5>
                          <div class="form-group has-feedback">
                            <select class="form-control" id="type_industry" name="type_industry" class="form-control">
                                <option disabled selected>Select type of industry</option>
                                <option value="Accommodation and Food Services Activities">Accommodation and Food Services Activities</option>
                                <option value="Arts, Entertainment and Recreation">Arts, Entertainment and Recreation</option>
                                <option value="Education">Education</option>
                                <option value="Financial and Insurance Activities">Financial and Insurance Activities</option>
                                <option value="Human Health and Social Work Activities">Human Health and Social Work Activities</option>
                                <option value="Information and Communication">Information and Communication</option>
                                <option value="Professional, Scientific and Technical Activities">Professional, Scientific and Technical Activities</option>
                                <option value="Real Estate Activities">Real Estate Activities</option>
                                <option value="Wholesale & Retail Trade, Repair of Motor Vehicles & Motorcycles">Wholesale & Retail Trade, Repair of Motor Vehicles & Motorcycles</option>
                                <option value="Transport and Storage">Transport and Storage</option>
                                <option value="Administrative and Support Service Activities">Administrative and Support Service Activities</option>
                                <option value="Public Administration and Defense, Compulsory Social Security">Public Administration and Defense, Compulsory Social Security</option>
                                <option value="Construction">Construction</option>
                                <option value="Electricity, Gas, Steam and Air Conditioning Supply">Electricity, Gas, Steam and Air Conditioning Supply</option>
                                <option value="Manufacturing">Manufacturing</option>
                                <option value="Mining and Quarrying">Mining and Quarrying</option>
                                <option value="Water Supply, Sewerage, Waste Management and Remediation Activities">Water Supply, Sewerage, Waste Management and Remediation Activities</option>
                                <option value="Agriculture, Forestry and Fishing">Agriculture, Forestry and Fishing</option>
                                <option value="Others">Others</option>
                              </select>
                          </div>
                        </div>
                        <div id="other_industry" style="display:none;">
                          <div class="col-md-5">
                            <h5 style="padding-left:5px;">OTHERS</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="other_industry" class="form-control" placeholder="Others"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="job_fair" style="display:none;">
                        <div class="row">
                            <h3 style="margin-left:13px;">Job Fair</h3>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">EVENT NAME</h5>
                            <div class="form-group has-feedback">
                              <?php
                                $table = "event_manager";
                                $columns = "*";
                                $where = ["AND"=>["type" => 'Job Fair',"status" => 'Active']];
                                $q_jf =$database->select($table,$columns,$where);

                                print'<select class="form-control"  name="jf" class="form-control">';
                                echo "<option value='".$jf_event_id."' disabled selected>".$jf_event_name."</option>";

                                foreach($q_jf as $q_jf_data){
                                  $jf_event_id2 = $q_jf_data['event_id'];
                                  $jf_event_name2 = $q_jf_data['event_name'];
                                  $counter = 0;

                                  $comstart3="";
                                  if($jf_event_name==$jf_event_name2)
                                  {
                                    $comstart3="<!--";
                                  }
                                  if($counter <= $jf_event_id)
                                  {
                                    echo $comstart3."<option value='".$jf_event_id2."'>".$jf_event_name2."</option>".$comend;
                                    $counter++;
                                  }
                                }
                              ?>
                              <?php
                                print '</select>';
                              ?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">CONTACT PERSON 1</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="contact_person_jf1" class="form-control" placeholder="Contact Person 1" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">POSITION</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="position_jf1" class="form-control" placeholder="Position" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">CONTACT NUMBER</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="contact_no_jf1" class="form-control" placeholder="Contact Number" />
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">CONTACT PERSON 2 (Optional)</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="contact_person_jf2" class="form-control" placeholder="Contact Person 2 (Optional)" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">POSITION (Optional)</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="position_jf2" class="form-control" placeholder="Position (Optional)" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">CONTACT NUMBER (Optional)</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="contact_no_jf2" class="form-control" placeholder="Contact Number (Optional)" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="seminar" style="display:none;">
                        <div class="row">
                            <h3 style="margin-left:13px;">SEMINAR</h3>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">EVENT NAME</h5>
                            <div class="form-group has-feedback">
                              <?php
                                $table_event_seminar = "event_manager";
                                $columns_event_seminar = "*";
                                $where_event_seminar = ["type" => 'Seminar'];
                                $q_event_seminar =$database->select($table_event_seminar,$columns_event_seminar,$where_event_seminar);

                                print'<select class="form-control"  name="seminar_event_id" class="form-control">';

                                 echo "<option value='".$event_seminar_id."' disabled selected>".$event_name."</option>";

                                 foreach($q_event_seminar as $q_event_seminar_data){

                                    $event_seminar_id2 = $q_event_seminar_data['event_id'];
                                    $event_name2 = $q_event_seminar_data['event_name'];
                                    $counter = 0;

                                $comstart3="";
                                if($event_name==$event_name2)
                                {
                                  $comstart3="<!--";
                                }
                                if($counter <= $event_seminar_id)
                                  {
                                      echo $comstart3."<option value='".$event_seminar_id2."'>".$event_name2."</option>".$comend;
                                     $counter++;
                                  }
                                }
                                ?>
                                <?php
                                print '</select>';
                                ?>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">SPEAKER 1</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="speaker1" class="form-control" placeholder="Speaker Name" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">TOPIC</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="topic1" class="form-control" placeholder="Topic" />
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-4"></div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">SPEAKER 2</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="speaker2" class="form-control" placeholder="(Optional) Speaker Name" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">TOPIC</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="topic2" class="form-control" placeholder="(Optional) Topic" />
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-4"></div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">SPEAKER 3</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="speaker3" class="form-control" placeholder="(Optional) Speaker Name" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <h5 style="padding-left:5px;">TOPIC</h5>
                            <div class="form-group has-feedback">
                              <input type="text" name="topic3" class="form-control" placeholder="(Optional) Topic" />
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row"><br><br>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-success btn-block" name="btn_add_company" id="btn-add"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button>
                        </div>
                        <div class="col-md-4">
                            <a href="e2e_company_records.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                        </div>
                      </div>
                </div>
              </div>
              </form>
            </div><!-- end: content -->
          </div>

          <!-- START: RIGHT MENU-->
          <?php
            require ("chat.php");
          ?>
		  <!-- END: RIGHT MENU-->

      </div>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="e2e_home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                      <a href="e2e_student_records.php"><i class="glyphicon glyphicon-tasks"></i>&nbsp; Student Records</a>
                      <a href="*"><i class="glyphicon fa fa-building-o"></i>&nbsp; Company Records</a>
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
 var table = $('#datatables').DataTable();
 });
</script>
<!-- end: Javascript -->
<script type="text/javascript">
function get_value_ays(){
  var selected_acad_year_start = document.getElementById("acad_year_start").value;
  var x = 1;
  var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
  document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;

  var selected_acad_year_start_jf = document.getElementById("acad_year_start_jf").value;
  var y = 1;
  var acad_year_end_jf = parseInt(selected_acad_year_start_jf) + parseInt(y);
  document.getElementById("acad_year_start_show_jf").innerHTML =  acad_year_end_jf;
  document.getElementById("acad_year_end_value_jf").value =  acad_year_end_jf;
}

$(document).ready(function(){
  $('#date_notary')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_company').bootstrapValidator('revalidateField', 'date_notary');
        });

  $('#date_expiry')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_company').bootstrapValidator('revalidateField', 'date_expiry');
        });

    $('#date_submit')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_company').bootstrapValidator('revalidateField', 'date_submit');
        });


 $('#acad_year_start')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_company').bootstrapValidator('revalidateField', 'acad_year_start');
        });

  $('#acad_year_start_jf')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_company').bootstrapValidator('revalidateField', 'acad_year_start_jf');
        });

  $('#add_company')
    .bootstrapValidator({
      message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
              comp_name: {
                    message: 'Company name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Company name is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 100,
                            message: 'Company name must be more than 1 and less than 100 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                status_company: {
                    message: 'Status is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Status is required and can\'t be empty'
                        }
                    }
                },
                comp_dept: {
                    message: 'Company department is not valid',
                    validators: {
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Company department must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/?]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                comp_desc: {
                    message: 'Company description is not valid',
                    validators: {
                  stringLength: {
                            min: 1,
                            max: 255,
                            message: 'Company description must be more than 1 and less than 255 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                comp_address: {
                    message: 'Company address is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Company address is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 100,
                            message: 'Company address must be more than 1 and less than 100 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                comp_city: {
                    message: 'Company city is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Company city is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Company city must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/?]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                contact_person: {
                    message: 'Contact person is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Contact person is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Contact person must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/?]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                position: {
                    message: 'Position is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Position is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Position must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/?]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                contact_no: {
                    message: 'Contact number is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Contact number is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 20,
                            message: 'Contact number must be more than 1 and less than 20 characters long'
                        },
                  regexp: {
                            regexp: /^[-/ 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                email: {
                    message: 'Email is not valid',
                    validators: {
                        emailAddress:{
                            message: 'Incorrect email'
                        },
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Email must be more than 1 and less than 50 characters long'
                        },
                    }
                },
                nop: {
                    message: 'Nature of partnership is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Nature of partnership is required and can\'t be empty'
                        }
                    }
                },
                jf: {
                    message: 'Event name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Event name is required and can\'t be empty'
                        }
                    }
                },
                contact_person_jf1: {
                    message: 'Contact person is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Contact person is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 20,
                            message: 'Contact person must be more than 1 and less than 20 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                position_jf1: {
                    message: 'Position is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Position is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Position must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/?]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                contact_no_jf1: {
                    message: 'Contact number is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Contact number is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 20,
                            message: 'Contact number must be more than 1 and less than 20 characters long'
                        },
                  regexp: {
                            regexp: /^[-/ 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                contact_person_jf2: {
                    message: 'Contact person is not valid',
                    validators: {
                      stringLength: {
                            min: 1,
                            max: 20,
                            message: 'Contact person must be more than 1 and less than 20 characters long'
                        },
                      regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                position_jf2: {
                    message: 'Position is not valid',
                    validators: {
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Position must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/?]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                contact_no_jf2: {
                    message: 'Contact number is not valid',
                    validators: {
                  stringLength: {
                            min: 1,
                            max: 20,
                            message: 'Contact number must be more than 1 and less than 20 characters long'
                        },
                  regexp: {
                            regexp: /^[-/ 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                event_mi_id: {
                    message: 'Event name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Event name is required and can\'t be empty'
                        }
                    }
                },
                semester_mi: {
                    message: 'Semester is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        }
                    }
                },
                acad_year_start_mi: {
                    message: 'Academic year start is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Academic year start is required and can\'t be empty'
                        }
                    }
                },
                status_ojt: {
                    message: 'Status is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Status is required and can\'t be empty'
                        }
                    }
                },
                remarks: {
                    message: 'Remarks is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Remarks is required and can\'t be empty'
                        }
                    }
                },
                date_notary: {
                    validators: {

                        date: {
                            max: 'date_expiry',
                            message: 'Date notary is invalid'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date notary(e.g. MM/DD/YYYY)'
                        },
                        notEmpty: {
                            message: 'Date notary is required and can\'t be empty'
                        }
                    }
                },
                date_expiry: {
                    validators: {

                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date expiry(e.g. MM/DD/YYYY)'
                        },
                        date: {
                            min: 'date_notary',
                            message: 'Invalid date expiry'
                        },
                         notEmpty: {
                            message: 'Date expiry is required and can\'t be empty'
                        }
                    }
                },
                 date_submit: {
                    validators: {
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date submit(e.g. MM/DD/YYYY)'
                        },
                         notEmpty: {
                            message: 'Date submit is required and can\'t be empty'
                        }
                    }
                },
                seminar_event_id: {
                    message: 'Event name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Event name is required and can\'t be empty'
                        }
                    }
                },
                speaker1: {
                    message: 'Speaker is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Speaker is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Speaker must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                topic1: {
                    message: 'Topic is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Topic is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 100,
                            message: 'Topic must be more than 1 and less than 100 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                speaker2: {
                    message: 'Speaker is not valid',
                    validators: {
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Speaker must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                topic2: {
                    message: 'Topic is not valid',
                    validators: {
                  stringLength: {
                            min: 1,
                            max: 100,
                            message: 'Topic must be more than 1 and less than 100 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                speaker3: {
                    message: 'Speaker is not valid',
                    validators: {
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Speaker must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                topic3: {
                    message: 'Topic is not valid',
                    validators: {
                  stringLength: {
                            min: 1,
                            max: 100,
                            message: 'Topic must be more than 1 and less than 100 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z 0-9]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
            }
      })
      .on('success.field.fv', function(e, data) {
            if (data.field === 'date_notary' && !data.fv.isValidField('date_expiry')) {
                // We need to revalidate the end date
                data.fv.revalidateField('date_expiry');
            }

            if (data.field === 'date_expiry' && !data.fv.isValidField('date_notary')) {
                // We need to revalidate the start date
                data.fv.revalidateField('date_notary');
            }
        });
  });

$('#nop').change(function(){
  selection = $(this).val();
  switch(selection)
  {
    case 'Job Fair':
      $('#job_fair').show();
      $('#mock_interview').hide();
      $('#ojt').hide();
      $('#seminar').hide();
      $('#job_fair').val
      break;
    case 'Mock Interview':
      $('#mock_interview').show();
      $('#job_fair').hide();
      $('#ojt').hide();
      break;
    case 'OJT':
      $('#ojt').show();
      $('#job_fair').hide();
      $('#mock_interview').hide();
      $('#seminar').hide();
      break;
    case 'Seminar':
      $('#seminar').show();
      $('#ojt').hide();
      $('#job_fair').hide();
      $('#mock_interview').hide();
      break;
    default:
      $('#job_fair').hide();
      $('#mock_interview').hide();
      $('#ojt').hide();
      $('#seminar').hide();
      break;
  }
});

$('#remarks').change(function(){
  selection = $(this).val();
  switch(selection)
  {
    case 'With MOA':
      $('#with_moa').show();
      $('#follow_up').hide();
      break;
    case 'HTE Training Agreement/MOA':
      $('#with_moa').show();
      $('#follow_up').hide();
      break;
    case 'For follow up':
      $('#with_moa').hide();
      $('#follow_up').show();
      break;
    case 'For Notary':
      $('#with_moa').hide();
      $('#follow_up').show();
      break;
    case 'Others':
      $('#with_moa').hide();
      $('#follow_up').show();
      break;
    default:
      $('#with_moa').hide();
      $('#follow_up').hide();
      break;
  }
});

$('#type_industry').change(function(){
  selection = $(this).val();
  switch(selection)
  {
    case 'Others':
      $('#other_industry').show();
      break;
    default:
      $('#other_industry').hide();
  }
});
</script>
</body>
</html>
