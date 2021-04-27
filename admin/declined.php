<?php
include('db.php');
include('session.php');
	$id = $_GET['id'];
	$OG='Declined';
	$accept='Declined';
	 
        $status="main";
        $que = mysql_query("SELECT * from activity_proposal where id='$id' ")or die(mysql_error());
        $row=mysql_fetch_array($que);
        $adviser=$row['adviser'];
$query = mysql_query("SELECT * from admin where checks='$status' and id='$session_id'  ")or die(mysql_error());
                    $count = mysql_num_rows($query);
                    if($count>0){
            
	mysql_query("UPDATE activity_proposal set status='$accept',adviser='$adviser and $user_username',date=NOW() where id='$id'")or die(mysql_error());

}else{
	mysql_query("UPDATE activity_proposal set status='$OG',adviser='$adviser and $user_username',date=NOW() where id='$id'")or die(mysql_error());

}
header("location:activity_formx.php");
	?>