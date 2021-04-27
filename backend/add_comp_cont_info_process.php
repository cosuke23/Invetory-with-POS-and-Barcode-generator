
<?php
// Start the session..
session_start();
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
require 'default_comp_img.php';

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);

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

if(isset($_POST['btn-add']))
	{
		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));
		$comp_name =  mysqli_real_escape_string($dbc, trim($_POST['comp_name']));
		$comp_desc =  mysqli_real_escape_string($dbc, trim($_POST['comp_desc']));
		$address =  mysqli_real_escape_string($dbc, trim($_POST['address']));
		$city =  mysqli_real_escape_string($dbc, trim($_POST['city']));
		$status =  mysqli_real_escape_string($dbc, trim($_POST['status']));
		$remarks =  mysqli_real_escape_string($dbc, trim($_POST['remarks']));
		$date_notary =  mysqli_real_escape_string($dbc, trim($_POST['date_notary']));
		$date_expiry =  mysqli_real_escape_string($dbc, trim($_POST['date_expiry']));
		$contact_person =  mysqli_real_escape_string($dbc, trim($_POST['contact_person']));
		$position =  mysqli_real_escape_string($dbc, trim($_POST['position']));
		$tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));
		$fax_no =  mysqli_real_escape_string($dbc, trim($_POST['fax_no']));
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		$program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));
		$cmp_user =  mysqli_real_escape_string($dbc, trim($_POST['cmp_user']));

		$date_notary2 = date('Y-m-d', strtotime(str_replace('-', '/', $date_notary)));
		$date_expiry2 = date('Y-m-d', strtotime(str_replace('-', '/', $date_expiry)));


		$type = $_FILES['image']['tmp_name'];
		$comp_id = generateId($dbc, 'comp_id','company_info');
		//restrict multiple insert check if it is already inserted
		$q_check = "SELECT username from company_info WHERE username='$cmp_user'";
		$q_check_res= $dbc->query($q_check);
		if($q_check_res->num_rows>0){
			header("Location:Company_info.php?success=1");
		}else{
		
		
	if(!empty($type))
		{
			
			$nw_pic = (file_get_contents($_FILES['image']['tmp_name']));
			$file_typex= basename($_FILES["image"]["name"]);
			$type2 = pathinfo($file_typex,PATHINFO_EXTENSION);
			
			$image = imagecreatefromstring($nw_pic);
			
			
			//NOTE: Resize all incoming images to reduce file size
			

			// Get new sizes
			list($width, $height) = getimagesize($type);
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
				$filename = "../files/company/".$comp_id.".jpg";
				file_put_contents($filename, $image_final);
			}
			

			//add query for company_info
			$query3 = "INSERT INTO company_info(comp_id,comp_name,comp_desc,address,city,contact_person,position,tel_no,fax_no,email,status,remarks,date_notary,date_expiry,notify_status,username,password) VALUES
			('$comp_id','$comp_name','$comp_desc','$address', '$city','$contact_person','$position','$tel_no','$fax_no',
			'$email','$status','$remarks','$date_notary2','$date_expiry2','none','$cmp_user','$cmp_user')";
			
			$query4 = "INSERT INTO company_program(comp_id,program_id,comp_program_status) VALUES
			('$comp_id','$program_id','$status')";
//------Email user/pass
			
			$admin_email = "ojtassisti@sticaloocan.edu.ph";
			$subject="Welcome to OJT - assiSTI";
			$message="Welcome to OJT - assiSTI!
	Because of your partnership with STI Caloocan on hiring students for OJT program, we are pleased to inform you
that you are given an access to our website where you can send your comments about our students that is training in your company.
You may login using the link below with the credentials:
			
		USERNAME: ".$cmp_user."
		PASSWORD: ".$cmp_user."
			
	Link: http://sticaloocan.edu.ph/ojtassisti/backend/company_login.php
	Note: You may change your password upon logging in.
			
Sincerely,
OJT-assiSTI Team";
	
			mail($email, $subject, $message, "From:" . $admin_email);
			//---- end email function

		$result3 = mysqli_query($dbc,$query3);
		$result4 = mysqli_query($dbc,$query4);
		if($result3 && $result4)
				{
					echo "Added";
					header("Location:Company_info.php?success=1");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
		}

		else if(empty($type))
		{
			$default_pic = "../files/default_comp.jpg";
			$nw_pic = (file_get_contents($default_pic));
			$file_typex= basename($default_pic);
			$image = imagecreatefromstring($nw_pic);
			
			
			//NOTE: Resize all incoming images to reduce file size
			

			// Get new sizes
			list($width, $height) = getimagesize($default_pic);
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
				$filename = "../files/company/".$comp_id.".jpg";
				file_put_contents($filename, $image_final);
			}
			

			//add query for company_info
			$query3 = "INSERT INTO company_info(comp_id,comp_name,comp_desc,address,city,contact_person,position,tel_no,fax_no,email,status,remarks,date_notary,date_expiry,notify_status,username,password) VALUES
			('$comp_id','$comp_name','$comp_desc','$address', '$city','$contact_person','$position','$tel_no','$fax_no',
			'$email','$status','$remarks','$date_notary2','$date_expiry2','none','$cmp_user','$cmp_user')";
			
			$query4 = "INSERT INTO company_program(comp_id,program_id,comp_program_status) VALUES
			('$comp_id','$program_id','$status')";
//------Email user/pass
			
			$admin_email = "ojtassisti@sticaloocan.edu.ph";
			$subject="Welcome to OJT - assiSTI";
			$message="Welcome to OJT - assiSTI!
	Because of your partnership with STI Caloocan on hiring students for OJT program, we are pleased to inform you
that you are given an access to our website where you can send your comments about our students that is training in your company.
You may login using the link below with the credentials:
			
		USERNAME: ".$cmp_user."
		PASSWORD: ".$cmp_user."
			
	Link: http://sticaloocan.edu.ph/ojtassisti/backend/company_login.php
	Note: You may change your password upon logging in.
			
Sincerely,
OJT-assiSTI Team";
	
			mail($email, $subject, $message, "From:" . $admin_email);
			//---- end email function

		$result3 = mysqli_query($dbc,$query3);
		$result4 = mysqli_query($dbc,$query4);
		if($result3 && $result4)
				{
					echo "Added";
					header("Location:Company_info.php?success=1");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}	
		}
 }	
 }
?>
