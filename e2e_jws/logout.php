<?php
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
	$username = $_COOKIE['username'];
	$tbl = "audit_trail";
	$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Logout","module"=>"Logout Module"];
	$q_data = $database->insert($tbl,$columns);
	
	$user_id = $_COOKIE['uid'];
	$tbl = "user_info";
	$col= ["chat_status"=>"offline"];
	$where = ["user_id"=>$user_id];
	$q_update = $database->update($tbl,$col,$where);
	
	setcookie("uid", "", time() - 3600);
	setcookie("ut", "", time() - 3600);
	header("Location: e2e_login.php");
	exit;
?>