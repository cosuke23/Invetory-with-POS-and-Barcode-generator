<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn-update']))
	{
		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));
		$comp_name = mysqli_real_escape_string($dbc, trim($_POST['comp_name']));
		$comp_desc = mysqli_real_escape_string($dbc, trim($_POST['comp_desc']));
		$address = mysqli_real_escape_string($dbc, trim($_POST['address']));
		$city = mysqli_real_escape_string($dbc, trim($_POST['city']));
		$status = mysqli_real_escape_string($dbc, trim($_POST['status']));
		$remarks = mysqli_real_escape_string($dbc, trim($_POST['remarks']));
		$date_notary = mysqli_real_escape_string($dbc, trim($_POST['date_notary']));
		$date_expiry = mysqli_real_escape_string($dbc, trim($_POST['date_expiry']));
		$contact_person = mysqli_real_escape_string($dbc, trim($_POST['contact_person']));
		$position =  mysqli_real_escape_string($dbc, trim($_POST['position']));
		$tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));
		$fax_no =  mysqli_real_escape_string($dbc, trim($_POST['fax_no']));
		$email =  mysqli_real_escape_string($dbc, trim($_POST['email']));
		$date_notary2 = date('Y/m/d', strtotime($date_notary));
		$date_expiry2 = date('Y/m/d', strtotime($date_expiry));
		$name = $_FILES['image']['tmp_name'];
		if(!empty($name))
		{
			$nw_pic = (file_get_contents($_FILES['image']['tmp_name']));
			$file_typex= basename($_FILES["image"]["name"]);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);
			
			$image = imagecreatefromstring($nw_pic);
			
			
			//NOTE: Resize all incoming images to reduce file size on database.
			// Content type pag iooutopu
			//header('Content-Type: image/jpeg');

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
				$filename = "../files/company/".$comp_id.".jpg";
				file_put_contents($filename, $image_final);
				chmod($filename, 0666);
			
			}else{
				echo "ERROR: img is empty.";
			 }
			 
			 
			//Update query for company_info
				$query_comp_info_update = "UPDATE company_info
				SET comp_name = '$comp_name',comp_desc = '$comp_desc', address = '$address', city = '$city',
				 status = '$status', remarks = '$remarks', date_notary = '$date_notary2',
				date_expiry = '$date_expiry2',contact_person = '$contact_person', position = '$position', tel_no = '$tel_no',
				fax_no = '$fax_no', email = '$email' WHERE comp_id = '$comp_id'";
				$result_comp_info_update = mysqli_query($dbc,$query_comp_info_update);
			if($result_comp_info_update)
			{
				echo "success";
			}else{
				echo "error";
			}
			if($status =="Not Active")
			{
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Not Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
			}
			elseif($remarks =="Banned")
			{
				$query_status = "UPDATE company_info
				SET status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_query_status = mysqli_query($dbc,$query_status);
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Not Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
				if($result_query_status &&  $result_ojt_offers_status && $result_comp_program_list_NA && $result_comp_info_status)
					{
					echo "update in banned remarks without pics (banned)";
					
					}
					else	
					{
						echo "query error failed please try again..";
					}
			}
			elseif($remarks =="expired MOA")
			{
				$query_status = "UPDATE company_info
				SET status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_query_status = mysqli_query($dbc,$query_status);
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Not Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
				if($result_query_status &&  $result_ojt_offers_status && $result_comp_program_list_NA && $result_comp_info_status)
				{
					echo "update in banned remarks without pics (expired MOA)" . "<br>";
					
				}
					else	
					{
						echo "query error failed please try again..";	
					}
			}
			elseif($remarks =="without MOA")
			{
				$query_status = "UPDATE company_info
				SET status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_query_status = mysqli_query($dbc,$query_status);
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Not Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
				if($result_query_status &&  $result_ojt_offers_status && $result_comp_program_list_NA && $result_comp_info_status)
				{
					echo "update in banned remarks without pics (expired MOA)" . "<br>";
					
				}
					else	
					{
						echo "query error failed please try again..";	
					}
			}
			elseif($status =="Active")
			{
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Available' WHERE comp_id = '$comp_id'";
				$result_query_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Active' WHERE comp_id = '$comp_id'";
				$result_query_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
			}			
		}
		else
		{
		//Update query for company_info
				$query_comp_info_update = "UPDATE company_info
				SET comp_name = '$comp_name',comp_desc = '$comp_desc', address = '$address', city = '$city',
				 status = '$status', remarks = '$remarks', date_notary = '$date_notary2',
				date_expiry = '$date_expiry2',contact_person = '$contact_person', position = '$position', tel_no = '$tel_no',
				fax_no = '$fax_no', email = '$email' WHERE comp_id = '$comp_id'";
				$result_comp_info_update = mysqli_query($dbc,$query_comp_info_update);
			if($result_comp_info_update)
			{
				echo "success updated comp info without pics" . "<br>";
			}else{
				echo "error";
			}
			if($status =="Not Active")
			{
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Not Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
				if($result_ojt_offers_status && $result_comp_program_list_NA && $result_comp_info_status)
				{
					echo "update in not active without pics" . "<br>";
					
				}
					else	
					{
						echo "query error failed please try again..";	
					}
			}
			elseif($remarks =="Banned")
			{
				$query_status = "UPDATE company_info
				SET status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_query_status = mysqli_query($dbc,$query_status);
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Not Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
				if($result_query_status &&  $result_ojt_offers_status && $result_comp_program_list_NA && $result_comp_info_status)
				{
					echo "update in banned remarks without pics";
					
				}
					else	
					{
						echo "query error failed please try again..";	
					}
			}
			elseif($remarks =="expired MOA")
			{
				$query_status = "UPDATE company_info
				SET status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_query_status = mysqli_query($dbc,$query_status);
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Not Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
				if($result_query_status &&  $result_ojt_offers_status && $result_comp_program_list_NA && $result_comp_info_status)
				{
					echo "update in banned remarks without pics (expired MOA)" . "<br>";
					
				}
					else	
					{
						echo "query error failed please try again..";	
					}
			}
			elseif($remarks =="without MOA")
			{
				$query_status = "UPDATE company_info
				SET status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_query_status = mysqli_query($dbc,$query_status);
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Not Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Not Active' WHERE comp_id = '$comp_id'";
				$result_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
				if($result_query_status &&  $result_ojt_offers_status && $result_comp_program_list_NA && $result_comp_info_status)
				{
					echo "update in banned remarks without pics (expired MOA)" . "<br>";
					
				}
					else	
					{
						echo "query error failed please try again..";	
					}
			}
			elseif($status =="Active")
			{
				
				$query_ojt_offers_status = "UPDATE ojt_offers
				SET status = 'Available' WHERE comp_id = '$comp_id'";
				$result_ojt_offers_status = mysqli_query($dbc,$query_ojt_offers_status);
				$query_comp_program_list_NA = "UPDATE company_program
				SET comp_program_status = 'Active' WHERE comp_id = '$comp_id'";
				$result_query_comp_program_list_NA = mysqli_query($dbc,$query_comp_program_list_NA);
				$q_updateStatus = "UPDATE company_info SET notify_status = 'none' WHERE comp_id = '$comp_id'";
				$result_comp_info_status = mysqli_query($dbc,$q_updateStatus);
				if($result_ojt_offers_status && $result_query_comp_program_list_NA && $result_comp_info_status)
				{
					echo "update in banned without pics & comp info";
					
				}
				else	
				{
					echo "query error failed please try again..";
				}
			}	
		}
		
		clearstatcache();
		header("Location:Company_info.php?success2=2&comp_name=$comp_name");
	}
	
	
	if(isset($_POST['btn-add']))
	{
		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));
		header("Location:add_comp_contact_person.php?comp_id=$comp_id");
	}
	
	if(isset($_POST['btn-updatex']))
	{
		$ocp_id= $_POST['ocp_id'];
		$comp_id= $_POST['comp_id'];
		header("Location:update_comp_contact_person.php?comp_id=$comp_id&ocp_id=$ocp_id");
	}
	
?>