<?php
date_default_timezone_set('Asia/Manila');
	require 'assets/connection/mysqli_dbconnection.php';
	
		if(isset($_POST['btn_update_weekly_journal']))
		{
			
			$stud_no = $_POST['stud_no'];
			$date_submitted = $_POST['date_submitted'];
			$acad_year_start= $_POST['acad_year_start'];
			$acad_year_end =$acad_year_start + 1;
			$semester = $_POST['semester'];
			$weekday = $_POST['weekday'];
			$weekly_summary = mysqli_real_escape_string($dbc,$_POST['weekly_summary']);
			if(empty($weekly_summary)){
			
				header("Location:edit_weekly_journal.php?error_empty=1&weekly_journal_date=$date_submitted");
			}else{

			$q_update_weekly_journal ="update journal set journal_entry='$weekly_summary' where stud_no='$stud_no' and date_submitted='$date_submitted' and type='Weekly' and semester='$semester' and acad_year_start='$acad_year_start'" ;
			
			$q_update_weekly_journal_res = $dbc->query($q_update_weekly_journal);
			if($q_update_weekly_journal_res == true){
				header("Location:journal_weekly.php?updated=ok");
			}else{
			 echo mysqli_error($dbc);
			}
			}
		
		}