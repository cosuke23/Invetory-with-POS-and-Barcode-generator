   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Announcement</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                	<?php
                                	$id=$_GET['id'];
													$user_query = mysql_query("SELECT * from announcement where ann_id=$id")or die(mysql_error());
													while($row = mysql_fetch_array($user_query)){
													$id = $row['ann_id'];
													?>
									
							<form method="post">
                        <center>
                        <div class="control-group">
                     
                            <div class="controls">
				
									
							<input type="Text" name="title" placeholder="title of the announcement" value="<?php echo $row['ann_name']; ?>" required>
                            </div>
                        </div>
                        <div class="control-group">
                     
                            <div class="controls">
				
									
							<textarea name="content" style="width:400px;height:180px;" value="<?php echo $row['content']; ?>" ><?php echo $row['content']; ?> </textarea>
                            </div>
                        </div>
</center>
                
					<?php } ?>
							
	
	
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



$title = $_POST['title'];
	$content = $_POST['content'];		


			
			mysql_query("UPDATE announcement set ann_name='$title',content='$content',date=NOW() where ann_id=$id")or die(mysql_error());

//mysql_query("insert into activity_log (date,username,action) values(NOW(),'$user_username','Add User $username')")or die(mysql_error());
?>
<script>
alert('Announcement edited');
window.location = "add_announcement.php";
</script>
<?php

}
?>