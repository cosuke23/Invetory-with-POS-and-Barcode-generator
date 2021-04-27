<?php
	require 'asset/connection/mysqli_dbconnection.php';
	if(isset($_POST['btn_report']))
		{
			$adviser_id = $_POST['adviser_id'];
			$file_name = $_POST['file_name'];
			$report_file = (file_get_contents($_FILES['report_file']['tmp_name']));
			$file_typex= basename($_FILES["report_file"]["name"]);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);
			if(!empty($report_file)){
			
				$report_base64 = base64_encode($report_file);
				$q_send_report = "INSERT INTO ojt_monitoring_report(adviser_id, fileName, fileData, status) VALUES('$adviser_id', '$file_name', '$report_base64', 'unread')";
				$r_send_report = $dbc->query($q_send_report);
				if($r_send_report == true)
				{
					header("Location:send_report.php?success=1");
					exit;
				}
			}else{
				header("Location:send_report.php?error=1");
				exit;
			}
		}
?>