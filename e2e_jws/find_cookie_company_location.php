<?php
	require 'asset/connection/mysqli_dbconnection.php';
	if(!isset($_COOKIE["cid"])) {
		header ("Location: e2e_company_login.php");
		exit;
	}else{
		header ("Location: e2e_company_home.php");
		exit;
	
	}
		
?>