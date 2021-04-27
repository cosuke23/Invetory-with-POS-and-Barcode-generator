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
		
		    $table = "user_info";
            $columns = "*";
           	$where = ["AND"=>
								[
								 "username"=>$username,
								 "password"=>$password
								]
						];

            $sql=$database->select($table,$columns,$where);
             
			foreach ($sql as $sql_data)
             {

              if($sql_data['status'] == 'Active')
				{
					$user_id = $sql_data['user_id'];
					setcookie('uid',$sql_data['user_id'],time() + 86400);
					setcookie('username',$sql_data['username'],time() + 86400);

					$tbl = "audit_trail";
					$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Login","module"=>"Login Module"];
					$q_data = $database->insert($tbl,$columns);

					$q_update = $database->query("UPDATE user_info set chat_status = 'online' Where user_id = '$user_id'")->fetchAll();
					echo "ok";
					exit;		
				}
				elseif($sql_data['status'] == 'Not Active')
				{
					setcookie('error','1',time() + 86400);
					echo "Your Account is Not Active.";
					exit;		
				}
             }	
			  echo "Incorrect Username Password";	
			}
?>
