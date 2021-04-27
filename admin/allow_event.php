<?php
include('dbcon.php');
$get_id = $_GET['id'];
$status='Allowed';
mysql_query("UPDATE  event set status='$status' where event_id = '$get_id'")or die(mysql_error());
?>
<script>
window.location = 'calendar_of_events.php';
</script>