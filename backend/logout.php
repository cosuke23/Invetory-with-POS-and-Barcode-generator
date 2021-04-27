<?php

	setcookie("uid", "", time() - 3600);

	setcookie("ut", "", time() - 3600);

	header("Location: login.php");

	exit;

?>