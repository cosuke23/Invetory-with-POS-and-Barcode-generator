<?php

// Start the session..

session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_update_stud_info']))

	{

		$stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no']));

		$lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));

		$fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));

		$mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));

		$gender =  mysqli_real_escape_string($dbc, trim($_POST['gender']));

		$bday =  mysqli_real_escape_string($dbc, trim($_POST['bday']));

		$program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

		$email =  mysqli_real_escape_string($dbc, trim($_POST['email']));

		$mobile_no =  mysqli_real_escape_string($dbc, trim($_POST['mobile_no']));

		$tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));

		$address =  mysqli_real_escape_string($dbc, trim($_POST['address']));

		$facebook =  mysqli_real_escape_string($dbc, trim($_POST['facebook']));

		$bday2 = date('Y-m-d', strtotime(str_replace('-', '/', $bday)));

			$name = $_FILES['image']['tmp_name'];

		if(!empty($name))

		{
			//update picture

			$nw_pic = (file_get_contents($_FILES['image']['tmp_name']));
			$file_typex= basename($_FILES["image"]["name"]);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);
			
			$image = imagecreatefromstring($nw_pic);
			// Get new sizes
			list($width, $height) = getimagesize($name);
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
				$filename = "../files/student_pics/".$stud_no.".jpg";

				if(file_put_contents($filename, $image_final) == TRUE){
				}

		    //Update query for student_info

			$query_student_update2 = "UPDATE student_info

			SET lname = '$lname', fname = '$fname', mname = '$mname', gender = '$gender',

			bday = '$bday2',  program_id = '$program_id', email = '$email',

			mobile_no = '$mobile_no',tel_no = '$tel_no',address = '$address', facebook ='$facebook' WHERE stud_no = '$stud_no'";

			$result_update_student_info2 = mysqli_query($dbc,$query_student_update2);

			if($result_update_student_info2)

				{

				echo "updated";

				 header("Location: Student_information.php?success=1&stud_no=$stud_no&lname=$lname&fname=$fname&mname=$mname");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}

		}

		else

		{

			$query_student_update2 = "UPDATE student_info

			SET lname = '$lname', fname = '$fname', mname = '$mname', gender = '$gender',

			bday = '$bday2',  program_id = '$program_id', email = '$email',

			mobile_no = '$mobile_no',tel_no = '$tel_no',address = '$address', facebook ='$facebook' WHERE stud_no = '$stud_no'";

			$result_update_student_info2 = mysqli_query($dbc,$query_student_update2);		

		if($result_update_student_info2)

				{

					echo "updated";

					header("Location: Student_information.php?success=1&stud_no=$stud_no&lname=$lname&fname=$fname&mname=$mname");

				}

			else	

			{

				echo "query error failed please try again.."; 

			}

		}			

	}

?>

