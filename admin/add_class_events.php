 <form id="signin_student" class="form-signin" method="post">
	<h4 class="form-signin-heading"><i class="icon-plus-sign"></i> Add Event</h4>
	<?php
	error_reporting(0);
	$id=$_GET['id'];

									 $event_query = mysql_query("SELECT * from event where event_id=$id    ")or die(mysql_error());
										while($row = mysql_fetch_array($event_query)){
							
								      
	?>
<!--	<input type="color" name="event_color" class="form-control" style="width:250px"> -->
	    <input type="text" class="input-block-level datepicker" name="date_start" id="date01" value="<?php echo $row['date_start'] ?>" required/>
	    <input type="text" class="input-block-level datepicker" name="date_end" id="date01" value="<?php echo $row['date_end'] ?>" required/>
		<input type="text" class="input-block-level" id="username" name="title" value="<?php echo $row['event_title'] ?>" />
		<input type="text" class="input-block-level" id="place" name="place" value="<?php echo $row['place'] ?>" />
		<?php
		if($row['color']!=""){
			?>
		<input type="text" class="input-block-level" id="username" name="event_color" value="<?php echo $row['color'] ?>" />
		<?php
	}else{

	?>
	<input type="text" class="input-block-level" id="username" name="event_color" placeholder="Remarks" />
	<?php
}
?>
		<input type="hidden" class="input-block-level" id="place" name="id" value="<?php echo $row['event_id'] ?>" />
		<?php
	}
		?>
	<button id="signin" name="add" class="btn btn-info" type="submit"><i class="icon-save"></i> Save</button>
</form>
<?php
if (isset($_POST['add'])){
	$date_start = $_POST['date_start'];
	$date_end = $_POST['date_end'];
	$title = $_POST['title'];
	$place = $_POST['place'];
	$color = $_POST['event_color'];
	$id = $_POST['id'];
	
	$query = mysql_query("UPDATE event set date_end='$date_end',date_start='$date_start',event_title='$title',color='$color',place='$place',status='Allowed' where event_id='$id'")or die(mysql_error());
	$event_query = mysql_query("SELECT * from event where event_id=$id    ")or die(mysql_error());
										$rowx = mysql_fetch_array($event_query);
										$title=$rowx['event_title'];
	?>
	<script>
	alert('<?php echo $title ?> event Edited');
	window.location = "calendar_of_events.php";
	</script>
<?php
}
?>

		<table cellpadding="0" cellspacing="0" border="0" class="table" id="">
									
		
	<thead>
										        <tr>
										        <th>action</th>
												<th>Event</th>
												<th>Date</th>
												<th>Place</th>
												
												
												</tr>
												
										</thead>
																			<tbody>
											
                             
									<?php
									$status="Pending";
									 $event_query = mysql_query("SELECT * from event order by date_start asc  ")or die(mysql_error());
										while($event_row = mysql_fetch_array($event_query)){
										$id  = $event_row['event_id'];
									?>                              
										<tr id="del<?php echo $id; ?>">
									 <td width="20">
							
										<a  class="btn btn-danger" href="delete_event.php<?php echo '?id='.$id; ?>"><i class="icon-trash icon-large"></i></a>
								
								
										 </td> 
										 <td><a  href="calendar_of_event.php<?php echo '?id='.$id; ?>"><?php echo $event_row['event_title']; ?></a> </td>
                                         <td><?php  echo $event_row['date_start']; ?>
											<br>To
											 <?php  echo $event_row['date_end']; ?></td>
											 <td><?php  echo $event_row['place']; ?></td>
									                                        
									
                               
                                </tr>
                         
						 <?php } ?>
						   
                              
										</tbody>
									</table>
