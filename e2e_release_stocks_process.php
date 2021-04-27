<?php

  session_start();
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection2.php';
  error_reporting(E_ALL | E_STRICT);
  


  
  
  if( isset($_POST['btn-release'])){
		
		$username =  mysqli_real_escape_string($dbc, trim($_POST['username']));
		$currentstock = mysqli_real_escape_string($dbc, trim($_POST['currentstock']));
		$releasestocks = mysqli_real_escape_string($dbc, trim($_POST['releasestocks']));
		$updatedstock = mysqli_real_escape_string($dbc, trim($_POST['updatedstock']));
		$currentconsumablestock = mysqli_real_escape_string($dbc, trim($_POST['currentconsumablestock']));
		$stcoks = mysqli_real_escape_string($dbc, trim($_POST['stocks']));
		
		if( $releasestocks <= $currentconsumablestock){
		
		$updatedstock = $currentconsumablestock - $releasestocks;
		
		
		$query3 = "UPDATE item_info SET stocks='$updatedstock'
			
			WHERE
		
			username='$username'";
		
		
		$query3 = "UPDATE item_info SET stocks='$updatedstock'
			
			WHERE
		
			username='$username'";	
		

	$result3 = mysqli_query($dbc,$query3);
		if($result3)
				{
					$userid = $_COOKIE["uid"];
					$action = $itemname ." ITEM RELEASED"; 
					$module = "RELEASE ITEM MODULE";
					
					$auditing = "INSERT INTO audit_trails(actiontaken ,user ,module )
								VALUES('$action' ,'$userid' ,'$module' )";
					$auditingresult = mysqli_query($dbc,$auditing);
					
					
					echo "Added";
					header("Location:e2e_consume.php?success=1");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}
	
		}
		
		
		else{
		
			?>
			
							<script>						
							alert("Invalid Input Quantity");
							window.location.replace('e2e_consume.php');
							</script>
							
							<?php
	}

  }


?>
