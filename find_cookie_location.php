<?php
	require 'asset/connection/mysqli_dbconnection.php';
	if(!isset($_COOKIE["sid"])) {
		header ("Location: e2e_login.php");
		exit;
	}else{
		header ("Location: e2e_admin_home.php");
		exit;
	
	}
		
?>