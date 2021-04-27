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
 if((isset($_GET['acad_year_start_rd'])) && (isset($_GET['semester_rd'])) && (isset($_GET['stud_no_records'])) ) {
  
  $acad_year_start_rd=$_GET['acad_year_start_rd'];
  $semester_rd=$_GET['semester_rd'];
  $stud_no_records=$_GET['stud_no_records'];
  
$query_emp_journal ="SELECT  date_submitted FROM journal  WHERE stud_no = '$stud_no_records' AND semester = '$semester_rd' AND acad_year_start = '$acad_year_start_rd'";
 $result_emp_journal = mysqli_query($dbc,$query_emp_journal);
  $num_rows_journal = mysqli_num_rows($result_emp_journal);
   if($result_emp_journal->num_rows >0)
       {
        while($row_emp_journal = mysqli_fetch_array($result_emp_journal))
        {
          $date_submitted_emp = $row_emp_journal[0];
        }
      }
   if($num_rows_journal != 0)
    {
      $query_stud_info_cl ="SELECT a.stud_no,a.lname,a.fname,a.mname,b.acad_year_start,b.acad_year_end,b.semester,c.category_description,b.section_id,a.program_id,e.program_code FROM student_info AS a INNER JOIN student_ojt_records as b INNER JOIN program_category_list AS c INNER JOIN dtr AS d INNER JOIN program_list AS e WHERE a.stud_no = b.stud_no and b.acad_year_start ='$acad_year_start_rd' AND b.semester = '$semester_rd' AND b.stud_no = '$stud_no_records' AND c.category_id = b.category_id";
                     
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
                    $program_id = $row[9];
                    $program_code = $row[10];
                  }
               }
            $nts = "";
      }else{
        $query_stud_info_cl ="SELECT a.stud_no,a.lname,a.fname,a.mname,b.acad_year_start,b.acad_year_end,b.semester,c.category_description,b.section_id,a.program_id,e.program_code FROM student_info AS a INNER JOIN student_ojt_records as b INNER JOIN program_category_list AS c INNER JOIN program_list AS e WHERE a.stud_no = b.stud_no and b.acad_year_start ='$acad_year_start_rd' AND b.semester = '$semester_rd' AND b.stud_no = '$stud_no_records' AND c.category_id = b.category_id";
                     
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
                    $program_id = $row[9];
                    $program_code = $row[10];
                  }
               }
          $nts = "No Journal Entry!";
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
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker.css"/>
  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />
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
                       </ul></li>';
					   ?>
                <li class="dropdown avatar-dropdown">
                <br>     
                    <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:7px 10px 7px 10px">
                    <i class="fa fa-building-o" style="color:white;font-size:17px;"></i><label class="badge badge-danger" style="font-size:15px;padding:1px 10px 3px 10px;"><?php echo $unread_msg ;?></label>
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
                        <h1 class="animated fadeInLeft">JOURNAL</h1>
                        <p class="animated fadeInDown">
                            View and manage journals submitted by the selected student.
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
                        <h3><label style="color:black;"><?php echo $lname." , ".$fname." ".$mname."."." - ".$category_desc; ?></label></h3>
                      </div>
                        <div class="col-md-3" style="padding-top:10px;padding-left:5px;padding-right:30px;">
                          <label style="color:black;" class="pull-right">School Year : <?php echo $b_acad_year_start." - ".$b_acad_year_end; ?><br>
                              Semester : <?php echo $semester_rd; ?></label>
                        </div>
                      </div>
                    </div>
                            
                      <?php
                       $query_journal ="SELECT stud_no,journal_entry,DATE_FORMAT(date_submitted, '%m/%d/%Y') AS date_submitted,skills_and_knowledge_used,type,semester,acad_year_start,acad_year_end FROM journal  WHERE stud_no = '$stud_no_records' AND acad_year_start = '$b_acad_year_start' AND semester = '$b_semester'"; 
                       $result_journal =  mysqli_query($dbc, $query_journal);
                        $num_rows = mysqli_num_rows($result_journal);
            print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                         <th class="text-center col-md-2">TYPE</th>
                          <th class="text-center">DATE SUBMITTED</th>
                          <th class="text-center" style="width:100px;">ACTION</th>            
                        </tr>
                      </thead>
                      <tbody>';
                        while($row = mysqli_fetch_array($result_journal)) {
                        
                        $color = ($row['type'] == 'Weekly' ? $color  = "#ebebe0" : '');
                          $font = ($row['type'] == 'Weekly' ? $font  = "#6b6b47" : '');
                           $stud_no = $row[0];
                           $journal_entry = $row[1];
                           $date_submitted =$row[2];
                           $skills_and_knowledge_used =$row[3];
                           $type =$row[4];
                           $semester =$row[5];
                           $acad_year_start = $row[6];
                           $acad_year_end = $row[7];
                      ?>
                      <tr style="<?php print 'background-color:' . $color . ';'; print 'color:' . $font; ?>" id="<?php echo $dtr_id; ?>">
                                <td><?php echo $type; ?></td>
                                <td><?php echo $date_submitted; ?></td>
                                 <td>
                                  <a href="view_journal.php?acad_year_start=<?php echo $acad_year_start; ?>&semester=<?php echo $semester; ?>&stud_no=<?php echo $stud_no; ?>&date_submitted=<?php echo $date_submitted; ?>">
                                  <button type="submit" class=" btn btn-outline btn-primary btn-block btn-sm">
                                  <span class="fa fa-eye"></span> &nbsp;&nbsp; View &nbsp; &nbsp;</button>
                                  </a>
                              </td>
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
                               <a href=" adviser_student_information.php?semester=<?php echo $semester_rd; ?>&acad_year_start=<?php echo $acad_year_start_rd; ?>&acad_year_end=<?php echo $b_acad_year_end; ?>&program_code=<?php echo $program_code; ?>&program_id=<?php echo $program_id; ?>&section_id=<?php echo $section_id; ?>"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
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
           if(confirm("Are you sure you want to approved?"))  
           {  
                var dtr_id = [];  
                $(':checkbox:checked').each(function(i){  
                     dtr_id[i] = $(this).val();
                });  
                if(dtr_id.length == 0) //tell you if the array is empty  
                {  
                     alert("Please Select atleast one checkbox");  
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
                                    $('tr#'+dtr_id[i]+'').fadeIn('slow');
                               }  
                          }  
                     });  
                }  
           }  
           else  
           {  
                return false;  
           }  
      }); 
      $(document).ajaxStop(function() {
          setTimeout("window.location='dtr.php?acad_year_start_rd=<?php echo $acad_year_start ?>&semester_rd=<?php echo $semester; ?>&stud_no_records=<?php echo $stud_no_records; ?>'",100);
       });   
</script>
<!-- end: Javascript -->
</body>
</html>