<?php
	require 'asset/connection/mysqli_dbconnection.php';
	if(!isset($_COOKIE["sid"])) {
		header ("Location: e2e_company_mi_login.php");
		exit;
	}else{
		header ("Location: e2e_scheduled_interviewees.php");
		exit;
	
	}
		
?>