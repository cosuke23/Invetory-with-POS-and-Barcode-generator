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
         $comp_type = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);

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
                         echo '<img src="data:'.$comp_type.';base64,'.$comp_logo.'" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
                    ?>

                     <ul class="dropdown-menu user-dropdown">
                       <li><a href="#"><span class="fa fa-user"></span> My Profile</a></li>
                       <li><a href="company_logout.php"><span class="fa fa-power-off"></span> Log out</a></li>
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
          <div class="container-fluid mimin-wrapper">
            <div id="content">
              <div class="col-md-12 padding-0"><br>
                <div class="col-md-5">
                  <div class="panel">
                    <div class="panel-heading" style="background:#0084ff;">
                      <div style="font-size:30px;color:#fff;text-align:center;">Inbox</div>
                    </div>
                    <div class="panel-body">
                      <div class="row" style="height:603px;">
                        <div class="col-md-12">
                        <?php
                          $q_inbox = $database->query("SELECT * FROM (SELECT * FROM messenger WHERE (receiver = '$sender_user') ORDER BY messenger_id DESC) AS tmp_messenger WHERE (receiver = '$sender_user') GROUP BY sender ORDER BY messenger_id DESC")->fetchAll();
                          foreach($q_inbox AS $q_inbox_data){
                            $message = $q_inbox_data["message"];
                            $sender = $q_inbox_data["sender"];
                            $datetime = $q_inbox_data["datetime"];
                            $message_status = $q_inbox_data["message_status"];

                            $q_user = $database->query("SELECT * FROM user_info WHERE username='$sender'")->fetchAll();
                            foreach($q_user AS $q_user_data){
                              $full_name = $q_user_data["fname"].' '.$q_user_data["lname"];
                              $dp = $q_user_data["profileData"];

                              $decoded_img_profile = base64_decode($dp);
                              $f = finfo_open();
                              $dp_type = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);
                          ?>
                            <ul class="nav nav-list">
                              <a href="chat_inbox_update_status.php?staff=<?php echo $sender; ?>" style="font-weight:normal;">
                                <li>
                                  <div class="panel-heading" style="background:#fff;">
                                    <div style="font-size:16px;color:#000;"><?php echo $full_name; ?>&nbsp;<?php echo '<img src="data:'.$dp_type.';base64,'.$dp.'" class="img-circle avatar">'; ?></div>
                                    <?php
                                    if($message_status == 'unread'){
                                      echo '<div style="color:#000;font-weight:bold;">'.$message.'</div>';
                                    }
                                    if($message_status == 'read'){
                                      echo '<div style="color:#000;">'.$message.'</div>';
                                    }
                                    ?>
                                  </div>
                                </li>
                              </a>
                            </ul>
                          <?php
                              }

                              $q_c = $database->query("SELECT * FROM company_info WHERE username='$sender'")->fetchAll();
                              foreach($q_c AS $q_c_data){
                                $comp_name = $q_c_data["comp_name"];
                                $comp_dp = $q_c_data["comp_logo"];

                                $decoded_img_profile = base64_decode($comp_dp);
                                $f = finfo_open();
                                $comp_type = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);
                          ?>
                            <ul class="nav nav-list">
                              <a href="chat_inbox_update_status.php?comp=<?php echo $sender; ?>" style="font-weight:normal;">
                                <li>
                                  <div class="panel-heading" style="background:#fff;">
                                    <div style="font-size:16px;color:#000;"><?php echo $comp_name; ?>&nbsp;<?php echo '<img src="data:'.$comp_type.';base64,'.$comp_dp.'" class="img-circle avatar">'; ?></div>
                                    <?php
                                    if($message_status == 'unread'){
                                      echo '<div style="color:#000;font-weight:bold;">'.$message.'</div>';
                                    }
                                    if($message_status == 'read'){
                                      echo '<div style="color:#000;">'.$message.'</div>';
                                    }
                                    ?>
                                  </div>
                                </li>
                              </a>
                            </ul>
                          <?php
                              }
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-7">
                  <?php
                  if(isset($_GET['user_id_clicked'])){
                    $user_id_clicked = $_GET['user_id_clicked'];
                     $tbl = "user_info";
                     $col = "*";
                     $wh = ["user_id" => $user_id_clicked];
                     $q_user = $database->select($tbl,$col,$wh);

                     foreach($q_user AS $q_user_data){
                       $full_name = $q_user_data["fname"].' '.$q_user_data["lname"];
                       $chat_status = $q_user_data["chat_status"];
                       $receiver_user = $q_user_data["username"];
                       $profileData = $q_user_data["profileData"];

                       $decoded_img_profile = base64_decode($profileData);
                       $f = finfo_open();
                       $img_type_profile = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);
                  ?>
                  <div class="panel" id="chat">
                    <div class="panel-heading" style="background:#0084ff;">
                      <div style="font-size:18px;color:#fff;"><?php echo $full_name; ?>&nbsp;<?php echo '<img src="data:'.$img_type_profile.';base64,'.$profileData.'" class="img-circle avatar">'; ?></div>
                      <div style="font-size:15px;color:#fff;"><?php echo $chat_status; ?></div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 chatbox">
                        <div class="chat-area">
                          <div class="chat-area-content">
                            <div class="msg_container_base">
                              <?php
                              $q_chat = $database->query("SELECT * FROM messenger WHERE (sender='$sender_user' AND receiver='$receiver_user') OR (sender='$receiver_user' AND receiver='$sender_user')")->fetchAll();
                              foreach($q_chat AS $q_chat_data){
                                $message = $q_chat_data["message"];
                                $sender = $q_chat_data["sender"];
                                $receiver = $q_chat_data["receiver"];
                                $datetime = $q_chat_data["datetime"];
                                $message_status = $q_chat_data["message_status"];
                                $type = "";

                                if($sender == $sender_user && $receiver == $receiver_user){
                                  $type = "send";
                                }
                                elseif($sender == $receiver_user && $receiver == $sender_user){
                                  $type = "receive";
                                }
                              ?>
                              <div class="row msg_container <?php echo $type; ?>">
                                <div class="col-md-9 col-xs-9 bubble">
                                  <?php
                                  if($type == 'send'){
                                    $background = "#0084ff";
                                    $color = "#fff";
                                  }
                                  else{
                                    $background = "#eaeaea";
                                    $color = "#000";
                                  }
                                  ?>
                                  <div class="messages msg_sent" style="background:<?php echo $background; ?>;color:<?php echo $color; ?>;">
                                    <p><?php echo $message; ?></p>
                                    <time datetime="2009-11-13T20:00" style="color:<?php echo $color; ?>;"><?php echo $datetime; ?></time>
                                  </div>
                                </div>
                                <?php
                                if($sender == $receiver_user){
                                  echo '<img src="data:'.$img_type_profile.';base64,'.$profileData.'" class="img-circle avatar">';
                                }
                                elseif($sender == $sender_user){
                                  echo '<img src="data:'.$comp_type.';base64,'.$comp_logo.'" class="img-circle avatar">';
                                }
                                ?>
                              </div>
                              <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div><hr>
                    <form method="post" action="chat_send_process.php" id="add_company" enctype="multipart/form-data">
                      <input name="user_id_clicked" type="hidden" value ="<?php echo $user_id_clicked; ?>" />
                      <input name="sender" type="hidden" value ="<?php echo $sender_user; ?>" />
                      <input name="receiver" type="hidden" value ="<?php echo $receiver_user; ?>" />
                      <div class="row">
                        <div class="col-md-10">
                          <div class="form-group has-feedback">
                            <textarea rows ="2" name="message" class="form-control" placeholder="type your message here.." style="margin-left:10px;"></textarea>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div style="margin-right:10px;">
                            <button type="submit" class="btn btn-block btn-lg" name="btn_comp_send" style="background:#0d47a1;color:#fff;"><span class="fa fa-chevron-circle-right fa-lg"></span></button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <?php
                      }
                    }
                    elseif(isset($_GET['comp_id_clicked'])){
                      $comp_id_clicked = $_GET['comp_id_clicked'];
                      $tbl = "nop_job_fair";
                      $col = "*";
                      $wh = ["comp_id"=>$comp_id_clicked];
                      $q_nop = $database->select($tbl,$col,$wh);

                      foreach($q_nop AS $q_nop_data){
                        $nop_comp_id = $q_nop_data["comp_id"];
                        $chat_status = $q_nop_data["chat_status"];

                        $tbl2 = "company_info";
                        $col2 = "*";
                        $wh2 = ["comp_id"=>$nop_comp_id];
                        $q_comp = $database->select($tbl2,$col2,$wh2);

                        foreach($q_comp AS $q_comp_data){
                          $comp_name = $q_comp_data["comp_name"];
                          $company_sender = $q_comp_data["username"];
                          $complogo = $q_comp_data["comp_logo"];

                          $decoded = base64_decode($complogo);
                          $x = finfo_open();
                          $comptype = finfo_buffer($x, $decoded, FILEINFO_MIME_TYPE);
                  ?>
                  <div class="panel" id="chat">
                    <div class="panel-heading" style="background:#0084ff;">
                      <div style="font-size:18px;color:#fff;"><?php echo $comp_name; ?>&nbsp;<?php echo '<img src="data:'.$comptype.';base64,'.$complogo.'" class="img-circle avatar">'; ?></div>
                      <div style="font-size:15px;color:#fff;"><?php echo $chat_status; ?></div>
                    </div>
                    <div class="row" style="height:500px;">
                      <div class="col-md-12 chatbox">
                        <div class="chat-area">
                          <div class="chat-area-content">
                            <div class="msg_container_base">
                              <?php
                              $q_chat = $database->query("SELECT * FROM messenger WHERE (sender='$sender_user' AND receiver='$company_sender') OR (sender='$company_sender' AND receiver='$sender_user')")->fetchAll();
                              foreach($q_chat AS $q_chat_data){
                                $message = $q_chat_data["message"];
                                $sender = $q_chat_data["sender"];
                                $receiver = $q_chat_data["receiver"];
                                $datetime = $q_chat_data["datetime"];
                                $message_status = $q_chat_data["message_status"];
                                $type = "";

                                if($sender == $sender_user){
                                  $type = "send";
                                }
                                elseif($receiver == $company_sender){
                                  $type = "receive";
                                }
                              ?>
                              <div class="row msg_container <?php echo $type; ?>">
                                <div class="col-md-9 col-xs-9 bubble">
                                  <?php
                                  if($type == 'send'){
                                    $background = "#0084ff";
                                    $color = "#fff";
                                  }
                                  else{
                                    $background = "#eaeaea";
                                    $color = "#000";
                                  }
                                  ?>
                                  <div class="messages msg_sent" style="background:<?php echo $background; ?>;color:<?php echo $color; ?>;">
                                    <p><?php echo $message; ?></p>
                                    <time datetime="2009-11-13T20:00" style="color:<?php echo $color; ?>;"><?php echo $datetime; ?></time>
                                  </div>
                                </div>
                                  <?php
                                  if($sender == $sender_user){
                                    echo '<img src="data:'.$comp_type.';base64,'.$comp_logo.'" class="img-circle avatar">';
                                  }
                                  elseif($sender == $company_sender){
                                    echo '<img src="data:'.$comptype.';base64,'.$complogo.'" class="img-circle avatar">';
                                  }
                                  ?>
                              </div>
                              <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div><hr>
                    <form method="post" action="chat_send_process.php" id="add_company" enctype="multipart/form-data">
                      <input name="comp_id_clicked" type="hidden" value ="<?php echo $comp_id_clicked; ?>" />
                      <input name="sender" type="hidden" value ="<?php echo $sender_user; ?>" />
                      <input name="receiver" type="hidden" value ="<?php echo $company_sender; ?>" />
                      <div class="row">
                        <div class="col-md-10">
                          <div class="form-group has-feedback">
                            <textarea rows ="2" name="message" class="form-control" placeholder="type your message here.." style="margin-left:10px;"></textarea>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div style="margin-right:10px;">
                            <button type="submit" class="btn btn-block btn-lg" name="btn_send" style="background:#0d47a1;color:#fff;"><span class="fa fa-chevron-circle-right fa-lg"></span></button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <?php
                      }
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>

          <?php require('chat_company.php'); ?>
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
                      <a href="e2e_business_card.php"><i class="glyphicon icons icon-credit-card"></i>&nbsp; Business Card</a>
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
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
</script>
</body>
</html>
