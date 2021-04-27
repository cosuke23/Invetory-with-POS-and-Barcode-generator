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
$current_year = date("Y") - 1;
$next_year = date("Y")+1;

$current_year_jf = date("Y") - 1;
$next_year_jf = date("Y")+1;

$current_year_seminar = date("Y") - 1;
$next_year_seminar = date("Y")+1;

$current_year_mi = date("Y") - 1;
$next_year_mi = date("Y")+1;
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
  <script src="asset/js/jquery.confirm.js"></script>
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
                <li class="user-name"><span>&nbsp; Hi' <?php echo  $title." ".$fname ; ?>&nbsp;</span></li>
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
                          <a href="e2e_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label>
                        <a href="e2e_student_records.php">
                          <i class="glyphicon glyphicon-tasks"></i>Student Records</a>
                        </label><br>
                        <label class="active"><a href="e2e_company_records.php">
                          <i class="glyphicon fa fa-building-o"></i>Company Records</a>
                        </label><br>
                        <label><a href="*">
                          <i class="glyphicon fa fa-user-secret"></i>Check Attire</a>
                        </label><br>
                        <label><a href="*">
                          <i class="glyphicon fa fa-smile-o"></i>Graduating ID Card</a>
                        </label><br>
                        <label><a href="*">
                          <i class="glyphicon icons icon-credit-card"></i>Business Card</a>
                        </label><br>
                        <label><a href="e2e_event_manager.php">
                          <i class="glyphicon glyphicon-list-alt"></i>Event Manager</a>
                        </label><br>
                        <label><a href="*">
                          <i class="glyphicon fa fa-user"></i>User Account</a>
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
                    <h1 class="animated fadeInLeft">COMPANY RECORDS</h1>
                    <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#tabs-demo4-area1" id="tabs-demo4-1" role="tab" data-toggle="tab" aria-expanded="true"><h5> COMPANY INFO</h5></a>
                      </li>
                      <li role="presentation">
                        <a href="#tabs-demo4-area2" role="tab" id="tabs-demo4-2" data-toggle="tab" aria-expanded="false"><h5> OJT INFO</h5></a>
                      </li>
                      <li role="presentation">
                        <a href="#tabs-demo4-area3" id="tabs-demo4-3" role="tab" data-toggle="tab" aria-expanded="false"><h5> MOCK INTERVIEW RECORDS</h5></a>
                      </li>
                      <li role="presentation">
                        <a href="#tabs-demo4-area4" role="tab" id="tabs-demo4-4" data-toggle="tab" aria-expanded="false"><h5> SEMINAR RECORDS</h5></a>
                      </li>
                      <li role="presentation">
                        <a href="#tabs-demo4-area5" role="tab" id="tabs-demo4-5" data-toggle="tab" aria-expanded="false"><h5> JOB FAIR RECORDS</h5></a>
                      </li>
                    </ul>
                  </div><!-- col-md-12 -->
                </div><!-- panel-body -->
              </div><!-- panel box-shadow-none -->
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-body">
                      <div class="col-md-12">
                        <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                          <?php if(isset($_GET['comp_id'])) {
                            $comp_id = $_GET['comp_id'];
                            $table = "company_info";
                            $columns = "*";
                            $where = ["comp_id" => $comp_id];
                            $q_comp_info =$database->select($table,$columns,$where);

                            foreach($q_comp_info as $comp_data){
                              $comp_logo        =   $comp_data['comp_logo'];
                              $comp_user        =   $comp_data['username'];
                              $comp_id          =   $comp_data['comp_id'];
                              $comp_name        =   $comp_data['comp_name'];
                              $comp_status      =   $comp_data['status'];
                              $comp_desc        =   $comp_data['comp_desc'];
                              $comp_address     =   $comp_data['comp_address'];
                              $comp_city        =   $comp_data['comp_city'];
                              $contact_person   =   $comp_data['contact_person'];
                              $position         =   $comp_data['position'];
                              $contact_no       =   $comp_data['contact_no'];
                              $email            =   $comp_data['email'];
                              $type_industry    =   $comp_data['type_industry'];
                              $other_industry   =   $comp_data['other_industry'];
                              $comp_dept        =   $comp_data['comp_dept'];

                              $decoded_img = base64_decode($comp_logo);
                              $f = finfo_open();
                              $type = finfo_buffer($f, $decoded_img, FILEINFO_MIME_TYPE);
                            }
                          }
                          ?>

                          <div class="row" style="background-color:#22c222;color:#fff";>
                            <div class="col-md-12">
                              <h4><b><?php echo $comp_name; ?></b></h4>
                            </div>
                          </div><br>
                          <!-- start area1 -->
                          <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo4-area1" aria-labelledby="tabs-demo4-area1">
                            <form method="post" action="e2e_update_company_records_process.php" id="update_company_records" enctype="multipart/form-data">
                            <div class="panel-heading animated fadeInDown"><h4><span class="icon icon-info"></span> COMPANY INFO</h4></div><br>
                              <div class="row">
                                <div class="col-md-3">
                                  <?php
                                    echo '<img src="data:'.$type.';base64,'.$comp_logo.'" style="height:200px;width:200px;">';
                                  ?>
                                </div>
                                <div class="col-md-6">
                                  <h5>COMPANY PICTURE &nbsp; <i class="fa fa-camera"></i></h5>
                                  <div class="form-group has-feedback">
                                    <input type="file" class="form-control" name="comp_logo" alt="upload image"/>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <input name="comp_id" type="hidden" value ="<?php echo $comp_id; ?>"/>
                                <div class="col-md-3">
                                  <h5 style="padding-left:5px;">COMPANY USERNAME</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="comp_user" id="comp_user" class="form-control" value ="<?php echo $comp_user; ?>" disabled/>
                                  </div>
                                </div>
                                <div class="col-md-7">
                                  <h5 style="padding-left:5px;">COMPANY NAME</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="comp_name" id="comp_name" class="form-control" value ="<?php echo $comp_name; ?>"/>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <h5 style="padding-left:5px;">STATUS</h5>
                                  <div class="form-group has-feedback">
                                    <?php
                                       $comstart1="";
                                       $comstart2="";
                                       $comend="-->";
                                       if($comp_status=="Active"){ $comstart1="<!--"; }
                                       else if($comp_status=="Inactive"){ $comstart2="<!--"; }
                                       ?>
                                      <select class="form-control" name="comp_status" id="comp_status">
                                      <option><?php echo $comp_status; ?></option>
                                      <?php echo $comstart1;?><option value="Active">Active</option><?php echo $comend;?>
                                      <?php echo $comstart2;?><option value="Inactive">Inactive</option><?php echo $comend;?>
                                      </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  <h5 style="padding-left:5px;">COMPANY DESCRIPTION</h5>
                                  <div class="form-group has-feedback">
                                    <textarea rows ="2" name="comp_desc" id="comp_desc" class="form-control"><?php echo $comp_desc; ?></textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-7">
                                  <h5 style="padding-left:5px;">TYPE OF INDUSTRY</h5>
                                  <div class="form-group has-feedback">
                                    <?php
                                       $comstart1  = "";
                                       $comstart2  = "";
                                       $comstart3  = "";
                                       $comstart4  = "";
                                       $comstart5  = "";
                                       $comstart6  = "";
                                       $comstart7  = "";
                                       $comstart8  = "";
                                       $comstart9  = "";
                                       $comstart10 = "";
                                       $comstart11 = "";
                                       $comstart12 = "";
                                       $comstart13 = "";
                                       $comstart14 = "";
                                       $comstart15 = "";
                                       $comstart16 = "";
                                       $comstart17 = "";
                                       $comstart18 = "";
                                       $comstart19 = "";
                                       $comend="-->";
                                       if($type_industry == "Accommodation and Food Services Activities"){ $comstart1 = "<!--"; }
                                       else if($type_industry == "Arts, Entertainment and Recreation"){ $comstart2 ="<!--"; }
                                       else if($type_industry == "Education"){ $comstart3 = "<!--"; }
                                       else if($type_industry == "Financial and Insurance Activities"){ $comstart4 = "<!--"; }
                                       else if($type_industry == "Human Health and Social Work Activities"){ $comstart5 = "<!--"; }
                                       else if($type_industry == "Information and Communication"){ $comstart6 = "<!--"; }
                                       else if($type_industry == "Professional, Scientific and Technical Activities"){ $comstart7 = "<!--"; }
                                       else if($type_industry == "Real Estate Activities"){ $comstart8 = "<!--"; }
                                       else if($type_industry == "Wholesale & Retail Trade, Repair of Motor Vehicles & Motorcycles"){ $comstart9 = "<!--"; }
                                       else if($type_industry == "Transport and Storage"){ $comstart10 = "<!--"; }
                                       else if($type_industry == "Administrative and Support Service Activities"){ $comstart11 = "<!--"; }
                                       else if($type_industry == "Public Administration and Defense, Compulsory Social Security"){ $comstart12 = "<!--"; }
                                       else if($type_industry == "Construction"){ $comstart13 = "<!--"; }
                                       else if($type_industry == "Electricity, Gas, Steam and Air Conditioning Supply"){ $comstart14 = "<!--"; }
                                       else if($type_industry == "Manufacturing"){ $comstart15 = "<!--"; }
                                       else if($type_industry == "Mining and Quarrying"){ $comstart16 = "<!--"; }
                                       else if($type_industry == "Water Supply, Sewerage, Waste Management and Remediation Activities"){ $comstart17 = "<!--"; }
                                       else if($type_industry == "Agriculture, Forestry and Fishing"){ $comstart18 = "<!--"; }
                                       else if($type_industry == "Others"){ $comstart19 = "<!--"; }
                                    ?>
                                      <select class="form-control" id="type_industry" name="type_industry" class="form-control">
                                        <option value="<?php echo $type_industry; ?>"><?php echo $type_industry; ?></option>
                                        <?php echo $comstart1;?><option value="Accommodation and Food Services Activities">Accommodation and Food Services Activities</option><?php echo $comend;?>
                                        <?php echo $comstart2;?><option value="Arts, Entertainment and Recreation">Arts, Entertainment and Recreation</option><?php echo $comend;?>
                                        <?php echo $comstart3;?><option value="Education">Education</option><?php echo $comend;?>
                                        <?php echo $comstart4;?><option value="Financial and Insurance Activities">Financial and Insurance Activities</option><?php echo $comend;?>
                                        <?php echo $comstart5;?><option value="Human Health and Social Work Activities">Human Health and Social Work Activities</option><?php echo $comend;?>
                                        <?php echo $comstart6;?><option value="Information and Communication">Information and Communication</option><?php echo $comend;?>
                                        <?php echo $comstart7;?><option value="Professional, Scientific and Technical Activities">Professional, Scientific and Technical Activities</option><?php echo $comend;?>
                                        <?php echo $comstart8;?><option value="Real Estate Activities">Real Estate Activities</option><?php echo $comend;?>
                                        <?php echo $comstart9;?><option value="Wholesale & Retail Trade, Repair of Motor Vehicles & Motorcycles">Wholesale & Retail Trade, Repair of Motor Vehicles & Motorcycles</option><?php echo $comend;?>
                                        <?php echo $comstart10;?><option value="Transport and Storage">Transport and Storage</option><?php echo $comend;?>
                                        <?php echo $comstart11;?><option value="Administrative and Support Service Activities">Administrative and Support Service Activities</option><?php echo $comend;?>
                                        <?php echo $comstart12;?><option value="Public Administration and Defense, Compulsory Social Security">Public Administration and Defense, Compulsory Social Security</option><?php echo $comend;?>
                                        <?php echo $comstart13;?><option value="Construction">Construction</option><?php echo $comend;?>
                                        <?php echo $comstart14;?><option value="Electricity, Gas, Steam and Air Conditioning Supply">Electricity, Gas, Steam and Air Conditioning Supply</option><?php echo $comend;?>
                                        <?php echo $comstart15;?><option value="Manufacturing">Manufacturing</option><?php echo $comend;?>
                                        <?php echo $comstart16;?><option value="Mining and Quarrying">Mining and Quarrying</option><?php echo $comend;?>
                                        <?php echo $comstart17;?><option value="Water Supply, Sewerage, Waste Management and Remediation Activities">Water Supply, Sewerage, Waste Management and Remediation Activities</option><?php echo $comend;?>
                                        <?php echo $comstart18;?><option value="Agriculture, Forestry and Fishing">Agriculture, Forestry and Fishing</option><?php echo $comend;?>
                                        <?php echo $comstart19;?><option value="Others">Others</option><?php echo $comend;?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-md-5">
                                  <h5 style="padding-left:5px;">DEPARTMENT</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="comp_dept" id="comp_dept" class="form-control" value ="<?php echo $comp_dept; ?>"/>
                                  </div>
                                </div>
                              </div>

                              <div class="other industry">
                                <div class="row">
                                  <div class="col-md-5">
                                    <h5 style="padding-left:5px;">OTHERS</h5>
                                    <div class="form-group has-feedback">
                                      <input type="text" name="other_industry" id="other_industry" class="form-control" value ="<?php echo $other_industry; ?>"/>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-8">
                                  <h5 style="padding-left:5px;">COMPANY ADDRESS</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="comp_address" id="comp_address" class="form-control" value ="<?php echo $comp_address; ?>"/>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <h5 style="padding-left:5px;">CITY</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="comp_city" id="comp_city" class="form-control" value ="<?php echo $comp_city; ?>" />
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-3">
                                  <h5 style="padding-left:5px;">CONTACT PERSON</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="contact_person" id="contact_person" class="form-control" value ="<?php echo $contact_person; ?>"/>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="padding-left:5px;">POSITION</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="position" id="position" class="form-control" value ="<?php echo $position; ?>" />
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="padding-left:5px;">CONTACT NUMBER</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="contact_no" id="contact_no" class="form-control" value ="<?php echo $contact_no; ?>" />
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <h5 style="padding-left:5px;">EMAIL</h5>
                                  <div class="form-group has-feedback">
                                    <input type="text" name="email" id="email" class="form-control" value ="<?php echo $email; ?>" />
                                  </div>
                                </div>
                              </div><br><br>
                              <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                  <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary" name="btn_update_company" id="btn_update_stud_info">
                                    <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                  </button>
                                </div>
                                <div class="col-md-4">
                                  <a href="e2e_company_records.php"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                                </div>
                              </div><br>
                            </form>
                            </div><!-- end area1 -->

                          <?php if(isset($_GET['comp_id'])) {
                            $comp_id = $_GET['comp_id'];
                            $table = "nop_ojt";
                            $columns = "*";
                            $where = ["comp_id" => $comp_id];
                            $q_ojt_info =$database->select($table,$columns,$where);

                            foreach ($q_ojt_info as $q_ojt_info_data) {
                              $ojt_id = $q_ojt_info_data["ojt_id"];
                              $remarks = $q_ojt_info_data["remarks"];
                              $date_notary = $q_ojt_info_data["date_notary"];
                              $date_expiry = $q_ojt_info_data["date_expiry"];
                              $note = $q_ojt_info_data["note"];
                              $date_submit = $q_ojt_info_data["date_submit"];
                              $ojt_status = $q_ojt_info_data["status"];
                            }
                          }
                          ?>
                          <!-- start area2 -->
                          <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area2" aria-labelledby="tabs-demo4-area2">
                            <div class="panel-heading animated fadeInDown"><h4><span class="fa fa-building-o"></span> OJT INFO</h4></div><br>
                            <?php
                              if(empty($q_ojt_info_data)){
              ?>
              <form method="post" action="e2e_add_ojt_info_process.php" id="add_ojt_info" enctype="multipart/form-data">
                              <input name="add_comp_id" type="hidden" value ="<?php echo $comp_id; ?>"/>
                              <input name="comp_name" type="hidden" value ="<?php echo $comp_name; ?>"/>
                              <div class="row">
                                <div class="col-md-2">
                                  <h5 style="padding-left:5px;">STATUS</h5>
                                  <div class="form-group has-feedback">
                                    <select class="form-control" name="add_ojt_status" id="ojt_status">
                                      <option disabled selected></option>
                                      <option value="Active">Active</option>
                                      <option value="Inactive">Inactive</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <h5 style="padding-left:5px;">REMARKS</h5>
                                  <div class="form-group has-feedback">
                                    <select class="form-control" name="add_remarks" id="add_remarks" class="form-control">
                                      <option value="" disabled selected></option>
                                      <option value="With MOA">With MOA</option>
                                      <option value="Without MOA">Without MOA</option>
                                      <option value="For follow up">For follow up</option>
                                      <option value="Expired MOA">Expired MOA</option>
                                      <option value="HTE Training Agreement/MOA">HTE Training Agreement/MOA</option>
                                      <option value="Banned">Banned</option>
                                      <option value="For Notary">For Notary</option>
                                      <option value="Others">Others</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="notary_expiry ojt">
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">DATE OF NOTARY</h5>
                                    <div class="form-group">
                                      <div class="dateContainer">
                                        <div class="input-group input-append date" id="add_date_notary">
                                          <input type="text" class="form-control" name="add_date_notary" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">DATE OF EXPIRY</h5>
                                    <div class="form-group">
                                      <div class="dateContainer">
                                        <div class="input-group input-append date" id="add_date_expiry">
                                          <input type="text" class="form-control" name="add_date_expiry" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="note_submit ojt">
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">NOTE</h5>
                                    <div class="form-group">
                                      <div class="form-group has-feedback">
                                        <input type="text" name="add_note" class="form-control" />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">DATE TO SUBMIT</h5>
                                    <div class="form-group">
                                      <div class="dateContainer">
                                        <div class="input-group input-append date" id="add_date_submit">
                                          <input type="text" class="form-control" name="add_date_submit" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div><br><br>
                              <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                  <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary" name="btn_add_ojt">
                                    <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                  </button>
                                </div>
                                <div class="col-md-4">
                                  <a href="e2e_company_records.php"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                                </div>
                              </div><br>
                            </form>
              <?php
                              }
                              else{
                            ?>
                            <form method="post" action="e2e_update_ojt_info_process.php" id="ojt_info" enctype="multipart/form-data">
                              <input name="ojt_id" type="hidden" value ="<?php echo $ojt_id; ?>"/>
                              <input name="comp_name" type="hidden" value ="<?php echo $comp_name; ?>"/>
                              <div class="row">
                                <div class="col-md-2">
                                  <h5 style="padding-left:5px;">STATUS</h5>
                                  <div class="form-group has-feedback">
                                    <?php
                                      $comstart1="";
                                      $comstart2="";
                                      $comend="-->";
                                      if($ojt_status=="Active"){ $comstart1="<!--"; }
                                      else if($ojt_status=="Inactive"){ $comstart2="<!--"; }
                                    ?>
                                    <select class="form-control" name="ojt_status" id="ojt_status">
                                      <option><?php echo $ojt_status; ?></option>
                                      <?php echo $comstart1;?><option value="Active">Active</option><?php echo $comend;?>
                                      <?php echo $comstart2;?><option value="Inactive">Inactive</option><?php echo $comend;?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <h5 style="padding-left:5px;">REMARKS</h5>
                                  <div class="form-group has-feedback">
                                    <?php
                                      $comstart1="";
                                      $comstart2="";
                                      $comstart3="";
                                      $comstart4="";
                                      $comstart5="";
                                      $comstart6="";
                                      $comstart7="";
                                      $comstart8="";
                                      $comend="-->";
                                      if($remarks=="With MOA"){ $comstart1="<!--"; }
                                      else if($remarks=="Without MOA"){ $comstart2="<!--"; }
                                      else if($remarks=="For follow up"){ $comstart3="<!--"; }
                                      else if($remarks=="Expired MOA"){ $comstart4="<!--"; }
                                      else if($remarks=="HTE Training Agreement/MOA"){ $comstart5="<!--"; }
                                      else if($remarks=="Banned"){ $comstart6="<!--"; }
                                      else if($remarks=="For Notary"){ $comstart7="<!--"; }
                                      else if($remarks=="Others"){ $comstart8="<!--"; }
                                    ?>
                                    <select class="form-control" name="remarks" id="remarks" class="form-control">
                                      <option value="<?php echo $remarks; ?>"><?php echo $remarks; ?></option>
                                      <?php echo $comstart1;?><option value="With MOA">With MOA</option><?php echo $comend;?>
                                      <?php echo $comstart2;?><option value="Without MOA">Without MOA</option><?php echo $comend;?>
                                      <?php echo $comstart3;?><option value="For follow up">For follow up</option><?php echo $comend;?>
                                      <?php echo $comstart4;?><option value="Expired MOA">Expired MOA</option><?php echo $comend;?>
                                      <?php echo $comstart5;?><option value="HTE Training Agreement/MOA">HTE Training Agreement/MOA</option><?php echo $comend;?>
                                      <?php echo $comstart6;?><option value="Banned">Banned</option><?php echo $comend;?>
                                      <?php echo $comstart7;?><option value="For Notary">For Notary</option><?php echo $comend;?>
                                      <?php echo $comstart8;?><option value="Other">Other</option><?php echo $comend;?>
                                    </select>
                                  </div>
                                </div>
                                <div class="notary_expiry ojt">
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">DATE NOTARY</h5>
                                    <div class="form-group">
                                      <div class="dateContainer">
                                        <div class="input-group input-append date" id="udate_notary">
                                          <input type="text" class="form-control" name="date_notary" value="<?php echo $date_notary; ?>" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">DATE EXPIRY</h5>
                                    <div class="form-group">
                                      <div class="dateContainer">
                                        <div class="input-group input-append date" id="udate_expiry">
                                          <input type="text" class="form-control" name="date_expiry" value="<?php echo $date_expiry; ?>" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="note_submit ojt">
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">NOTE</h5>
                                    <div class="form-group">
                                      <div class="form-group has-feedback">
                                        <input type="text" name="note" class="form-control" value="<?php echo $note; ?>" />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">DATE TO SUBMIT</h5>
                                    <div class="form-group">
                                      <div class="dateContainer">
                                        <div class="input-group input-append date" id="udate_submit">
                                          <input type="text" class="form-control" name="date_submit" value="<?php echo $date_submit; ?>" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div><br><br>
                              <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                  <button type="submit" class="btn btn-ripple btn-raised btn-block btn-primary" name="btn_update_ojt" id="btn_update_stud_info">
                                    <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                                  </button>
                                </div>
                                <div class="col-md-4">
                                  <a href="e2e_company_records.php"><button type="button" class="btn btn-ripple btn-raised btn-block btn-info"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                                </div>
                              </div><br>
                            </form>
                          <?php
                            }
                          ?>
                          </div><!-- end area2 -->

                          <!-- start area3 -->
                          <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area3" aria-labelledby="tabs-demo4-area3">
              <div class="panel-heading animated fadeInDown"><h4><span class="icon icon-people"></span> MOCK INTERVIEW RECORDS</h4></div><br>
                            <form method="post" action="e2e_add_mock_interview_process.php" id="add_mock_interview" enctype="multipart/form-data">
                              <input type="hidden" name="comp_id" value="<?php echo $comp_id ?>">
                              <div class="row">
                                <div class="col-md-5">
                                  <h5 style="padding-left:5px;">EVENT NAME</h5>
                                  <div class="form-group has-feedback">
                                    <?php
                                      $table = "event_manager";
                                      $columns = "*";
                                      $where = ["AND"=>["type" => 'Mock Interview',"status" => 'Active']];
                                      $q_em =$database->select($table,$columns,$where);

                                      print'<select class="form-control"  name="em" class="form-control">';
                                      echo "<option value='".$event_id."' disabled selected>".$event_name."</option>";

                                      foreach($q_em as $q_em_data){
                                        $event_id2 = $q_em_data['event_id'];
                                        $event_name2 = $q_em_data['event_name'];
                                        $counter = 0;

                                        $comstart3="";
                                        if($event_name==$event_name2)
                                        {
                                          $comstart3="<!--";
                                        }
                                        if($counter <= $event_id)
                                        {
                                          echo $comstart3."<option value='".$event_id2."'>".$event_name2."</option>".$comend;
                                          $counter++;
                                        }
                                      }
                                    ?>
                                    <?php
                                      print '</select>';
                                    ?>
                                  </div>
                                </div>
                                <div class="col-md-3"><br>
                                  <button type="submit" class="btn btn-ripple btn-raised btn-success" name="btn_add_mi" id="btn_add_mi" style="margin-top:15px;">
                                    <span class="glyphicon glyphicon-plus"></span> &nbsp;ADD
                                  </button>
                                </div>
                              </div>
                            </form><br>
                            <div class="responsive-table">
                              <table id="datatables_mi" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th class="text-center">EVENT CODE</th>
                                    <th class="text-center">EVENT NAME</th>
                                    <th class="text-center">EVENT DATE</th>
                                    <th class="text-center">ACAD YEAR</th>
                                    <th class="text-center">SEMESTER</th>
                                    <th class="text-center">DATE ADDED</th>
                                  </tr>
                                </thead>
                                <?php
                                if(isset($_GET['comp_id'])) {
                                  $comp_id = $_GET['comp_id'];
                                  $table = "nop_mock_interview";
                                  $columns = "*";
                                  $where = ["comp_id" => $comp_id];
                                  $q_nmi =$database->select($table,$columns,$where);

                                  foreach($q_nmi as $q_nmi_data){
                                    $acad_year = $q_nmi_data['acad_year_start_mi'].' - '.$q_nmi_data['acad_year_end_mi'];
                                    $semester_mi = $q_nmi_data['semester_mi'];
                                    $event_id = $q_nmi_data['event_id'];
                                    $date_added = date("F j, Y",strtotime($q_nmi_data["date_added"]));

                                    $table2 = "event_manager";
                                    $columns2 = "*";
                                    $where2 = ["event_id" => $event_id];
                                    $q_event =$database->select($table2,$columns2,$where2);

                                    foreach($q_event as $q_event_data){
                                      $event_code = $q_event_data["event_code"];
                                      $event_name = $q_event_data["event_name"];
                                      $event_date = date("F j, Y",strtotime($q_event_data["event_start_date"])).' - '.date("F j, Y",strtotime($q_event_data["event_end_date"]));
                                  ?>
                                    <tr>
                                      <td><?php echo $event_code; ?></td>
                                      <td><?php echo $event_name; ?></td>
                                      <td><?php echo $event_date; ?></td>
                                      <td><?php echo $acad_year; ?></td>
                                      <td><?php echo $semester_mi; ?></td>
                                      <td><?php echo $date_added; ?></td>
                                    </tr>
                                <?php
                                    }
                                  }
                                }
                                ?>
                              </table>
                            </div>
                          </div><!-- end area3 -->
                          <!-- start area4 -->
                          <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area4" aria-labelledby="tabs-demo4-area4">
                          <div class="panel-heading animated fadeInDown"><h4><span class="icon icon-people"></span> SEMINAR RECORDS</h4></div><br>
                            <div class="row">
                              <div class="col-md-3">
                                <button type="submit" class="btn btn-success btn-block" id="btn_toggle_seminar"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button>
                              </div>
                            </div>
                            <div class="seminar_form" style="display:none">
                              <form method="post" action="e2e_add_seminar_process.php" id="add_seminar" enctype="multipart/form-data">
                                <input name="comp_id" type="hidden" value ="<?php echo $comp_id; ?>"/>
                                <div class="row">
                                  <div class="col-md-4">
                                    <h5 style="padding-left:5px;">EVENT NAME</h5>
                                    <div class="form-group has-feedback">
                                      <?php
                                        $table = "event_manager";
                                        $columns = "*";
                                        $where = ["AND"=>["type" => 'Seminar',"status" => 'Active']];
                                        $q_sem =$database->select($table,$columns,$where);

                                        print'<select class="form-control"  name="sem" class="form-control">';
                                        echo "<option value='".$sem_event_id."' disabled selected>".$sem_event_name."</option>";

                                        foreach($q_sem as $q_sem_data){
                                          $sem_event_id2 = $q_sem_data['event_id'];
                                          $sem_event_name2 = $q_sem_data['event_name'];
                                          $counter = 0;

                                          $comstart3="";
                                          if($sem_event_name==$sem_event_name2)
                                          {
                                            $comstart3="<!--";
                                          }
                                          if($counter <= $sem_event_id)
                                          {
                                            echo $comstart3."<option value='".$sem_event_id2."'>".$sem_event_name2."</option>".$comend;
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
                                      <input type="text" name="speaker1" class="form-control" placeholder="Speaker 1" />
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <h5 style="padding-left:5px;">TOPIC 1</h5>
                                    <div class="form-group has-feedback">
                                      <input type="text" name="topic1" class="form-control" placeholder="Topic" />
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-4">
                                    <h5 style="padding-left:5px;">SPEAKER 2 (Optional)</h5>
                                    <div class="form-group has-feedback">
                                      <input type="text" name="speaker2" class="form-control" placeholder="Speaker 2 (Optional)" />
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <h5 style="padding-left:5px;">TOPIC 2 (Optional)</h5>
                                    <div class="form-group has-feedback">
                                      <input type="text" name="topic2" class="form-control" placeholder="Topic (Optional)" />
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-4">
                                    <h5 style="padding-left:5px;">SPEAKER 3 (Optional)</h5>
                                    <div class="form-group has-feedback">
                                      <input type="text" name="speaker3" class="form-control" placeholder="Speaker 3 (Optional)" />
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <h5 style="padding-left:5px;">TOPIC 3 (Optional)</h5>
                                    <div class="form-group has-feedback">
                                      <input type="text" name="topic3" class="form-control" placeholder="Topic (Optional)" />
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-9"></div>
                                  <div class="col-md-3">
                                    <button type="submit" class="btn btn-ripple btn-raised btn-success btn-block" name="btn_add_seminar" id="btn_add_seminar" style="margin-top:15px;">
                                      <span class="glyphicon glyphicon-plus"></span> &nbsp;ADD
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div><br><br>
                            <div class="responsive-table">
                              <table id="datatables_seminar" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th class="text-center">EVENT CODE</th>
                                    <th class="text-center">EVENT NAME</th>
                                    <th class="text-center">EVENT DATE</th>
                                    <th class="text-center">SPEAKER</th>
                                    <th class="text-center">TOPIC</th>
                                    <th class="text-center">ACAD YEAR</th>
                                    <th class="text-center">SEMESTER</th>
                                    <th class="text-center">DATE ADDED</th>
                                  </tr>
                                </thead>
                                <?php
                                if(isset($_GET['comp_id'])) {
                                  $comp_id = $_GET['comp_id'];
                                  $table = "nop_seminar";
                                  $columns = "*";
                                  $where = ["comp_id" => $comp_id];
                                  $q_seminar =$database->select($table,$columns,$where);

                                  foreach($q_seminar as $q_seminar_data){
                                    $event_id = $q_seminar_data["event_id"];
                                    $speaker1 = $q_seminar_data["speaker1"];
                                    $topic1 = $q_seminar_data["topic1"];
                                    $speaker2 = $q_seminar_data["speaker2"];
                                    $topic2 = $q_seminar_data["topic2"];
                                    $speaker3 = $q_seminar_data["speaker3"];
                                    $topic3 = $q_seminar_data["topic3"];
                                    $acad_year = $q_seminar_data['acad_year_start_seminar'].' - '.$q_seminar_data['acad_year_end_seminar'];
                                    $semester = $q_seminar_data["semester"];
                                    $date_added = date("F j, Y",strtotime($q_seminar_data["date_added"]));

                                    $table2 = "event_manager";
                                    $columns2 = "*";
                                    $where2 = ["event_id" => $event_id];
                                    $q_event =$database->select($table2,$columns2,$where2);

                                    foreach($q_event as $q_event_data){
                                      $event_code = $q_event_data["event_code"];
                                      $event_name = $q_event_data["event_name"];
                                      $event_date = date("F j, Y",strtotime($q_event_data["event_start_date"])).' - '.date("F j, Y",strtotime($q_event_data["event_end_date"]));
                                  ?>
                                    <tr>
                                      <td><?php echo $event_code; ?></td>
                                      <td><?php echo $event_name; ?></td>
                                      <td><?php echo $event_date; ?></td>
                                      <td><?php echo $speaker1; ?><br><?php echo $speaker2; ?><br><?php echo $speaker3; ?></td>
                                      <td><?php echo $topic1; ?><br><?php echo $topic2; ?><br><?php echo $topic3; ?></td>
                                      <td><?php echo $acad_year; ?></td>
                                      <td><?php echo $semester; ?></td>
                                      <td><?php echo $date_added; ?></td>
                                    </tr>
                                <?php
                                    }
                                  }
                                }
                                ?>
                              </table>
                            </div>
                          </div><!-- end area4 -->

                          <!-- start area5 -->
                          <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area5" aria-labelledby="tabs-demo4-area5">
                          <div class="panel-heading animated fadeInDown"><h4><span class="fa fa-briefcase"></span> JOB FAIR RECORDS</h4></div><br>
                            <div class="row">
                              <div class="col-md-3">
                                <button type="submit" class="btn btn-success btn-block" id="btn_toggle_job_fair"><span class="glyphicon glyphicon-plus"></span> &nbsp;ADD</button>
                              </div>
                            </div>
                            <div class="job_fair_form" style="display:none">
                              <form method="post" action="e2e_add_job_fair_process.php" id="a_add_job_fair" enctype="multipart/form-data">
                                <input name="comp_id" type="hidden" value ="<?php echo $comp_id; ?>"/>
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
                                <div class="row">
                                  <div class="col-md-9"></div>
                                  <div class="col-md-3">
                                    <button type="submit" class="btn btn-ripple btn-raised btn-success btn-block" name="btn_add_jf" id="btn_add_seminar" style="margin-top:15px;">
                                      <span class="glyphicon glyphicon-plus"></span> &nbsp;ADD
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div><br><br>
                            <div class="responsive-table">
                              <table id="datatables_job_fair" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th class="text-center">EVENT NAME</th>
                                    <th class="text-center">EVENT DATE</th>
                                    <th class="text-center">CONTACT PERSON</th>
                                    <th class="text-center">POSITION</th>
                                    <th class="text-center">CONTACT NUMBER</th>
                                    <th class="text-center">ACAD YEAR</th>
                                    <th class="text-center">SEMESTER</th>
                                    <th class="text-center">DATE ADDED</th>
                                  </tr>
                                </thead>
                                <?php
                                if(isset($_GET['comp_id'])) {
                                  $comp_id = $_GET['comp_id'];
                                  $table = "nop_job_fair";
                                  $columns = "*";
                                  $where = ["comp_id" => $comp_id];
                                  $q_jf = $database->select($table,$columns,$where);

                                  foreach($q_jf as $q_jf_data){
                                    $event_id = $q_jf_data["event_id"];
                                    $contact_person_jf1 = $q_jf_data["contact_person_jf1"];
                                    $position_jf1 = $q_jf_data["position_jf1"];
                                    $contact_no_jf1 = $q_jf_data["contact_no_jf1"];
                                    $contact_person_jf2 = $q_jf_data["contact_person_jf2"];
                                    $position_jf2 = $q_jf_data["position_jf2"];
                                    $contact_no_jf2 = $q_jf_data["contact_no_jf2"];
                                    $acad_year = $q_jf_data['acad_year_start_jf'].' - '.$q_jf_data['acad_year_end_jf'];
                                    $semester = $q_jf_data["semester_jf"];
                                    $date_added = date("F j, Y",strtotime($q_jf_data["date_added"]));

                                    $table2 = "event_manager";
                                    $columns2 = "*";
                                    $where2 = ["event_id" => $event_id];
                                    $q_event =$database->select($table2,$columns2,$where2);

                                    foreach($q_event as $q_event_data){
                                      $event_name = $q_event_data["event_name"];
                                      $event_date = date("F j, Y",strtotime($q_event_data["event_start_date"])).' - '.date("F j, Y",strtotime($q_event_data["event_end_date"]));
                                  ?>
                                    <tr>
                                      <td><?php echo $event_name; ?></td>
                                      <td><?php echo $event_date; ?></td>
                                      <td><?php echo $contact_person_jf1; ?><br><?php echo $contact_person_jf2; ?></td>
                                      <td><?php echo $position_jf1; ?><br><?php echo $position_jf2; ?></td>
                                      <td><?php echo $contact_no_jf1; ?><br><?php echo $contact_no_jf2; ?></td>
                                      <td><?php echo $acad_year; ?></td>
                                      <td><?php echo $semester; ?></td>
                                      <td><?php echo $date_added; ?></td>
                                    </tr>
                                <?php
                                    }
                                  }
                                }
                                ?>
                              </table>
                            </div>
                          </div><!-- end area5 -->
                        </div><!-- #tabsDemo4Content -->
                      </div><!-- col-md-12 -->
                    </div><!-- panel-body -->
                  </div><!-- panel -->
                </div><!-- col-md-12 -->
              </div><!-- col-md-12 padding-0 -->
            </div><!-- end content -->
          </div><!-- container-fluid mimin-wrapper -->
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
<script type="text/javascript">
function get_value_ays(){
  var selected_acad_year_start_jf = document.getElementById("acad_year_start_jf").value;
  var y = 1;
  var acad_year_end_jf = parseInt(selected_acad_year_start_jf) + parseInt(y);
  document.getElementById("acad_year_start_show_jf").innerHTML =  acad_year_end_jf;
  document.getElementById("acad_year_end_value_jf").value =  acad_year_end_jf;

  var selected_acad_year_start_seminar = document.getElementById("acad_year_start_seminar").value;
  var y = 1;
  var acad_year_end_seminar = parseInt(selected_acad_year_start_seminar) + parseInt(y);
  document.getElementById("acad_year_start_show_seminar").innerHTML =  acad_year_end_seminar;
  document.getElementById("acad_year_end_value_seminar").value =  acad_year_end_seminar;

  var selected_acad_year_start_mi = document.getElementById("acad_year_start_mi").value;
  var y = 1;
  var acad_year_end_mi = parseInt(selected_acad_year_start_mi) + parseInt(y);
  document.getElementById("acad_year_start_show_mi").innerHTML =  acad_year_end_mi;
  document.getElementById("acad_year_end_value_mi").value =  acad_year_end_mi;
}

$(document).ready(function(){
  var table = $('#datatables_job_fair').DataTable();
  var table = $('#datatables_seminar').DataTable();
  var table = $('#datatables_mi').DataTable();

  $("#btn_toggle_job_fair").click(function(){
    $(".job_fair_form").toggle();
  });
  $("#btn_toggle_seminar").click(function(){
    $(".seminar_form").toggle();
  });
  $("#btn_toggle_mi").click(function(){
    $(".mi_form").toggle();
  });

  $('#date_notary')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_company').bootstrapValidator('revalidateField', 'date_notary');
        });
   $('#udate_notary')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#ojt_info').bootstrapValidator('revalidateField', 'date_notary');
        });
  $('#add_date_notary')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_ojt_info').bootstrapValidator('revalidateField', 'add_date_notary');
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

  $('#udate_expiry')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#ojt_info').bootstrapValidator('revalidateField', 'date_expiry');
        });
  $('#add_date_expiry')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_ojt_info').bootstrapValidator('revalidateField', 'add_date_expiry');
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

    $('#udate_submit')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#ojt_info').bootstrapValidator('revalidateField', 'date_submit');
        });
  $('#add_date_submit')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_ojt_info').bootstrapValidator('revalidateField', 'add_date_submit');
        });
  $('#acad_year_start_jf')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_job_fair').bootstrapValidator('revalidateField', 'acad_year_start_jf');
        });
  $('#acad_year_start_seminar')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_seminar').bootstrapValidator('revalidateField', 'acad_year_start_seminar');
        });
  $('#acad_year_start_mi')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#add_mock_interview').bootstrapValidator('revalidateField', 'acad_year_start_mi');
        });

  $('#update_company_records')
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
                comp_status: {
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
                        notEmpty: {
                            message: 'Company department is required and can\'t be empty'
                        },
                  stringLength: {
                            min: 1,
                            max: 50,
                            message: 'Company department must be more than 1 and less than 50 characters long'
                        },
                  regexp: {
                            regexp: /^[a-zA-Z /]+$/,
                            message: 'Invalid characters'
                        },
                    }
                },
                comp_desc: {
                    message: 'Company description is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Company description is required and can\'t be empty'
                        },
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
                            regexp: /^[a-zA-Z ]+$/,
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
                            regexp: /^[a-zA-Z ]+$/,
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
                        notEmpty: {
                            message: 'Email is required and can\'t be empty'
                        },
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
                job_fair_name: {
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
                            regexp: /^[a-zA-Z ]+$/,
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
                            regexp: /^[a-zA-Z ]+$/,
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

      $('#ojt_info')
    .bootstrapValidator({
      message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
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
            }
      })

    $('#add_mock_interview')
    .bootstrapValidator({
      message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                em: {
                    message: 'Event name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Event name is required and can\'t be empty'
                        }
                    }
                },
            }
      })

    $('#add_ojt_info')
    .bootstrapValidator({
      message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
        add_ojt_status: {
                    message: 'Status is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Status is required and can\'t be empty'
                        },
                    }
                },
        add_remarks: {
                    message: 'Remarks is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Remarks is required and can\'t be empty'
                        },
                    }
                },
                add_date_notary: {
                    validators: {

                        date: {
                            max: 'add_date_expiry',
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
                add_date_expiry: {
                    validators: {
                        date: {
                            format: 'MM/DD/YYYY',
                            message: 'Invalid format of date expiry(e.g. MM/DD/YYYY)'
                        },
                        date: {
                            min: 'add_date_notary',
                            message: 'Invalid date expiry'
                        },
                         notEmpty: {
                            message: 'Date expiry is required and can\'t be empty'
                        }
                    }
                },
                 add_date_submit: {
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
            }
      })

    $('#add_seminar')
    .bootstrapValidator({
      message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
        sem: {
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

     $('#a_add_job_fair')
    .bootstrapValidator({
      message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                jf: {
                    message: 'Event name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Event name is required and can\'t be empty'
                        },
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
                            regexp: /^[a-zA-Z ]+$/,
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
                            regexp: /^[a-zA-Z ]+$/,
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

      if (data.field === 'add_date_notary' && !data.fv.isValidField('add_date_expiry')) {
                // We need to revalidate the end date
                data.fv.revalidateField('add_date_expiry');
            }

            if (data.field === 'add_date_expiry' && !data.fv.isValidField('add_date_notary')) {
                // We need to revalidate the start date
                data.fv.revalidateField('add_date_notary');
            }
        });
  });
</script>
<script type="text/javascript">
$(document).ready(function(){
    $("#remarks").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="With MOA"){
                $(".ojt").not(".notary_expiry").hide();
                $(".notary_expiry").show();
            }
            else if($(this).attr("value")=="HTE Training Agreement/MOA"){
                $(".ojt").not(".notary_expiry").hide();
                $(".notary_expiry").show();
            }
            else if($(this).attr("value")=="For follow up"){
                $(".ojt").not(".note_submit").hide();
                $(".note_submit").show();
            }
            else if($(this).attr("value")=="For Notary"){
                $(".ojt").not(".note_submit").hide();
                $(".note_submit").show();
            }
            else if($(this).attr("value")=="Without MOA"){
                $(".ojt").hide();
            }
            else if($(this).attr("value")=="Expired MOA"){
                $(".ojt").hide();
            }
            else if($(this).attr("value")=="Banned"){
                $(".ojt").hide();
            }
            else if($(this).attr("value")=="Other"){
                $(".ojt").hide();
            }
        });
    }).change();
  $("#add_remarks").change(function(){
        $(this).find("option:selected").each(function(){
      if($(this).attr("value")==""){
                $(".ojt").hide();
            }
            else if($(this).attr("value")=="With MOA"){
                $(".ojt").not(".notary_expiry").hide();
                $(".notary_expiry").show();
            }
            else if($(this).attr("value")=="HTE Training Agreement/MOA"){
                $(".ojt").not(".notary_expiry").hide();
                $(".notary_expiry").show();
            }
            else if($(this).attr("value")=="For follow up"){
                $(".ojt").not(".note_submit").hide();
                $(".note_submit").show();
            }
            else if($(this).attr("value")=="For Notary"){
                $(".ojt").not(".note_submit").hide();
                $(".note_submit").show();
            }
            else if($(this).attr("value")=="Without MOA"){
                $(".ojt").hide();
            }
            else if($(this).attr("value")=="Expired MOA"){
                $(".ojt").hide();
            }
            else if($(this).attr("value")=="Banned"){
                $(".ojt").hide();
            }
            else if($(this).attr("value")=="Other"){
                $(".ojt").hide();
            }
        });
    }).change();
    $("#type_industry").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="Accommodation and Food Services Activities"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Arts, Entertainment and Recreation"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Education"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Financial and Insurance Activities"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Human Health and Social Work Activities"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Information and Communication"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Professional, Scientific and Technical Activities"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Real Estate Activities"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Wholesale & Retail Trade, Repair of Motor Vehicles & Motorcycles"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Transport and Storage"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Administrative and Support Service Activities"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Public Administration and Defense, Compulsory Social Security"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Construction"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Electricity, Gas, Steam and Air Conditioning Supply"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Manufacturing"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Mining and Quarrying"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Water Supply, Sewerage, Waste Management and Remediation Activities"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Agriculture, Forestry and Fishing"){
                $(".other").hide();
            }
            else if($(this).attr("value")=="Others"){
                $(".industry").not(".other").hide();
                $(".other").show();
            }
        });
    }).change();
});
</script>
<!-- end: Javascript -->
</body>
</html>
