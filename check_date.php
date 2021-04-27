<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_date']))
{
	$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
	$acad_year_start = mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));
	$acad_year_end = mysqli_real_escape_string($dbc, trim($_POST['acad_year_end']));
	$semester = mysqli_real_escape_string($dbc, trim($_POST['semester']));
	$category_id = mysqli_real_escape_string($dbc, trim($_POST['category_id']));
	$date_sub = mysqli_real_escape_string($dbc, trim($_POST['date_sub']));
	date_default_timezone_set('Asia/Manila');
	$date_now=date("Y-m-d");
	/*get ojt start date */
	$q_start_date = "select ojt_start_date from company_ojt_student where stud_no='$stud_no' and status='Ongoing'";
	$q_start_date_res = $dbc->query($q_start_date);
	$row = $q_start_date_res->fetch_assoc();
	$ojt_start_date = $row['ojt_start_date'];
	if($date_sub == 0){
	header("Location:date.php?error=no_date");
	}else{
	
	if(strtotime($date_sub) >= strtotime($ojt_start_date)){
		if(strtotime($date_sub) > strtotime($date_now)){
		header("Location: date.php?start_date_error=1");
	}else{
	$query_check_date = "SELECT * FROM dtr WHERE stud_no='$stud_no' AND date_submitted='$date_sub' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester' AND category_id='$category_id' ORDER BY id DESC";
	$result_check_date = mysqli_query($dbc, $query_check_date);
		if(mysqli_num_rows($result_check_date)>0)
		{
			$row = mysqli_fetch_assoc($result_check_date);
			$time_out = $row['time_out'];
			
			if($time_out == null)
			{
				
				header("Location: time.php?stud_no=$stud_no&acad_year_start=$acad_year_start&acad_year_end=$acad_year_end&semester=$semester&category_id=$category_id&date_sub=$date_sub&time2=1");
				exit;
			}
			else
			{
				//--Pangalawang time in--//
				header("Location: time.php?stud_no=$stud_no&acad_year_start=$acad_year_start&acad_year_end=$acad_year_end&semester=$semester&category_id=$category_id&date_sub=$date_sub&time=1");
				exit;
			}
		}
		else
		{
			//--Unang time in--//
			header("Location: time.php?stud_no=$stud_no&acad_year_start=$acad_year_start&acad_year_end=$acad_year_end&semester=$semester&category_id=$category_id&date_sub=$date_sub&time=1");
			exit;
		}
		
		}
	}else {
		header("Location: date.php?start_date_error=1");
	
		
	}
}
}

?>