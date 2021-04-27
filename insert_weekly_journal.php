<?php
date_default_timezone_set('Asia/Manila');
	require 'assets/connection/mysqli_dbconnection.php';
	
		if(isset($_POST['btn_submit_weekly']))
		{
			
			$stud_no = $_POST['stud_no'];
			$date_submitted = $_POST['date_submitted'];
			$acad_year_start= $_POST['acad_year_start'];
			$acad_year_end =$acad_year_start + 1;
			$semester = $_POST['semester'];
			$week_no = $_POST['week_no'];
			$weekly_summary = mysqli_real_escape_string($dbc,$_POST['weekly_summary']);
			
			if(empty($weekly_summary)){
			
				header("Location:create_weekly_journal_entry.php?error_empty=1&weekly_dtr_date=$date_submitted&week_no=$week_no");
			}else{
			
			/* avoid duplicate insert */
			$q_try = "select * from journal where stud_no='$stud_no' AND date_submitted='$date_submitted' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester' AND week_no='$week_no' AND type='Weekly'";
			$q_try_res = $dbc->query($q_try);
			
			if($q_try_res->num_rows > 0 ){
				header("Location:journal_weekly.php?added=ok");
			}else{
			
				$q_insert_weekly_journal ="insert into journal (stud_no,journal_entry,date_submitted,day,type,semester,acad_year_start,acad_year_end,week_no) values ('$stud_no','$weekly_summary','$date_submitted','Sat','Weekly','$semester','$acad_year_start','$acad_year_end','$week_no')";
			
				$q_insert_weekly_journal_res = $dbc->query($q_insert_weekly_journal);
					if($q_insert_weekly_journal_res == true){
						header("Location:journal_weekly.php?added=ok");
					}else{
						echo mysqli_error($dbc);
					}
			
			
				}
			}
			
		}
		?>