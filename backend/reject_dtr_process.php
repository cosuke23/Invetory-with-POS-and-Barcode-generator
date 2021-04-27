<?php

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



if(isset($_POST["dtr_id"]))  

 { 

      foreach($_POST["dtr_id"] as $dtr_id)  

      {  	

      	$query_ayrs_sem_studno = "SELECT stud_no,acad_year_start,semester,date_submitted FROM dtr WHERE dtr_id = '".$dtr_id."'";

          	$result_ayrs_sem_studno = mysqli_query($dbc, $query_ayrs_sem_studno);

            while($row = mysqli_fetch_array($result_ayrs_sem_studno)){

              $stud_no = $row[0];

              $acad_year_start = $row[1];

              $semester = $row[2];

              $date_submitted = $row[3];



              $query_dtr_del="DELETE FROM dtr WHERE dtr_id='$dtr_id' AND stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND semester='$semester'";

			  $result_dtr_del=mysqli_query($dbc, $query_dtr_del);



			  $query_journal="DELETE FROM journal WHERE date_submitted='$date_submitted' AND stud_no='$stud_no' AND semester = '$semester' AND acad_year_start = '$acad_year_start'";

			$result_journal=mysqli_query($dbc, $query_journal);

          	}  

      }

      if($result_dtr_del==true && $result_journal==true)

		{

			header("Location:dtr.php?stud_no_records=$stud_no&acad_year_start_rd=$acad_year_start_rd&semester_rd=$semester_rd&reject=1&date_submitted=$date_submitted");

			exit;

		}

		else

		{

			echo "ERROR: query_reject";

			exit;

		}  

 } 



?>