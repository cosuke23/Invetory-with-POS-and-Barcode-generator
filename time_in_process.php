<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
// error_reporting(0);
if(isset($_POST['btn_time']))
{
	$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
	
	$date_sub = mysqli_real_escape_string($dbc, trim($_POST['date_sub']));	
	$time_in = mysqli_real_escape_string($dbc, trim($_POST['hour']));



	$query_select_time = "SELECT time_in, time_out FROM dtr WHERE stud_no='$stud_no' AND date_submitted='$date_sub' ORDER BY id DESC";
	$result_select_time = mysqli_query($dbc, $query_select_time);
	if(mysqli_num_rows($result_select_time)>0)
	{
		$row_select = mysqli_fetch_assoc($result_select_time);
		$s_timein = $row_select['time_in'];
		$s_timeout = $row_select['time_out'];
	}

	//--VALIDATE if time_out == null--//
	if($s_timein != "" AND $s_timeout == "")
	{
		$query_check_date = "SELECT * FROM dtr WHERE stud_no='$stud_no'  ORDER BY id DESC";
		$result_check_date = mysqli_query($dbc, $query_check_date);
		if(mysqli_num_rows($result_check_date)>0)
		{
			$row = mysqli_fetch_assoc($result_check_date);
			$time_in_new = $row['time_in'];
		}

			
		$unix_timein_new = strtotime($time_in_new);
		$unix_timeout_new = strtotime($time_in);

		//--VALIDATION--//
		if($unix_timein_new != '')
		{
			$query_select_dtr_id = "SELECT * FROM dtr WHERE stud_no='$stud_no'  ORDER BY id DESC";
			$result_select_dtr_id = mysqli_query($dbc, $query_select_dtr_id);
			if(mysqli_num_rows($result_select_dtr_id)>0)
			{
				$row_dtr = mysqli_fetch_assoc($result_select_dtr_id);
				$time_in_nw = $row_dtr['time_in'];
				$dtr_id = $row_dtr['dtr_id'];
				$id = $row_dtr['id'];
			}


			$unix_timein = strtotime($time_in_nw);
			$unix_timeout = strtotime($time_in);
if($unix_timein_new <= $unix_timeout_new)
		{
			$input_minute = ($unix_timeout - $unix_timein)/60;
		}else{
$input_minute = ( $unix_timein - $unix_timeout)/60;
		}
			$input_minutes=round($input_minute);
			$total_hour=$input_minutes/60;
			$total_hours=round($total_hour);

			$query_insert_timeout = "UPDATE dtr SET total_minutes='$input_minutes',total_hours='$total_hours', time_out='$time_in' WHERE stud_no='$stud_no'  AND dtr_id='$dtr_id' AND id = $id";
			$result_insert_timeout = mysqli_query($dbc, $query_insert_timeout);
			 $hour = intval($input_minutes / 60);
                    $min = $input_minutes % 60;
			if($result_select_dtr_id == true && $result_insert_timeout == true)
			{
				?>
					<script>
alert('<?php echo $hour; ?> Hour/s <?php echo $min; ?> Minutes ');
window.location = 'date.php';
</script>
<?php
				exit;
			}
		}
		else
		{
			header("Location: time.php?stud_no=$stud_no&acad_year_start=$acad_year_start&acad_year_end=$acad_year_end&semester=$semester&category_id=$category_id&date_sub=$date_sub&time2=1&msg=1");
		}
	}
	//--Insert dtr--//
	else
	{
		$query_check_date = "SELECT * FROM dtr WHERE stud_no='$stud_no' AND date_submitted='$date_sub' ORDER BY id DESC";
		$result_check_date = mysqli_query($dbc, $query_check_date);
		if(mysqli_num_rows($result_check_date)>0)
		{
			$row = mysqli_fetch_assoc($result_check_date);
			$time_out = $row['time_out'];
		}
		if($time_out == "")
		{
			
			$query_incrmnt = "SELECT MAX(dtr_id) FROM dtr";
			$result_incrmnt = mysqli_query($dbc, $query_incrmnt);

			

			if(mysqli_num_rows($result_incrmnt)>0)
			{
				$row_incrmnt = mysqli_fetch_assoc($result_incrmnt);
				$dtr_id2 = $row_incrmnt['MAX(dtr_id)']+1;
			}

			//---INSERT INTO---//
$day=date('l');
			$query_sched = "SELECT * FROM schedule left join admin_info on schedule.stud_no=admin_info.admin_id
			 where schedule.stud_no='$stud_no' and schedule.day='$day'";
			$result_sched = mysqli_query($dbc, $query_sched);
			$row_sched = mysqli_fetch_assoc($result_sched);
			$time_s=$row_sched['start_time'];
			if($row_sched['position']!='OJT-IT'){
			$adjusted =date('H:i',strtotime('+10 minutes',strtotime($time_s)));
			}else{
				$adjusted =date('H:i',strtotime('+30 minutes',strtotime($time_s)));
			}
			if($row_sched!=''){
			if($time_in>$adjusted&&$query_sched!=''){
				$remarks='Late';
			}
			else{	
				$remarks='On Time';
			}
		}
			else {	
				$remarks='No Sched';
			}
			$query_insert_dtr = "INSERT INTO dtr(stud_no,  time_in,  time_out, total_hours, total_minutes, remarks, dtr_id, date_submitted) 
			VALUES('$stud_no', '$time_in','','','','$remarks',  '$dtr_id2', '$date_sub')";
			$result_insert_dtr = mysqli_query($dbc, $query_insert_dtr);
			
			if( $result_insert_dtr == true)
			{
				?>
				<script>
alert('<?php echo $remarks ?> ');
window.location = 'date.php';
</script>
<?php
			}
			else
			{
				echo "ERROR: select_comp_id, insert_dtrs";
			}
		}
		//--INSERT NEW DTR--//
		else
		{
			$query_check_date = "SELECT * FROM dtr WHERE stud_no='$stud_no' AND date_submitted='$date_sub' ORDER BY id DESC";
			$result_check_date = mysqli_query($dbc, $query_check_date);
			if(mysqli_num_rows($result_check_date)>0)
			{
				$row = mysqli_fetch_assoc($result_check_date);
				$time_out = $row['time_out'];
			}

			
			$unix_timein_nw = strtotime($time_in);
			$unix_timeout_nw = strtotime($time_out);

			//--VALIDATION--//
			if($unix_timeout_nw >= $unix_timein_nw)
			{
				header("Location: time.php?stud_no=$stud_no&acad_year_start=$acad_year_start&acad_year_end=$acad_year_end&semester=$semester&category_id=$category_id&date_sub=$date_sub&time=1&msg=1");
			}
			else
			{
			
				//-- SELECT dtr_id --//
				$query_in = "SELECT dtr_id FROM dtr WHERE stud_no='$stud_no' AND date_submitted='$date_sub' ORDER BY id DESC";
				$result_in = mysqli_query($dbc, $query_in);
				if(mysqli_num_rows($result_in)>0)
				{
					$row_in = mysqli_fetch_assoc($result_in);
					$dtr_id2 = $row_in['dtr_id'];
				}

				//---INSERT INTO---//
				
				$query_insert_dtr =  "INSERT INTO dtr(stud_no,  time_in,  time_out, total_hours, total_minutes, remarks, dtr_id, date_submitted) 
			VALUES('$stud_no', '$time_in','','','','late',  '$dtr_id2', '$date_sub')";
				$result_insert_dtr = mysqli_query($dbc, $query_insert_dtr);
				
				if( $result_insert_dtr == true)
				{
					header("Location: date.php?msg2=1");
					exit;
				}
				else
				{
					echo "ERROR: select_comp_id, insert_dtrs";
				}
			}
		}
	}
}
?>