<?php
require 'asset/connection/mysqli_dbconnection.php';
require 'default_dp.php';
require 'default_cover.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");

if(isset($_POST['btn_add_item_info']))
	{
		$position = $_POST['position'];
		$status =  "Active";
		$username =  $_POST['username'];
		$usertype =  $_POST['position'];
		$lname =  ucwords(ucfirst($_POST['lname']));
		$fname =  ucwords(ucfirst($_POST['fname']));
		$mname =  ucwords(ucfirst($_POST['mname']));
		$address =  ucwords(ucfirst($_POST['address']));
		$email =  $_POST['email'];
		$title = $_POST['title'];
		$contact_no =  $_POST['contact_no'];

			$table = "user_info";
			$columns = ["status"=>$status,"usertype"=>$position,"lname"=>$lname,"fname"=>$fname,"mname"=>$mname,"contact_no"=>$contact_no,"email"=>$email,"address"=>$address,"username"=>$username,"password"=>$username,"profileData"=>$default_dp,"coverData"=>$default_cover,"title"=>$title];
			$q_data = $database->insert($table,$columns);

			$username = $_COOKIE['username'];
			$tbl = "audit_trail";
			$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Add User : ".$username."","module"=>"User Account Module"];
			$q_data = $database->insert($tbl,$columns);

			header("Location: e2e_user_account.php?success2=1&user_no=$username");

			if($q_data == true){
				echo "true";
			}else{
				echo "false";
			}
	}
?>