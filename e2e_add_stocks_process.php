<?php

  session_start();
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection2.php';
  error_reporting(E_ALL | E_STRICT);
  
 

  if( isset($_POST['btn-add'])){
		
		$code =  mysqli_real_escape_string($dbc, trim($_POST['code']));
		$currentstock = mysqli_real_escape_string($dbc, trim($_POST['currentstock']));
		$addstocks = mysqli_real_escape_string($dbc, trim($_POST['addstocks']));
		$updatedstock = $currentstock + $addstocks;
		
		$query3 = "UPDATE products SET product_qty='$updatedstock'
			
			WHERE
		
			product_id='$code'";

	$result3 = mysqli_query($dbc,$query3);
		if($result3)
				{
					
					$userid = $_COOKIE["uid"];
					$action = $itemname ." STOCKS ADDED"; 
					$module = "ADD ITEM STOCKS MODULE";
					
				//	$auditing = "INSERT INTO audit_trails(actiontaken ,user ,module )
				//				VALUES('$action' ,'$userid' ,'$module' )";
				//	$auditingresult = mysqli_query($dbc,$auditing);
					
					echo "Added";
					header("Location:e2e_stocks.php?success=1");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}	


  }
    


?>
