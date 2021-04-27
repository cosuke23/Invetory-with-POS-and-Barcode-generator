<?php
require_once "employee/function.php";
session_start();
require 'asset/connection/mysqli_dbconnection2.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
error_reporting(E_ALL | E_STRICT);

function generateId($con, $item_id, $item_info) {
    $query = "SELECT $item_id FROM products";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if($num <= 0) {
        $item_id = 1;
        return $item_id;
    } else {
        $query1 = "SELECT MAX($item_id) FROM products";
        $result1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_array($result1, MYSQLI_NUM);
        $item_id = $row1[0] - 1;
        return $item_id;
    }
}

if(isset($_POST['btn_add_item_info'])) {

		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$date_buy = mysqli_real_escape_string($dbc, trim($_POST['date_buy']));
		$or = mysqli_real_escape_string($dbc, trim($_POST['or']));		
		$itemname =  mysqli_real_escape_string($dbc, trim($_POST['itemname']));
		$crit =  mysqli_real_escape_string($dbc, trim($_POST['crit']));
		$unit =  mysqli_real_escape_string($dbc, trim($_POST['unit']));		
		$category=  mysqli_real_escape_string($dbc, trim($_POST['category']));
		$itemdesc =  mysqli_real_escape_string($dbc, trim($_POST['itemdesc']));
		$status = mysqli_real_escape_string($dbc, trim("With Stocks"));
		$itemtype =  mysqli_real_escape_string($dbc, trim($_POST['itemtype']));
		$new_item_qty =  mysqli_real_escape_string($dbc, trim($_POST['qty']));
		$new_item_cost =  mysqli_real_escape_string($dbc, trim($_POST['cost']));
		$total =  mysqli_real_escape_string($dbc, trim($_POST['total']));				 $barcode = generateBarcode($data = array('mrp'=>$or, 'sku'=>$itemname, 'model'=>$itemdesc), 'tmp');
			
		$query3 = "INSERT INTO products
		(
			 `product_name`, `product_qty`, `crit_level`, `product_price`, `total`, `date_buyed`, `product_size`, `product_type`,`barcode`,status
			)
			
			VALUES
			
		(
			
			'$or' ,
			'$new_item_qty' ,
			'$crit' ,
			'$new_item_cost' ,
			'$total' ,
			'$date_buy' ,
			'$itemtype' ,
			'$status','$barcode',
			'Active' )";
			
			
	$result3 = mysqli_query($dbc,$query3);
		if($result3)
				{
					
					$userid = $_COOKIE["sid"];
					$action = $itemname ." NEW ITEM ADDED"; 
					$module = "ADD ITEM MODULE";
					
					$auditing = "INSERT INTO audit_trails(actiontaken ,user ,module )
								VALUES('$action' ,'$userid' ,'$module' )";
					$auditingresult = mysqli_query($dbc,$auditing);
					
					echo "Added";
					header("Location:e2e_stocks.php?add_item_name=$itemname");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}	
}
?>