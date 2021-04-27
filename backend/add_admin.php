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
		$usertype =  mysqli_real_escape_string($dbc, ($_POST['user_type']));

		$profile_pic = $_FILES['profileData']['tmp_name'];

		
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
				$query_admin_infox = "SELECT * from user left join admin_info on user.admin_id=admin_info.user_id where admin_info.user_id='$admin_id' and user.admin_id='$admin_id' ";
				$result_admin_infox = mysqli_query($dbc,$query_admin_infox);
				if($result_admin_infox->num_rows > 0){?>
				<script type="text/javascript">
alert("Hello! I am an alert box!!");

header("Location: admin_home.php");
</script>
<?php
				}else{

		$query_admin_info = "INSERT INTO admin_info(admin_id, lname ,fname , mname , email,title) values ('$admin_id','$lname','$fname','$mname','$email','$title')";
			$result_admin_info = mysqli_query($dbc,$query_admin_info);

			//insert user
			$query_admin_info = "INSERT INTO user(user_id, username, password ,usertype) values ('$admin_id','$admin_id','$new_pass','$usertype')";
			$result_admin_info = mysqli_query($dbc,$query_admin_info);

}
		
		header("Location: admin_home.php?success=1");
	
			
	}
?>
