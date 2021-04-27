<?php
date_default_timezone_set('Asia/Manila');
	require 'assets/connection/mysqli_dbconnection.php';
	
		if(isset($_POST['btn_change_pic']))
		{
			$stud_no = $_POST['stud_no'];
			$name = $_FILES['nw_pic']['tmp_name'];
			
			$nw_pic = (file_get_contents($_FILES['nw_pic']['tmp_name']));
			$file_typex= basename($_FILES["nw_pic"]["name"]);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);
			
			$image = imagecreatefromstring($nw_pic);
			
			
			//NOTE: Resize all incoming images to reduce file size
			

			// Get new sizes
			list($width, $height) = getimagesize($name);
			 $newwidth = 300;
			 $newheight = 300;
			
			// // Load
			 $thumb = imagecreatetruecolor($newwidth, $newheight);
			 $source = $image;

			// // Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			// // Output
			 
						
			 if(!empty($nw_pic)){
				
				ob_start();
				imagejpeg($thumb);
				$image_final = ob_get_contents();
				ob_end_clean();
				$filename = "files/student_pics/".$stud_no.".jpg";
				
				if(file_put_contents($filename, $image_final) == TRUE){
					chmod($filename, 0666);
					clearstatcache();
					header("Location:change_picture.php");
				}
			
			}else{
				header("Location:change_picture.php?error_no_file=No File Selected!");

			 }
		}
		?>