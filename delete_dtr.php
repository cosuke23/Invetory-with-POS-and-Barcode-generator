<?php
// require the sql connection..
date_default_timezone_set('Asia/Manila');
require 'assets/connection/mysqli_dbconnection.php';
if(isset($_GET["dtr_id"]))  
 { 
      $dtr_id=  $_GET["dtr_id"];
      $dt=  $_GET["dt"];
       	
      	$query_ayrs_sem_studno = "SELECT * FROM dtr WHERE id = '".$dtr_id."'";
          	$result_ayrs_sem_studno = mysqli_query($dbc, $query_ayrs_sem_studno);
            while($row = mysqli_fetch_array($result_ayrs_sem_studno)){
              $stud_no = $row[1];

              $query_dtr_del="DELETE FROM dtr WHERE date_submitted='$dt' AND stud_no='$stud_no'";
			  $result_dtr_del=mysqli_query($dbc, $query_dtr_del);
			  $query_journal="DELETE FROM journal WHERE date_submitted='$date_submitted' AND stud_no='$stud_no' ";
			$result_journal=mysqli_query($dbc, $query_journal);
          	}  
      
      if($result_dtr_del==true && $result_journal==true)
		{
			header("Location:date.php?delete=success");
			exit;
		}
		else
		{
			echo "ERROR: query_reject";
			exit;
		}  
 } 
?>