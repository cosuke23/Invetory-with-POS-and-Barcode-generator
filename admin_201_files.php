<!DOCTYPE html>
<?php
 include('db.php');
 include('session.php');
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
//student number static for debugging purposes



//get student info


//get student course
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");
//get total hours
	
//get total Approved hours
$date_now=date('Y-m-d');
$secs=date('H:i:s');
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

    <title>APOSYS</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
      <link rel="icon" href="assets/img/img_step.jpg">
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
            <a href="home.php" class="logo" style="font-size:25px"><b>APOSYS</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
               
            </div>
           
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
<?php
include('sidebar.php');
?>
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
									</div>

										<?php

										if(isset($_GET['error'])){

											echo '
											
											<div style="margin-left:-14px;z-index:1;float:right;padding-top:8px;width:250px;height:35px;position:absolute;" class="alert alert-danger alert-dismissable">

											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

											  <strong>Error: No date selected!</strong> 
										
											</div>';
											}
											if(isset($_GET['start_date_error'])){

											echo '
											
											<div style="margin-left:-14px;z-index:1;float:right;padding-top:2px;width:350px;height:40px;position:absolute;" class="alert alert-danger alert-dismissable">

											  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

											  <strong>Error: Invalid date selected! You have selected a date prior to your OJT start date.</strong> 
										
											</div>';
											}

											?>
							</div><br>
									
							</div>
                    <?php
                        
                        include('db.php');
                       

              ?>
              <?php
                        if (isset($_POST['save'])){
                          $date_start=$_POST['date'];
                        }
                        require 'asset/connection/mysqli_dbconnection.php';
                        $day=date('l');
                        if($date_start==FALSE){
                          $date_start=date('Y-m-d');
                        }
                          $table = "dtr"; 
                          $columns = "*";
                          $where_em1 = ["stud_no[=]"=>$stud_no];
                          $where= ["AND" => ["stud_no[=]" => $stud_no,"date_submitted[>=]" => $date_start,'GROUP' => 'stud_no']]; 

                     $info =mysql_query("SELECT * from schedule as a left join admin_info as b on 
                      b.admin_id=a.stud_no
                      where a.day ='$day' and b.status='On Going'")or die(mysql_error());
                     $info =mysql_query("SELECT sum(a.total_hours) as hours,sum(a.total_minutes) as minutes,a.stud_no,b.status from dtr a
                     left join admin_info b on b.admin_id=a.stud_no where b.status='On Going'  group by stud_no    ")or die(mysql_error());
      
              ?>

                <div class="control-group">
                                   
                        <button name="save" class="btn btn-info"><a href="admin_202_files.php"><i >View Previews DTR</i></a></button></span>

                                          </div>
                                        </div>
          
							
							<div class="row">
								<input type="hidden" name="stud_no" value="<?php echo $stud_no;?>"/>
								<input type="hidden" name="acad_year_start" value="<?php echo $acad_year_start;?>"/>
								<input type="hidden" name="acad_year_end" value="<?php echo $acad_year_end;?>"/>
								<input type="hidden" name="semester" value="<?php echo $semester;?>"/>
								<input type="hidden" name="category_id" value="<?php echo $category_id;?>"/>
                <center>
								<input type="text" name="date_sub" value="<?php echo $date_now;?>" readonly/><br>
								<input type="text" name="hour" value="<?php echo $secs;?>" readonly/>
								</center>
								
								
							</div>
							<br>
 <script type="text/javascript">     
    function PrintDiv() {    
       var divToPrint = document.getElementById('divToPrint');
       var popupWin = window.open('', '_blank', 'width=300,height=300');
       popupWin.document.open();
       popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
            }
 </script>





                  

    <script language="javascript">
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,widtd=900, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("print_content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<html><head><title>APOSYS-DTR</title>'); 
   docprint.document.write('</head><body onLoad="self.print()" style="widtd: 900px; font-size:16px; font-family:arial;">');          
   docprint.document.write(content_vlue);          
   docprint.document.write('</body></html>'); 
   docprint.document.close(); 
   docprint.focus(); 
}
</script>
<style>
#print_content{
width:1054px;
margin:0 auto;
}
</style>

						 <div class="panel-body">
                          <div class="responsive-table">
                      <a href="javascript:Clickheretoprint()">Print  </a>

<?php echo $stud_id; ?> &nbsp&nbsp&nbsp&nbsp<?php echo $studname; ?>
<br/> 
                          <table id="datatables" cellpadding="5" cellspacing="0"  border="1"   class="table table-bordered table-hover table-condensed table-reflow" width="100%" padding-top="100px" cellspacing="0">
                      <thead> 
                          <tr>
                          <th class="text-center">Officer</th>
                          <th class="text-center">TOTAL MINUTES</th>
                          <th class="text-center">TOTAL HOURS</th>
                          <th class="text-center">View</th>
						  </tr>
                          </thead>
                          <tbody>
                          <?php
                          while($item_data=mysql_fetch_array($info)){
                          $studs = $item_data['stud_no'];
                          $total_minutes = $item_data['minutes'];
                          $total_hours = $item_data['hours'];
                         
                          ?>    						  
						  
						  
						  
                          <tr>
              
                         

             
                          <td><?php echo $studs; ?></td>
                          <td><?php echo $total_minutes; ?></td>
                          <td><?php echo $total_hours; ?></td>
                          <td>
                                     <form method="post">
                                     <input type="hidden" value="<?php echo $studs; ?>" name="stud">
                        <button name="check" class="btn btn-info"><i  class="fa fa-eye" aria-hidden="true" ></i></button></td>
 </form>

						  
                          

                        
						  </tr>


                          <?php
                        
                          }
                         ?></tbody>
                          </table>
                          <div id="print_content">
                            <table id="datatables" cellpadding="5" cellspacing="0"  border="1"   class="table table-bordered table-hover table-condensed table-reflow" width="100%" padding-top="100px" cellspacing="0">
                      <thead> 
                          <tr>
                          <th class="text-center">Officers</th>
                          <th class="text-center">Day</th>
                          <th class="text-center">TIME Start</th>
                          <th class="text-center">Remarks</th>
              </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (isset($_POST['check'])){
                          $stud=$_POST['stud'];
                        }
                          $infos =mysql_query("SELECT * from dtr where stud_no='$stud'    ")or die(mysql_error());

                          while($item_data=mysql_fetch_array($infos)){
                          $date = $item_data['date_submitted'];
                          $stud = $item_data['stud_no'];
                          $time_end = $item_data['time_out'];
                          $time_start = $item_data['time_in'];
                          $remarks=$item_data['remarks'];
                          ?>                  
              
              
              
                          <?php
                          if($remarks=='Late'){ 
                          ?><tr style="color:red;">
                          <?php
                        }else{
                          ?>

                          <tr>

                          <?php
                        }
                          ?>
                          <td ><center><?php echo $stud; ?></center></td>
                      
                      
                          <td><center><?php echo $date; ?></center></td>
                          <td><center><?php echo $time_start; ?></center></td>
                          <td><center><?php echo $remarks; ?></center></td>


              
                          

                        
              </tr>


                          <?php
                          }
                         ?></tbody>
                          </table>
                           <?php
                           include('db.php');
                          $query_idno = mysql_query("SELECT sum(total_hours)as total,sum(total_minutes)as totalm from dtr where stud_no='$stud_no'"); //error
        $row_idno = mysql_fetch_array($query_idno);

  $total=round($row_idno['total']);
  $totalm=round($row_idno['totalm']);

						  ?>
						  
						  <div style='text-align:right'>

                           </div>
                           </div>
							<div class="row">
							<div class="col-md-2">

							

								
								
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
