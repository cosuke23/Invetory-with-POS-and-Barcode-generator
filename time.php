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
$stud_program_id = $studinfo['course'];
if($stud_program_id==1){

	$stud_course='BSIT';
}else if($stud_program_id==2){

	$stud_course='BSHRM';
}else if($stud_program_id==3){

	$stud_course='BSHRM';
}else if($stud_program_id==4){

	$stud_course='BSHRM';
}else if($stud_program_id==5){

	$stud_course='BSAT';
}else if($stud_program_id==6){

	$stud_course='BSTM';
}else if($stud_program_id==7){

	$stud_course='BSTM';
}else if($stud_program_id==8){

	$stud_course='BSIT';
}else if($stud_program_id==9){

	$stud_course='BSIT';
}else if($stud_program_id==10){

	$stud_course='BSIT';
}else if($stud_program_id==11){

	$stud_course='BSIT';
}else if($stud_program_id==12){

	$stud_course='BSIT';
}else{
	$stud_course='NONE';
}

//get student course
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
//get total hours
	
//get total Approved hours
$date_now=date('Y-m-d');
$secs=date('h:i:s');
$sec=date('h:i:s',strtotime($secs.'+2 hours'));
$hourzx=strtotime($sec)-strtotime($secs );
$hourz=floor($hourzx / 60);
//$hourzs=floor($minz / 60);
					
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
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
          <section class="wrapper ">
		  
		   <div style="padding-top:20px"  class="">
				
						<div class="col-lg-12 col-md-12 col-sm-12">
						  <div class="weather-2">
							<div class="weather-2-header row">
									<div class="">
										<div class="col-sm-12 col-xs-12">
											<p style="font-size:25px;padding-top:7px;">DAILY TIME RECORD</p>
										</div>
									</div>
							</div><br>
							</div>
							
							<form action="time_in_process.php" method="POST" enctype="multipart/form-data">
							<div class="row">
								<input type="hidden" name="stud_no" value="<?php echo $stud_no;?>"/>
								<input type="hidden" name="acad_year_start" value="<?php echo $acad_year_start;?>"/>
								<input type="hidden" name="acad_year_end" value="<?php echo $acad_year_end;?>"/>
								<input type="hidden" name="semester" value="<?php echo $semester;?>"/>
								<input type="hidden" name="category_id" value="<?php echo $category_id;?>"/>
								
								<?php 
								if(isset($_GET['msg2']))
								{
									print'<div class="col-md-3">
									<h5 style="color:green;font-size:20px;padding:10px;" class="alert alert-success">DTR successfully recorded.</h5>
									</div>';
								}
								else if(isset($_GET['msg']))
								{
									$msg_show = '<div class="col-md-2">
									<h5 style="color:red;font-size:20px;padding:10px;" class="alert alert-danger">Invalid time</h5>
									</div>';
								}
								else
								{
									$msg_show = "";
								}
								?>							
							</div>
							<div class="row">
							<?php
							//--Unang time in--//
								if(isset($_GET['time']))
								{
									$stud_no = $_GET['stud_no'];
									$acad_year_start = $_GET['acad_year_start'];
									$acad_year_end = $_GET['acad_year_end'];
									$semester = $_GET['semester'];
									$category_id = $_GET['category_id'];
									$date_sub = $_GET['date_sub'];
									
									print '
									<div class="col-md-12">
									<h2>TIME IN:</h2>
									</div>
										'.$msg_show.'
										<div class="col-md-12"></div>
									<div>
										<input type="hidden" name="date_sub" value="'.$date_sub.'"/>
										<input type="hidden" name="stud_no" value="'.$stud_no.'"/>
										<input type="hidden" name="acad_year_start" value="'.$acad_year_start.'"/>
										<input type="hidden" name="acad_year_end" value="'.$acad_year_end.'"/>
										<input type="hidden" name="semester" value="'.$semester.'"/>
										<input type="hidden" name="category_id" value="'.$category_id.'"/>
									<div class="col-md-1">
									<h5>Hour(s):</h5>
									<select class="form-control" name="hour">
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
									</select>
									</div>
									<div class="col-md-1">
									<h5>Minute(s):</h5>
									<select class="form-control" name="minute">
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
										<option value="32">32</option>
										<option value="33">33</option>
										<option value="34">34</option>
										<option value="35">35</option>
										<option value="36">36</option>
										<option value="37">37</option>
										<option value="38">38</option>
										<option value="39">39</option>
										<option value="40">40</option>
										<option value="41">41</option>
										<option value="42">42</option>
										<option value="43">43</option>
										<option value="44">44</option>
										<option value="45">45</option>
										<option value="46">46</option>
										<option value="47">47</option>
										<option value="48">48</option>
										<option value="49">49</option>
										<option value="50">50</option>
										<option value="51">51</option>
										<option value="52">52</option>
										<option value="53">53</option>
										<option value="54">54</option>
										<option value="55">55</option>
										<option value="56">56</option>
										<option value="57">57</option>
										<option value="58">58</option>
										<option value="59">59</option>
									</select>
									</div>
									<div class="col-md-1">
									<h5>Meridian:</h5>
										<select class="form-control" name="ampm">
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>
									</div>
									</div>';
								}
								//--Pangalawang time out--//
								if(isset($_GET['time2']))
								{
									$stud_no = $_GET['stud_no'];
									$acad_year_start = $_GET['acad_year_start'];
									$acad_year_end = $_GET['acad_year_end'];
									$semester = $_GET['semester'];
									$category_id = $_GET['category_id'];
									$date_sub = $_GET['date_sub'];
									
									print '
									<div class="col-md-12">
									<h2>TIME OUT:</h2>
								</div>
										'.$msg_show.'
										<div class="col-md-12"></div>
									
									<div>
										<input type="hidden" name="date_sub" value="'.$date_sub.'"/>
										<input type="hidden" name="stud_no" value="'.$stud_no.'"/>
										<input type="hidden" name="acad_year_start" value="'.$acad_year_start.'"/>
										<input type="hidden" name="acad_year_end" value="'.$acad_year_end.'"/>
										<input type="hidden" name="semester" value="'.$semester.'"/>
										<input type="hidden" name="category_id" value="'.$category_id.'"/>
									<div class="col-md-1">
									<h5>Hour(s):</h5>
									<select class="form-control" name="hour">
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
									</select>
									</div>
									<div class="col-md-1">
									<h5>Minute(s):</h5>
									<select class="form-control" name="minute">
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
										<option value="32">32</option>
										<option value="33">33</option>
										<option value="34">34</option>
										<option value="35">35</option>
										<option value="36">36</option>
										<option value="37">37</option>
										<option value="38">38</option>
										<option value="39">39</option>
										<option value="40">40</option>
										<option value="41">41</option>
										<option value="42">42</option>
										<option value="43">43</option>
										<option value="44">44</option>
										<option value="45">45</option>
										<option value="46">46</option>
										<option value="47">47</option>
										<option value="48">48</option>
										<option value="49">49</option>
										<option value="50">50</option>
										<option value="51">51</option>
										<option value="52">52</option>
										<option value="53">53</option>
										<option value="54">54</option>
										<option value="55">55</option>
										<option value="56">56</option>
										<option value="57">57</option>
										<option value="58">58</option>
										<option value="59">59</option>
									</select>
									</div>
									<div class="col-md-1">
									<h5>Meridian:</h5>
										<select class="form-control" name="ampm">
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>
									</div>
									</div>';
								}
							?>
								
							</div>
							<br>
							<div class="row">
							<div class="col-md-2">
								<button type="submit" name="btn_time" class="btn btn-primary">Submit</button>
							</div>
							</div>
							</form>	
						
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