<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$datetime = date("F j, Y, g:i A");
$table = "messenger";
$columns = "messenger_id";
$messenger_id =$database->max($table,$columns) + 1;

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn']))
{
  $user_id_clicked = $_POST['user_id_clicked'];
  $message = $_POST['message'];
  $sender = $_POST['sender'];
  $receiver = $_POST['receiver'];

  $data = $database->insert("messenger",[
    "messenger_id" =>  $messenger_id,
    "message" =>  $message,
    "sender" =>  $sender,
    "receiver" =>  $receiver,
    "datetime" => $datetime,
    "message_status" => 'unread',
  ]);
  header("location: chatbox.php?user_id_clicked=$user_id_clicked");
}
elseif(isset($_POST['btn_comp']))
{
  $comp_id_clicked = $_POST['comp_id_clicked'];
  $message = $_POST['message'];
  $sender = $_POST['sender'];
  $receiver = $_POST['receiver'];

  $data = $database->insert("messenger",[
    "messenger_id" =>  $messenger_id,
    "message" =>  $message,
    "sender" =>  $sender,
    "receiver" =>  $receiver,
    "datetime" => $datetime,
    "message_status" => 'unread',
  ]);
  header("location: chatbox.php?comp_id_clicked=$comp_id_clicked");
}
elseif(isset($_POST['btn_comp_send']))
{
  $user_id_clicked = $_POST['user_id_clicked'];
  $message = $_POST['message'];
  $sender = $_POST['sender'];
  $receiver = $_POST['receiver'];

  $data = $database->insert("messenger",[
    "messenger_id" =>  $messenger_id,
    "message" =>  $message,
    "sender" =>  $sender,
    "receiver" =>  $receiver,
    "datetime" => $datetime,
    "message_status" => 'unread',
  ]);
  header("location: chatbox_company.php?user_id_clicked=$user_id_clicked");
}
elseif(isset($_POST['btn_send']))
{
  $comp_id_clicked = $_POST['comp_id_clicked'];
  $message = $_POST['message'];
  $sender = $_POST['sender'];
  $receiver = $_POST['receiver'];

  $data = $database->insert("messenger",[
    "messenger_id" =>  $messenger_id,
    "message" =>  $message,
    "sender" =>  $sender,
    "receiver" =>  $receiver,
    "datetime" => $datetime,
    "message_status" => 'unread',
  ]);
  header("location: chatbox_company.php?comp_id_clicked=$comp_id_clicked");
}
?>
