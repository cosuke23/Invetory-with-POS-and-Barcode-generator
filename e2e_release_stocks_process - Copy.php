<?php

  session_start();
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection2.php';
  error_reporting(E_ALL | E_STRICT);
  
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }


  if( isset($_POST['btn-return'])){
		
		$username =  mysqli_real_escape_string($dbc, trim($_POST['username']));
		$currentstock = mysqli_real_escape_string($dbc, trim($_POST['currentstock']));
		$borrowstocks = mysqli_real_escape_string($dbc, trim($_POST['borrowstocks']));
		$updatedstock = mysqli_real_escape_string($dbc, trim($_POST['updatedstock']));
		$returnstocks = mysqli_real_escape_string($dbc, trim($_POST['returnstocks']));
		$borrowedqty = mysqli_real_escape_string($dbc, trim($_POST['borrowedqty']));
		$stcoks = mysqli_real_escape_string($dbc, trim($_POST['stocks']));
		$returnee = mysqli_real_escape_string($dbc, trim($_POST['returnee']));
		
		
		if($borrowstocks>=$currentstock){

		
		$sql = "SELECT borrowed FROM item_info where username='$username'";
		$result = mysqli_query($dbc, $sql);

				if (mysqli_num_rows($result) > 0)
					{
					// output data of each row
						while($row = mysqli_fetch_assoc($result)) {
						  
						  $stocks= $row["borrowed"]; 
						  echo $stocks;
						}
					} 
				
				else {
					echo "0 results";
				}
		
		
		$updatedborrowstock = $returnstocks + $currentstock;
		$borrowstocks=0;
		//$updatedborrowstocks = $borrowstocks + $stocks;
		
		
		$query3 = "UPDATE item_info SET stocks='$updatedstock', borrowed='$updatedborrowstocks'
			
			WHERE
		
			username='$username'";

	$result3 = mysqli_query($dbc,$query3);
		if($result3)
				{
					echo "Added";
					header("Location:e2e_consume.php?success=1");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}
		}
		
		else{
			echo "Invalid Input";
			//header("Location:e2e_release_stocks_process.php");
		}


  }
    


?>
