<?php
// Start the session..
//session_start();

// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn-login']))
	{
		//$user_id = $_POST['user_id'];
		$username = $_POST['validate_username'];
		$password = $_POST['validate_password'];
		
	    $table = "tbl_interviewer";
        $columns = "*";
       	$where = ["AND"=>
							[
							 "username"=>$username,
							 "password"=>$password
							]
					];

        $sqlA=$database->get($table,$columns,$where);
        
        setcookie('miid',$sqlA['interviewer_id'],time() + 86400);
		setcookie('username',$sqlA['username'],time() + 86400);	
		echo "ok";
		
		exit;	

		// if(!$sql){
		// 	echo "Incorrect Username Password";	
		// }		
	}
?>
