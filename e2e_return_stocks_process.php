<?php

  session_start();
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection2.php';
  error_reporting(E_ALL | E_STRICT);
  



  if( isset($_POST['btn-return'])){
		
		$username =  mysqli_real_escape_string($dbc, trim($_POST['username']));
		$currentborrowstock = mysqli_real_escape_string($dbc, trim($_POST['currentborrowstock']));
		$returnqtystocks = mysqli_real_escape_string($dbc, trim($_POST['returnqtystocks']));
		//$borrowedstocks=0;
		$borrow_qty = mysqli_real_escape_string($dbc, trim($_POST['borrowedqty']));
		$borrow_id =  mysqli_real_escape_string($dbc, trim($_POST['borrow_id']));
		$returnee = mysqli_real_escape_string($dbc, trim($_POST['returnee']));
	//	$updatedstock = mysqli_real_escape_string($dbc, trim($_POST['updatedstock']));
		
		if( $returnqtystocks<=$borrow_qty ) {
			

		echo "<br>";
		$sql = "SELECT borrowed FROM item_info where username='$username'";
		$result = mysqli_query($dbc, $sql);

				if (mysqli_num_rows($result) > 0)
					{
					// output data of each row
						while($row = mysqli_fetch_assoc($result)) {
						  
						  $borrowedstocks= $row["borrowed"]; 
						  
						//  echo $borrowedstocks;
						  
						  
						}
					} 
			/*	if(	$returnqtystocks = $borrowedqty){
					$newstock=0;
				}else if($returnqtystocks > $borrowedqty){
					echo '<script> ';
					echo 'alert(error)';
					echo '</script> ';
					
				}else{
		$newstock =  $returnqtystocks - $borrowedqty  ;
		$updatedstock =$currentborrowstock + $returnqtystocks;
				}
				*/
					
					$newstock =  $borrow_qty - $returnqtystocks;
		$updatedstock = $currentborrowstock + $returnqtystocks;
		//$currentborrowstock = $updatedstock;
	 //   echo $updatedstock;
	//	echo $updatedborrowstocks;
	
	{
		$query3 = "UPDATE item_info SET stocks='$updatedstock', borrowed='$newstock'
			
			WHERE
		
			username='$username'";

	$result3 = mysqli_query($dbc,$query3);
		if($result3)
				{
					
					$userid = $_COOKIE["uid"];
					$action = $itemname ." ITEM RETURNED"; 
					$module = "RETURN ITEM MODULE";
					
					$auditing = "INSERT INTO audit_trails(actiontaken ,user ,module )
								VALUES('$action' ,'$userid' ,'$module' )";
					$auditingresult = mysqli_query($dbc,$auditing);
					
					echo "returned";
					header("Location:e2e_borrow.php?success=11");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}	
$date_today =  date("Y-m-d");
$query4 = "UPDATE borrow SET date_return='$date_today',borrow_qty='$newstock',returnee='$returnee'
			
			WHERE
		
			borrow_id='$borrow_id'";

	$result4 = mysqli_query($dbc,$query4);
		if($result4)
				{
					echo "returned";
					header("Location:e2e_borrow.php?success=1");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}	



		
	}
	
		}
	else{
		
				?>
							<script>						
							alert("Invalid Input Quantity");
							window.location.replace('e2e_borrow.php');
							</script>
							
							<?php
	}
		
		


  }
    


?>
