   <div class="row-fluid">
                       <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Edit Moderator</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<?php
								$query = mysql_query("SELECT * from admin where admin_id = '$get_id'")or die(mysql_error());
								$row = mysql_fetch_array($query);
								?>
								<form method="post">
                
                 <div class="control-group">
                                          <div class="controls">
 <select name="status" id="user_type" class="form-control" maxlength="=40" />
                                  <option value="creator">Admin</option>
                                  <option value="staff">Staff</option>
                                  </select>
                                          </div>
                                        </div>

                  <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" value="<?php echo $row['admin_id']; ?>"  name="adviser" id="focusedInput" type="text" placeholder = "Username" required>
                                          </div>
                                        </div>



                                          <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" value="<?php echo $row['name']; ?>" name="name" id="focusedInput" type="text" placeholder = "Firstname" required>
                                          </div>
                                        </div>

										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" value="<?php echo $row['username']; ?>" name="firstname" id="focusedInput" type="text" placeholder = "Firstname" required>
                                          </div>
                                        </div>
										
										
									

                
								
										
											<div class="control-group">
                                          <div class="controls">
												<button name="update" class="btn btn-success"><i class="icon-save icon-large"></i></button>

                                          </div>
                                        </div>
                                </form>
								</div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
			<?php		
if (isset($_POST['update'])){

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$name = $_POST['name'];
$username = $_POST['adviser'];
$pos = $_POST['position'];
$title = $_POST['title'];
$student = $_POST['student'];
$status = $_POST['status'];

mysql_query("UPDATE admin set admin_id = '$username'  , username = '$firstname', name = '$name',position = '$status' where id = '$get_id' ")or die(mysql_error());


?>
<script>
  window.location = "admin_user.php"; 
</script>
<?php
}
?>