<?php
session_id();
session_destroy();
	date_default_timezone_set('Asia/Manila');
	setcookie("sid", "", time() - 3600);
	header("Location: login.php");
	exit;
?>