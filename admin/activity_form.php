<?php 
$user_query = mysql_query("SELECT * from activity_proposal  group by id desc")or die(mysql_error());
$count=mysql_num_rows($user_query);
if($count>0){

?>
	<script>

	window.location = "activity_forms.php";
	</script>
	<?php }else{ ?>

	<script>
alert('Activity Proposal still pending.!');
	window.location = "admin_user.php";
	</script>
		<?php } ?>