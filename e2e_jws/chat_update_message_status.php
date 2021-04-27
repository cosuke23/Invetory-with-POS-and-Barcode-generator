<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_GET['user_id_clicked'])){
  $user_id_clicked = $_GET['user_id_clicked'];
  $tbl = "user_info";
  $col = "*";
  $wh = ["user_id" => $user_id_clicked];
  $q_user = $database->select($tbl,$col,$wh);

  foreach($q_user AS $q_user_data){
    $username = $q_user_data["username"];
    $tbl2 = "messenger";
    $col2 = "*";
    $wh2 = ["sender" => $username];
    $q_mes = $database->select($tbl2,$col2,$wh2);

    foreach($q_mes AS $q_mes_data){
      $messenger_id = $q_mes_data["messenger_id"];
      $col3 = ["message_status" => 'read'];
      $wh3 = ["messenger_id" => $messenger_id];
      $q_update = $database->update($tbl2,$col3,$wh3);
    }
  }
  header("location: chatbox.php?user_id_clicked=$user_id_clicked");
}

elseif(isset($_GET['comp_id_clicked'])&&isset($_GET['sender_user'])){
  $comp_id_clicked = $_GET['comp_id_clicked'];
  $sender_user = $_GET['sender_user'];
  $tbl = "company_info";
  $col = "*";
  $wh = ["comp_id" => $comp_id_clicked];
  $q_comp = $database->select($tbl,$col,$wh);

  foreach($q_comp AS $q_comp_data){
    $username = $q_comp_data["username"];
    $tbl2 = "messenger";
    $col2 = "*";
    $wh2 = ["AND"=>["sender"=>$username,"receiver"=>$sender_user]];
    $q_mes = $database->select($tbl2,$col2,$wh2);

    foreach($q_mes AS $q_mes_data){
      $messenger_id = $q_mes_data["messenger_id"];
      $col3 = ["message_status" => 'read'];
      $wh3 = ["messenger_id" => $messenger_id];
      $q_update = $database->update($tbl2,$col3,$wh3);
    }
  }
  header("location: chatbox.php?comp_id_clicked=$comp_id_clicked");
}

elseif(isset($_GET['comp_user_id_clicked'])&&isset($_GET['sender_user'])){
  $comp_user_id_clicked = $_GET['comp_user_id_clicked'];
  $sender_user = $_GET['sender_user'];
  $tbl = "user_info";
  $col = "*";
  $wh = ["user_id"=>$comp_user_id_clicked];
  $q_user = $database->select($tbl,$col,$wh);

  foreach($q_user AS $q_user_data){
    $username = $q_user_data["username"];

    $tbl2 = "messenger";
    $col2 = "*";
    $wh2 = ["AND"=>["sender"=>$username,"receiver"=>$sender_user]];
    $q_mes = $database->select($tbl2,$col2,$wh2);

    foreach($q_mes AS $q_mes_data){
      $messenger_id = $q_mes_data["messenger_id"];
      $col3 = ["message_status" => 'read'];
      $wh3 = ["messenger_id" => $messenger_id];
      $q_update = $database->update($tbl2,$col3,$wh3);
    }
  }
  header("location: chatbox_company.php?user_id_clicked=$comp_user_id_clicked");
}

elseif(isset($_GET['user_comp_id_clicked'])){
  $comp_id_clicked = $_GET['user_comp_id_clicked'];
  $tbl = "company_info";
  $col = "*";
  $wh = ["comp_id" => $comp_id_clicked];
  $q_comp = $database->select($tbl,$col,$wh);

  foreach($q_comp AS $q_comp_data){
    $username = $q_comp_data["username"];
    $tbl2 = "messenger";
    $col2 = "*";
    $wh2 = ["sender" => $username];
    $q_mes = $database->select($tbl2,$col2,$wh2);

    foreach($q_mes AS $q_mes_data){
      $messenger_id = $q_mes_data["messenger_id"];
      $col3 = ["message_status" => 'read'];
      $wh3 = ["messenger_id" => $messenger_id];
      $q_update = $database->update($tbl2,$col3,$wh3);
    }
  }
  header("location: chatbox_company.php?comp_id_clicked=$comp_id_clicked");
}
?>
