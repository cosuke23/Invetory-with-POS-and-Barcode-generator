<?php
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
if(isset($_POST['btn_update_item_info']))
	{
		$user_id =  $_POST['user_id'];
		$position = $_POST['position'];
		$status =  $_POST['status'];
		$username =  $_POST['username'];

			$table = "user_info";
			$columns = ["status"=>$status,"usertype"=>$position];
			$where = ["user_id" => $user_id];
			$q_data = $database->update($table,$columns,$where);

			$username = $_COOKIE['username'];
			$tbl = "audit_trail";
			$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Update User : ".$username."","module"=>"User Account Module"];
			$q_data = $database->insert($tbl,$columns);

			header("Location: e2e_user_account.php?success=1&user_no=$username");

			if($q_data == true){
				echo "true";
			}else{
				echo "false";
			}
	}
?>