<?php 

require 'asset/connection/mysqli_dbconnection.php';

$username = $_GET['username'];
$comp_id = $_GET['comp_id'];
$q_email = "SELECT email FROM company_info WHERE comp_id='$comp_id' AND username='$username'";$r_email = mysqli_query($dbc, $q_email);if(mysqli_num_rows($r_email)>0){	$row = mysqli_fetch_assoc($r_email);	$email = $row['email'];}else{echo "Error";}
$q_reset_pass = "update company_info set password='$username' where username='$username'";
if($dbc->query($q_reset_pass) == true){
	
	
			
			$admin_email = "ojtassisti@sticaloocan.edu.ph";
			$subject="Welcome to OJT - assiSTI";
			$message="Welcome to OJT - assiSTI!
	Because of your partnership with STI Caloocan on hiring students for OJT program, we are pleased to inform you
that you are given an access to our website where you can send your comments about our students that is training in your company.
You may login using the link below with the credentials:
			
			
		USERNAME: ".$username."
		PASSWORD: ".$username."
			
	Link: http://sticaloocan.edu.ph/ojtassisti/backend/company_login.php
	Note: You may change your password upon logging in.
			
Sincerely,
OJT-assiSTI Team

----This email is system generated. Please do not reply----";
	
			mail($email, $subject, $message, "From:" . $admin_email);
			header("Location: update_comp_cont_info.php?comp_id=$comp_id&resend=ok");
}else{
echo 'error';
}

?>