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
if(isset($_POST['btn_adviser_add']))
	{
		$adviser_id = mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));
		$title =  mysqli_real_escape_string($dbc, trim($_POST['title']));
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		$program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));
		$lname = mysqli_real_escape_string($dbc, trim($_POST['lname']));
		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
		$mname = mysqli_real_escape_string($dbc, trim($_POST['mname']));
		
		$mobile_no =  "00000000000";
		/*default_image*/
			$flname = "../files/default_img.jpg";
			$nw_pic = (file_get_contents($flname));
			$file_typex= basename($flname);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);

			$image = imagecreatefromstring($nw_pic);

			//NOTE: Resize all incoming images to reduce file size on database.
			// Content type pag iooutopu
			//header('Content-Type: image/jpeg');

			// Get new sizes
			list($width, $height) = getimagesize($flname);
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
			}
			else
			{
				echo "ERROR: img is empty.";
			}
			
	 	$user_id = generateId($dbc, 'user_id','user');
		//$ash_id = generateId($dbc, 'ash_id','adviser_section_handled');
		$query_add_ojt_adviser_info = "INSERT INTO adviser_info(adviser_id,lname,fname,mname,title,email,program_id,status,mobile_no) VALUES('$adviser_id','$lname','$fname','$mname','$title','$email','$program_id','Active','$mobile_no')";
		$query_add_ojt_adviser_user = "INSERT INTO user(user_id,username,password,usertype) VALUES('$user_id','$adviser_id','$adviser_id','2')";
		
		//------Email user/pass
			
			$admin_email = "ojtassisti@sticaloocan.edu.ph";
			$subject="Welcome to OJT - assiSTI";
			$message="Welcome to OJT - assiSTI!
	You have been selected as an OJT Adviser. You may now access our website to monitor your OJT advisory students.
You may login using the link below with the credentials:
			
		USERNAME: ".$adviser_id."
		PASSWORD: ".$adviser_id."
			
	Link: http://sticaloocan.edu.ph/ojtassisti/backend/login.php
	Note: You may change your password upon logging in.
			
Sincerely,
OJT-assiSTI Team";
	
			mail($email, $subject, $message, "From:" . $admin_email);
			//---- end email function
						$result_add_ojt_adviser_info = mysqli_query($dbc,$query_add_ojt_adviser_info);
						$result_add_ojt_adviser_user = mysqli_query($dbc,$query_add_ojt_adviser_user);
						$ash_id = generateId($dbc, 'ash_id','adviser_section_handled');
						//$add_OJT_adviser_section_handled = "INSERT INTO adviser_section_handled(adviser_id,section_id,semester,acad_year_start,acad_year_end,program_id,status,ash_id) VALUES
						//('$adviser_id','$section_id','$semester','$acad_year_start','$acad_year_end','$program_id','$status_ash','$ash_id')";
						//$result_OJT_adviser_section_handled = mysqli_query($dbc,$add_OJT_adviser_section_handled);	
							
								if($result_add_ojt_adviser_info && $result_add_ojt_adviser_user)
								{
									echo "Added";
									header("Location: OJT_adviser.php?success=1");
								}
									else	
									{
										echo "query error failed please try again.."; 
									}
                   
	}       
?>