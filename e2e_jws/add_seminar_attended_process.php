<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_add_seminar_attended']))
	{
		$stud_no = $_POST['stud_no'];
		$stud_name = $_POST['stud_name'];
		$event_id = $_POST['event_name-hidden'];

		$s1_timein = strtotime($_POST['s1_time_in']);
		//$s1_time_out = strtotime($_POST['s1_time_out']);
		//$s1_status  = $_POST['s1_status'];

		$s2_timein= strtotime($_POST['s2_time_in']);
		//$s2_time_out  = strtotime($_POST['s2_time_out']);
		//$s2_status  = $_POST['s2_status'];

		$q_check_sa = $database->query("SELECT a.event_id, c.event_name FROM seminar_attended AS a INNER JOIN seminar_attended AS b INNER JOIN event_manager AS c WHERE a.event_id = c.event_id AND b.event_id = c.event_id AND a.event_id = b.event_id AND  a.stud_no = b.stud_no AND a.stud_no = '$stud_no'");
		foreach($q_check_sa AS $q_check_sa_data){

			$event_id_check = $q_check_sa_data['event_id'];
			$event_name_check =  $q_check_sa_data['event_name'];
			if($event_id_check == $event_id){
				header("location:add_seminar_attended.php?error=1&stud_no=$stud_no&event_name=$event_name_check&stud_name=$stud_name");
				exit;
			}
		}
		//check event id if exists
		$q_em_check  = $database->query("SELECT * FROM event_manager")->fetchAll();
		foreach($q_em_check AS $q_em_check_data){
				echo $event_id_checked = $q_em_check_data['event_id'];
		}
			if($event_id != $event_id_checked){
			header("location:add_seminar_attended.php?error2=2&stud_no=$stud_no&event_name=$event_id&stud_name=$stud_name");
			exit;
			}
		//check event id if type is seminar
		$q_em_check2 = $database->query("SELECT * FROM event_manager WHERE event_id = '$event_id'")->fetchAll();
		foreach($q_em_check2 AS $q_em_check_data2){
				echo $event_type = $q_em_check_data2['type'];
		}
		if($event_type != 'Seminar'){
			header("location:add_seminar_attended.php?error3=3&stud_no=$stud_no&event_name=$event_id&stud_name=$stud_name");
			 exit;
		}
	
	

		$q_em  = $database->query("SELECT * FROM event_manager WHERE event_id = '$event_id'")->fetchAll();

		foreach($q_em As $q_em_data){
			$acad_year_start = $q_em_data['acad_year_start_seminar'];
			$acad_year_end = $q_em_data['acad_year_end_seminar'];
			$semester = $q_em_data['semester'];
			$s1_start = $q_em_data['s1_start'];
			$s1_end = $q_em_data['s1_end'];
			$s2_start = $q_em_data['s2_start'];
			$s2_end = $q_em_data['s2_end'];

		}

		$s1_start_plus30 = date("h:i A",strtotime("+30 minutes",$s1_start));
        $F_plus30 = strtotime($s1_start_plus30);

        $s2_start_plus30 = date("h:i A",strtotime("+30 minutes",$s2_start));
        $F2_plus30 = strtotime($s2_start_plus30);

        $q_check_session = $database->query("SELECT * FROM event_manager WHERE status = 'Active'");
		foreach($q_check_session AS $q_checkData){
			$no_session = $q_checkData['no_session'];
			$event_name = $q_checkData['event_name'];
		}
		if($no_session == 2){
			if($s1_timein <= $s1_start){
		       $s1_status = "On Time";
		     }elseif($s1_timein > $s1_start && $s1_timein <= $F_plus30){
		       $s1_status = "Late";
		     }
		     elseif($s1_timein > $F_plus30){
		        $s1_status = "Absent";
		     }

		     if($s2_timein <= $s2_start){
		      	$s2_status = "On Time";
		     }elseif($s2_timein > $s2_start && $s2_timein <= $F2_plus30){
		        $s2_status = "Late";
		     }
		     elseif($s2_timein > $F2_plus30){
		        $s2_status = "Absent";
		     }
		}elseif($no_session == 1){
			$s2_status = "- - -";
			$s2_timein = "0";
			$s2_end = "0";
		}

		

		
		$seminar_date =  date("Y-m-d");

	 $table_sa = "seminar_attended";
	 $column_sa = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start,"acad_year_end"=>$acad_year_end,
	 "semester"=>$semester,"s1_timein"=>$s1_timein,"s1_timeout"=>$s1_end,"s1_status"=>$s1_status,"event_id"=>$event_id,"batch_id"=>'0',"date_attended"=>$seminar_date];
	 $q_add = $database->insert($table_sa,$column_sa);

	  $table_sa2 = "seminar_attended_2";
	 $column_sa2 = ["stud_no"=>$stud_no,"acad_year_start"=>$acad_year_start,"acad_year_end"=>$acad_year_end,
	 "semester"=>$semester,"s2_timein"=>$s2_timein,"s2_timeout"=>$s2_end,"s2_status"=>$s2_status,"event_id"=>$event_id,"batch_id"=>'0',"date_attended"=>$seminar_date];
	 $q_add2 = $database->insert($table_sa2,$column_sa2);

		if($q_add == true && $q_add2 == true){
			
			echo "success";
		}else{
			echo "error";
		}
		//header("location:add_seminar_attended.php?success=1&stud_no=$stud_no&stud_name=$stud_name");
	}
?>