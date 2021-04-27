<?php
			require 'asset/connection/mysqli_dbconnection.php';
			if(!isset($_COOKIE["uid"])) {
				header ("Location: login.php");
				exit;
			}
			if($_COOKIE["ut"] == 1) {
				header ("Location: admin_home.php");
				exit;
			} 
			if($_COOKIE["ut"] == 2) {
				$username = $_COOKIE['uid'];
				date_default_timezone_set('Asia/Manila');
				$login_time = time();
				$q_logtime = "update user set last_login='$login_time' where username='$username'";
				$q_logtime_res = $dbc->query($q_logtime);
				header ("Location: adviser_home.php");
				exit;
			}
			if($_COOKIE["ut"] == 3) {
				header ("Location: student_home.php");
				exit;
			}
		?>