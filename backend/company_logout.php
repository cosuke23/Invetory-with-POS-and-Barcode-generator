<?php



setcookie("cid", "", time() - 3600);

header ("Location: company_login.php");

exit;



?>