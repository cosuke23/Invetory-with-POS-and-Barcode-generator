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
		$username = trim($_POST['validate_username']);
		$password = trim($_POST['validate_password']);
		
		
			/*$query1 = "SELECT user_id FROM user WHERE username = '$username' and password = '$password'";
		
		$result = mysqli_query($dbc,$query1);
		if(mysqli_num_rows($result)>0)
				{
					$row = mysqli_fetch_assoc($result);
					$user_id = $row["user_id"];
					$_SESSION['user_session'] = $row['user_id'];
					echo "ok";
				}
				
			else	
			{
				echo "login failed please try again.."; 
			}*/
			
				$sql = $dbc->query("SELECT * FROM user WHERE BINARY username = '$username' AND BINARY password = '$password'");
						//$sqlcua = $conn->query("SELECT * FROM user WHERE BINARY username = '$username' AND BINARY password = '$password'");
						if($sql->num_rows != 0) {
							$row = $sql->fetch_assoc();
							if($row['usertype']==1)
							{	
								
								setcookie('uid',$row["username"],time() + 86400);
								setcookie('ut',1,time() + 86400);
								
								echo "ok";
								exit;
							}

							$sql = $dbc->query("SELECT * FROM user WHERE BINARY username = '$username' AND BINARY password = '$password'");
						//$sqlcua = $conn->query("SELECT * FROM user WHERE BINARY username = '$username' AND BINARY password = '$password'");
						
							$row = $sql->fetch_assoc();
							if($row['usertype']==3||$row['usertype']==4||$row['usertype']==5)
							{	
								
								setcookie('uid',$row["username"],time() + 86400);
								setcookie('ut',1,time() + 86400);
								
								echo "ok";
								exit;
							}

							if($row['usertype']==2)
							{
								$sql2 = $dbc->query("SELECT * FROM adviser_info WHERE adviser_id='$username'");
								if($sql2->num_rows !=0)
								{
									$row2 = $sql2->fetch_assoc();
									if($row2['status']=="Active")
									{										
										
										setcookie('uid',$row["username"],time() + 86400);
										setcookie('ut',$row["usertype"],time() + 86400);
										//header ("Location: adviser_home.php");
										echo "ok";
										exit;
									}
									else
									{
										echo "Account you tried to login is not active.";
										exit;
									}
								}
							}
						}
						else {
							setcookie('error','1',time() + 86400);
							//header ("Location: login.php");
							echo "Username or Password incorrect.";
							exit;		
						}
	
			
	}
?>