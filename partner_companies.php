<!DOCTYPE html>
<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//student number static for debugging purposes
if(!isset($_COOKIE["sid"])) {
	header ("Location: login.php");
	exit;
}
$stud_no=$_COOKIE['sid'];
//get student info
$q_studinfo ="select * from student_info where stud_no='$stud_no'";
$q_studinfo_res = $dbc->query($q_studinfo);
$studinfo = $q_studinfo_res->fetch_assoc();
$studname= $studinfo['fname']. ' ' .$studinfo['lname'];
//get student course
$stud_program_id = $studinfo['program_id'];
$q_course = "select * from program_list where program_id='$stud_program_id'";
$q_course_res = $dbc->query($q_course);
$course = $q_course_res->fetch_assoc();
$stud_course = $course['program_code'];

//get student's enrollment status
$q_stud_enrollment_status = "select * from student_ojt_records where stud_no='$stud_no' and ojt_status='Ongoing'";
$q_stud_enrollment_status_res = $dbc->query($q_stud_enrollment_status);
$stud_enrollment_status = $q_stud_enrollment_status_res->fetch_assoc();
$enrollment_status = $stud_enrollment_status['enrollment_status'];

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>OJT-assiSTI</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link rel="icon" href="assets/img/icon.png">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	    <!--mimin table css-->
	 <link rel="stylesheet" type="text/css" href="asset/css/buttons.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="asset/css/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
body {
font: normal 13px arial,sans-serif;
}
.tutorial_list{ 
margin-bottom:20px;
}
/*list item Panel */
.list_item {
	text-align: left;
	
	
}

.list_item p {
	margin-top: 5px;
	font-weight: 700;
	margin-left: 15px;
}
.list_item .whiteheader{
	background: #f4f4f4;
	padding: 3px;
	margin-bottom: 5px;
	color: #c6c6c6;
}
.list_item .small{
	font-size: 10px;
	color: #ccd1d9;
}

