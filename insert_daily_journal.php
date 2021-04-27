<?php
date_default_timezone_set('Asia/Manila');
	require 'assets/connection/mysqli_dbconnection.php';
	
		if(isset($_POST['btn_submit_journal']))
		{
			
			$admin = $_POST['admin'];
			$date_submitted = $_POST['date_submitted'];
			
			$skills_and_knowledge_used = mysqli_real_escape_string($dbc,$_POST['skills_and_knowledge_used']);
		
			
			if(empty($skills_and_knowledge_used) ){
				header("Location:create_journal_entry.php?error_empty=1&dtr_date=$date_submitted");
			}else{
			
			/* avoid duplicate insert */
			$q_try = "SELECT * from journal where stud_no='$admin' AND date_submitted='$date_submitted' ";
			$q_try_res = $dbc->query($q_try);
			
			
				$q_insert_daily_journal ="INSERT into journal (stud_no,journal_entry,date_submitted,skills_and_knowledge_used,comander,status) 
				values ('$admin','$skills_and_knowledge_used','$date_submitted','$skills_and_knowledge_used','stud_no','Ongoing')";
				
				$q_insert_daily_journal_res = $dbc->query($q_insert_daily_journal);
				if($q_insert_daily_journal_res == true){
					header("Location:journal.php?added=ok");
				}else{
				 echo mysqli_error($dbc);
				}
		
				
			
			}
		}
		?>