<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
// Set the auto increment..
function generateId($con, $id, $table_name) {
    $query = "SELECT $id FROM $table_name";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if($num <= 0) {
        $id = 1;
        return $id;
    } else {
        $query1 = "SELECT MAX($id) FROM $table_name";
        $result1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_array($result1, MYSQLI_NUM);
        $id = $row1[0] + 1;
        return $id;
    }
}
/*if(isset($_POST['btn-softcopy-add']))
	{
		
		$file_desc =  mysqli_real_escape_string($dbc, trim($_POST['file_desc']));
		$file_id = generateId($dbc, 'fileID','ojt_softcopy_files');
		$target_dir = "asset/Uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$file_name=basename($_FILES["fileToUpload"]["name"]);
		
			$query_add = "INSERT INTO ojt_softcopy_files VALUES ('$file_id','$file_name','$file_desc')";
		
			$result_add = mysqli_query($dbc,$query_add);
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		{
		if($result_add)
				{
					echo "Added";
					header("Location: ojtsoftcopy.php");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}
		}			
	}*/
	
	if (isset($_POST['btn-softcopy-add'])){
		$target_dir = "../files/downloadables/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$file_name=basename( $_FILES["fileToUpload"]["name"]);
		$file_desc=$_POST['file_desc'];
	
		
		$file_id = generateId($dbc, 'fileID','ojt_softcopy_files');
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		{
			$query="INSERT into ojt_softcopy_files (fileID, fileName, fileDescription) VALUES ('$file_id','$file_name','$file_desc')";
			if ($dbc->query($query) === TRUE) 
			{
				echo "New record created successfully";
				//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				header("Location: ojtsoftcopy.php?added=1&file_name=$file_name");
			}
		} 
		else 
		{
			echo "Sorry, there was an error uploading your file.";
		}
	}
?>