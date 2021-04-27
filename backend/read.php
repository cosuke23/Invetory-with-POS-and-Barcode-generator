<?php
require "asset/connection/mysqli_dbconnection.php";

/*$query="SELECT read_status FROM conversations_data";
$result=mysqli_query($dbc, $query);
while($row=mysqli_fetch_assoc($result))
{
	if($row['read_status']==0)
	{
		echo "AYUN";
	}
	else
	{
		echo "WALEY";
	}
}*/
$username='sticaloocan';
$s_id="SELECT id FROM conversations WHERE parent='$username' OR child='$username'";
				$r_id=mysqli_query($dbc, $s_id);
				if(mysqli_num_rows($r_id)>0)
				{
					$count_conv=0;
					while($row_id = mysqli_fetch_assoc($r_id))
					{
						$s_conv="SELECT COUNT(conv_id) AS num FROM conversations_data WHERE id='".$row_id['id']."' AND sender!='$username' AND read_status=0";
						$r_conv=mysqli_query($dbc, $s_conv);
						if(mysqli_num_rows($r_conv)>0)
						{
							$row_conv = mysqli_fetch_assoc($r_conv);
							$count_conv += $row_conv['num'];
							
						}
					}
				}
				else
				{
					$count_conv='0';
				}
				echo $count_conv;
?>