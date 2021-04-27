<html>
  <head>
    <link rel="stylesheet" type="text/css" href="asset/css/sweetalert.css"/>
    <script src="asset/js/jquery.confirm.min.js"></script>
    <script src="asset/js/sweetalert-dev.js"></script>
    <script>
      var p1 ="";
    </script>
  </head>
  <body></body>
</html>

<?php
date_default_timezone_set('Asia/Manila');
$today = date("Y-m-d");
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn-add']))
	{
		$status =  mysqli_real_escape_string($dbc, trim($_POST['status']));
		$remarks =  mysqli_real_escape_string($dbc, trim($_POST['remarks']));
		$date_notary =  mysqli_real_escape_string($dbc, trim($_POST['date_notary']));
		$date_expiry =  mysqli_real_escape_string($dbc, trim($_POST['date_expiry']));
	
		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));
		$contact_person = mysqli_real_escape_string($dbc, trim($_POST['contact_person']));
		$position =  mysqli_real_escape_string($dbc, trim($_POST['position']));
		$tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));
		$fax_no =  mysqli_real_escape_string($dbc, trim($_POST['fax_no']));
		$email =  mysqli_real_escape_string($dbc, trim($_POST['email']));
		
		$date_notary2 = date('Y-m-d', strtotime(str_replace('-', '/', $date_notary)));
		$date_expiry2 = date('Y-m-d', strtotime(str_replace('-', '/', $date_expiry)));
		
		$searchcompany = "SELECT * FROM company_info WHERE comp_id = '".$comp_id."'";
		 
		$searchresult = $dbc->query($searchcompany);
		if($searchresult->num_rows > 0 )
		{
			while($row = $searchresult->fetch_assoc())
			{
			   $maindate_notary = $row["date_notary"];
			   $maindate_expiry = $row["date_expiry"]; 
			   $maincontact_person = $row["contact_person"];
			   $mainposition = $row["position"];
			   $mainemail = $row["email"];
			   $maintel_no = $row["tel_no"];
			   $mainfax_no = $row["fax_no"];
			   $mainstatus = $row["status"];
			   $mainremarks = $row["remarks"];
			   $mainnotify_status = $row["notify_status"];
			}
			
			$countnewentry = date_create(date($date_expiry2));
			$countoldentry = date_create(date($maindate_expiry));
			$counttodayentry = date_create(date($today));
			
			$dayofnew=date_diff($counttodayentry,$countnewentry);
			$dayofold=date_diff($counttodayentry,$countoldentry);
		
			if($dayofnew->format('%R%a') > $dayofold->format('%R%a'))
			{
			//	echo "NEW";
				$queryx = "INSERT INTO company_info_other_contact_person(comp_id,contact_person,position,tel_no,fax_no,email,status,remarks,date_notary,date_expiry,notify_status)
				VALUES('$comp_id','$maincontact_person','$mainposition','$maintel_no','$mainfax_no','$mainemail','$mainstatus','$mainremarks','$maindate_notary','$maindate_expiry','$mainnotify_status')";
		
				if(mysqli_query($dbc,$queryx))
				{
					$queryx = "UPDATE company_info SET contact_person = '$contact_person' , position = '$position' , tel_no = '$tel_no' , fax_no ='$fax_no' , email ='$email' , status = '$status' , remarks ='$remarks' , date_notary = '$date_notary2' , date_expiry = '$date_expiry2' , notify_status ='none' WHERE comp_id ='$comp_id'";	
					if(mysqli_query($dbc,$queryx))
					{
						//echo "Added";
						//header("Location:update_comp_cont_info.php?comp_id=$comp_id");
						
						
						echo '<script language = javascript>
							swal({
							   title: "Successfully Added Other Contact Person!",
								html: true,
							   text: "<strong> '. $contact_person.' Added</strong>",
							   type: "success",
							   showCancelButton: false,

							   confirmButtonText: "OK",
							   closeOnConfirm: false,
							   closeOnCancel: false
							 },
							 function(isConfirm){
							   if (isConfirm) {
								 window.location.href="update_comp_cont_info.php?comp_id='.$comp_id.'";
							   }
							 });
						 </script>';
					}
					else	
					{
					echo "query error failed please try again.."; 
					echo $dbc->error;
					}	
				}
				else	
				{
				echo "query error failed please try again.."; 
				echo $dbc->error;
				}	
			}
			else
			{
			//	echo "OLD";
				$queryx = "INSERT INTO company_info_other_contact_person(comp_id,contact_person,position,tel_no,fax_no,email,status,remarks,date_notary,date_expiry,notify_status)
				VALUES('$comp_id','$contact_person','$position','$tel_no','$fax_no','$email','$status','$remarks','$date_notary2','$date_expiry2','none')";
		
				if(mysqli_query($dbc,$queryx))
				{
				//	echo "Added";
					//header("Location:update_comp_cont_info.php?comp_id=$comp_id");
					
							echo '<script language = javascript>
							swal({
							   title: "Successfully Added Other Contact Person!",
								html: true,
							   text: "<strong> '. $contact_person.' Added</strong>",
							   type: "success",
							   showCancelButton: false,

							   confirmButtonText: "OK",
							   closeOnConfirm: false,
							   closeOnCancel: false
							 },
							 function(isConfirm){
							   if (isConfirm) {
								 window.location.href="update_comp_cont_info.php?comp_id='.$comp_id.'";
							   }
							 });
						 </script>';
				}
				else	
				{
				echo "query error failed please try again.."; 
				echo $dbc->error;
				}		
			}
		}
	}
	
	

?>