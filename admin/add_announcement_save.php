<?php
include('db.php');
include('session.php');
$title = $_POST['title'];
	$content = $_POST['content'];		
	$id=$_POST['id'];


				$img="http://192.168.43.29/subok/sampics/logo/finals1.png";
				$club="Admin";
			
			mysql_query("INSERT into annoucements (adviser_id,title,content,date,club,image_url) values('$session_id','$title','$content',NOW(),'$club','$img')")or die(mysql_error());
	
		
?>


