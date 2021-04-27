<?php
require_once "employee/function.php";
session_start();
require 'asset/connection/mysqli_dbconnection2.php';
include('db.php');
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
		$buyer = mysqli_real_escape_string($dbc, trim($_POST['buyer']));
		$date_buy = mysqli_real_escape_string($dbc, trim($_POST['date_buy']));
		$product = mysqli_real_escape_string($dbc, trim($_POST['product']));
		$new_item_qty =  mysqli_real_escape_string($dbc, trim($_POST['qty']));
		$new_item_cost =  mysqli_real_escape_string($dbc, trim($_POST['cost']));
		$total =  mysqli_real_escape_string($dbc, trim($_POST['total']));
		$query_name=mysqli_query($conn,"SELECT  * from products where product_price='$product'")or die(mysqli_error());
		$result_query = mysqli_fetch_array($query_name);
		$product_name=$result_query['product_name'];
		$product_qty=$result_query['product_qty'];
		$qty=$product_qty-$new_item_qty;


		$query3 = "INSERT INTO `sale`( `prepared_by`,`date_buyed`, `buyer`, `product`, `product_price`, `product_qty`, `product_total` ) 
		VALUES ('$username','$date_buy','$buyer','$product_name','$new_item_cost','$new_item_qty','$total')" ;
			
			
	$result3 = mysqli_query($dbc,$query3);
		if($result3)
				{
					$query_name=mysqli_query($conn,"UPDATE products set product_qty='$qty'  where product_price='$product'")or die(mysqli_error());
					$userid = $username;
					$action = $product ." Sale ITEM ADDED"; 
					$module = "SALE ITEM MODULE";
					
					$auditing = "INSERT INTO audit_trails(actiontaken ,user ,module )
								VALUES('$action' ,'$userid' ,'$module' )";
					$auditingresult = mysqli_query($dbc,$auditing);
					
					echo "Added";
					header("Location:print_sale.php?buyer=$buyer");
				}
			else	
			{
				echo "Query error. Please try again.."; 
			}	
}
?>