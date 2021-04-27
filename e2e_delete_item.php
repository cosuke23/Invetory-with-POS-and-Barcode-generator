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
  $date_today =  date("Y-m-d");
  require 'asset/connection/mysqli_dbconnection.php';
include('session.php');
  if(isset($_GET['Item_Number'])){
    $username = $_GET['Item_Number'];
	
    echo '<script language = javascript>
      swal({
        title: "Are you sure you want to delete this Item?",
        text: "ID: '.$username.'",
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
          window.location.href = "e2e_delete_item_process.php?Item_Number= '.$username.'";
        } else {
          // swal("Cancelled", "Delete Item Cancelled.", "error");
          window.location.href = "e2e_stocks.php?delete_cancelled=ok";
        }
      });</script>
    ';

  }
?>
