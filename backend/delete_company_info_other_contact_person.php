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
  date_default_timezone_set("Asia/Manila");
  if(!isset($_COOKIE["uid"])) {
	header ("Location: login.php");
	exit;
}
$username = $_COOKIE["uid"];
$usertype = $_COOKIE["ut"];
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
  if(isset($_GET['ocp_id'])&&isset($_GET['comp_id'])){
    $ocp_id = $_GET['ocp_id'];
	$comp_id = $_GET['comp_id'];
	$cp = $_GET['cp'];
	//$sql = ' DELETE FROM company_info_other_contact_person WHERE comp_id = "'.$comp_id.'" AND id= "'.$ocp_id.'"';
//	$hey = mysqli_query($dbc, $sql);
	
    echo '<script language = javascript>
      swal({
        title: "Do you want to delete \n'.$cp.'?",
        text: "Note: This will be deleted permanently!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Confirm Delete",
        cancelButtonText: "Cancel",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
          // swal("Deleted!", "Your imaginary file has been deleted.", "success");
			
           window.location.href = "delete_company_info_other_contact_person2.php?comp_id='.$comp_id.'&ocp_id='.$ocp_id.'&cp='.$cp.'";
        } else {
          // swal("Cancelled", "Delete Event Cancelled.", "error");
          window.location.href = "update_comp_cont_info.php?comp_id='.$comp_id.'";
        }
      });</script>
    ';

  }
?>
