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
if(isset($_POST['btn-update']))
	{
		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));
		$ocp_id = mysqli_real_escape_string($dbc, trim($_POST['ocp_id']));
		$contact_person = mysqli_real_escape_string($dbc, trim($_POST['contact_person']));
		$position =  mysqli_real_escape_string($dbc, trim($_POST['position']));
		$tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));
		$fax_no =  mysqli_real_escape_string($dbc, trim($_POST['fax_no']));
		$email =  mysqli_real_escape_string($dbc, trim($_POST['email']));
		$status =  mysqli_real_escape_string($dbc, trim($_POST['status']));
		$remarks =  mysqli_real_escape_string($dbc, trim($_POST['remarks']));
		$date_notary =  mysqli_real_escape_string($dbc, trim($_POST['date_notary']));
		$date_expiry =  mysqli_real_escape_string($dbc, trim($_POST['date_expiry']));
		
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
				
				$queryx = "	UPDATE 
					company_info_other_contact_person
					SET 
					contact_person = '$maincontact_person',
					position = '$mainposition',
					tel_no = '$maintel_no',
					fax_no = '$mainfax_no',
					email = '$mainemail',
					status = '$mainstatus',
					remarks = '$mainremarks',
					date_notary = '$maindate_notary',
					date_expiry = '$maindate_expiry',
					notify_status = '$mainnotify_status'
					WHERE
					id = $ocp_id AND comp_id = $comp_id";
					
				if(mysqli_query($dbc,$queryx))
				{
					$queryx = "UPDATE company_info SET contact_person = '$contact_person' , position = '$position' , tel_no = '$tel_no' , fax_no ='$fax_no' , email ='$email' , status = '$status' , remarks ='$remarks' , date_notary = '$date_notary2' , date_expiry = '$date_expiry2' , notify_status ='none' WHERE comp_id ='$comp_id'";	
					if(mysqli_query($dbc,$queryx))
					{
					//	echo "Added";
					//	header("Location:update_comp_cont_info.php?comp_id=$comp_id");
						
							echo '<script language = javascript>
							swal({
							   title: "Successfully Updating Other Contact Person!",
								html: true,
							   text: "<strong> '. $contact_person.' Updated</strong>",
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
					$xxxxx = "
					UPDATE 
					company_info_other_contact_person
					SET 
					contact_person = '$contact_person',
					position = '$position',
					tel_no = '$tel_no',
					fax_no = '$fax_no',
					email = '$email',
					status = '$status',
					remarks = '$remarks',
					date_notary = '$date_notary2',
					date_expiry = '$date_expiry2',
					notify_status = 'none'
					WHERE
					id = $ocp_id AND comp_id = $comp_id
					";
				
					$xxxxx = mysqli_query($dbc,$xxxxx);
		
				if($xxxxx)
				{
				//echo "SUCCESS";
				clearstatcache();
			//	header("Location:update_comp_cont_info.php?comp_id=$comp_id");
					echo '<script language = javascript>
							swal({
							   title: "Successfully Updating Other Contact Person!",
								html: true,
							   text: "<strong> '. $contact_person.' Updated</strong>",
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
			}
		}
	}
	
	

?>