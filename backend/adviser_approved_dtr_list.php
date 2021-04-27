<?php
$page_title = 'OJT-assiSTI';
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
 if((isset($_GET['acad_year_start_rd'])) && (isset($_GET['semester_rd'])) && (isset($_GET['stud_no_records'])) ) {
  
  $acad_year_start_rd=$_GET['acad_year_start_rd'];
  $semester_rd=$_GET['semester_rd'];
  $stud_no_records=$_GET['stud_no_records'];
  
 $query_empdtr ="SELECT dtr_id FROM dtr WHERE stud_no = '$stud_no_records' AND semester = '$semester_rd' AND acad_year_start = '$acad_year_start_rd'";
 $result_empdtr = mysqli_query($dbc,$query_empdtr);
  $num_rows_dtr = mysqli_num_rows($result_empdtr);
   if($result_empdtr->num_rows >0)
       {
        while($row = mysqli_fetch_array($result_empdtr))
        {
          $dtr_id = $row[0];
        }
      }
if($num_rows_dtr != 0)
{
  $query_stud_info_cl ="SELECT a.stud_no,a.lname,a.fname,a.mname,b.acad_year_start,b.acad_year_end, b.semester,c.category_description,b.section_id,b.category_id,a.program_id,e.program_code FROM student_info AS a INNER JOIN student_ojt_records as b INNER JOIN program_category_list AS c INNER JOIN dtr AS d INNER JOIN program_list AS e WHERE  a.program_id = e.program_id AND a.stud_no = b.stud_no and b.acad_year_start ='$acad_year_start_rd' AND b.semester = '$semester_rd' AND b.stud_no = '$stud_no_records' AND c.category_id = b.category_id";
                 
  $result_stud_info_cl =  mysqli_query($dbc, $query_stud_info_cl);         
          if($result_stud_info_cl->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_stud_info_cl))
              {             
                            $stud_no2 = $row[0];
                            $lname = $row[1];
                            $fname = $row[2];
                            $mname = $row[3];
                            $b_acad_year_start = $row[4];
                            $b_acad_year_end = $row[5];
                            $b_semester = $row[6];
                            $category_desc = $row[7];
                            $section_id = $row[8];
                            $category_id = $row[9];
                            $program_id = $row[10];
                            $program_code = $row[11];
              }
           }
           $nts = "";
}else{
  $query_stud_info_cl ="SELECT a.stud_no,a.lname,a.fname,a.mname,b.acad_year_start,b.acad_year_end, b.semester,c.category_description,b.section_id,b.category_id,a.program_id,e.program_code FROM student_info AS a INNER JOIN student_ojt_records as b INNER JOIN program_category_list AS c INNER JOIN program_list AS e WHERE  a.program_id = e.program_id AND a.stud_no = b.stud_no and b.acad_year_start ='$acad_year_start_rd' AND b.semester = '$semester_rd' AND b.stud_no = '$stud_no_records' AND c.category_id = b.category_id";
                 
  $result_stud_info_cl =  mysqli_query($dbc, $query_stud_info_cl);         
          if($result_stud_info_cl->num_rows > 0 )
            {   
              while ($row = mysqli_fetch_array($result_stud_info_cl))
              {             
                            $stud_no2 = $row[0];
                            $lname = $row[1];
                            $fname = $row[2];
                            $mname = $row[3];
                            $b_acad_year_start = $row[4];
                            $b_acad_year_end = $row[5];
                            $b_semester = $row[6];
                            $category_desc = $row[7];
                            $section_id = $row[8];
                            $category_id = $row[9];
                            $program_id = $row[10];
                            $program_code = $row[11];
              }
           }
           $nts = "No DTR Entry!";
  }
