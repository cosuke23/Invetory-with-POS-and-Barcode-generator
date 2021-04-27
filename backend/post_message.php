<?php
include "asset/connection/mysqli_dbconnection.php";
    //post message
    if(isset($_POST['message'])){
        $message = mysqli_real_escape_string($dbc, $_POST['message']);
        $conv_id = mysqli_real_escape_string($dbc, $_POST['id']);
        $user = mysqli_real_escape_string($dbc, $_POST['user']);
        
		date_default_timezone_set("Asia/Manila");
		$timestamp = time();
        
		//insert into conversation_data
        $q = mysqli_query($dbc, "INSERT INTO conversations_data(id, message, sender, timestamp, notified, read_status) VALUES ('$conv_id','$message','$user','$timestamp', '0', 'unread')");
        if($q){
            echo "Sent";
        }else{
            echo "Message not sent";
        }
    }
?>