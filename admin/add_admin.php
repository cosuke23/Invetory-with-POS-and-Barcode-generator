   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Order Coffee</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form method="post">
                         <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="admin_id" id="focusedInput" type="text" placeholder = "Admin ID" required>
                                          </div>
                                        </div>

									 <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="username" id="focusedInput" type="text" placeholder = "Username" required>
                                          </div>
                                        </div>
                  
                  
                                                     

                                                          <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="name" id="focusedInput" type="text" placeholder = "Name" required>
                                          </div>
                                        </div>

										
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
  $user_id = $_POST['id'];
$user = $_POST['username'];
//$pass = $_POST['password'];
$name = $_POST['name'];
$check ="creator";
//$email = $_POST['email'];
//$address = $_POST['address'];
//$contact = $_POST['contact'];
$img ="";


$query = mysql_query("SELECT * from admin where username='$user'  ")or die(mysql_error());
$count = mysql_num_rows($query);

if ($count > 0){ ?>
<script>
alert('Data Already Exist');
</script>
<?php
}else{
mysql_query("INSERT into admin (admin_id,username,name,position) values
  ('$user_id','$user','$name','$check')")or die(mysql_error());

mysql_query("INSERT into activity_log (date,username,action) values(NOW(),'$user_username','Add User $username')")or die(mysql_error());
?>
<script>
window.location = "system.php";
</script>
<?php
}
}
?>