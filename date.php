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
    <link rel="icon" href="assets/img/img_steps.png">
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

 
              ?>
                                      <?php
                        $day=date('l'); 
$time_p=date('h:i:s', strtotime($time_out)); 
if (isset($_POST['save'])){
  $date_start=$_POST['date']; 
  $date_end=$_POST['date_end']; 
  }
   
  require 'asset/connection/mysqli_dbconnection.php'; 
  include('db.php'); 
  $now=date('Y-m-d'); 
  if($date_start!=''){
  $query_cess = mysql_query("SELECT * from dtr where stud_no='$stud_no'and date_submitted>='$date_start' and date_submitted<='$date_end' or date_submitted='$now' order by date_submitted")or die (mysql_error()); 
}else{
  $query_cess = mysql_query("SELECT * from dtr where stud_no='$stud_no'and date_submitted>='$date_start' and date_submitted<='$date_end' or date_submitted='$now' group by date_submitted")or die (mysql_error());   
}

  $table = "dtr"; $columns = "*"; 
  $where_em1 = ["stud_no[=]"=>$stud_no]; 
  $where_now= ["AND" => ["stud_no[=]" => $stud_no,"date_submitted[>=]" => $date_start,"date_submitted[<=]" => $date_end]]; 
  $date_now=date('Y-m-d'); 
  $where= ["AND" => ["stud_no[=]" => $stud_no,"date_submitted[>=]" => $date_now]]; 
  $order=["ORDER" => ["date_submitted" => "DESC"]];
   if($date_start&&$date_end!=''){
    $q_item_info =$database->select($table,$columns,$where_now,$order); 
  }
    else
    {
      $q_item_info =$database->select($table,$columns,$where,$order); 
    } 
              ?>
               <form method="post"> <div class="control-group"> FROM:<div class="controls"><span><input type="date" name="date"><br/> TO:
    <div class="controls"><span><input type="date" name="date_end"> 
    <button name="save" class="btn btn-info"><i >Submit</i></button></span> 
    </div> </div> </form>   

                  <form action="time_in_process.php" method="POST" enctype="multipart/form-data">
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
<div id="print_content">
<?php echo $stud_id; ?> &nbsp&nbsp&nbsp&nbsp<?php echo $studname; ?>
<br/> 
                          <table id="datatables" cellpadding="5" cellspacing="0"  border="1"   class="table table-bordered table-hover table-condensed table-reflow" width="100%" padding-top="100px" cellspacing="0">
                      <thead> 
                          <tr>
                          <th class="text-center">DATE</th>
                          <th class="text-center">TIME IN</th>
                          <th class="text-center">TIME OUT</th>
                          <th class="text-center">DAY</th>
                          <th class="text-center">TOTAL HOURS</th>
                          <th class="text-center">TOTAL MINUTES</th>
                          <th class="text-center">REMARKS</th> 
              </tr>
                          </thead>
                          <tbody>
                          <?php

                          //while($item_data = mysql_fetch_array($query_cess)){
                          foreach($q_item_info as $item_data){
                          $date = $item_data['date_submitted'];
                          $nameOfDay = date('D', strtotime($date));
                          $time_in = $item_data['time_in'];
                          $time_out = $item_data['time_out'];
                          $total_hours = $item_data['total_hours'];
                          $total_minutes = $item_data['total_minutes'];
                          $remarks = $item_data['remarks'];
                          ?>                  
              
              
              
                          <tr>
                          <td><?php echo $date; ?></td>
                          <td><?php echo $time_in; ?></td>
                          <td><?php echo $time_out; ?></td>
                          <td><?php echo $nameOfDay; ?></td>
                          <td><?php echo $total_hours; ?></td>
                          <td><?php echo $total_minutes; ?></td>
                          <td><?php echo $remarks; ?></td>


              
                          

                        
              </tr>


                          <?php
                          }
                         ?></tbody>
                          </table>
                          
                           <?php
                         include('db.php'); 
                $query_idno = mysql_query("SELECT sum(total_hours)as total,sum(total_minutes)as totalm from dtr where stud_no='$stud_no'and date_submitted>='$date_start'")or die (mysql_error()); //error $row_idno = mysql_fetch_array($query_idno); $total=round($row_idno['total']); $totalm=round($row_idno['totalm']); $total_minutes=$totalm; $hour = intval($total_minutes / 60); $min = $total_minutes % 60;
  $row_idno = mysql_fetch_array($query_idno);

  $total=round($row_idno['total']);
  $totalm=round($row_idno['totalm']);
  $total_minutes=$totalm;
  $hour = intval($total_minutes/60);
  $min = $total_minutes % 60;

              ?>
               <div style='text-align:left'>



                       <span style="color:blue">    <p style="color: black">_________________________</p>
                          <p style="color: black"> Mrs,Annabelle O. Villegas</p>
                           </div>
              
              <div style='text-align:right'>



                       <span style="color:blue">   <?php echo $hour; ?> Hour/s <?php echo $min; ?> Minutes
                           
                           </div>
                           </div>
              <div class="row">
              <div class="col-md-2">

                <?php 
                $q_studinfos ="SELECT * from dtr where stud_no='$stud_no' and date_submitted='$date_now'";
