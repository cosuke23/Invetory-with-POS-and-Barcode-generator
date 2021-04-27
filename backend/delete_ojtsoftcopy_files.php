<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
	if ($dbc->connect_error) {
		die("Connection failed: " . $dbc->connect_error);
		} else{
		}
	
		$target_dir = "../files/downloadables/";
		$file_id = $_GET['fileID'];
			
	
		
		//------------delete ung dati
		$retQuery = "select fileName from ojt_softcopy_files where fileID='$file_id'";
		$x = $dbc->query($retQuery)->fetch_assoc();
		$z = $x["fileName"];
		if(unlink($target_dir.$z) === true){
			echo "file has been deleted";
			$q_del="delete from ojt_softcopy_files where fileID='$file_id'";
			$q_del_res=$dbc->query($q_del);
			header("Location: ojtsoftcopy.php?deleted=1");
		} else{
			echo "error in deleting file...";
		}
	
	
	?>