<?php

  session_start();
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection2.php';
  error_reporting(E_ALL | E_STRICT);
  
include('session.php');
  
  if(isset($_GET['Item_Number'])){
		$username =  mysqli_real_escape_string($dbc, trim($_GET['Item_Number']));
		$query = "DELETE FROM products WHERE product_id='$username'";
		
		
		$result3 = mysqli_query($dbc,$query);
		if($result3>0)
				{
					
					$userid = $_COOKIE["uid"];
					$action = $itemname ." ITEM DELETED"; 
					$module = "DELETE ITEM MODULE";
					//
					//$auditing = "INSERT INTO audit_trails(actiontaken ,user ,module )
					//			VALUES('$action' ,'$userid' ,'$module' )";
				//	$auditingresult = mysqli_query($dbc,$auditing);
					
					echo "Deleted";
					header ("Location: e2e_stocks.php?delete_item=success&&username=".$username."");
				}
			else {
				echo "Error";
			}				
  }
?>