$query_stud_app_dtr ="SELECT SUM(a.input_minutes) AS input_minutes,a.remarks FROM dtr AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no = b.stud_no AND a.semester = b.semester AND a.acad_year_start AND b.acad_year_start AND a.stud_no = '$stud_no_records' AND a.semester = '$semester_rd' AND a.acad_year_start = '$acad_year_start_rd' AND a.remarks = 'Approved'";
                 
  $result_stud_app_dtr =  mysqli_query($dbc, $query_stud_app_dtr);         
          if($result_stud_app_dtr->num_rows > 0 )
            {   
              while ($row2 = mysqli_fetch_array($result_stud_app_dtr))
              {             
                            $total_approved_hours = intval($row2[0]/60);
                            $total_approved_mins = intval($row2[0]%60);
              }
           }
           if($total_approved_hours==0){
              $F_total_approve = $total_approved_hours. " hours";
           }else{
              $F_total_approve = $total_approved_hours. " hours and ". $total_approved_mins. " mins";
           }
           //end of approve hours
$query_stud_pen_dtr ="SELECT SUM(a.input_minutes) AS input_minutes,a.remarks FROM dtr AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no = b.stud_no AND a.semester = b.semester AND a.acad_year_start AND b.acad_year_start AND a.stud_no = '$stud_no_records' AND a.semester = '$semester_rd' AND a.acad_year_start = '$acad_year_start_rd' AND a.remarks = 'Pending'";
                 
  $result_stud_pen_dtr =  mysqli_query($dbc, $query_stud_pen_dtr);         
          if($result_stud_app_dtr->num_rows > 0 )
            {   
              while ($row2 = mysqli_fetch_array($result_stud_pen_dtr))
              {             
                            $total_pending_hours = intval($row2[0]/60);
                            $total_pending_mins =  intval($row2[0]%60);
              }
           }
           if($total_pending_mins==0){
              $F_total_pending = $total_pending_hours. " hours";
           }else{
              $F_total_pending = $total_pending_hours. " hours and ". $total_pending_mins. " mins";
           }
           //end of pending hours