$q_studinfo_re = $dbc->query($q_studinfos);
$studinfos = $q_studinfo_re->fetch_assoc();
$timeI=$studinfos['time_in'];
$timeO=$studinfos['time_out'];
$date=$studinfos['date_submitted'];
$now=date('Y-m-d');

if($date==$now||$date==''&&$timeI==''){
?>

                <button type="submit" name="btn_time" class="btn btn-primary">Time</button>
              </div>
              </div>
              </form> 
          <?php }else  { ?>
                <button type="submit" name="btn_time" class="btn btn-primary">Time-Out</button>
              
              
              </form> 
          
          <?php } ?>
          <?php  ?>
                  
                  <?php
                    $dtar_query = $dbc->query("SELECT * FROM dtr WHERE stud_no = '$stud_no' order by date_submitted desc");
                    $temp_date = "0";
                    $input_mins = 0;
                    
                    while($row = $dtar_query->fetch_assoc()) {
                    $dtr_id = $row["id"];
                    $dtr_date = $row["date_submitted"];
                    $dtr_date2 = strtotime($dtr_date);
                    $format = "F d, Y";
                    $formatted_date = date($format,$dtr_date2);
                    print '<div class="">';
                    
                      if($temp_date == "0") {
                        $temp_date = $row["date_submitted"];
                        print '<a href="confirm_delete_dtr.php?dtr_id='.$dtr_id.'"><i class="glyphicon glyphicon-trash"></i> Delete</a><br>';
                        print '<span>' . $row["time_in"] . '-' . $row["time_out"] . '&nbsp;&nbsp;' . $formatted_date  . '</span><br>';    
              //          $input_mins = $row["input_minutes"];
                      } else {
                        if($temp_date == $row["date_submitted"]) {
                          $temp_date = $row["date_submitted"];
                          print '<span>' . $row["time_in"] . '-' . $row["time_out"] . '</span><br>';
                          $input_mins = $input_mins + $row["total_minutes"];
                        } else {
                          $hour = intval($input_mins / 60);
                          $min = $input_mins % 60;
                          print '<span>' . $hour . ' hour(s) ' . $min . ' minute(s)</span><br><br>';
                          print '<a href="confirm_delete_dtr.php?dtr_id='.$dtr_id.'""><i class="glyphicon glyphicon-trash"></i> Delete</a><br>';
                          $input_mins = $row["total_minutes"];
                          print '<span>' . $row["time_in"] . '-' . $row["time_out"] . '&nbsp;&nbsp;' . $formatted_date . '</span><br>';
                          $temp_date = $row["date_submitted"];
                          
                        }
                      }
                      
                      print '</div>';
                    }
                    print '<div>';
                    $hour = intval($input_mins / 60);
                    $min = $input_mins % 60;
                    print '<span>' . $hour . ' hour(s) ' . $min . ' minute(s)</span>';
                          $input_mins = $row["total_minutes"];
                    //print '<a href="delete_dtr.php"><i class="glyphicon glyphicon-remove"></i></a>';
                    print '</div>';                   
                  ?>
                
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
