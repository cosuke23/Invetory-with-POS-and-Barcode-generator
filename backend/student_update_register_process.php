<?php



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';

header("Location: student_home.php");

//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn_student_info_update']))

	{

		$stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no']));

		

		$email =  mysqli_real_escape_string($dbc, trim($_POST['email']));

		$mobile_no =  mysqli_real_escape_string($dbc, trim($_POST['mobile_no']));

		$tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));

		$address =  mysqli_real_escape_string($dbc, trim($_POST['address']));

		$facebook =  mysqli_real_escape_string($dbc, trim($_POST['facebook']));



		$type = $_FILES['image']['type'];



		if(!empty($type))

		{

			$content = (file_get_contents($_FILES['image']['tmp_name']));

			$base64=base64_encode($content);



			$img =  mysqli_real_escape_string($dbc, trim($_POST['img']));

			$query_stud_pic = "UPDATE student_info SET imageData = '$base64' WHERE stud_no = '$stud_no'";

			$result_stud_pic = mysqli_query($dbc,$query_stud_pic);



							//Update query for student_info

				$query_stud_info_update = "UPDATE student_info

				SET email = '$email',mobile_no = '$mobile_no', tel_no = '$tel_no', address = '$address',

				facebook = '$facebook' WHERE stud_no = '$stud_no'";

				

			

			$result_stud_info_update = mysqli_query($dbc,$query_stud_info_update);

			

		if($result_stud_info_update)

				{

					echo "update";

					

				}

			else	

			{

				echo "query error failed please try again.."; 

			}

		}

		else

		{

				//Update query for student_info

				$query_stud_info_update = "UPDATE student_info

				SET email = '$email',mobile_no = '$mobile_no', tel_no = '$tel_no', address = '$address',

				facebook = '$facebook' WHERE stud_no = '$stud_no'";

			

			$result_stud_info_update = mysqli_query($dbc,$query_stud_info_update);





		if($result_stud_info_update)

				{

					echo "update";

					

				}

			else	

			{

				echo "query error failed please try again.."; 

			}	

		}

	}



?>

