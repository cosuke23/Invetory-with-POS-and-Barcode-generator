<?php
include('db.php');
include('session.php');
	$id = $_POST['id'];
	$day = $_POST['date_start'];
	$day1 = $_POST['date_end'];
	$OG='OnGoing';
	$accept='Accepted';
	 
        $status="main";
        $que = mysql_query("SELECT * from activity_proposal where id='$id' ")or die(mysql_error());
        $row=mysql_fetch_array($que);
        $adviser=$row['adviser'];
$query = mysql_query("SELECT * from admin where checks='$status' and id='$session_id'  ")or die(mysql_error());
                    $count = mysql_num_rows($query);
                    if($count>0){
            $month=date("Y-m-d ",strtotime("+$day days"));

	mysql_query("UPDATE activity_proposal set status='$accept',adviser='$adviser and $user_username',dateS='$day1',dateE='$day1' where id='$id'");

}else{

	mysql_query("UPDATE activity_proposal set status='$OG',adviser='$adviser and $user_username',dateS='$day1',dateE='$day1' where id='$id'");

}
header("location:activity_formx.php");
	?>