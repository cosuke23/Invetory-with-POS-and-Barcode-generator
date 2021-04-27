<?php
		include('dbcon.php');
		session_start();
		$username = $_POST['username'];

		$query = mysql_query("SELECT * FROM admin WHERE username='$username' ")or die(mysql_error());
		$count = mysql_num_rows($query);
		$row = mysql_fetch_array($query);
		$check=$row['position'];


		if ($count > 0 && $check=="primary"){
		
		$_SESSION['id']=$row['id'];
		
		echo 'true';
		
		 }else if($count > 0 && $check=="creator"){ 
		 	$_SESSION['id']=$row['id'];
		echo 'main';
		}else{
			echo 'false';
		}	
				
		?>