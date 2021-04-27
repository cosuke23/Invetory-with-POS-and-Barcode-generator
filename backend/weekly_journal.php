<?php

$page_title = 'download journal';

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';

require 'pdfcrowd.php';

try

{   

    // create an API client instance

    $client = new Pdfcrowd("limsteven1994", "75fec50cfd85a5b095e1b8375ef82026");



    // convert a web page and store the generated PDF into a $pdf variable

    $pdf = $client->convertHtml("<head></head><body></body>");

    // set HTTP response headers

    header("Content-Type: application/pdf");

    header("Cache-Control: max-age=0");

    header("Accept-Ranges: none");

    header("Content-Disposition: attachment; filename=\"journal.pdf\"");



    // send the generated PDF 

    echo $pdf;

}

catch(PdfcrowdException $why)

{

    echo "Pdfcrowd Error: " . $why;

}





  if(isset($_GET['weekly_date']) && isset($_GET['stud_no']) && isset($_GET['semester']) && isset($_GET['acad_year_start'])) {

  

   //7 days ago

  $weekly_date=$_GET['weekly_date'];

    $stud_no=$_GET['stud_no'];

  $semester=$_GET['semester'];

  $acad_year_start=$_GET['acad_year_start'];

  

$timestring=  $weekly_date;

$datetime=new DateTime($timestring);

$datetime->modify('-6 day');

$date_2 = $datetime->format("Y-m-d");

 

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



<link rel="shortcut icon" href="ojtassistilogo.png">

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

<br>

<body>



   <div class="col-md-12">

            

            <!-- start: Content -->

            <div id="content2">

             

              <div class="col-md-12 padding-0">

                <div class="col-md-12">

                  <div class="panel">

                <div class="panel-body" style="margin-left:20px;margin-right:20px;">





                     <?php

                      

                     $query_stud_info_NaCn = "SELECT a.lname,a.fname,a.mname,c.comp_name FROM student_info AS a INNER JOIN

                     company_ojt_student AS b INNER JOIN company_info AS c WHERE a.stud_no = b.stud_no AND b.comp_id = c.comp_id AND b.stud_no = '$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester'";

                 

                    $result_stud_info_journal =  mysqli_query($dbc, $query_stud_info_NaCn);         

                            if($result_stud_info_journal->num_rows > 0 )

                              {   

                                while ($row_NaCn = mysqli_fetch_array($result_stud_info_journal))

                                {

                                              $stud__lname_row_NaCn = $row_NaCn[0];

                                              $stud__fname_row_NaCn = $row_NaCn[1];

                                              $stud__mname_row_NaCn = $row_NaCn[2];

                                              $stud__comp_row_NaCn = $row_NaCn[3];



                               }

                             }



                    ?>



               

                      <div class="row">

                          <div class="col-md-12">



                            <div class="col-md-2">

                              <img src="asset/img/stilogi_wj.png"/>

                            </div>

                          </div>

                        </div> 

                        <br>

                        <br>



                         <div class="row">

                          <div class="col-md-12">

                          

                            <div class="col-md-6">

                              <label> Name of the Student Trainee: <?php echo $stud__lname_row_NaCn.", ".$stud__fname_row_NaCn. " ".$stud__mname_row_NaCn ?> <label>

                            </div>







                             <div class="col-md-6">

                              <label> Name of Company:  <?php echo  $stud__comp_row_NaCn; ?>  <label>

                            </div>



                             <div class="col-md-4">

                              <label><label>

                            </div>

                          </div>

                        </div>



                        <div class="row" style="padding-top:10px;">

                          <div class="col-md-12">

                           <div class="col-md-4"></div>

                           <div class="col-md-6">

                            <h4> ON THE JOB TRAINING / PRACTICUM JOURNAL <?php echo $date_2; ?></h4>

                           </div>

                           <div class="col-md-2"></div>

                          </div>

                        </div>





                      <div class="responsive-table">

                      <table id="datatables" class="table table-bordered" cellspacing="0" >

                      <thead style="background-color:gray;">

                        <tr>

                         <th class="text-center" style="width:5%;font-size:12px;">DAY</th>

                         <th class="text-center" style="width:10%;font-size:12px;"> DATE</th> 

                         <th class="text-center" style="width:30%;font-size:12px;"> NATURE OF ACTIVITY</th>

                         <th class="text-center" style="width:7%;font-size:10px;">NO. OF WORKING HOURS</th>

                         <th class="text-center" style="width:20%;font-size:12px;">SKILLS AND KNOWLEDGED USED</th>

                          <th  class="text-center" style="font-size:10px;">EVALUATION OF WEEK`S EXPERIENCES THAT<br> WERE BENEFICIALTO YOUR PRE- <br> PROFESSIONAL DEVELOPMENT </th>  

                         </tr>

                         </thead>

                      <tbody>



                       <?php

                    



                        $query_journal_info = "SELECT a.journal_entry FROM journal AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no = b.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND b.ojt_status = 'Ongoing' AND a.date_submitted = '$weekly_date' AND a.type = 'Weekly'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $journal_entry_weekly = $row[0];

                               }

                             }

                        ?> 

          

                       <?php

                       

                        $query_journal_info = "SELECT a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,b.input_hours FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Mon' AND a.type ='Daily'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $journal_entry = $row[0];

                                  $date_day = $row[1];

                                  $date_submitted_from_tbl = $row[2];

                                  $skills_and_knowledge_used = $row[3];

                                  $type = $row[4];

                                  $input_hours1 = $row[5];



                                     

                                      if($date_day =="Mon" && $type="Daily")

                                      {

                                            print '<tr>';

                                                  echo '<td>Mon</td>';

                                                  echo '<td>'.$date_submitted_from_tbl.'</td>';

                                                  echo ' <td>'.$journal_entry.'</td>';

                                                   echo '<td><input type="hidden" value="'.$input_hours1.'" id="input_hour_Mon"/>'.$input_hours1.'</td>';

                                                  echo '<td>'.$skills_and_knowledge_used.'</td>';

                                                  echo '<td rowspan="15">'.$journal_entry_weekly.'</td>';

                                                  print '<tr>';

                                                 

                                      }



                                        

                               }

                             }

                              else{



                                          print '<tr>

                                                <td>Mon</td>

                                                <td></td>

                                                <td></td>

                                                <td></td>

                                                <td></td>

                                                <td rowspan="15">'.$journal_entry_weekly.'</td>

                                                  <tr>';

                                           

                                      }

                        ?> 



                         <?php

                       

                       $query_journal_info = "SELECT  a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,b.input_hours FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Tue' AND a.type ='Daily'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $journal_entry = $row[0];

                                  $date_day = $row[1];

                                  $date_submitted_from_tbl = $row[2];

                                  $skills_and_knowledge_used = $row[3];

                                  $type = $row[4];

                                  $input_hours2 = $row[5];



                                     

                                      if($date_day =="Tue" && $type="Daily")

                                      {

                                            print '<tr>

                                                  <td>Tue</td>

                                              <td>'.$date_submitted_from_tbl.'</td>

                                              <td>'.$journal_entry.'</td>

                                              <td><input type="hidden" value="'.$input_hours2.'" id="input_hour_Tue"/>'.$input_hours2.'</td>

                                              <td>'.$skills_and_knowledge_used.'</td>

                                                  <tr>';

                                      }

                               }

                             }

                              else{



                                          print '<tr>

                                                  <td>Tue</td>

                                              <td></td>

                                              <td></td>

                                              <td></td>

                                              <td></td>



                                                  <tr>';

                                           

                                      }

                        ?> 



                          <?php

                      

                          $query_journal_info = "SELECT  a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,b.input_hours FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Wed' AND a.type ='Daily'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $journal_entry = $row[0];

                                  $date_day = $row[1];

                                  $date_submitted_from_tbl = $row[2];

                                  $skills_and_knowledge_used = $row[3];

                                  $type = $row[4];

                                  $input_hours3 = $row[5];



                                  

                                     

                                      if($date_day =="Wed" && $type=="Daily")

                                      {

                                       

                                             print '<tr>

                                                  <td>Thru</td>

                                                  <td>'.$date_submitted_from_tbl.'</td>

                                                  <td>'.$journal_entry.'</td>

                                                  <td><input type="hidden" value="'.$input_hours3.'" id="input_hour_Wed"/>'.$input_hours3.'</td>

                                                  <td>'.$skills_and_knowledge_used.'</td>

                                                      <tr>';

                                      }

                               }

                             }

                              else{



                                          print '<tr>

                                                  <td>Wed</td>

                                                  <td></td>

                                                  <td></td>

                                                  <td></td>

                                                  <td></td>

                                                  <tr>';

                                           

                                      }

                        ?> 



                         <?php

                      

                       $query_journal_info = "SELECT  a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,b.input_hours FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Thu' AND a.type ='Daily'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $journal_entry = $row[0];

                                  $date_day = $row[1];

                                  $date_submitted_from_tbl = $row[2];

                                  $skills_and_knowledge_used = $row[3];

                                  $type = $row[4];

                                  $input_hours4 = $row[5];



                                     

                                      if($date_day =="Thu" && $type=="Daily")

                                      {

                                            print '<tr>

                                                  <td>Thru</td>

                                              <td>'.$date_submitted_from_tbl.'</td>

                                              <td>'.$journal_entry.'</td>

                                              <td><input type="hidden" value="'.$input_hours4.'" id="input_hour_Thu"/>'.$input_hours4.'</td>

                                              <td>'.$skills_and_knowledge_used.'</td>

                                                  <tr>';

                                      }

                               }

                             }

                              else{



                                          print '<tr>

                                                  <td>Thu</td>

                                              <td></td>

                                              <td></td>

                                              <td></td>

                                              <td></td>

                                                  <tr>';

                                           

                                      }

                        ?> 

                          

                         <?php

                       

                      $query_journal_info = "SELECT  a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,b.input_hours FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Fri' AND a.type ='Daily'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $journal_entry = $row[0];

                                  $date_day = $row[1];

                                  $date_submitted_from_tbl = $row[2];

                                  $skills_and_knowledge_used = $row[3];

                                  $type = $row[4];

                                  $input_hours5 = $row[5];



                                     

                                      if($date_day =="Fri" && $type=="Daily")

                                      {

                                            print '<tr>

                                                  <td>Fri</td>

                                              <td>'.$date_submitted_from_tbl.'</td>

                                              <td>'.$journal_entry.'</td>

                                              <td><input type="hidden" value="'.$input_hours5.'" id="input_hour_Fri"/>'.$input_hours5.'</td>

                                              <td>'.$skills_and_knowledge_used.'</td>

                                                  <tr>';

                                      }

                               }

                             }

                              else{



                                          print '<tr>

                                              <td>Fri</td>

                                              <td></td>

                                              <td></td>

                                              <td></td>

                                              <td></td>

                                                  <tr>';

                                           

                                      }

                        ?> 



                           <?php

                       

                        $query_journal_info = "SELECT  a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,b.input_hours FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Sat' AND a.type ='Daily'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $journal_entry = $row[0];

                                  $date_day = $row[1];

                                  $date_submitted_from_tbl = $row[2];

                                  $skills_and_knowledge_used = $row[3];

                                  $type = $row[4];

                                  $input_hours6 = $row[5];



                                     

                                      if($date_day =="Sat" && $type=="Daily")

                                      {

                                            print '<tr>

                                                  <td>Sat</td>

                                              <td>'.$date_submitted_from_tbl.'</td>

                                              <td>'.$journal_entry.'</td>

                                              <td><input type="hidden" value="'.$input_hours6.'" id="input_hour_Sat"/>'.$input_hours6.'</td>

                                              <td>'.$skills_and_knowledge_used.'</td>

                                                  <tr>';

                                      }

                               }

                             }

                              else{



                                          print '<tr>

                                                <td>Sat</td>

                                                <td></td>

                                                <td></td>

                                                <td></td>

                                                <td></td>

                                                  <tr>';

                                           

                                      }

                        ?> 



                       <?php

                      

                        $query_journal_info = "SELECT  a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,b.input_hours FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Sun' AND a.type ='Daily'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $journal_entry = $row[0];

                                  $date_day = $row[1];

                                  $date_submitted_from_tbl = $row[2];

                                  $skills_and_knowledge_used = $row[3];

                                  $type = $row[4];

                                  $input_hours7 = $row[5];



                                     

                                      if($date_day =="Sun" && $type=="Daily")

                                      {

                                            print '<tr>

                                                  <td>Sat</td>

                                              <td>'.$date_submitted_from_tbl.'</td>

                                              <td>'.$journal_entry.'</td>

                                              <td><input type="hidden" value="'.$input_hours7.'" id="input_hour_Sun"/>'.$input_hours7.'</td>

                                              <td>'.$skills_and_knowledge_used.'</td>

                                                  <tr>';

                                      }

                               }

                             }

                              else{



                                          print '<tr>

                                                  <td>Sun</td>

                                              <td></td>

                                              <td></td>

                                              <td></td>

                                              <td></td>

                                              <td></td>

                                                  <tr>';

                                           

                                      }

                        ?> 

                               



                      

                     </tbody>

                     </table>

                     </div>



                  



                     </div>



                      <div class="row">

                          <div class="col-md-5"></div>

                          <div class="col-md-2">



                           <?php

                      

                        $query_journal_info = "SELECT Sum(b.input_hours) AS input_hours FROM journal AS a INNER JOIN dtr AS b WHERE b.date_submitted >= '$date_2' AND b.date_submitted <= '$weekly_date' AND  b.date_submitted = a.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='00820130084' AND b.acad_year_start = '2016' AND b.semester = '2nd Semester'";



                           $result_journal_info = mysqli_query($dbc, $query_journal_info);

                          $num_rows = mysqli_num_rows($result_journal_info);

                           

                              if($result_journal_info->num_rows > 0 )

                                {   

                                  while ($row = mysqli_fetch_array($result_journal_info))

                                  {

                                  $input_hours_total = $row[0];

                               }

                             }

                              

                        ?> 



                            <label> Total no: of hours: &nbsp;&nbsp;

                            

                             <label><?php echo  $input_hours_total;?></label></label>

                          </div>

                    </div>



                     <div class="row">

                     

                          <div class="col-md-8"></div>

                          <div class="col-md-2">

                            <label> Certified by: &nbsp;&nbsp;   mam / sir</label>

                          </div>

                   

                    </div>



                    <div class="row">

                      

                          <div class="col-md-9"></div>

                          <div class="col-md-3">

                            <label></label>

                          </div>

                     

                    </div>



                    <div class="row">

                      

                          <div class="col-md-9"></div>

                          <div class="col-md-3">

                            <label>______________________________________</label>

                          </div>

                    

                    </div>



                    <div class="row">

                     

                          <div class="col-md-9"></div>

                          <div class="col-md-3">

                          

                            <label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; OJT SUPERVISOR </label>

                          </div>

                    

                    </div>

                    <br>

                  </div>



                </div>



              </div>

            </div><!-- end: content -->

     </div>



     <div id="editor"></div>

    <button id="btn">Generate PDF</button>

    <?php

     $a = "http://localhost/OJTassisti-v20/weekly_journal.php?weekly_date=2016-09-10&stud_no=00820130001&acad_year_start=2016&semester=1st%20Semester";

    ?>

    <form action="downloadjournal.php" METHOD ="POST">

    <input type="text" value="<?php echo $a ?>" name="URL"/>

    <input type="submit" name="downloadjournal">

    </form>

    </body>

          

     



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

<script type="text/javascript" src="asset/js/jspdf.min.js"></script>

<!-- custom -->

<script src="asset/js/main.js"></script>

</script>

<script type="text/javascript">

var doc = new jsPDF('landscape');

var specialElementHandlers = {

'#editor': function (element, renderer) {

return true;

}

};



$(document).ready(function() {

$('#btn').click(function () {

doc.fromHTML($('#content2').html(), 15, 15, {

'width': 1000,

'elementHandlers': specialElementHandlers

});

doc.save('sample-content.pdf');

});

});



function printDiv(divName) {

    var printContents = document.getElementById(divName).innerHTML;

    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;

}

</script>





</body>

</html>