$query_total_dtr ="SELECT ojt_hours FROM program_category_list WHERE program_id = '$program_id' AND category_id = '$category_id'";
                 
  $result_total_dtr =  mysqli_query($dbc, $query_total_dtr);         
          if($result_total_dtr->num_rows > 0 )
            {   
              while ($row3 = mysqli_fetch_array($result_total_dtr))
              {             
                            $total_hours = $row3[0];
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OJT-assiSTI</title>
<!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker.css"/>
  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/red.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>
  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
   <link rel="stylesheet" type="text/css" href="asset/css/sweetalert.css"/>
  <link href="asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->
  <link rel="shortcut icon" href="asset/img/ojtassistilogo.png">
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
                <a href="home.php" class="navbar-brand"> 
                 <b>OJT-assiSTI</b>
                </a>
              <ul class="nav navbar-nav navbar-right user-nav">
               <?php
			   $s_id="SELECT id FROM conversations WHERE parent='$username' OR child='$username'";
				$r_id=mysqli_query($dbc, $s_id);
				if(mysqli_num_rows($r_id)>0)
				{	
					$count_conv=0;
					while($row_id = mysqli_fetch_assoc($r_id))
					{
						$idd = $row_id['id'];
						$s_conv="SELECT COUNT(conv_id) AS count FROM conversations_data WHERE id='$idd' AND sender!='$username' AND read_status='unread'";
						$r_conv=mysqli_query($dbc, $s_conv);
						if(mysqli_num_rows($r_conv)>0)
						{
							$row_conv = mysqli_fetch_assoc($r_conv);
							$count_conv += $row_conv['count'];	
						}
					}
				}
				else
				{
					$count_conv='0';
				}
               print '<li class="dropdown avatar-dropdown">
                              <br>
                               
                               <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" 
                                style="padding:1px 1px 1px 1px;">
                                    <i class="glyphicon glyphicon-envelope" style="color:white;font-size:17px;"></i>
                                    <label style="font-size:15px;padding:2px 5px 2px 5px;" class="badge badge-danger"> '.$count_conv.'</label></span>
                               <ul class="dropdown-menu user-dropdown">
							   <div style="background-color:#f5f5f0;border-radius:5px;margin-top:2px;">
                                      <li>
                                        <a href="adviser_chat.php">
                                              <div style="font-size:14px;margin-left:2px;margin-right:2px;margin-top:2px; margin-bottom:2px;"><label class="text-primary"> '.$count_conv.' </label> message(s).
                                              </div>
                                      </a>
                                      </li>
                                        </div>
                       </ul></li>';?>
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
                        <label class="active">
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
                        <h1 class="animated fadeInLeft">APPROVE DAILY TIME RECORD</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                            This section will show the approve daily time record of the student.
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <div class="row">
                      <div class="col-md-9">
                        <h3><label style="color:black;"><?php echo $lname.", ".$fname." ".$mname."."." - ".$category_desc; ?></label></h3>
                      </div>
                        <div class="col-md-3" style="padding-top:10px;padding-left:5px;padding-right:30px;">
                          <label style="color:black;" class="pull-right">School Year : <?php echo $b_acad_year_start." - ".$b_acad_year_end; ?><br>
                              Semester : <?php echo $semester_rd; ?></label>
                        </div>
                      </div>
                    </div>
          <br>
                
                      <?php
                       $query_dtr ="SELECT a.stud_no,a.category_id,SUM(a.input_minutes) AS input_minutes,DATE_FORMAT(a.date_submitted, '%m/%d/%Y'),a.remarks,a.acad_year_start,a.acad_year_end,a.semester,a.dtr_id,b.ojt_hours,c.comp_name FROM dtr AS a INNER JOIN program_category_list AS b INNER JOIN company_info AS c WHERE a.comp_id = c.comp_id AND a.category_id = b.category_id AND a.stud_no = '$stud_no_records' AND a.acad_year_start = '$b_acad_year_start' AND a.semester = '$b_semester' AND a.remarks = 'Approved' group by a.dtr_id,a.date_submitted";
                       $result_dtr =  mysqli_query($dbc, $query_dtr);
                        $num_rows = mysqli_num_rows($result_dtr);
            print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="width:20px;"></th>
                          <th class="text-center col-md-2">HOURS</th>
                          <th class="text-center">DATE SUBMITTED</th>
                          <th class="text-center">COMPANY NAME</th>
                          <th class="text-center">REMARKS</th>
                        </tr>
                      </thead>
                      <tbody>';
                        while($row = mysqli_fetch_array($result_dtr)) {
                        
                          $color = ($row['remarks'] == 'Approved' ? $color  = "#ebebe0" : '');
                          $font = ($row['remarks'] == 'Approved' ? $font  = "#6b6b47" : '');
                           $stud_no_dtr = $row[0];
                           $category_id = $row[1];
                           $input_hours =$row[2];
                           $date_submitted =$row[3];
                           $remarks =$row[4];
                           $acad_year_start =$row[5];
                           $acad_year_end = $row[6];
                           $semester = $row[7];
                           $dtr_id = $row[8];
                           $ojt_hours = $row[9];
                           $dtr_comp_name = $row[10];
                           $F_ojt_hours = intval($input_hours /60);
                           $F_ojt_mins = intval($input_hours %60);
                           if($F_ojt_mins==0){
                            $FF_ojt = $F_ojt_hours. " hour(s)";
                           }else{
                              $FF_ojt = $F_ojt_hours. " hours(s)". " and ". $F_ojt_mins. " minute(s)";
                           }
                      ?>
                      <tr style="<?php print 'background-color:' . $color . ';'; print 'color:' . $font; ?>" id="<?php echo $dtr_id; ?>">
                          <?php
                            if($remarks == 'Approved')
                              print '<td>
                                  <div class="form-group form-animate-checkbox">
                                   <span class="icons icon-check-square-o"></span>
                                  </div> 
                                </td>';
                              else{
                                print '<td>
                                  <div class="form-group form-animate-checkbox">
                                   <input name="checkbox[]" class="checkbox" type="checkbox" value='.$dtr_id.'>
                                  </div> 
                                </td>  ';
                              }
                            ?>    
                                <td class="text-center"><?php echo $FF_ojt; ?></td>
                                <td class="text-center"><?php echo $date_submitted; ?></td>
                                <td class="text-center"><?php echo $remarks; ?></td>
                                <td class="text-center"><?php echo $dtr_comp_name; ?></td>
                      </tr>
                      <?php 
                     }
                    print '</tbody>
                     </table>
                     </div>
                     </div>';
                     ?> 
                      <div class="col-md-12">
                     <h3 class="text-center"><?php  echo $nts; ?></h3>
                     </div>
                     <br>
                         <div class="row" style="padding-bottom:20px;padding-right:10px;padding-left:10px;">
                            <div class="col-md-8"></div>
                             <div class="col-md-4">
                               <a href="dtr.php?acad_year_start_rd=<?php echo $acad_year_start_rd; ?>&semester_rd=<?php echo $semester_rd; ?>&stud_no_records=<?php echo $stud_no_records; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                               </div>
                          </div>
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
<script src="asset/js/bootstrap-datepicker.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script src="asset/js/run_prettify.js"></script>
<script src="asset/js/jquery.confirm.mins.js"></script>
<script src="asset/js/jquery.confirm.js"></script>
<script src="asset/js/sweetalert-dev.js"></script>
<script type="text/javascript">
 
  $(document).ready(function(){
  var table = $('#datatables').DataTable();
 var buttons = new $.fn.dataTable.Buttons(table, {
     buttons: [
            {
                extend: 'excelHtml5',
                title: 'Student Checklist',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'print',
                title: 'Student Checklist',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
        ]
    }).container().appendTo($('#buttons'));  
  });
  $('#btn_approved').click(function(){ 
    var dtr_id = []; 
    
                $(':checkbox:checked').each(function(i){  
                     dtr_id[i] = $(this).val();
                }); 
  $.confirm({
        text: "Are you sure you want to approve DTR?",
        confirm: function(button) { 
                if(dtr_id.length === 0) //tell you if the array is empty  
                {  
                    sweetAlert("Oops...", "Please Select atleast one in checkbox to approve DTR!", "error"); 
                }  
                else  
                {  
                     $.ajax({  
                          url:'approved_dtr_process.php',  
                          method:'POST',  
                          data:{dtr_id:dtr_id},  
                          success:function()  
                          {  
                               for(var i=0; i<dtr_id.length; i++)  
                               {  
                                    $('tr#'+dtr_id[i]+'').css('background-color', '#ccc');  
                                    $('tr#'+dtr_id[i]+'').fadeOut('slow');
                               }  
                          }  
                     });  
                }
            }, 
        });     
    });
    $('#btn_reject').click(function(){ 
    var dtr_id = []; 
    
                $(':checkbox:checked').each(function(i){  
                     dtr_id[i] = $(this).val();
                }); 
  $.confirm({
        text: "Are you sure you want to delete DTR and journal entry/entries?",
        confirm: function(button) { 
                if(dtr_id.length === 0) //tell you if the array is empty  
                {  
                    sweetAlert("Oops...", "Please Select atleast one in checkbox to delete DTR!", "error"); 
                }  
                else  
                {  
                     $.ajax({  
                          url:'reject_dtr_process.php',  
                          method:'POST',  
                          data:{dtr_id:dtr_id},  
                          success:function()  
                          {  
                               for(var i=0; i<dtr_id.length; i++)  
                               {  
                                    $('tr#'+dtr_id[i]+'').css('background-color', '#ccc');  
                                    $('tr#'+dtr_id[i]+'').fadeOut('slow');
                               }  
                          }  
                     });  
                }
            }, 
        });     
    }); 
      $(document).ajaxStop(function() {
          setTimeout("window.location='dtr.php?acad_year_start_rd=<?php echo $acad_year_start ?>&semester_rd=<?php echo $semester; ?>&stud_no_records=<?php echo $stud_no_records; ?>'",100);
       });  
</script>
<!-- end: Javascript -->
</body>
</html>