<?php
include('dbcon.php');
if (isset($_POST['delete_club'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$res=mysql_query("SELECT * from clubs where c_id='$id[$i]'")or die(mysql_error());
	$row=mysql_fetch_array($res);
	$cname=$row['c_name'];
	$cadviser=$row['c_adviser'];
$empty='Empty';

        mysql_query("UPDATE club_advisers set club = '$empty' where club = '$cname' ")or die(mysql_error());
       mysql_query("DROP TABLE $cname ")or die(mysql_error());
	 mysql_query("DELETE FROM clubs where c_id='$id[$i]'")or die(mysql_error());
	 


}
?>

<script>
alert('club successfully deleted!')
window.location = "club.php";
</script>
        <?php
}
?>