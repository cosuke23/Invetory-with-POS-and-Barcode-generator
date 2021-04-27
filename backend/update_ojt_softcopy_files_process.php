<?php

// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

	if ($dbc->connect_error) {
		die("Connection failed: " . $dbc->connect_error);
		} else{
		}
	if (isset($_POST['btn-softcopy-update'])){
	$file_nameC =  mysqli_real_escape_string($dbc, trim($_POST['file_nameC']));
	$target_dir = "../files/downloadables/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$file_name=basename( $_FILES["fileToUpload"]["name"]);
	$file_desc=$_POST['file_desc'];
	$file_id = $_POST['file_id'];
	if(empty($file_name) and !empty($file_desc)){
		$query="update ojt_softcopy_files set fileDescription='$file_desc' where fileID='$file_id'";
		if ($dbc->query($query) === TRUE) {
		echo "file desc has been updated";
		header("Location: ojtsoftcopy.php?success=1&file_name=$file_nameC");
			}
		}
    
	if(!empty($file_name) and empty($file_desc)){
		
		//------------delete ung dati
		$retQuery = "select fileName from ojt_softcopy_files where fileID='$file_id'";
		$x = $dbc->query($retQuery)->fetch_assoc();
		$z = $x["fileName"];
		if(unlink($target_dir.$z) === true){
			echo "file has been deleted";
			//header("Location: ojtsoftcopy.php?success=1&file_name=$file_name");
		} else{
			echo "error in deleting file...";
		}
			
		
		//------------
		
		$query="update ojt_softcopy_files set fileName='$file_name' where fileID='$file_id'";
		if ($dbc->query($query) === TRUE) {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			
			echo "file has been updated";
			header("Location: ojtsoftcopy.php?success=1&file_name=$file_name");
		}
		}
	}
	
	if(!empty($file_name) and !empty($file_desc)){
		$query="update ojt_softcopy_files set fileDescription='$file_desc' where fileID='$file_id'";
		if ($dbc->query($query) === TRUE) {
		echo "file desc has been updated";
		//header("Location: ojtsoftcopy.php?success=1&file_name=$file_name");
		}
		
		
				//------------delete ung dati
		$retQuery = "select fileName from ojt_softcopy_files where fileID='$file_id'";
		$x = $dbc->query($retQuery)->fetch_assoc();
		$z = $x["fileName"];
		if(unlink($target_dir.$z) === true){
			echo "file has been deleted";
			//header("Location: ojtsoftcopy.php?success=1&file_name=$file_name");
		} else{
			echo "error in deleting file...";
		}
			
		
		//------------
		
		$query="update ojt_softcopy_files set fileName='$file_name' where fileID='$file_id'";
		if ($dbc->query($query) === TRUE) {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			
			echo "file has been updated";
			header("Location: ojtsoftcopy.php?success=1&file_name=$file_name");
		}
		}
		
		}
	}
	?>