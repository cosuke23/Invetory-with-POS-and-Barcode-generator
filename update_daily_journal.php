<?php
date_default_timezone_set('Asia/Manila');
	require 'assets/connection/mysqli_dbconnection.php';
	
		if(isset($_POST['btn_update_journal']))
		{
			
			$stud_no = $_POST['stud_no'];
			$date_submitted = $_POST['date_submitted'];
			$td_id = $_POST['td_id'];
			$status = $_POST['status'];

			
			$nature_of_activity = mysqli_real_escape_string($dbc,$_POST['nature_of_activity']);
			
			if(empty($nature_of_activity) ){
				header("Location:edit_journal.php?error_empty=1&journal_date=$date_submitted");
			}else{
			

			$q_update_daily_journal ="UPDATE journal set skills_and_knowledge_used='$nature_of_activity', journal_entry='$nature_of_activity',status='$status' where stud_no='$stud_no' and id='$td_id' " ;
			
			$q_update_daily_journal_res = $dbc->query($q_update_daily_journal);
			if($q_update_daily_journal_res == true){
				header("Location:journal.php?updated=ok");
			}else{
			 echo mysqli_error($dbc);
			}
			}
		
		}