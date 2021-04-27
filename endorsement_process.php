<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_POST['btn-save']))
{
	$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
	$program_id = mysqli_real_escape_string($dbc, trim($_POST['program_id']));
	$adviser_id = mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));
	$thours = mysqli_real_escape_string($dbc, trim($_POST['thours']));
	$date_created = mysqli_real_escape_string($dbc, trim($_POST['date_created']));
	$sub_date = mysqli_real_escape_string($dbc, trim($_POST['sub_date']));
	$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));
	$contact_person = mysqli_real_escape_string($dbc, trim($_POST['contact_person']));
	$position = mysqli_real_escape_string($dbc, trim($_POST['position']));
	$contact_no = mysqli_real_escape_string($dbc, trim($_POST['tel_no']));
	$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	
	$date_created2 = date('Y/m/d', strtotime($date_created));
	$sub_date2 = date('Y/m/d', strtotime($sub_date));
	
	/*-------------------------------------validate---------------------------------------*/
	$query_select = "SELECT endorsement_id FROM endorsement WHERE stud_no='$stud_no' AND status='Active'";
	$result_select = mysqli_query($dbc, $query_select);
	if(mysqli_num_rows($result_select)>0)
	{
		$row = mysqli_fetch_assoc($result_select);
		$en_id = $row['endorsement_id'];
		/*-------------------------------------query update---------------------------------------*/
		$query_update = "UPDATE endorsement SET status='Not Active' WHERE endorsement_id='$en_id'";
		$result_update = mysqli_query($dbc, $query_update);
		if($result_update==false)
		{
			echo "ERROR: query_update";
			exit;
		}
		/*-------------------------------------query insert---------------------------------------*/
		$query_insert = "INSERT INTO endorsement(stud_no, adviser_id, comp_id, program_id, training_hours, date_created, submission_date, contact_person, position, contact_no, email, status) VALUES('$stud_no', '$adviser_id', '$comp_id', '$program_id', '$thours', '$date_created2', '$sub_date2', '$contact_person', '$position', '$contact_no', '$email', 'Active')";
		$result_insert = mysqli_query($dbc, $query_insert);
		if($result_insert == true)
		{
			//Email information
			$admin_email = "no-reply@sticaloocan.edu.ph";
			date_default_timezone_set('Asia/Manila');
			$date_today =  date("n/j/Y");
			$query_email = "SELECT * FROM adviser_info WHERE adviser_id='$adviser_id'";
			$result_email = mysqli_query($dbc, $query_email);
			if(mysqli_num_rows($result_email)>0)
			{
				$row2 = mysqli_fetch_assoc($result_email);
				$title = $row2['title'];
				$ad_fname = $row2['fname'];
				$ad_lname = $row2['lname'];
				$adviser_email = $row2['email'];
			}
			$query_stud = "SELECT a.lname, a.fname, a.mname, b.program_code FROM student_info AS a INNER JOIN program_list AS b WHERE a.stud_no='$stud_no' AND a.program_id = b.program_id";
			$result_stud = mysqli_query($dbc, $query_stud);
			if(mysqli_num_rows($result_stud)>0)
			{
				$row3 = mysqli_fetch_assoc($result_stud);
				$stud_fname = $row3['fname'];
				$stud_lname = $row3['lname'];
				$stud_mname = $row3['mname'];
				$stud_prog = $row3['program_code'];
			}
			$query_comp = "SELECT * FROM company_info WHERE comp_id = '$comp_id'";
			$result_comp = mysqli_query($dbc, $query_comp);
			if(mysqli_num_rows($result_comp)>0)
			{
				$row4 = mysqli_fetch_assoc($result_comp);
				$comp_name = $row4['comp_name'];
				$comp_adddress = $row4['address'];
			}
			  $subject = "OJT - assiSTI: APPROVED FOR COMPANY ENDORSEMENT";
			  $message ="OJT Adviser: ".$title." ".$ad_fname." ".$ad_lname."					Date: ".$date_today."
				
			APPROVED FOR COMPANY ENDORSEMENT
	
			Name: ".$stud_fname." ".$stud_mname." ".$stud_lname."
			Course/Program: ".$stud_prog."
			No. of Training Hours: ".$thours."
			Complete Name of Host Company: ".$comp_name."
			Name of Host Company Representative: ".$contact_person."
			Contact No.: ".$contact_no."
			
			
			
			<<This message is auto-generated. Please don't reply>>";
 
			  //send email
			  mail($adviser_email, $subject, $message, "From:" . $admin_email);
			  
			header("Location: endorsement.php?success=ok");
			exit;
		}
		else
		{
			echo "ERROR: query_insert";
			exit;
		}
	}
	else
	{
		/*-------------------------------------query insert---------------------------------------*/
		$query_insert = "INSERT INTO endorsement(stud_no, adviser_id, comp_id, program_id, training_hours, date_created, submission_date, contact_person, position, contact_no, email, status) VALUES('$stud_no', '$adviser_id', '$comp_id', '$program_id', '$thours', '$date_created2', '$sub_date2', '$contact_person', '$position', '$contact_no', '$email', 'Active')";
		$result_insert = mysqli_query($dbc, $query_insert);
		if($result_insert == true)
		{
			
			header("Location: endorsement.php?success=ok");
			exit;
		}
		else
		{
			echo "ERROR: query_insert";
			exit;
		}
	}
	
}
?>