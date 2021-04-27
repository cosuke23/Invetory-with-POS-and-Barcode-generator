	<?php include('dbcon.php'); 
	$id=$_GET['id'];
	error_reporting(0); ?>
	<form action="delete_strand.php" method="post">
	<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
	<a data-toggle="modal" href="#delete_section" id="delete"  class="btn btn-danger" name=""><i class="icon-trash icon-large"></i></a>
	<div class="pull-right">
			    <ul class="nav nav-pills">
				<li class="active">
					<a >List of all strands</a>
				</li>
				</ul>
	</div>
	<?php include('modal_delete.php'); ?>
		<thead>
		<tr>
				<th></th>
					<th>id</th>
					<th>Section</th>
		
			

					<th></th>
		</tr>
		</thead>
		<tbody>
			
		<?php
	$query = mysql_query("SELECT * from section") or die(mysql_error());
	while ($row = mysql_fetch_array($query)) {
		$id = $row['id'];
		?>
	
		<tr>	
		<td width="30">
		<input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
		</td>
	
										<td><?php echo $row['id']; ?></td>
										<td><?php echo $row['section']; ?></td> 


	
		<td width="30"><a href="sections.php<?php echo '?id='.$id; ?>" class="btn btn-success"><i class="icon-pencil"></i> </a></td>
	
		</tr>
	<?php } ?>    
	
		</tbody>
	</table>
	</form>