<?php

$page_title = 'OJT AssiSTI';



if(!isset($_COOKIE["uid"])) {

  header ("Location: login.php");

  exit;

}

$username = $_COOKIE["uid"];

$usertype = $_COOKIE["ut"];

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



if($usertype==1)

{

  header("Location: admin_home.php");

}

if($usertype!=1)

{

  $query2 = "SELECT * from adviser_info WHERE adviser_id = '$username'";

  $result2 = mysqli_query($dbc,$query2);

    if(mysqli_num_rows($result2)>0)

    {

      $row2 = mysqli_fetch_assoc($result2);

      $fname2 = $row2["fname"];

    }

}

if(isset($_GET['adviser_id']) && isset($_GET['ach_id'])) {

  

  $adviser_id= $_GET['adviser_id'];

  $ach_id= $_GET['ach_id'];



  $query_update_consulatation_hours = "SELECT * FROM adviser_consultation_hours WHERE adviser_id = '$adviser_id' AND ach_id = '$ach_id'";



  $result_update_consultation_hours = mysqli_query($dbc,$query_update_consulatation_hours);

  if($result_update_consultation_hours->num_rows > 0)

  {

    while($row = mysqli_fetch_array($result_update_consultation_hours))

    {

      $adviser_id = $row[0];

      $day= $row[1];

      $hour_start = $row[2];

      $hour_end = $row[3];

      $ach_id = $row[4];

    }



  }



}



/// check if there are unread remarks from companies

  //COMPANY COMMENTS NOTIFICATION FIX

    $x=0;

    $q_advsec = "select distinct section_id from adviser_section_handled where adviser_id='$username' and status = 'Active'";

    $q_advsec_res = $dbc->query($q_advsec);

    if($q_advsec_res->num_rows > 0){

      while($advsec = $q_advsec_res->fetch_assoc()){

        $sec = $advsec['section_id'];

        $q_advstud = "select * from student_ojt_records where section_id = '$sec' and ojt_status='Ongoing'";

        $q_advstud_res = $dbc->query($q_advstud);

        while($advstud = $q_advstud_res->fetch_assoc()){

          $stud=$advstud['stud_no'];

          $q_compstudnt = "select * from company_ojt_student where stud_no = '$stud' and status='Ongoing'";

          $q_compstudnt_res=$dbc->query($q_compstudnt);

          while($compstudnt=$q_compstudnt_res->fetch_assoc()){

            $student = $compstudnt['stud_no'];

            $q = "select count(status) as unread_count from company_remarks where stud_no='$student' and status='unread'";

            $q_res = $dbc->query($q);

            $count= $q_res->fetch_assoc();

            $x = $x + intval($count['unread_count']);

          }

        }

      }

      $unread_msg = $x;

    }else{

      $unread_msg = '0';

    }

    //note: pakipalitan ung echo sa baba ung dating unread['num'] change to $unread_msg 

    //--end of fix

?>

<!DOCTYPE html>

<html lang="en">

<head>

  

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OJT assiSTI</title>



  <!-- start: Css -->

  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

   <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker.css"/>

  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />

  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />

   <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datetimepicker.min.css" />

 

  <!-- plugins -->

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>

  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>



  <link href="asset/css/style.css" rel="stylesheet">

  <!-- end: Css -->



