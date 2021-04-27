<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
if(isset($_GET['fid']))
{
	$fid=$_GET['fid'];
	$query_update = "UPDATE ojt_monitoring_report SET status='read' WHERE fid='$fid'";
	$result=mysqli_query($dbc, $query_update);
	$query="SELECT fileData FROM ojt_monitoring_report WHERE fid='$fid'";
	$result=mysqli_query($dbc, $query);
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_assoc($result);
		$file_data = $row['fileData'];
		$decoded_file = base64_decode($file_data);
		$f = finfo_open();
		$file_type = finfo_buffer($f, $decoded_file, FILEINFO_MIME_TYPE);

		//echo 'data:'.$file_type.';base64,'.$file_data.'"';
	}
	//$file_data = $_GET['file'];
}	

?>
<html>
 <iframe src="data:<?php echo $file_type.";base64,".$file_data;?>" type="application/pdf" width="100%" height="100%"></iframe>
</html>