.list_item i {
	color: #68dff0;
	padding-right: 4px;
	font-size: 14px;
}
.show_more_main {
margin: 15px 25px;
}
.show_more {
background-color: #f8f8f8;
background-image: -webkit-linear-gradient(top,#fcfcfc 0,#f8f8f8 100%);
background-image: linear-gradient(top,#fcfcfc 0,#f8f8f8 100%);
border: 1px solid;
border-color: #d3d3d3;
color: #333;
font-size: 12px;
outline: 0;
}
.show_more {
cursor: pointer;
display: block;
padding: 10px 0;
text-align: center;
font-weight:bold;
}
.loding {
background-color: #e9e9e9;
border: 1px solid;
border-color: #c6c6c6;
color: #333;
font-size: 12px;
display: block;
text-align: center;
padding: 10px 0;
outline: 0;
font-weight:bold;
}
.loding_txt {
background-image: url(loading_16.gif);
background-position: left;
background-repeat: no-repeat;
border: 0;
display: inline-block;
height: 16px;
padding-left: 20px;
}
  </style>
    <script src="assets/js/loadmore.js"></script>	
	<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','.show_more',function(){
			var ID = $(this).attr('id');
			var srch = document.getElementById("search_query").value;
			$('.show_more').hide();
			$('.loding').show();
			$.ajax({
				type:'POST',
				url:'ajax_more.php',
				data:'comp_id='+ID+'&comp_search='+srch,
				success:function(html){
					$('#show_more_main'+ID).remove();
					$('.tutorial_list').append(html);
				}
			});
			
		});
	});
	</script>
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div style="color:#ffffff;" class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="home.php" class="logo" style="font-size:25px"><b>OJT-assiSTI</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
               
            </div>
           
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	   <p class="centered"><img src=<?php echo "../files/student_pics/".$stud_no.".jpg"; ?> class="img-circle" style="height:100px;width:100px;"></p>
              	  <h5 class="centered"><?php echo $studname; ?></h5>
				  <h6 class="centered" style="color:#ffffff"><?php echo $stud_course; ?></h6>
              	  	
                  <li class="mt">
                      <a href="home.php">
                          <i class="fa fa-home"></i>
                          <span>Home</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="my_account.php">
                          <i class="fa fa-user"></i>
                          <span>My Account</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="announcements.php">
                          <i class="fa fa-bullhorn"></i>
                          <span>Announcements</span>
                      </a>
                  </li>
				    <li class="sub-menu">
                      <a href="about_us.php">
                          <i class="glyphicon glyphicon-question-sign"></i>
                          <span>About us</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="logout.php">
                          <i class="fa fa-gear"></i>
                          <span>Logout</span>
                      </a>
                  </li>

              </ul>
			  
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
			
					
						<div style="padding-top:20px"  class="">
					
						<div class="col-lg-12 col-md-12 col-sm-12 mb">
						  <div class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-12 col-xs-12">
											<p style="font-size:25px;padding-top:7px;">PARTNER COMPANIES</p>
										</div>
										
									</div>
							</div><br>
							</div>
							<span style="font-size:17px;">Companies with current partnership with STI are shown here.</span></br>
							<span style="font-size:17px;">Click on the company to view more information.</span></br><br>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
							<div class="col-md-3 mb">
								<input type="text" class="form-control" name="comp_search">
							</div>	
							<button style="" type="submit" name="btnsearch" class="btn btn-default goright">SEARCH</button>
							</form>
							
					</div>

						<div class="col-md-8 mb">
						<div class="tutorial_list">
						<?php
							$comp_search="";
						//get rows query
						if(isset($_POST["btnsearch"])){
							$comp_search=$_POST['comp_search'];
							$query = mysqli_query($dbc, "SELECT * FROM company_info where status='Active' and (comp_name LIKE '%$comp_search%' OR comp_desc LIKE '%$comp_search%') ORDER BY 1 DESC LIMIT 10");
							$queryAll = mysqli_query($dbc,"SELECT COUNT(*) as num_rows FROM company_info WHERE status='Active' and (comp_name LIKE '%$comp_search%' OR comp_desc LIKE '%$comp_search%') ORDER BY comp_id DESC");
							$roww = mysqli_fetch_assoc($queryAll);
							$allRows = $roww['num_rows'];
						}else{
							$query = mysqli_query($dbc, "SELECT * FROM company_info where status='Active' ORDER BY 1 DESC LIMIT 10");
							$queryAll = mysqli_query($dbc,"SELECT COUNT(*) as num_rows FROM company_info where status='Active' ORDER BY comp_id DESC");
							$roww = mysqli_fetch_assoc($queryAll);
							$allRows = $roww['num_rows'];
						}
						//get rows query
					
						
						//number of rows
						$rowCount = mysqli_num_rows($query);
						$showLimit = 10;
						if($rowCount > 0){ 
							while($row = mysqli_fetch_assoc($query)){ 
								$comp_id = 	$row['comp_id'];
								
						?>
							<input type="hidden" id="search_query" value=<?php echo $comp_search; ?>>
							<a href="company_info.php?comp_id=<?php echo $comp_id; ?>">
							<div style="padding-left:20px;padding-top:10px"  class="list_item pn-offer">
							
							<span style="font-size:17px;"><?php echo $row['comp_name']; ?></span>
							<img class="" style="float:right;padding-right:10px;padding-top:5px;padding-bottom:5px" src=<?php echo "../files/company/".$comp_id.".jpg"; ?> width="50" height="50">
							</div>
							</a>
							
						<?php } if($allRows > $showLimit){ ?>
						<div class="show_more_main" id="show_more_main<?php echo $comp_id; ?>">
							<span id="<?php echo $comp_id; ?>" class="show_more" title="Load more posts">Show more</span>
							<span class="loding" style="display: none;"><span class="loding_txt">Loading…</span></span>
						</div>
						<?php }
						
						} else{
						echo '<span style="font-size:17px;">No results found for <b><i>'.$comp_search.'.</i></b></span>';
						}?>
						</div>
						</div>
						
			</div>
					
			
			
		</section><! --/wrapper -->
		
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
	<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
	<script src="asset/js/plugins/jquery.datatables.min.js"></script>
	<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
 

  </body>
</html>