<link rel="shortcut icon" href="asset/img/ojtassistilogo.png">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      <![endif]-->

    

    <?php

      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

      header("Cache-Control: post-check=0, pre-check=0", false);

      header("Pragma: no-cache");

    ?>

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

                <a href="home.php" class="navbar-brand"> 

                 <b>OJT assiSTI</b>

                </a>

              <ul class="nav navbar-nav navbar-right user-nav">

                <li class="dropdown avatar-dropdown">

                <br>     

                    <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:7px 10px 7px 10px">

                    <i class="glyphicon glyphicon-envelope" style="color:white;font-size:17px;"><label class="badge badge-danger" style="font-size:15px;padding:1px 10px 3px 10px;"><?php echo $unread_msg ;?></label></i>

                    </span>

					<ul class="dropdown-menu user-dropdown">

					<div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">

                        <li>

                            <a href="adviser_company_remarks.php">

                            <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;">There is/are

                                <label class="text-primary"> <?php echo  $unread_msg; ?> </label> unread company comment/s.

                            </div>

                            </a>

                        </li>

                    </div>

					</ul>

				</li>

				<li class="user-name">&nbsp;<span>&nbsp;<?php echo $fname2 ; ?>&nbsp;</span></li>

                  <li class="dropdown avatar-dropdown">

                  <br>

                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>

                   <ul class="dropdown-menu user-dropdown">

                     <li><a href="adviser_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span>&nbsp;My Account</a></li>

                      <li><a href="logout.php"><span class="fa fa-power-off ">&nbsp;Log Out</span></a></li> 

                  </ul>

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



                    <div  style="background: linear-gradient(#ebebe0, 50%,#ebebe0);height:90px;">

                      <img src="asset/img/ojtassistilogo.png" style="padding-top:10px;margin-left:35px;width:150px;height:150px;" class="animated fadeInLeft">

                    </div>

                    <div  style="margin-top:-20px;background: linear-gradient(#ebebe0, 50%,#ebebe0);height:100px;">

                    <br>

                       <p class="animated fadeInRight" style="color:gray;margin-left:20px;margin-top:60px;">

                               <?php

                                 echo  date("l, F j, Y"); 

                               ?>

                        </p>

                    </div>



                      <div class="nav-side-menu">

                       <label>

                          <a href="adviser_home.php"><i class="glyphicon glyphicon-home"></i>Home</a>

                        </label><br>

                        <label>

                          <a href="adviser_company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Information</a>

                        </label><br>

                        <label>

                           <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;My Students</a>

                        </label><br>

                          <label>

                          <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i>Company Comments</a>

                          </label><br>

                           <label>

                          <a href="pending_student_list.php"><i class="fa fa-list"></i>Pending Students</a>

                          </label><br>

                      </div>

              </div>

            </div>

          <!-- end: Left Menu -->

       



            <!-- start: Content -->

            <div id="content">

               <div class="panel box-shadow-none content-header">

                  <div class="panel-body">

                    <div class="col-md-12">

                        <h1 class="animated fadeInLeft">CONSULTATION HOURS</h1>

                        <p class="animated fadeInDown" style="padding-left:10px;">

                            This section can update your consultation hours.

                        </p>

                    </div>

                </div>

              </div>

              <div class="col-md-12 padding-0">

                <div class="col-md-12">

                  <div class="panel">

                    <div class="panel-heading"><h3>UPDATE CONSULTATION HOURS</h3></div>

                      <form id="defaultForm" method="post" action="update_consulation_hours_process.php" enctype="multipart/form-data">

                       <div class="panel-body" style="padding-bottom:30px;">

                        <input name="adviser_id" type="hidden" value ="<?php echo $adviser_id ?>"/>

                        <input name="ach_id" type="hidden" value ="<?php echo $ach_id ?>"/>



                    

                        <div class="row">

                          <div class="col-md-4">                          

                                <h5 style="padding-left:5px;">DAY</h5>

                                 <div class="form-group has-feedback">

                                   <select class="form-control" name="day" id="day" class="form-control" placeholder="Day">

                                    <option value="<?php 

									if($day=="Monday")

									{

										$comstart="<!--";

										$comend="-->";

										echo $day;

									}

									if($day=="Tuesday")

									{

										$comstart2="<!--";

										$comend2="-->";

										echo $day;

									}

									if($day=="Wednesday")

									{

										$comstart3="<!--";

										$comend3="-->";

										echo $day;

									}

									if($day=="Thursday")

									{

										$comstart4="<!--";

										$comend4="-->";

										echo $day;

									}

									if($day=="Friday")

									{

										$comstart5="<!--";

										$comend5="-->";

										echo $day;

									}

									if($day=="Saturday")

									{

										$comstart6="<!--";

										$comend6="-->";

										echo $day;

									}

									?>"><?php echo $day; ?></option>

                                    <?php echo $comstart;?><option value="Monday">Monday</option><?php echo $comend;?>

                                    <?php echo $comstart2;?><option value="Tuesday">Tuesday</option><?php echo $comend2;?>

                                    <?php echo $comstart3;?><option value="Wednesday">Wednesday</option><?php echo $comend3;?>

                                    <?php echo $comstart4;?><option value="Thursday">Thursday</option><?php echo $comend4;?>

                                    <?php echo $comstart5;?><option value="Friday">Friday</option><?php echo $comend5;?>

                                    <?php echo $comstart6;?><option value="Saturday">Saturday</option><?php echo $comend6;?>

                                    </select>

                                </div>

                           </div>



                            <div class="col-md-3">

                                <h5 style="padding-left:5px;">HOUR START</h5>

                                  <div class="form-group has-feedback">

                                   <select class="form-control" name="hour_start" id="hour_start" class="form-control" placeholder="remarks">

                                   <?php

                                   if($hour_start == "7"){

                                        $hour_start2 = "7:00 AM";

                                      }

                                      else if($hour_start == "8"){

                                        $hour_start2 = "7:30 AM";

                                      }

                                      else if($hour_start == "9"){

                                        $hour_start2 = "8:00 AM";

                                      }

                                      else if($hour_start == "10"){

                                        $hour_start2 = "8:30 AM";

                                      }

                                      else if($hour_start == "11"){

                                        $hour_start2 = "9:00 AM";

                                      }

                                      else if($hour_start == "12"){

                                        $hour_start2 = "9:30 AM";

                                      }

                                      else if($hour_start == "13"){

                                        $hour_start2 = "10:00 AM";

                                      }

                                      else if($hour_start == "14"){

                                        $hour_start2 = "10:30 AM";

                                      }

                                      else if($hour_start == "15"){

                                        $hour_start2 = "11:00 AM";

                                      }

                                       else if($hour_start == "16"){

                                        $hour_start2 = "11:30 AM";

                                      }

                                       else if($hour_start == "17"){

                                        $hour_start2 = "12:00 PM";

                                      }

                                       else if($hour_start == "18"){

                                        $hour_start2 = "12:30 PM";

                                      }

                                      else if($hour_start == "19"){

                                        $hour_start2 = "1:00 PM";

                                      }

                                      else if($hour_start == "20"){

                                        $hour_start2 = "1:30 PM";

                                      }

                                      else if($hour_start == "21"){

                                        $hour_start2 = "2:00 PM";

                                      }

                                      else if($hour_start == "22"){

                                        $hour_start2 = "2:30 PM";

                                      }

                                      else if($hour_start == "23"){

                                        $hour_start2 = "3:00 PM";

                                      }

                                      

                                      else if($hour_start == "24"){

                                        $hour_start2 = "3:30 PM";

                                      }

                                       else if($hour_start == "25"){

                                        $hour_start2 = "4:00 PM";

                                      }

                                       else if($hour_start == "26"){

                                        $hour_start2 = "4:30 PM";

                                      }

                                       else if($hour_start == "27"){

                                        $hour_start2 = "5:00 PM";

                                      }

                                       else if($hour_start == "28"){

                                        $hour_start2 = "5:30 PM";

                                      }

                                       else if($hour_start == "29"){

                                        $hour_start2 = "6:00 PM";

                                      }

                                       else if($hour_start == "30"){

                                        $hour_start2 = "6:30 PM";

                                      }

                                       else if($hour_start == "31"){

                                        $hour_start2 = "7:00 PM";

                                      }



                                      if($hour_end == "7"){

                                        $hour_end2 = "7:00 AM";

                                      }

                                      else if($hour_end == "8"){

                                        $hour_end2 = "7:30 AM";

                                      }

                                      else if($hour_end == "9"){

                                        $hour_end2 = "8:00 AM";

                                      }

                                      else if($hour_end == "10"){

                                        $hour_end2 = "8:30 AM";

                                      }

                                      else if($hour_end == "11"){

                                        $hour_end2 = "9:00 AM";

                                      }

                                      else if($hour_end == "12"){

                                        $hour_end2 = "9:30 AM";

                                      }

                                      else if($hour_end == "13"){

                                        $hour_end2 = "10:00 AM";

                                      }

                                      else if($hour_end == "14"){

                                        $hour_end2 = "10:30 AM";

                                      }

                                      else if($hour_end == "15"){

                                        $hour_end2 = "11:00 AM";

                                      }

                                       else if($hour_end == "16"){

                                        $hour_end2 = "11:30 AM";

                                      }

                                       else if($hour_end == "17"){

                                        $hour_end2 = "12:00 PM";

                                      }

                                       else if($hour_end == "18"){

                                        $hour_end2 = "12:30 PM";

                                      }

                                      else if($hour_end == "19"){

                                        $hour_end2 = "1:00 PM";

                                      }

                                      else if($hour_end == "20"){

                                        $hour_end2 = "1:30 PM";

                                      }

                                      else if($hour_end == "21"){

                                        $hour_end2 = "2:00 PM";

                                      }

                                      else if($hour_end == "22"){

                                        $hour_end2 = "2:30 PM";

                                      }

                                      

                                      else if($hour_end == "23"){

                                        $hour_end2 = "3:00 PM";

                                      }

                                      else if($hour_end == "24"){

                                        $hour_end2 = "3:30 PM";

                                      }

                                       else if($hour_end == "25"){

                                        $hour_end2 = "4:00 PM";

                                      }

                                       else if($hour_end == "26"){

                                        $hour_end2 = "4:30 PM";

                                      }

                                       else if($hour_end == "27"){

                                        $hour_end2 = "5:00 PM";

                                      }

                                       else if($hour_end == "28"){

                                        $hour_end2 = "5:30 PM";

                                      }

                                       else if($hour_end == "29"){

                                        $hour_end2 = "6:00 PM";

                                      }

                                       else if($hour_end == "30"){

                                        $hour_end2 = "6:30 PM";

                                      }

                                       else if($hour_end == "32"){

                                        $hour_end2 = "7:00 PM";

                                      }



                                   ?>

                                     <option value="<?php echo $hour_start; ?>"><?php echo $hour_start2; ?></option> 

                                    <option value="7">7:00 AM</option>

                                    <option value="8">7:30 AM</option>

                                    <option value="9">8:00 AM</option>

                                    <option value="10">8:30 AM</option>

                                    <option value="11">9:00 AM</option>

                                    <option value="12">9:30 AM</option>

                                    <option value="13">10:00 AM</option>

                                    <option value="14">10:30 AM</option>

                                    <option value="15">11:00 AM</option>

                                    <option value="16">11:30 AM</option>

                                    <option value="17">12:00 PM</option>

                                    <option value="18">12:30 PM</option>

                                    <option value="19">1:00 PM</option>

                                    <option value="20">1:30 PM</option>

                                    <option value="21">2:00 PM</option>

                                    <option value="22">2:30 PM</option>

                                    <option value="23">3:00 PM</option>

                                    <option value="24">3:30 PM</option>

                                    <option value="25">4:00 PM</option>

                                    <option value="26">4:30 PM</option>

                                    <option value="27">5:00 PM</option>

                                    <option value="28">5:30 PM</option>

                                    <option value="29">6:00 PM</option>

                                    <option value="30">6:30 PM</option>

                                     <option value="31">7:00 PM</option>

                                    </select>

                                </div>

                           </div>



                             <div class="col-md-3">

                              <h5 style="padding-left:5px;">HOUR END</h5>

                                  <div class="form-group has-feedback">

                                   <select class="form-control" name="hour_end" id="hour_end" class="form-control" placeholder="hour end">

                                    <option value="<?php echo $hour_end; ?>"><?php echo $hour_end2; ?></option> 

                                    <option value="7">7:00 AM</option>

                                    <option value="8">7:30 AM</option>

                                    <option value="9">8:00 AM</option>

                                    <option value="10">8:30 AM</option>

                                    <option value="11">9:00 AM</option>

                                    <option value="12">9:30 AM</option>

                                    <option value="13">10:00 AM</option>

                                    <option value="14">10:30 AM</option>

                                    <option value="15">11:00 AM</option>

                                    <option value="16">11:30 AM</option>

                                    <option value="17">12:00 PM</option>

                                    <option value="18">12:30 PM</option>

                                    <option value="19">1:00 PM</option>

                                    <option value="20">1:30 PM</option>

                                    <option value="21">2:00 PM</option>

                                    <option value="22">2:30 PM</option>

                                    <option value="23">3:00 PM</option>

                                    <option value="24">3:30 PM</option>

                                    <option value="25">4:00 PM</option>

                                    <option value="26">4:30 PM</option>

                                    <option value="27">5:00 PM</option>

                                    <option value="28">5:30 PM</option>

                                    <option value="29">6:00 PM</option>

                                    <option value="30">6:30 PM</option>

                                     <option value="31">7:00 PM</option>

                                    </select>

                                </div>

                           </div>

                           

                         </div>

                        <br>

                        <br>

                          <div class="row">

                            <div class="col-md-4"></div>

                             <div class="col-md-4">

                             <button type="submit" class="btn btn-info btn-block" name="btn_update_consulation_hours" id="btn_update_consulation_hours"><span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE</button>

                             </div>

                               <div class="col-md-4">

                               <a href="adviser_account.php?username=<?php echo $adviser_id; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>

                               </div>

                            </div>

                       </div><!--ENd of panel body-->

                      </form>        

              

                  </div>

                </div>

              </div>

            </div><!-- end: content -->

     </div>

          

      <!-- start: Mobile -->

      <div id="mimin-mobile" class="reverse">

        <div class="mimin-mobile-menu-list">

            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">

               <ul class="nav nav-list">

                    <li class="ripple">

                     <a href="adviser_home.php"><i class="glyphicon glyphicon-home"></i> Home</a>

                    </li>

                     <li class="ripple">

                       <a href="adviser_company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Information</a>

                    </li>

                     <li class="ripple">

                      <a href="adviser_section_handled.php"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;My Students</a>

                    </li>

                     <li class="ripple">

                      <a href="adviser_company_remarks.php"><i class="glyphicon glyphicon-envelope"></i> Company Comments</a>

                    </li>

                    <li class="ripple">

                       <a href="pending_student_list.php"><i class="fa fa-list"></i>Pending Students</a>

                    </li>

                </ul>

            </div>

        </div>       

      </div>

      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle"  style="background-color:#0d47a1;">

        <span class="fa fa-bars" style="color:yellow;"></span>

      </button>

       <!-- end: Mobile -->



