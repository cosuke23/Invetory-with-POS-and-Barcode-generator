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
$current_year = date("Y")-2;
$next_year = date("Y")+1;
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
                    <h1 class="animated fadeInLeft"> REPORTS</h1>
                </div><!-- panel-body -->
              </div><!-- panel box-shadow-none -->
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                    <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-list-alt"></span> PRINT CERTIFICATE</a>
                      </li>
                      <li role="presentation">
                        <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-home"></span> SEMINAR ATTENDANCE</a>
                      </li>
                    </ul>
                  </div><br>
                  <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
                      <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v2" role="tablist">
                        <li role="presentation" class="active">
                          <a href="#tabs-demo3-area1" id="tabs-demo3-1" role="tab" data-toggle="tab" aria-expanded="true">BATCH PRINTING</a>
                        </li>
                        <li role="presentation" class="">
                          <a href="#tabs-demo3-area2" role="tab" id="tabs-demo3-2" data-toggle="tab" aria-expanded="false">INDIVIDUAL PRINTING</a>
                        </li>
                    </ul>
                      <div id="tabsDemo3Content" class="tab-content tabs-content-v2">
                        <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo3-area1" aria-labelledby="tabs-demo3-area1">
                          <div class="panel box-v7">
                            <div class="panel-body">
                              <div class="panel-body">
                                <form id="batch_certi" method="post" action="e2e_certificate_process.php" enctype="multipart/form-data">
                                  <div class="row">
                                    <div class="col-md-2">
                                      <h5 style="padding-left:5px;">PROGRAM</h5>
                                      <div class="form-group has-feedback">
                                        <?php
                                          $table = "program_list";
                                          $columns = "*";
                                          $q_program =$database->select($table,$columns);

                                          print'<select class="form-control"  name="program" class="form-control">';
                                          echo "<option value='".$program_id."' disabled selected>".$program_code."</option>";

                                          foreach($q_program as $q_program_data){
                                            $program_id2 = $q_program_data['program_id'];
                                            $program_code2 = $q_program_data['program_code'];
                                            $counter = 0;

                                            $comstart3="";
                                            if($program_code==$program_code2)
                                            {
                                              $comstart3="<!--";
                                            }
                                            if($counter <= $program_id)
                                            {
                                              echo $comstart3."<option value='".$program_id2."'>".$program_code2."</option>".$comend;
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
                                      <button type="submit" class="btn btn-ripple btn-raised btn-primary" name="btn_prog" id="btn_update_stud_info" style="margin-top:15px;">
                                        <span class="glyphicon glyphicon-ok"></span> &nbsp;OK
                                      </button>
                                    </div>
                                  </div>
                                </form>
                                <div class="responsive-table">
                                  <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                    <thead>
                                      <tr>
                                        <th class="col-md-1"></th>
                                        <th class="text-center">EVENT CODE</th>
                                        <th class="text-center">EVENT NAME</th>
                                        <th class="text-center">DATE RANGE</th>
                                        <th class="text-center">VENUE</th>
                                        <th class="text-center">PROGRAM</th>
                                        <th class="text-center">ACTION</th>
                                      </tr>
                                    </thead>
                                    <?php
                                      $table = "event_manager";
                                      $columns = "*";
                                      $where = ["type"=>"Seminar"];
                                      $q_seminar =$database->select($table,$columns,$where);

                                      foreach($q_seminar as $q_seminar_data){
                                        $event_id = $q_seminar_data['event_id'];
                                        $event_code = $q_seminar_data['event_code'];
                                        $event_name = $q_seminar_data['event_name'];
                                        $event_start_date = $q_seminar_data['event_start_date'];
                                        $event_end_date = $q_seminar_data['event_end_date'];
                                        $event_date_range = "";
                                        if($event_start_date == $event_end_date){
                                        $event_date_range = $event_start_date;
                                        } else{
                                        $event_date_range = $event_start_date . " - " . $event_end_date;
                                        }
                                        $venue = $q_seminar_data['venue'];
                                        $status = $q_seminar_data['status'];
                                        $event_img = $q_seminar_data['event_img'];
                                      ?>
                                        <tr>
                                          <td><img src="grad_id/grad_data/images/<?php echo $event_img; ?>" style="height:40px;width:50px;"></td>
                                          <td><?php echo $event_code; ?></td>
                                          <td><?php echo $event_name; ?></td>
                                          <td><?php echo $event_date_range; ?></td>
                                          <td><?php echo $venue; ?></td>
                                          <td><?php if(isset($_GET['program_code'])){ echo $_GET['program_code']; } ?></td>
                                          <td class="text-center">
                                            <?php
                                              if(empty($_GET['program_code']))
                                              {
                                            ?>
                                                <a target="_blank" href="grad_id/grad_data/generate_certificate_all.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>&&event_img=<?php echo $event_img; ?>&&program_id=<?php echo $program_id2; ?>">
                                                  <button type="button" class="btn btn-outline btn-success" name= data-toggle="tooltip" data-placement="top" title="Choose Program" disabled="disabled">
                                                    <span class="glyphicon glyphicon-list-alt"></span>
                                                  </button>
                                                </a>
                                            <?php
                                              }
                                              elseif(!empty($_GET['program_code']))
                                              {
                                            ?>
                                                <a target="_blank" href="grad_id/grad_data/generate_certificate_all.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>&&event_img=<?php echo $event_img; ?>&&program_id=<?php echo $_GET['program_id']; ?>">
                                                  <button type="button" class="btn btn-outline btn-success" name= data-toggle="tooltip" data-placement="top" title="Print Certificate">
                                                    <span class="glyphicon glyphicon-list-alt"></span>
                                                  </button>
                                                </a>
                                            <?php
                                              }
                                            ?>
                                          </td>
                                        </tr>
                                      <?php
                                        }
                                      ?>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabs-demo3-area2" aria-labelledby="tabs-demo3-area2">
                          <div class="panel box-v7">
                            <div class="panel-body">
                              <div class="panel-body">
                                <form id="indiv_certi" method="post" action="e2e_individual_certificate_process.php" enctype="multipart/form-data">
                                  <div class="row">
                                    <div class="col-md-3">
                                      <h5 style="padding-left:5px;">STUDENT NUMBER</h5>
                                      <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Student Number" name="studno" />
                                      </div>
                                    </div>
                                    <div class="col-md-2"><br>
                                      <button type="submit" class="btn btn-ripple btn-raised btn-primary" name="btn_indiv" id="btn_update_stud_info" style="margin-top:15px;">
                                        <span class="glyphicon glyphicon-ok"></span> &nbsp;OK
                                      </button>
                                    </div>
                                  </div>
                                </form><br>
                                <div class="responsive-table">
                                  <table id="datatables3" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                                    <thead>
                                      <tr>
                                        <th class="col-md-1"></th>
                                        <th class="text-center">EVENT CODE</th>
                                        <th class="text-center">EVENT NAME</th>
                                        <th class="text-center">DATE RANGE</th>
                                        <th class="text-center">VENUE</th>
                                        <th class="text-center">STUDENT NAME</th>
                                        <th class="text-center">ACTION</th>
                                      </tr>
                                    </thead>
                                    <?php
                                      $table = "event_manager";
                                      $columns = "*";
                                      $where = ["type"=>"Seminar"];
                                      $q_seminar =$database->select($table,$columns,$where);

                                      foreach($q_seminar as $q_seminar_data){
                                        $event_id = $q_seminar_data['event_id'];
                                        $event_code = $q_seminar_data['event_code'];
                                        $event_name = $q_seminar_data['event_name'];
                                        $event_start_date = $q_seminar_data['event_start_date'];
                                        $event_end_date = $q_seminar_data['event_end_date'];
                                        $event_date_range = "";
                                        if($event_start_date == $event_end_date){
                                        $event_date_range = $event_start_date;
                                        } else{
                                        $event_date_range = $event_start_date . " - " . $event_end_date;
                                        }
                                        $venue = $q_seminar_data['venue'];
                                        $status = $q_seminar_data['status'];
                                        $event_img = $q_seminar_data['event_img'];
                                      ?>
                                      <tr>
                                        <td><img src="grad_id/grad_data/images/<?php echo $event_img; ?>" style="height:40px;width:50px;"></td>
                                        <td><?php echo $event_code; ?></td>
                                        <td><?php echo $event_name; ?></td>
                                        <td><?php echo $event_date_range; ?></td>
                                        <td><?php echo $venue; ?></td>
                                        <td><?php if(isset($_GET['full_name'])){ echo $_GET['full_name']; } ?></td>
                                        <td class="text-center">
                                          <?php
                                            if(empty($_GET['full_name']))
                                            {
                                          ?>
                                              <a href="">
                                                <button type="button" class="btn btn-outline btn-success" name= data-toggle="tooltip" data-placement="top" title="Choose Student" disabled="disabled">
                                                  <span class="glyphicon glyphicon-list-alt"></span>
                                                </button>
                                              </a>
                                          <?php
                                            }
                                            elseif(!empty($_GET['full_name']))
                                            {
                                          ?>
                                              <a target="_blank" href="grad_id/grad_data/generate_certificate_individual.php?event_id=<?php echo $event_id; ?>&&event_name=<?php echo $event_name; ?>&&event_start_date=<?php echo $event_start_date; ?>&&event_img=<?php echo $event_img; ?>&&stud_no=<?php echo $_GET['stud_no']; ?>">
                                                <button type="button" class="btn btn-outline btn-success" name= data-toggle="tooltip" data-placement="top" title="Print Certificate">
                                                  <span class="glyphicon glyphicon-list-alt"></span>
                                                </button>
                                              </a>
                                          <?php
                                            }
                                          ?>
                                        </td>
                                      </tr>
                                    <?php
                                      }
                                    ?>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">
                    <div id="tabsDemo3Content" class="tab-content tabs-content-v2">
                      <div role="tabpanel" class="tab-pane fade active in" id="tabs-demo3-area1" aria-labelledby="tabs-demo3-area1">
                        <div class="panel box-v7">
                          <div class="panel-body">
                            <form action="#" method="get" onsubmit="return filters()" id="defaultForm_search">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-5">
                                    <h5>EVENT NAME</h5>
                                    <div class="form-group has-feedback">
                                      <input type="text" list="suggestion" class="form-control" name="event_name" id="event_name"/>
                                      <?php
                                      $query_em_list=$database->query("SELECT * FROM event_manager WHERE type='Seminar'");
                                      print'<datalist id="suggestion">';
                                      foreach($query_em_list  AS $qemDAta){
                                        $event_id = $qemDAta["event_id"];
                                        $event_name = $qemDAta["event_name"];

                                        echo "<option data-value='".$event_id."'>".$event_name."</option>";
                                      }
                                      ?>
                                          <input type="hidden" name="event_name-hidden" id="event_name-hidden"/>
                                          <script>
                                          document.querySelector('input[list]').addEventListener('input', function(e) {
                                            var input = e.target,
                                            list = input.getAttribute('list'),
                                            options = document.querySelectorAll('#' + list + ' option'),
                                            hiddenInput = document.getElementById(input.id + '-hidden'),
                                            inputValue = input.value;
                                            hiddenInput.value = inputValue;
                                            for(var i = 0; i < options.length; i++) {
                                              var option = options[i];
                                              if(option.innerText === inputValue) {
                                                hiddenInput.value = option.getAttribute('data-value');
                                                break;
                                              }
                                            }
                                          });
                                        </script>
                                      <?php
                                      print '</datalist>';
                                      ?>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <h5>BATCH NUMBER</h5>
                                    <div class="form-group has-feedback">
                                      <select class="form-control" name="batch_id" id="batch_id">
                                        <option value="0">ALL</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">PROGRAM</h5>
                                    <div class="form-group has-feedback">
                                        <?php
                                        $table_pl = "program_list";
                                        $columns_pl = "*";
                                        $where_pl = ["status" => 'Active'];
                                        $q_pl =$database->select($table_pl,$columns_pl,$where_pl);

                                        print'<select class="form-control"  name="program_id" id="program_id">';

                                         echo "<option value='0'>ALL</option>";

                                         foreach($q_pl as $q_pl_data){

                                            $program_id2 = $q_pl_data['program_id'];
                                            $program_code2 = $q_pl_data['program_code'];
                                            $counter = 0;
                                        if($counter <= $program_id2)
                                          {
                                              echo "<option value='".$program_id2."'>".$program_code2."</option>";
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
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-3">
                                    <h5 style="padding-left:5px;">SEMESTER</h5>
                                    <div class="form-group has-feedback">
                                      <select class="form-control" name="semester" id="semester">
                                        <option disabled selected></option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                        <option value="Summer">Summer</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>"/>
                                    <input type="hidden" name="next_year" id="next_year" value="<?php echo $next_year; ?>"/>
                                    <h5 style="padding-left:5px;">S.Y. START</h5>
                                    <div class="form-group">
                                      <div class="dateContainer">
                                        <div class="input-group input-append date">
                                          <input type="text" class="form-control" name="acad_year_start" placeholder="(e.g.YYYY)" id="acad_year_start" onchange="get_value_ays()" />
                                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <h5>S.Y. END</h5>
                                    <div>
                                     <input type="hidden" id="acad_year_end_value" name="acad_year_end" />
                                     <h4 id ="acad_year_start_show"></h4>
                                    </div>
                                  </div>
                                  <div class="col-md-3" style="padding-top:30px;">
                                    <button type="submit" class="btn btn-primary btn-block" name="btn_search" id = "btn_search">
                                    <span class="fa fa-search"></span>&nbsp; Search</button>
                                  </div>
                                </div>
                              </div>
                            </form><br>
                            <div class="row" style="padding-top:10px;">
                              <div class="col-md-12">
                                <div class="col-md-2"></div>
                                <div class="col-md-6"></div>
                                <div class="col-md-4">
                                  <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="responsive-table">
                              <table id="datatables2" class="display table table-bordered table-hover table-condensed table-list-search table-reflow" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th class="text-center">STUDENT NUMBER</th>
                                    <th class="text-center">LASTNAME</th>
                                    <th class="text-center">FIRSTNAME</th>
                                    <th class="text-center">MIDDLENAME</th>
                                    <th class="text-center">PROGRAM</th>
                                    <th class="text-center">SEMESTER</th>
                                    <th class="text-center">S1 TIME IN</th>
                                    <th class="text-center">S1 STATUS</th>
                                    <th class="text-center">S2 TIME IN</th>
                                    <th class="text-center">S2 STATUS</th>
                                    <th class="text-center">BATCH</th>
                                  </tr>
                                </thead>
                                <tbody></tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
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
 var event_name = document.getElementById('event_name').value;
function get_value_ays(){
var selected_acad_year_start = document.getElementById("acad_year_start").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
 document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
  document.getElementById("acad_year_end_value").value =  acad_year_end;
 }
  function filters() {
var semester = document.getElementById('semester').value;
 var acad_year_start = document.getElementById("acad_year_start").value;
 var program_id = document.getElementById('program_id').value;
 
 
 
 var event_name = document.getElementById('event_name').value + " Attendance";
 var batch_id = document.getElementById('batch_id').value;
  var event_id_hidden = document.getElementById('event_name-hidden').value;
  //alert("batch id="+batch_id+"program_id="+program_id+"event_id="+event_id_hidden);
    $('#datatables2').dataTable().fnDestroy();
     var table = $('#datatables2').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 1, "asc" ]],
        "ajax": "e2e_reports_search_processing.php?semester="+semester+"&acad_year_start="+acad_year_start+"&program_id="+program_id+"&batch_id="+batch_id+"&event_id="+event_id_hidden,
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },

  });

 var buttons = new $.fn.dataTable.Buttons(table, {

     buttons: [
            {
                extend: 'excelHtml5',
                title: event_name,
                 text: '<i class="glyphicon glyphicon-save-file"></i> EXCEL',
                 className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,4,6,7,8,9]
                }
            },
            {
                extend: 'print',
                title: event_name,
                text: '<i class="glyphicon glyphicon-print"></i> PRINT',
                className: 'btn btn-info btn-outline',
                exportOptions: {
                    columns: [0,1,2,4,6,7,8,9]
                }
            },

        ]
    }).container().appendTo($('#buttons'));
   return false;
}

