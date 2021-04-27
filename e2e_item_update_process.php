<?php

  session_start();
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection2.php';
  error_reporting(E_ALL | E_STRICT);
 

  if( isset($_POST['btn-update'])){
		
		$username =  mysqli_real_escape_string($dbc, trim($_POST['username']));
		$itemname =  mysqli_real_escape_string($dbc, trim($_POST['itemname']));
		$itemtype =  mysqli_real_escape_string($dbc, trim($_POST['itemtype']));	
		$qty =  mysqli_real_escape_string($dbc, trim($_POST['qty']));		
		$unit =  mysqli_real_escape_string($dbc, trim($_POST['unit']));		
		$status=  mysqli_real_escape_string($dbc, trim($_POST['status']));
		$category=  mysqli_real_escape_string($dbc, trim($_POST['category']));
		$itemdesc =  mysqli_real_escape_string($dbc, trim($_POST['itemdesc']));
		
		$query3 = "UPDATE products SET
		
			product_name='$itemname' ,
			product_type='$itemtype' ,
			product_size='$unit',
			product_qty='$qty'
			
			WHERE
		
			product_id='$username'";


	$result3 = mysqli_query($dbc,$query3);
		if($result3)
				{
					
					$userid = $_COOKIE["uid"];
					$action = $itemname ." ITEM UPDATED"; 
					$module = "UPDATE ITEM MODULE";
					
					$auditing = "INSERT INTO audit_trails(actiontaken ,user ,module )
								VALUES('$action' ,'$userid' ,'$module' )";
					$auditingresult = mysqli_query($dbc,$auditing);
					
					
					echo "Added";
					header("Location:e2e_stocks.php?success=1");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}	


  }
    


?>
