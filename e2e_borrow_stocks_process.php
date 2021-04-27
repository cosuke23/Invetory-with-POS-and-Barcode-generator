<?php

  session_start();
  date_default_timezone_set("Asia/Manila");
  $date_today =  date("Y-m-d"); 
  require 'asset/connection/mysqli_dbconnection2.php';
  error_reporting(E_ALL | E_STRICT);



  if( isset($_POST['btn-borrow'])){
		
		$item_id = mysqli_real_escape_string($dbc, trim( $_POST['item_id']));
		$currenborrowtstock = mysqli_real_escape_string($dbc, trim($_POST['currenborrowtstock']));
		$borrowstocks = mysqli_real_escape_string($dbc, trim($_POST['borrowstocks']));
		$stocks=0;
		$date_return = mysqli_real_escape_string($dbc, trim($_POST['date_return']));
		$remarks = mysqli_real_escape_string($dbc, trim($_POST['remarks']));
		$department = mysqli_real_escape_string($dbc, trim($_POST['department']));
		$borrower = mysqli_real_escape_string($dbc, trim($_POST['borrower']));
		$itemtype = mysqli_real_escape_string($dbc, trim($_POST['itemtype']));
		$itemname = mysqli_real_escape_string($dbc, trim($_POST['itemname']));
		$category = mysqli_real_escape_string($dbc, trim($_POST['category']));
		 echo $item_id;
		if($borrowstocks<=$currenborrowtstock){
			$updatedstock = $currenborrowtstock - $borrowstocks;
		
		$sql = "SELECT borrowed FROM item_info where item_id='$item_id'";
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
		
		$updatedborrowstocks = $borrowstocks+$stocks;
		
		
		$query3 = "UPDATE item_info SET stocks='$updatedstock', borrowed='$updatedborrowstocks'
			
			WHERE
		
			item_id='$item_id'";
			

	$result3 = mysqli_query($dbc,$query3);
		if($result3)
				{


echo "Added";
					header("Location:e2e_borrow.php?success=11");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}	

	$date_today =  date("Y-m-d");
	$query4 = "INSERT into borrow (item_id,itemname,itemtype,category,borrower,borrow_date,date_return,remarks,department,borrow_qty) Values('$item_id','$itemname','$itemtype','$category','$borrower','$date_today','$date_return','$remarks','$department','$borrowstocks')";

	$result4 = mysqli_query($dbc,$query4);
		if($result4)
				{
					
					$userid = $_COOKIE["sid"];
					$action = $itemname ." ITEM BORROWED"; 
					$module = "BORROW ITEM MODULE";
					
					$auditing = "INSERT INTO audit_trails(actiontaken ,user ,module )
								VALUES('$action' ,'$userid' ,'$module' )";
					$auditingresult = mysqli_query($dbc,$auditing);
					
					
					echo "Added";
					header("Location:e2e_borrow.php?success=12");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}	
		}
		
		
		
			else{
				
					?>
					<?php
				?>
							<script>						
							alert("Invalid Input Quantity");
							window.location.replace('e2e_borrow.php');
							</script>
							
							<?php
			
			
		}
  }
  

 

?>
