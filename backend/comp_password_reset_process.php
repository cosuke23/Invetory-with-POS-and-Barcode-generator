<html>
<body>
<?php
	$user="root";
	$pass="";
	$db="e2e_assisti";
	$con=mysqli_connect('localhost',$user,$pass,$db);
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username=$_GET['username'];
	$nwpass = $_POST['nwpass'];
	
	$q_updatepass = "update company_info set password='$nwpass' where username='$username'";
	$q_updatepass_res = $con->query($q_updatepass);
	if($q_updatepass_res == TRUE){
		$message = "Your password has been reset!";
               
		$q_deleteUpdated ="delete from forget_password_handler where user_id='$username'";
		$q_deleteUpdated_res = $con->query($q_deleteUpdated);
		 header("Location: company_login.php?message=$message");
	}
	}
?>

</body>
</html>	