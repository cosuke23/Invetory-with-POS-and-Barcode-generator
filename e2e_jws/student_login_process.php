<?php
// Start the session..
//session_start();

// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

date_default_timezone_set("Asia/Manila");
$date_today =  date("Y-m-d");

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn-login']))
	{
		//$user_id = $_POST['user_id'];
		$username = $_POST['validate_username'];
		$password = $_POST['validate_password'];
		
				$table = "student_info";
				$columns = ["si_id","stud_no","password"];
				$where = ["AND"=>
								[
								 "stud_no"=>$username,
								 "password"=>$password
								]
						];

             $sql=$database->select($table,$columns,$where);
             
             foreach ($sql as $sql_data)
             {
             				$si_id =$sql_data['si_id'];
							if($sql_data["si_id"]==$si_id)
							{	setcookie('stud_no',$sql_data['stud_no'],time() + 86400);
								echo "ok";
								exit;
							}
							
							elseif($sql_data['stud_no'] != $username && $sql_data['password'] != $password)
							{
							setcookie('error','1',time() + 86400);
							echo "Username or Password incorrect.";
							exit;		
						}
             }	
	}
?>