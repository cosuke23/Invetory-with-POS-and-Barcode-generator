<?php
		include('db.php');
		session_start();
		$username = $_POST['username'];
		$password = $_POST['password'];
		/* student */
		
				/* Admin */
		$query_admin = mysql_query("SELECT * FROM admin WHERE Username='$username' AND Password='$password'")or die(mysql_error());
		$num_row_admin = mysql_num_rows($query_admin);
		$row_admin = mysql_fetch_array($query_admin);
		
		
		 if($num_row_admin > 0){
			 $_SESSION['id']=$row_admin['Id'];	
			 echo 'true_admin';
			 
		 }
		 else{ 
				echo 'false';
		}	
				
		?>