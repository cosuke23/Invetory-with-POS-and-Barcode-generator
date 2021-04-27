<?php
// Start the session..
session_start();

// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_admin_info']))
	{
		$admin_id =  mysqli_real_escape_string($dbc, ($_POST['admin_id']));
		$lname =  mysqli_real_escape_string($dbc, ($_POST['lname']));
		$title =  mysqli_real_escape_string($dbc, ($_POST['title']));
		$fname =  mysqli_real_escape_string($dbc, ($_POST['fname']));
		$mname =  mysqli_real_escape_string($dbc, ($_POST['mname']));
		$email =  mysqli_real_escape_string($dbc, ($_POST['email']));
		$new_pass =  mysqli_real_escape_string($dbc, ($_POST['new_pass']));

		$profile_pic = $_FILES['profileData']['tmp_name'];

		if(!empty($profile_pic) && !empty($new_pass))
		{
			$nw_pic = (file_get_contents($_FILES['profileData']['tmp_name']));
			$file_typex= basename($_FILES["profileData"]["name"]);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);
			
			$image = imagecreatefromstring($nw_pic);
			// Get new sizes
			list($width, $height) = getimagesize($profile_pic);
			 $newwidth = 300;
			 $newheight = 300;
			
			// // Load
			 $thumb = imagecreatetruecolor($newwidth, $newheight);
			 $source = $image;

			// // Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				ob_start();
				imagejpeg($thumb);
				$image_final = ob_get_contents();
				ob_end_clean();
				$filename = "../files/admin_pics/".$admin_id.".jpg";

				if(file_put_contents($filename, $image_final) == TRUE){
					echo "pics updated";
				}

		    //Update query for student_info
			$query_admin_info = "UPDATE admin_info
			SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email',title='$title' WHERE admin_id = '$admin_id'";
			$result_admin_info = mysqli_query($dbc,$query_admin_info);

			//query_password
			$query_pass = "UPDATE user SET password = '$new_pass' WHERE username = '$admin_id'";
			$result_pass = mysqli_query($dbc,$query_pass);

			if($result_admin_info && $result_pass)
					{
							echo "updated";
							$admin_email = "ojtassisti@sticaloocan.edu.ph";
							$subject="Password Change Notification";
							$message="Good day!
						This is to inform you that your password has been successfully updated.
								
					You may now login using your new password.
							
					Link: http://sticaloocan.edu.ph/ojtassisti/backend/login.php
			
					
		Sincerely,
		OJT-assiSTI Team

		----This email is system generated. Please do not reply----";
	
			mail($email, $subject, $message, "From:" . $admin_email);
						header("Location: admin_home.php?success=1");
					}
				else	
				{
					echo "query error failed please try again.."; 
				}
			}
		header("Location: admin_home.php?success=1");
		else if(!empty($profile_pic))
		{
			$nw_pic = (file_get_contents($_FILES['profileData']['tmp_name']));
			$file_typex= basename($_FILES["profileData"]["name"]);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);
			$image = imagecreatefromstring($nw_pic);
			// Get new sizes
			list($width, $height) = getimagesize($profile_pic);
			 $newwidth = 300;
			 $newheight = 300;
			
			// // Load
			 $thumb = imagecreatetruecolor($newwidth, $newheight);
			 $source = $image;

			// // Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				ob_start();
				imagejpeg($thumb);
				$image_final = ob_get_contents();
				ob_end_clean();
				$filename = "../files/admin_pics/".$admin_id.".jpg";

				if(file_put_contents($filename, $image_final) == TRUE){
					echo "pics updated";
				}else{
					echo "may mali";
				}

		    //Update query for student_info
			$query_admin_info = "UPDATE admin_info
			SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email',title='$title' WHERE admin_id = '$admin_id'";
			$result_admin_info = mysqli_query($dbc,$query_admin_info);

			if($result_admin_info)
					{
						echo "updated";
						//header("Location: admin_home.php?success=1");
					}
				else	
				{
					echo "query error failed please try again.."; 
				}
			}
			header("Location: admin_home.php?success=1");
			else if(!empty($new_pass))
			{

		    //Update query for student_info
			$query_admin_info = "UPDATE admin_info
			SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email',title='$title' WHERE admin_id = '$admin_id'";
			$result_admin_info = mysqli_query($dbc,$query_admin_info);

			//query_password
			$query_pass = "UPDATE user SET password = '$new_pass' WHERE username = '$admin_id'";
			$result_pass = mysqli_query($dbc,$query_pass);

			if($result_admin_info && $result_pass)
					{
						echo "updated";
						$admin_email = "ojtassisti@sticaloocan.edu.ph";
			$subject="Password Change Notification";
			$message="Good day!
					This is to inform you that your password has been successfully updated.
							
				You may now login using your new password.
						
				Link: http://sticaloocan.edu.ph/ojtassisti/backend/login.php
				
						
			Sincerely,
			OJT-assiSTI Team

			----This email is system generated. Please do not reply----";
	
			mail($email, $subject, $message, "From:" . $admin_email);
						header("Location: admin_home.php?success=1");
					}
				else	
				{
					echo "query error failed please try again.."; 
				}
			header("Location: admin_home.php?success=1");
			}else{
				 //Update query for student_info
			$query_admin_info = "UPDATE admin_info
			SET lname = '$lname', fname = '$fname', mname = '$mname', email = '$email',title='$title' WHERE admin_id = '$admin_id'";
				$result_admin_info = mysqli_query($dbc,$query_admin_info);
				header("Location: admin_home.php?success=1");
			}	
	}
?>
