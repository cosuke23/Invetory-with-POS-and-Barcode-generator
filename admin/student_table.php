	<?php include('dbcon.php'); ?>
	<form action="delete_club.php" method="post">
	<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
	<a data-toggle="modal" href="#delete_club" id="delete"  class="btn btn-danger" name=""><i class="icon-trash icon-large"></i></a>
	<div class="pull-right">
			    <ul class="nav nav-pills">
				<li class="active">
					<a >List of all clubs</a>
				</li>
				</ul>
	</div>
	<?php include('modal_delete.php'); ?>
		<thead>
		<tr>
					<th></th>
					<th>Club</th>				
					<th>Name of Adviser</th>
		
			

					<th></th>
		</tr>
		</thead>
		<tbody>
			
		<?php
	$query = mysql_query("select * from clubs") or die(mysql_error());
	while ($row = mysql_fetch_array($query)) {
		$id = $row['c_id'];
		?>
	
		<tr>	
		<td width="30">
		<input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
		</td>
	
                                        <td><?php echo $row['c_name'];?> </td> 
										<td><?php echo $row['c_adviser']; ?></td>  
	

	
		<td width="30"><a href="edit_student.php<?php echo '?id='.$id; ?>" class="btn btn-success"><i class="icon-pencil"></i> </a></td>
	
		</tr>
	<?php } ?>    
	
		</tbody>
	</table>
	</form>