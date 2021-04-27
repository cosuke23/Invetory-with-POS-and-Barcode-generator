<?php
// Start the session..
session_start();

// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';
include('db.php');
date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");

//Show all possible problems..
//error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn-login']))
	{
		$stud_no =$_POST['stud_no'];
		$password =$_POST['password'];
	//	$password_final = crypt($password_pre, '$2a$12$xyYidadDvFewdFQZFIcDDs');
		$user_query = mysqli_query($conn,"SELECT * from user where username = '$stud_no' and password='$password'")or die(mysqli_error());
$user_row = mysqli_fetch_array($user_query);
$num_rows= mysqli_num_rows($user_query);
				if($num_rows != 0) 
				{
					
					if($user_row['user_level']==1)
					{
						$_SESSION['user_id']=$user_row['user_id'];
						header("Location: admin/dashboard/index.php");
						exit;
					}
					else
					{
					$_SESSION['user_id']=$user_row['user_id'];
						header("Location: home.php");
						exit;
					}
				}
				else
				{
					header("Location: login.php?stud_no=$stud_no&error=13");
					exit;
				}
	
	}
	else{
		header("Location: login.php?stud_no=$stud_no&error=11");
					exit;
	}
?>
