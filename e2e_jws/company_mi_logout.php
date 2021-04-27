<?php
require 'asset/connection/mysqli_dbconnection.php';
	
	$comp_id = $_COOKIE['cid'];
	$tbl = "nop_job_fair";
	$col= ["chat_status"=>"offline"];
	$where = ["comp_id"=>$comp_id];
	$q_update = $database->update($tbl,$col,$where);
	
	setcookie("miid", "", time() - 3600);
	setcookie("username", "", time() - 3600);
	header("Location: e2e_company_mi_login.php");
	exit;
?>