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
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");

if (isset($_POST['btnupdateincidentreport'])){
		$id = mysqli_real_escape_string($dbc, trim($_POST['incident_id']));
		$comp_id = mysqli_real_escape_string($dbc, trim($_POST['comp_id']));
		$date_todayz = mysqli_real_escape_string($dbc, trim($_POST['date_today2']));
		$remarks = mysqli_real_escape_string($dbc, trim($_POST['remarksreport']));
		$name = $_FILES['company_report']['tmp_name'];
		
		$datetoday = date('Y-m-d', strtotime(str_replace('-', '/', $date_todayz)));
		
		if(!empty($name))
		{
			$new_record = (file_get_contents($_FILES['company_report']['tmp_name']));
			$file_typex= basename($_FILES["company_report"]["name"]);
			
			$path = $_FILES['company_report']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			
			if($ext=="pdf") {

			}

			else
			{
			die("<script language = javascript>
							swal({
							   title: 'Failed to Update',
								html: true,
							   text: '<strong>Only PDF File Extention is Allowed</strong>',
							   type: 'error',
							   showCancelButton: false,

							   confirmButtonText: 'OK',
							   closeOnConfirm: false,
							   closeOnCancel: false
							 },
							 function(isConfirm){
							   if (isConfirm) {
								 window.location.href='update_comp_cont_info.php?comp_id=".$comp_id."';
							   }
							 });
						 </script>");
			}
			
			
			
			
			
				if(!empty($new_record)){
					
					$filename = "../files/company_report/".$id.".pdf";
					
					if (file_exists($filename)) {
						//echo "Sorry, file already exists.";
						unlink($filename);
					}
					
					file_put_contents($filename, $new_record);
					chmod($filename, 0666);
				
				}
				
				$filenamepo = $id .".pdf";
				$queryx = "UPDATE company_report SET filename = '$filenamepo', remarks = '$remarks',date ='$datetoday' WHERE id ='$id'";
				if(mysqli_query($dbc,$queryx))
				{
					
				}else
				{
				echo "error";
				}
		}else
		{
				$queryx = "UPDATE company_report SET remarks = '$remarks',date ='$datetoday' WHERE id ='$id'";
				if(mysqli_query($dbc,$queryx))
				{
					
				}else
				{
				echo "error";
				}
		}
		
		echo '<script language = javascript>
							swal({
							   title: "Incident Updated",
								html: true,
							   text: "<strong>'.$date_today.'</strong>",
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
		
		
		/*
		if($counter =="NO" && !empty($new_record))
		{
				$newwwfilenameee = $comp_name . ".pdf";
				$queryx = "INSERT INTO company_record(comp_id,filename,filefolder)
				VALUES('$comp_id','$newwwfilenameee','$filefolder')";
		
				if(mysqli_query($dbc,$queryx))
				{
					clearstatcache();
		//header("Location:update_comp_cont_info.php?comp_id=$comp_id");
		echo '<script language = javascript>
							swal({
							   title: "Uploading Record!",
								html: true,
							   text: "<strong> '. $comp_name.' Saved</strong>",
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
		}else if($counter =="NO" && empty($new_record))
		{
				$newwwfilenameee = $comp_name . ".pdf";
				$queryx = "INSERT INTO company_record(comp_id,filefolder)
				VALUES('$comp_id','$filefolder')";
		
				if(mysqli_query($dbc,$queryx))
				{
					clearstatcache();
		//header("Location:update_comp_cont_info.php?comp_id=$comp_id");
		echo '<script language = javascript>
							swal({
							   title: "Uploading Record!",
								html: true,
							   text: "<strong> '. $comp_name.' Saved</strong>",
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
		}else
		{
		
		 $queryx = "UPDATE company_record SET filefolder='$filefolder' WHERE id = '$id'";
				if(mysqli_query($dbc,$queryx))
				{
				}
		
		clearstatcache();
		//header("Location:update_comp_cont_info.php?comp_id=$comp_id");
		echo '<script language = javascript>
							swal({
							   title: "Successful Updated!",
								html: true,
							   text: "<strong> '. $comp_name.'</strong>",
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
		}*/
}
?>