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
  if(!isset($_COOKIE["uid"])) {
    header ("Location: e2e_admin_login.php");
    exit;
  }
  if(isset($_GET['event_id'])&&isset($_GET['event_name'])){
    $event_id = $_GET['event_id'];
    $event_name = $_GET['event_name'];

    echo '<script language = javascript>
      swal({
        title: "Are you sure you want to delete this Event?",
        text: "ID: '.$event_id.' - '.$event_name.'",
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
          window.location.href = "e2e_event_delete_succeed.php?delete_succeed=ok&&event_id='.$event_id.'";
        } else {
          // swal("Cancelled", "Delete Event Cancelled.", "error");
          window.location.href = "e2e_event_manager.php?delete_cancelled=ok";
        }
      });</script>
    ';

  }
?>
