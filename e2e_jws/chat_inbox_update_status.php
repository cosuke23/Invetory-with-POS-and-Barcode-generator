<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_GET['sender'])){
	$sender = $_GET['sender'];
	$tbl = "user_info";
	$col = "*";
	$wh = ["username"=>$sender];
	$q_user = $database->select($tbl,$col,$wh);

	foreach($q_user AS $q_user_data){
		$user_id = $q_user_data["user_id"];

		$tbl2 = "messenger";
		$col2 = "*";
		$wh2 = ["sender"=>$sender];
		$q_mes = $database->select($tbl2,$col2,$wh2);

		foreach($q_mes AS $q_mes_data){
			$messenger_id = $q_mes_data["messenger_id"];
			$col3 = ["message_status" => 'read'];
		    $wh3 = ["messenger_id" => $messenger_id];
		    $q_update = $database->update($tbl2,$col3,$wh3);
		}
	}
	header("location: chatbox.php?user_id_clicked=$user_id");
}
elseif(isset($_GET['staff'])){
	$staff = $_GET['staff'];
	$tbl = "user_info";
	$col = "*";
	$wh = ["username"=>$staff];
	$q_user = $database->select($tbl,$col,$wh);

	foreach($q_user AS $q_user_data){
		$user_id = $q_user_data["user_id"];

		$tbl2 = "messenger";
		$col2 = "*";
		$wh2 = ["sender"=>$staff];
		$q_mes = $database->select($tbl2,$col2,$wh2);

		foreach($q_mes AS $q_mes_data){
			$messenger_id = $q_mes_data["messenger_id"];
			$col3 = ["message_status" => 'read'];
		    $wh3 = ["messenger_id" => $messenger_id];
		    $q_update = $database->update($tbl2,$col3,$wh3);
		}
	}
	header("location: chatbox_company.php?user_id_clicked=$user_id");
}
elseif(isset($_GET['sender_comp'])){
	$sender_comp = $_GET['sender_comp'];
	$tbl = "company_info";
	$col = "*";
	$wh = ["username"=>$sender_comp];
	$q_comp = $database->select($tbl,$col,$wh);

	foreach($q_comp AS $q_comp_data){
		$comp_id = $q_comp_data["comp_id"];

		$tbl2 = "messenger";
		$col2 = "*";
		$wh2 = ["sender"=>$sender_comp];
		$q_mes = $database->select($tbl2,$col2,$wh2);

		foreach($q_mes AS $q_mes_data){
			$messenger_id = $q_mes_data["messenger_id"];
			$col3 = ["message_status" => 'read'];
		    $wh3 = ["messenger_id" => $messenger_id];
		    $q_update = $database->update($tbl2,$col3,$wh3);
		}
	}
	header("location: chatbox.php?comp_id_clicked=$comp_id");
}
elseif(isset($_GET['comp'])){
	$comp = $_GET['comp'];
	$tbl = "company_info";
	$col = "*";
	$wh = ["username"=>$comp];
	$q_comp = $database->select($tbl,$col,$wh);

	foreach($q_comp AS $q_comp_data){
		$comp_id = $q_comp_data["comp_id"];

		$tbl2 = "messenger";
		$col2 = "*";
		$wh2 = ["sender"=>$comp];
		$q_mes = $database->select($tbl2,$col2,$wh2);

		foreach($q_mes AS $q_mes_data){
			$messenger_id = $q_mes_data["messenger_id"];
			$col3 = ["message_status" => 'read'];
		    $wh3 = ["messenger_id" => $messenger_id];
		    $q_update = $database->update($tbl2,$col3,$wh3);
		}
	}
	header("location: chatbox_company.php?comp_id_clicked=$comp_id");
}
?>