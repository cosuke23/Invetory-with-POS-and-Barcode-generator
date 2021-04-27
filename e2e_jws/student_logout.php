<?php
	setcookie("stud_no", "", time() - 3600);
	header("Location: e2e_student_login.php");
	exit;
?>