$(document).ready(function() {
$('#acad_year_start')
        .datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm_search').bootstrapValidator('revalidateField', 'acad_year_start');
        });


 $('#datatables2').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 1, "asc" ]],
        "ajax": "e2e_reports_processing.php",
        lengthMenu: [[10, 50, -1], [10, 50, "All"]],
        oLanguage: {
         sProcessing: "<img src='asset/img/table_loader.gif'>"
        },
  });

  $('#datatables').DataTable();
  $('#datatables3').DataTable();

//start of form validation
$('#defaultForm_search')
    .bootstrapValidator({
        message: 'This value is invalid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid:'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          semester: {
                    validators: {
                        notEmpty: {
                            message: 'Semester is required and can\'t be empty'
                        },
                    },
                },
           program_id: {
                    validators: {
                        notEmpty: {
                            message: 'Program is required and can\'t be empty'
                        },
                    },
                },
          batch_id: {
                    validators: {
                        notEmpty: {
                            message: 'Batch Number is required and can\'t be empty'
                        },
                        stringLength: {
                        min: 1,
                        max: 4,
                        message: 'Batch Number must be more than 1 / less than 3 characters'
                    }
                    },
                },
          event_name: {
                    validators: {
                        notEmpty: {
                            message: 'Event Name is required and can\'t be empty'
                        },
                    },
                },
                acad_year_start: {
                    validators: {
                        notEmpty: {
                            message: 'Academic year start is required and can\'t be empty'
                        },

                         regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Invalid characters'
                        },
                        callback: {
                        message: 'Date is not in the range',
                        callback: function(value, validator) {
                            var m = new moment(value, 'YYYY', true);
                            var cy = document.getElementById("current_year").value;
                             var ny = document.getElementById("next_year").value;
                            if (!m.isValid()) {
                                return false;
                            }
                            return m.isAfter(cy) && m.isBefore(ny);
                        }
                       },
                    }
                }
        }
    });

    $('#batch_certi')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
              program: {
                        validators: {
                            notEmpty: {
                                message: 'Program is required and can\'t be empty'
                            },
                        },
                    },
            }
        });

        $('#indiv_certi')
            .bootstrapValidator({
                message: 'This value is invalid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid:'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                  studno: {
                            validators: {
                                notEmpty: {
                                    message: 'Student Number is required and can\'t be empty'
                                },
                                regexp: {
                                   regexp: /^[0-9]+$/,
                                   message: 'Invalid characters'
                               },
                               stringLength: {
                                 min: 11,
                                 max: 11,
                                 message: 'Student Number must be 11 digits'
                              }
                            },
                        },
                }
            });

} );
</script>
<!-- end: Javascript -->
</body>
</html>
