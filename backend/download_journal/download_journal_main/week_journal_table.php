<?php
$page_title = 'OJT AssiSTI - Download Journal';
require 'asset/connection/mysqli_dbconnection.php'; 

  if(isset($_GET['stud_no']) && isset($_GET['semester']) && isset($_GET['acad_year_start'])) {
  
   //7 days ago
  $stud_no=$_GET['stud_no'];
  $semester=$_GET['semester'];
  $acad_year_start=$_GET['acad_year_start'];
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
       
   <div>
            <!-- start: Content -->
            <div>
              
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>MY WEEKLY JOURNAL</h3></div>
                               
                      <?php
					  $CW = 1;
                      $query_journal_week = "SELECT stud_no,semester,acad_year_start,date_submitted,DATE_FORMAT(date_submitted, '%b/%d/%Y') as date2,type FROM JOURNAL WHERE stud_no ='$stud_no' AND acad_year_start='$acad_year_start' AND semester = '$semester' AND type='Weekly'";
                          $result_journal_week = mysqli_query($dbc, $query_journal_week);
                          $num_rows = mysqli_num_rows($result_journal_week);

            print '<div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>WEEK NUMBER</th>   
                          <th class="text-center">DATE</th>
                          <th class="text-center" style="width:100px;">ACTION</th>
                                          
                        </tr>
                      </thead>
                      <tbody>';
                        while($row = mysqli_fetch_array($result_journal_week)) {

                            $stud_no = $row[0];
                            $semester = $row[1];
                            $acad_year_start = $row[2];
                            $weekly_date = $row[3];
                            $weekly_date2 = $row[4];
                            $type = $row[5] + $CW;
							$week_num = $type;
						
                      ?>
                       <tr>                                     
                                <td><?php echo "Week ".$type; ?></td>
                                <td><?php echo $weekly_date2; ?></td>
                              <td>
                                  <a href="weekly_journal.php?weekly_date=<?php echo $weekly_date; ?>&stud_no=<?php echo $stud_no; ?>&acad_year_start=<?php echo $acad_year_start; ?>&semester=<?php echo $semester; ?>&week_num=<?php echo $week_num; ?>">
                                  <button type="submit" class=" btn btn-primary btn-block btn-sm">
                                  <span class="glyphicon glyphicon-download"></span> &nbsp; Download</button>
                                  </a>
                              </td>
                      </tr>
                      <?php 
					  $CW++;
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