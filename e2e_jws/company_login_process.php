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

		    $table = "company_info";
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
               $comp_id = $sql_data['comp_id'];
               $Event_em = $database->query("SELECT * FROM event_manager where status = 'Active'");
				foreach($Event_em  AS $em_data){
					$event_id = $em_data['event_id'];
				}
				$table = "nop_job_fair";
				$columns = "*";
				$where = ["AND"=>["comp_id"=>$comp_id,"event_id"=>$event_id]];
				$q_data = $database->count($table,$columns,$where);
				if($q_data == ""){
					echo "You are not allowed to log in.";
					exit;
				}
              if($sql_data['status'] == 'Active')
				{
					$comp_id = $sql_data['comp_id'];
					setcookie('cid',$sql_data['comp_id'],time() + 86400);
					setcookie('username',$sql_data['username'],time() + 86400);

					$tbl = "audit_trail";
					$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Login","module"=>"Login Module"];
					$q_data = $database->insert($tbl,$columns);
					$q_update = $database->query("UPDATE nop_job_fair set chat_status = 'online' Where comp_id = '$comp_id'")->fetchAll();
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
