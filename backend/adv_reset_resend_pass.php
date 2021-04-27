<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

$username = $_GET['username'];
//update the password back to default,, which means it is the same as the username.
$q_reset_pass = "update user set password='$username' where username='$username'";
if($dbc->query($q_reset_pass) == true){
		$q_getemail = "select * from adviser_info where adviser_id='$username'";
		$q_getemail = $dbc->query($q_getemail);
		$row = $q_getemail->fetch_assoc();
		//------Email user/pass
			$email = $row['email'];
			$admin_email = "no-reply@sticaloocan.edu.ph";
			$subject="Welcome to OJT - assiSTI";
			$message="Welcome to OJT - assiSTI!
	Your password has been reset. You may now access our website as an OJT adviser to monitor your students.
You may login using the link below with the credentials:
			
		USERNAME: ".$username."
		PASSWORD: ".$username."
			
	Link: http://sticaloocan.edu.ph/ojtassisti/backend/login.php
	Note: You may change your password upon logging in.
			
Sincerely,
OJT-assiSTI Team

----This email is system generated. Please do not reply----";
	
			mail($email, $subject, $message, "From:" . $admin_email);
			//---- end email function
header("Location: update_OJT_adviser.php?adviser_id=$username&resend=ok");
}else{
echo 'error';
}

?>