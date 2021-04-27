<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_adviser_info']))
	{
		$adviser_id =  mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));
		$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
		$lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));
		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
		$mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));
		$email =  mysqli_real_escape_string($dbc, trim($_POST['email']));
		$new_pass =  mysqli_real_escape_string($dbc, trim($_POST['new_pass']));
		$mobile_no =  mysqli_real_escape_string($dbc, trim($_POST['mobile_no']));
		$profile_pic = $_FILES['profileData']['tmp_name'];
		
			
		if(!empty($profile_pic) && !empty($new_pass))
		{
			/*Upload image*/
		
			$nw_pic = (file_get_contents($_FILES['profileData']['tmp_name']));
			$file_typex= basename($_FILES['profileData']['name']);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);

			$image = imagecreatefromstring($nw_pic);

			//NOTE: Resize all incoming images to reduce file size on database.
			// Content type pag iooutopu
			//header('Content-Type: image/jpeg');

			// Get new sizes
			list($width, $height) = getimagesize($profile_pic);
			$newwidth = 300;
			$newheight = 300;

			// // Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = $image;
			// // Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			// // Output
			if(!empty($nw_pic))
			{
				ob_start();
				imagejpeg($thumb);
				$image_final = ob_get_contents();
				ob_end_clean();
				$filename = "../files/admin_pics/".$adviser_id.".jpg";
				file_put_contents($filename, $image_final);
				chmod($filename, 0666);
			}
			else
			{
				echo "ERROR: img is empty.";
			}
			
			
		    //Update query adviser_info
			$query_adviser_info = "UPDATE adviser_info SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email', title='$title', mobile_no ='$mobile_no' WHERE adviser_id = '$adviser_id'";
			$result_adviser_info = mysqli_query($dbc,$query_adviser_info);

			//query_password
			$query_pass = "UPDATE user SET password = '$new_pass' WHERE username = '$adviser_id'";
			$result_pass = mysqli_query($dbc,$query_pass);

			if($result_adviser_info && $result_pass)
			{
				echo "updated";
				clearstatcache();
				header("Location: adviser_home.phpsuccess=1");

			}
			else	
			{
				echo "query error failed please try again.."; 
			}
		}
		else if(!empty($profile_pic))
		{
			/*Upload image*/
		
			$nw_pic = (file_get_contents($_FILES['profileData']['tmp_name']));
			$file_typex= basename($_FILES['profileData']['name']);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);

			$image = imagecreatefromstring($nw_pic);

			//NOTE: Resize all incoming images to reduce file size on database.
			// Content type pag iooutopu
			//header('Content-Type: image/jpeg');

			// Get new sizes
			list($width, $height) = getimagesize($profile_pic);
			$newwidth = 300;
			$newheight = 300;

			// // Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = $image;
			// // Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			// // Output
			if(!empty($nw_pic))
			{
				ob_start();
				imagejpeg($thumb);
				$image_final = ob_get_contents();
				ob_end_clean();
				$filename = "../files/admin_pics/".$adviser_id.".jpg";
				file_put_contents($filename, $image_final);
				chmod($filename, 0666);
			}
			else
			{
				echo "ERROR: img is empty.";
			}
			
		    //Update query for student_info
			$query_adviser_info = "UPDATE adviser_info
			SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email', title='$title', mobile_no ='$mobile_no' WHERE adviser_id = '$adviser_id'";
			$result_adviser_info = mysqli_query($dbc,$query_adviser_info);

			if($result_adviser_info)
			{
				echo "updated";
				clearstatcache();
				header("Location: adviser_home.php?success=1");
			}
			else	
			{
				echo "query error failed please try again.."; 
			}
		}
			
	    else if(!empty($profile_pic) && !empty($new_pass))
		{	
			/*Upload image*/
		
			$nw_pic = (file_get_contents($_FILES['profileData']['tmp_name']));
			$file_typex= basename($_FILES['profileData']['name']);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);

			$image = imagecreatefromstring($nw_pic);

			//NOTE: Resize all incoming images to reduce file size on database.
			// Content type pag iooutopu
			//header('Content-Type: image/jpeg');

			// Get new sizes
			list($width, $height) = getimagesize($profile_pic);
			$newwidth = 300;
			$newheight = 300;

			// // Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = $image;
			// // Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			// // Output
			if(!empty($nw_pic))
			{
				ob_start();
				imagejpeg($thumb);
				$image_final = ob_get_contents();
				ob_end_clean();
				$filename = "../files/admin_pics/".$adviser_id.".jpg";
				file_put_contents($filename, $image_final);
				chmod($filename, 0666);
			}
			else
			{
				echo "ERROR: img is empty.";
			}

		    //Update query for student_info
			$query_adviser_info = "UPDATE adviser_info
			SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email', title='$title', mobile_no ='$mobile_no' WHERE adviser_id = '$adviser_id'";
			$result_adviser_info = mysqli_query($dbc,$query_adviser_info);

			//query_password
			$query_pass = "UPDATE user SET password = '$new_pass' WHERE username = '$adviser_id'";
			$result_pass = mysqli_query($dbc,$query_pass);

				if($result_adviser_info && $result_pass)
				{
					echo "updated";
					clearstatcache();
					header("Location: adviser_home.php?success=1");;
				}
				else	
				{
					echo "query error failed please try again.."; 
				}
			}
			else if(!empty($new_pass))
			{

		    //Update query for student_info
			$query_adviser_info = "UPDATE adviser_info
			SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email', title='$title', mobile_no ='$mobile_no' WHERE adviser_id = '$adviser_id'";
			$result_adviser_info = mysqli_query($dbc,$query_adviser_info);

			//query_password
			$query_pass = "UPDATE user SET password = '$new_pass' WHERE username = '$adviser_id'";
			$result_pass = mysqli_query($dbc,$query_pass);

				if($result_adviser_info && $result_pass)
				{
					echo "updated";
					header("Location: adviser_home.php?success=1");
				}
				else	
				{
					echo "query error failed please try again.."; 
				}
			}
			else if(empty($profile_pic) && empty($new_pass))
			{

		    //Update query for student_info
			$query_adviser_info = "UPDATE adviser_info
			SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email', title='$title', mobile_no ='$mobile_no' WHERE adviser_id = '$adviser_id'";
			$result_adviser_info = mysqli_query($dbc,$query_adviser_info);

			if($result_adviser_info)
					{
						echo "updated";
						header("Location: adviser_home.php?success=1");
					}
				else	
				{
					echo "query error failed please try again.."; 
				}
			}
			else
			{
				//Update query for student_info
				//header("Location: adviser_home.php?success=1");
			}	
			
	}
?>
