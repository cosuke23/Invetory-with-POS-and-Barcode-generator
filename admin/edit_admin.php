   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Admin</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form method="post">
                    <a href="system.php"><i class="icon-arrow-left"></i> Back</a>
                     <?php
                     $get_id=$_GET['id'];
                     $query = mysql_query("SELECT * from admin where id = '$get_id'")or die(mysql_error());
                     while($row = mysql_fetch_array($query)){
                     ?>
                     
									 <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="username" id="focusedInput" type="text" value="<?php echo $row['username']; ?>" required>
                                          </div>
                                        </div>
                  

										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="name" id="focusedInput" type="text" value="<?php echo $row['name']; ?>" required>
                                          </div>
                                        </div>
										
								


										<?php } ?>
											<div class="control-group">
                                          <div class="controls">
												<button name="save" class="btn btn-info"><i class="icon-plus-sign icon-large"></i></button>

                                          </div>
                                        </div>
                                </form>
								</div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
					<?php
if (isset($_POST['save'])){
$user = $_POST['username'];
$pass = $_POST['password'];
$name = $_POST['name'];
$check ="primary";
$email = $_POST['email'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$img ="";



mysql_query("UPDATE admin set username='$user',name='$name' where id = '$get_id'")or die(mysql_error());

mysql_query("INSERT into activity_log (date,username,action) values(NOW(),'$user_username','Add User $username')")or die(mysql_error());
?>
<script>
window.location = "system.php";
</script>
<?php

}
?>