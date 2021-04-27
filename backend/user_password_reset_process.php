<html>
<body>
<?php
	$user="root";
	$pass="";
	$db="e2e_ojtassisti";
	$con=mysqli_connect('localhost',$user,$pass,$db);
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username=$_GET['username'];
	$nwpass = $_POST['nwpass'];
	
	$q_updatepass = "update user set password='$nwpass' where username='$username'";
	$q_updatepass_res = $con->query($q_updatepass);
	if($q_updatepass_res == TRUE){
		//echo "your password has been reset!";
		$q_deleteUpdated ="delete from forget_password_handler where user_id='$username'";
		$q_deleteUpdated_res = $con->query($q_deleteUpdated);
		header("Location: login.php");
	}
	}
?>

</body>
</html>