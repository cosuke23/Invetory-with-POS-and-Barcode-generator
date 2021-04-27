 <form id="signin_student" class="form-signin" method="post">
	<h4 class="form-signin-heading"><i class="icon-plus-sign"></i> Add Event</h4>

<!--	<input type="color" name="event_color" class="form-control" style="width:250px"> -->
<input type="text" class="input-block-level datepicker" name="user" id="date01" value="<?php echo $user ?>" readonly/>
	    <input type="text" class="input-block-level datepicker" name="date_start" id="date01" placeholder="Date start" required/>
	    <input type="text" class="input-block-level datepicker" name="date_end" id="date01" placeholder="Date end"  required/>
		<input type="text" class="input-block-level" id="username" name="title" placeholder="Event title" />
		<input type="text" class="input-block-level" id="username" name="event_color" placeholder="Remarks"  />
		<input type="text" class="input-block-level" id="place" name="place"  placeholder="Place" />
		
	<button id="signin" name="add" class="btn btn-info" type="submit"><i class="icon-save"></i> Save</button>
</form>
<?php
if (isset($_POST['add'])){
	$date_start = $_POST['date_start'];
	$date_end = $_POST['date_end'];
	$title = $_POST['title'];
	$place = $_POST['place'];
	$color = $_POST['event_color'];

	$query = mysql_query("INSERT INTO event (date_end,date_start,event_title,color,place,status,person) values('$date_end','$date_start','$title','$color','$place','Allowed','$user')")or die(mysql_error());
	?>
	<script>
	window.location = "calendar_of_events.php";
	</script>
<?php
}
?>
<style type="text/css">
div.scrollbar {
height: 400px;
width: 340px;
overflow: auto;
border: solid 1px #000;
padding: 5px;
}
</style>

<div class="scrollbar">
		<table cellpadding="10" cellspacing="10" border="1" class="table" id="">
									
		
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
									 $event_query = mysql_query("SELECT * from event order by date_start asc   ")or die(mysql_error());
										while($event_row = mysql_fetch_array($event_query)){
										$id  = $event_row['event_id'];
									?>                              
										<tr id="del<?php echo $id; ?>">
									 <td width="20">
							
										<a  class="btn btn-danger" href="delete_event.php<?php echo '?id='.$id; ?>"><i class="icon-trash icon-large"></i>
								
								
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
</div>