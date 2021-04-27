<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
ini_set('max_execution_time', 100000);
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];

if(isset($_GET['event_id'])){
	$event_id = $_GET['event_id'];
	$stud_no = '10000131563';	
		
		$files = "asset/resume_data/0082A080441.pdf";
		$newfile = (file_get_contents($files));
		$file_typex = basename($files);
		$type = pathinfo($file_typex,PATHINFO_EXTENSION);
		
		ob_start();
		$fpdf = ob_get_contents();
		ob_end_clean();
		$filename = "../resume2017/0082A080441.pdf";
		file_put_contents($filename,$fpdf);
	
	


echo "<H2>Copy files completed!</H2>"; //output when done
	
}
?>