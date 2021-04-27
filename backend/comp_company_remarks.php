<?php

$page_title = 'OJT AssiSTI';



if(!isset($_COOKIE["cid"])) {

	header ("Location: company_login.php");

	exit;

}

$username = $_COOKIE["cid"];

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';

	



	$query2 = "SELECT * from company_info WHERE username = '$username'";

	$result2 = mysqli_query($dbc,$query2);

		if(mysqli_num_rows($result2)>0)

		{

			$row2 = mysqli_fetch_assoc($result2);

			$fname = $row2["comp_name"];

			$comp_id = $row2["comp_id"];

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

		<style>

		.img_hidden{display:none;}

		.img_show{display:block;}

	</style>

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

                <a href="company_home.php" class="navbar-brand"><b>OJT assiSTI</b>

                </a>

              <ul class="nav navbar-nav navbar-right user-nav">

                <li class="user-name"><span>&nbsp;<?php echo $fname ; ?>&nbsp;</span></li>

                  <li class="dropdown avatar-dropdown">

                  <br>

                   <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="fa fa-reorder" style="padding-right:10px;color:yellow;"/></span>

                   <ul class="dropdown-menu user-dropdown">

                     <li><a href="comp_change_pass.php?comp_id=<?php echo $comp_id;?>"><span class="fa fa-user"></span>&nbsp;Change password</a></li>

                      <li><a href="company_logout.php"><span class="fa fa-power-off ">&nbsp;Log Out</span></a></li> 

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

                      

                         <label class="active">

                          <a href="comp_company_remarks.php?comp_id=<?php echo $row2['comp_id']; ?>"><i class="glyphicon glyphicon-globe"></i>Company OJT Students</a>

                          </label><br>

						  <label>

                          <a href="sti_ojtofficer_contact.php"><i class="glyphicon glyphicon-user"></i>STI OJT Officer Contact</a>

                          </label><br>

						  <label>

                          <a href="comp_sent.php?comp_id=<?php echo $row2['comp_id']; ?>"><i class="glyphicon glyphicon-envelope"></i>Comment Sent</a>

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

                        <h1 class="animated fadeInLeft">COMPANY OJT STUDENT(S)</h1>

                        <p class="animated fadeInDown" style="padding-left:10px;">

                          This section will show all the student that are currently on going to company.

                        </p>

                    </div>

                </div>

              </div>

              <div class="col-md-12 padding-0">

                <div class="col-md-12">

                  <div class="panel">

                    <div class="panel-heading"><h3>List of all Students</h3></div>



                     <br>

                    <div class="row">

                      <div class="col-md-12">



                         <?php

                         if(isset($_GET['pass'])) 

                            {   

                            print '<div class="col-md-12">

                              <div class="alert alert-info alert-dismissible fade in" role="alert">

                                     <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                        <span aria-hidden="true">×</span></button>

                                    <strong>&nbsp;Password was Sucessfully Updated!</strong>

                               </div></div>';

                            }

                            else if(isset($_GET['send'])) 

                                {   

                                print '<div class="col-md-12">

                                  <div class="alert alert-primary alert-dismissible fade in" role="alert">

                                         <span class="fa fa-check-square-o"></span> &nbsp; | &nbsp;

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                            <span aria-hidden="true">×</span></button>

                                        <strong>&nbsp;Comments was Successfully Sent!</strong>

                                   </div></div>';

                                }

                          ?>

                      </div>

                      </div>



                      <div class="row" style="padding-top:10px;">

                          <div class="col-md-12">

                               <div class="col-md-8"> </div>

                             <div class="col-md-4">

                             <div id="buttons" class="pull-right" style="padding-top:6px;"></div>

                            </div>

                          </div>

                        </div>           

                      <?php

					  print '<div class="panel-body">

									  <div class="responsive-table">

									  <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">

									  <thead>

										<tr>

										 <th class="text-center">STUDENT NAME</th>

										  <th class="text-center">REMARKS DATE</th>

										  <th class="text-center">PROGRAM</th>

                      <th class="text-center">TOTAL OJT WORK HOURS</th>

                      <th class="text-center">TOTAL OJT HOURS</th>

										  <th class="text-center" style="width:100px;">Action</th>                 

										</tr>

									  </thead>

									  <tbody>';

									  

							$comp_id = $_GET['comp_id'];

						// get company info

							$q_compinfo = "select * from company_info where comp_id='$comp_id'";

							$q_compinfo_res = $dbc->query($q_compinfo);

							$comp_info = $q_compinfo_res->fetch_assoc();

							//--

							//get all stud_no that is currently on OJT in the company

							$q_OJTstud ="select * from company_ojt_student where comp_id='$comp_id' and status='Ongoing'";

							$q_OJTstud_res = $dbc->query($q_OJTstud);

							if($q_OJTstud_res->num_rows > 0){

							while($OJTstud = $q_OJTstud_res->fetch_assoc()){

								$stud_no = $OJTstud['stud_no'];

								$acad_year_start = $OJTstud['acad_year_start'];

                $semester = $OJTstud['semester'];

								//get student info 

								$q_studinfo = "select * from student_info where stud_no='$stud_no'";

								$q_studinfo_res = $dbc->query($q_studinfo);

								$studinfo = $q_studinfo_res->fetch_assoc();

								$stud_name= $studinfo['lname'].', '.$studinfo['fname'].' '.$studinfo['mname'];

								//get student program

								$stud_program_id= $studinfo['program_id'];

								$q_studprogram = "select * from program_list where program_id='$stud_program_id'";

								$q_studprogram_res=$dbc->query($q_studprogram);

								$studprogram = $q_studprogram_res->fetch_assoc();

                

                $q_stud_dtr = "select SUM(input_minutes) as total_dtr from dtr where stud_no='$stud_no' AND acad_year_start = '$acad_year_start' AND semester = '$semester'";

                $q_stud_dtr_res = $dbc->query($q_stud_dtr);

                $stud_dtr = $q_stud_dtr_res->fetch_assoc();

                $total_dtr = $stud_dtr['total_dtr'];  

                $total_dtr_hours = intval($total_dtr/60);

                $total_dtr_mins = intval($total_dtr%60);



                $q_stud_categ_id = "select category_id from student_ojt_records where stud_no='$stud_no' AND acad_year_start = '$acad_year_start' AND semester = '$semester'";

                $q_stud_categ_id_res = $dbc->query($q_stud_categ_id);

                $categ_id = $q_stud_categ_id_res->fetch_assoc();

                $category_id = $categ_id['category_id'];



                $q_stud_ojt_hours ="select ojt_hours from program_category_list where category_id = '$category_id'";

                $q_stud_ojt_hours_res = $dbc->query($q_stud_ojt_hours);

                $ojt_hours = $q_stud_ojt_hours_res->fetch_assoc();

                $total_ojt_hours = $ojt_hours['ojt_hours']. " Hours";





                if($total_dtr_mins == 0)

                {

                  $F_total_dtr =  $total_dtr_hours. " hours";

                }else{

                  $F_total_dtr =  $total_dtr_hours. " hours and ". $total_dtr_mins. "mins";

                }

                      ?>

                      <tr>       

                                <td><?php echo $stud_name; ?></td>

                                <td><?php echo $OJTstud['ojt_start_date']; ?></td> 

                                <td><?php echo $studprogram['program_code']; ?></td>

                                <td><?php echo $F_total_dtr;  ?></td>

                                 <td><?php echo $total_ojt_hours;  ?></td>

                              <td>

                                <a href="comp_send_remarks.php?studno=<?php echo $stud_no;?>&studname=<?php echo $stud_name;?>&ojt_start_date=<?php echo $OJTstud['ojt_start_date'];?>&studprogram=<?php echo $studprogram['program_code'];?>&comp_id=<?php echo $comp_id;?>">

                                  <button type="submit" class="btn btn-outline btn-success btn-block btn-sm">

                                  <span class="glyphicon glyphicon-send">&nbsp;Send Comments</button>

                                  </a>

                              </td> 

                      </tr>

                      <?php 

								

							

						

                     }

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

          

      <!-- start: Mobile -->

      <div id="mimin-mobile" class="reverse">

        <div class="mimin-mobile-menu-list">

            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">

              <ul class="nav nav-list">

                    <li class="ripple">

                     <a href="comp_company_remarks.php?comp_id=<?php echo $comp_id; ?>"><i class="glyphicon glyphicon-globe"></i> Company OJT Students</a>

                    </li>

                     <li class="ripple">

                       <a href="sti_ojtofficer_contact.php"><i class="glyphicon glyphicon-user"></i> STI OJT Officer Contact</a>

                    </li>

                     <li class="ripple">

                      <a href="comp_sent.php?comp_id=<?php echo $comp_id; ?>"><i class="glyphicon glyphicon-envelope"></i> Comment Sent</a>

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

});

</script>

<!-- end: Javascript -->



</body>

</html>