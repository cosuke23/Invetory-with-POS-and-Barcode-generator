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
	$query2 = "SELECT * from admin_info WHERE admin_id = '$username'";
	$result2 = mysqli_query($dbc,$query2);
		if(mysqli_num_rows($result2)>0)
		{
			$row2 = mysqli_fetch_assoc($result2);
			$fname2 = $row2["fname"];
		}
}
if($usertype!=1)
{
	header("Location: adviser_home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OJT assiSTI</title>
  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>
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
                <li class="user-name"><span>&nbsp;Hi' <?php echo $fname2 ; ?>&nbsp;</span></li>
                  <li class="dropdown avatar-dropdown">
                  <br>
                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="admin_account.php?username=<?php echo $username; ?>"><span class="fa fa-user"></span> My Account</a></li>
                      <li><a href=""><span class="fa fa-lock"></span> Lock Screen</a></li>
                      <li><a href="logout.php"><span class="fa fa-power-off "> Log Out</span></a></li> 
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
                    <div class="left-bg"></div>
                    <div  class="time">
                      <h1 class="animated fadeInLeft"></h1>
                      <p class="animated fadeInRight"></p>
                    </div>
                      <div class="nav-side-menu">
                        <label>
                          <a href="home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                        <label>
                          <a href="#"><i class="glyphicon glyphicon-briefcase"></i> OJT Offers</a>
                        </label><br>
                        <label>
                          <a href="Company_info.php"><i class="glyphicon glyphicon-globe"></i> Company Information</a>
                        </label><br>
                        <label>
                          <a href="OJT_adviser.php"><i class="glyphicon glyphicon-user"></i> OJT Adviser</a>
                        </label><br>
                        <label>
                          <a href="#"><i class="glyphicon glyphicon-object-align-bottom"></i> OJT Student list</a>
                        </label><br>
                        <label class="ripple">
                          <a class="tree-toggle nav-header"><i class="glyphicon glyphicon-info-sign"></i>Student Information
                            <span class="fa-angle-down fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list tree" style="height:150px;">
                              <label class="ripple"><a href ="Student_information.php" > &nbsp;  &nbsp; &nbsp; <span class="glyphicon glyphicon-home"></span> Student Information</a></label><br>
                               <label class="active ripple"><a href="OJT_checklist.php"> &nbsp;  &nbsp; &nbsp; <span class="glyphicon glyphicon-ok-sign"></span> OJT Checkist</a></label>
                          </ul>
                        </label><br>
                         <label>
                           <a href="Manage_course.php"><i class="glyphicon glyphicon-list-alt"></i>Manage Courses</a>
                         </label><br>
                         <label>
                          <a href="ojtsoftcopy.php"><i class=" glyphicon glyphicon-folder-open"></i> OJT Softcopy Files</a>
                         </label><br>
						 <label>
                          <a href="student_deliverables.php"><i class="glyphicon glyphicon-list-alt"></i> Student Deliverables</a>
						</label><br>
                          <label>
                          <a href="#"><i class="glyphicon glyphicon-envelope"></i> Remarks</a>
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
                        <h1 class="animated fadeInLeft">OJT Checklist.</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                          This section will show all the OJT checklist information of the students.
                        </p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>List of all OJT Checklist of the Student.</h3></div>
                      <div class="row" style="padding-top:10px;">
                          <div class="col-md-12">
                            <div class="col-md-2">    
                                  <a href="#">
                                        <button class="btn btn-danger btn-outline btn-sm btn-block">
                                           <span class="fa fa-trash"></span> &nbsp; DELETE &nbsp;
                                      </button>
                                  </a>     
                            </div>
                            <div class="col-md-6"></div>
                             <div class="col-md-4">
                             <div id="buttons" class="pull-right" style="padding-top:6px;"></div>
                            </div>
                          </div>
                        </div>
                   <?php
                    $query_checklist ="SELECT a.stud_no,a.deliverables_id,DATE_FORMAT(a.date_submitted, '%m/%d/%Y') AS date_submitted,a.remarks,b.deliverables_id,b.deliverables_name,b.authorization,c.lname,c.fname,c.mname FROM stud_checklist AS a INNER JOIN stud_deliverables AS b INNER JOIN student_info AS c where a.deliverables_id = b.deliverables_id group by a.deliverables_id,b.deliverables_id";
                       $result_checklist =  mysqli_query($dbc, $query_checklist);
                        $num_rows = mysqli_num_rows($result_checklist);
            print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables" class="display table table-striped table-bordered table-condensed" width="100%">
                      <thead>
                        <tr>
                         <th>#</th>
                          <th>Student Number</th>   
                          <th>Name</th>
                          <th>OJT Placement Activity</th>
                          <th>Date Submitted</th>
                          <th>Remarks</th>
                          <th style="width:20px;">Action</th>
                          <th style="width:20px;">Action</th>         
                        </tr>
                      </thead>
                      <tbody>';
                       while($row = mysqli_fetch_array($result_checklist)) {
               
                            $stud_no = $row[0];
                            $a_deliverables_id = $row[1];
                            $date_submitted = $row[2];
                            $a_remarks = $row[3];
                            $c_deliverables_id = $row[4];
                            $b_deliverables_name = $row[5];
                            $b_authorization = $row[6];
                            $lname = $row[7];
                            $fname = $row[8];
                            $mname = $row[9];   
                      ?>
                      <tr>      
                              <td>
                              <div class="form-group form-animate-checkbox">
                                 <input name="checkbox[]" class="checkbox" type="checkbox" value="<?php echo $row['$stud_no']; ?>"/>
                                </div>
                              </td> 
                              <td><?php echo $stud_no; ?></td> 
                              <td><?php echo $lname." , ".$fname." ".$mname."."; ?></td>
                              <td><?php echo $b_deliverables_name; ?></td>
                               <td><?php echo $date_submitted; ?></td>
                              <td><?php echo $a_remarks; ?></td>
                          
                              <td>
                                <a href="update_Student_information.php?stud_no=<?php echo $stud_no; ?>">
                                  <button type="submit" class=" btn btn-outline btn-primary btn-block btn-sm">
                                  <span class="glyphicon glyphicon-pencil"></span> &nbsp; Update</button>
                                </a>
                              </td>
                              <td>
                               <a href="view_Student_information.php?stud_no=<?php echo $stud_no; ?>">
                                  <button type="submit" class="btn btn-outline btn-warning btn-block btn-sm">
                                  <span class="glyphicon glyphicon-info-sign"></span> &nbsp;More &nbsp;</button>
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
                  </div>
                </div>
              </div>  
            </div><!-- end: content -->
     </div>
          
          
     
    <!-- end: content -->
      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
               <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="home.php"><i class="glyphicon glyphicon-home"></i>&nbsp;Home</a>
                    </li>
                    <li class="ripple">
                      <a href="#"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;OJT Offers</a>
                    </li>
                     <li class="active ripple">
                      <a href="Company_info.php"><i class="glyphicon glyphicon-globe"></i> &nbsp;Company Info</a>
                    </li>
                     <li class="ripple">
                      <a href="OJT_adviser.php"><i class="glyphicon glyphicon-user"></i>  &nbsp;OJT Adviser</a>
                    </li>
                     <li class="ripple">
                      <a href="#"><i class="glyphicon glyphicon-object-align-bottom"></i>  &nbsp;OJT Student list</a>
                    </li>
                     <li class="ripple">
                       <a href ="Student_information.php" class="tree-toggle nav-header"><i class="glyphicon glyphicon-info-sign"></i>Student Info
                            <span class="fa-angle-down fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list tree">
                               <label><a href="dashboard-v1.html"> &nbsp;  &nbsp; &nbsp; <span class="glyphicon glyphicon-ok-sign"></span> OJT Checkist</a></label>
                          </ul>
                    </li>
                     <li class="ripple">
                     <a href="Manage_course.php"><i class="glyphicon glyphicon-list-alt"></i> &nbsp;Manage Courses</a>
                    </li>
                     <li class="ripple">
                      <a href="ojtsoftcopy.php"><i class=" glyphicon glyphicon-folder-open"></i>&nbsp;OJT Softcopy Files
                      </a>
                    </li>
						<li>
                        <a href="student_deliverables.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Student Deliverables</a>
                    </li>
                    <li class="ripple">
                        <a href="#"><i class="glyphicon glyphicon-envelope"></i>&nbsp;Remarks</a>
                    </li>
                </ul>
            </div>
        </div>       
      </div>
      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
        <span class="fa fa-bars"></span>
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
  $(document).ready(function(){
  var table = $('#datatables').DataTable();
  var buttons = new $.fn.dataTable.Buttons(table, {
     buttons: [
            {
                extend: 'copyHtml5',
                title: 'Student Information',
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8,9,10]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Student Information',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Student Information',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10]
                }
            },
             {
                extend: 'csvHtml5',
                title: 'Student Information',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10]
                }
            },
            {
                extend: 'print',
                title: 'Student Information',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10]
                }
            },
        ]
    }).container().appendTo($('#buttons'));  
  });
</script>
<!-- end: Javascript -->
</body>
</html>