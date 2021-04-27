<?php
if(isset($_POST['btn_search']))
{
	$id=$_POST['search-hidden'];
	
	header("Location: adviser_chat.php?id=$id");
	exit;
}
else
{
	$id=$_POST['search-hidden'];
	
	header("Location: admin_chat.php?id=$id");
	exit;
}
?>