<!-- start: Javascript -->

<script src="asset/js/jquery.min.js"></script>

<script src="asset/js/jquery.ui.min.js"></script>

<script src="asset/js/bootstrap.min.js"></script>

>

<!-- plugins -->

<script src="asset/js/plugins/moment.min.js"></script>

<script src="asset/js/plugins/jquery.datatables.min.js"></script>

<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>

<script src="asset/js/plugins/jquery.nicescroll.js"></script>



<script src="asset/js/plugins/jquery.knob.js"></script>

<script src="asset/js/plugins/ion.rangeSlider.min.js"></script>



<script src="asset/js/plugins/jquery.nicescroll.js"></script>

<script src="asset/js/plugins/jquery.mask.min.js"></script>

<script src="asset/js/plugins/select2.full.min.js"></script>

<script src="asset/js/plugins/nouislider.min.js"></script>

<script src="asset/js/plugins/jquery.validate.min.js"></script>



<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>

<script type="text/javascript" src="asset/js/moment.min.js"></script>

<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>

<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>

<script type="text/javascript" src="asset/js/bootstrap-datetimepicker.min.js"></script>

<!-- custom -->

<script src="asset/js/main.js"></script>

<script type="text/javascript">

  $(document).ready(function(){

  var table = $('#datatables').DataTable();

$('#defaultForm')

    .find('[name="hour_start"]')

        .submit(function(e) {

            $('#defaultForm').bootstrapValidator('revalidateField', 'hour_start');

        })

        .end()

    .find('[name="hour_end"]')

        .submit(function(e) {

            $('#defaultForm').bootstrapValidator('revalidateField', 'hour_end');

        })

        .end()

    .bootstrapValidator({

            message: 'This value is not valid',

            feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid:'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            },

            excluded: ':disabled',

            fields: {

              day: {

                    message: 'Day is not valid',

                    validators: {

                        notEmpty: {

                            message: 'Day is required and can\'t be empty'

                        }

                      }

                    },

                    

                hour_start: {

                    message: 'Hour start is not valid',

                    validators: {

                        notEmpty: {

                            message: 'Hour start is required and can\'t be empty'

                        },

                       between:{             

                        min:7,

                        max: 'hour_end',

                        message: 'Invalid end of time'

                        },

                     callback: {

                        message: 'start time and end time must not be the same',

                        callback: function(value, validator, $field) {

                            var startTime = validator.getFieldElements('hour_start').val();

                            var endTime = validator.getFieldElements('hour_end').val();

                            if (endTime === '') {

                                return true;

                            }

                            if(endTime == startTime) {

                                // The start time is also valid

                                // So, we need to update its status

                                validator.updateStatus('hour_start', validator.STATUS_VALID, 'callback');

                                return false;

                            }

                           

                            else{

                                return true;



                            }

                        }

                    }



                  }                

                },

                hour_end: {

                    message: 'Hour end is not valid',

                    validators: {

                        notEmpty: {

                            message: 'Hour end is required and can\'t be empty'

                        },

                      between:{             

                        min:'hour_start',

                        max: 'hour_end',

                        message: 'Invalid end of time'

                        },

                        callback: {

                        message: 'start time and end time must not be the same',

                        callback: function(value, validator, $field) {

                            var startTime = validator.getFieldElements('hour_start').val();

                            var endTime = validator.getFieldElements('hour_end').val();

                            if (endTime === '') {

                                return true;

                            }

                            if(endTime == startTime) {

                                // The start time is also valid

                                // So, we need to update its status

                                validator.updateStatus('hour_end', validator.STATUS_VALID, 'callback');

                                return false;

                            }

                            else{

                                return true;



                            }

                        }

                    }

                      }                        

                    }

                

            }

        }).on('success.field.fv', function(e, data) {

            if (data.field === 'hour_start' && !data.fv.isValidField('hour_end')) {

                // We need to revalidate the end date

                data.fv.revalidateField('date_expiry');

            }



            if (data.field === 'hour_end' && !data.fv.isValidField('hour_start')) {

                // We need to revalidate the start date

                data.fv.revalidateField('hour_start');

            }

        });

       

  });



</script>

<!-- end: Javascript -->



</body>

</html>