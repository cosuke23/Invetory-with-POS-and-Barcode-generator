   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Announcement</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
							<form method="post">
                        <center>
                        <div class="control-group">
                     
                            <div class="controls">
				
									
							<input type="Text" name="title" placeholder="title of the announcement" required>
                            </div>
                        </div>
                        <div class="control-group">
                     
                            <div class="controls">
				
									
							<textarea name="content" style="width:400px;height:180px;" > </textarea>
                            </div>
                        </div>
</center>
                
					
							
	
	
									</div>
									<div class="span4">
											

					
									<div class="pull-left">

											
							</div>
							
									
                                </div>
								<div class="span10">
								<hr>
									<center>
									<div class="control-group">
												<div class="controls">
													<button name="Upload" type="submit" value="Upload" class="btn btn-success" /><i class="icon-check"></i>&nbsp;Post</button>
												</div>
									</div>
									</center>
             
						       </form>	
								</div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
					<?php
if (isset($_POST['Upload'])){

													$user_query = mysql_query("SELECT * from announcement")or die(mysql_error());
													$row = mysql_num_rows($user_query);
if ($row > 0){ ?>
<script>
alert('Data Already Exist');
</script>
<?php
}else{
$title = $_POST['title'];
	$content = $_POST['content'];		
	//$id=$_POST['event_id'];

			
			mysql_query("INSERT into announcement (ann_name,content,date) values('$title','$content',NOW())")or die(mysql_error());

//mysql_query("insert into activity_log (date,username,action) values(NOW(),'$user_username','Add User $username')")or die(mysql_error());
?>
<script>
alert('Announcement Save');
window.location = "add_announcement.php";
</script>
<?php
}
}
?>