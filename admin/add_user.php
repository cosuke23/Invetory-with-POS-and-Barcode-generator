   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Moderator</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form method="post">
                <div class="control-group">
                                          <div class="controls">
                                             <select name="user_type" id="user_type" class="form-control" maxlength="=40" />
                                  <option value="">Position</option>
                                  <option value="OJT-IT">OJT-IT</option>
                                  <option value="OJT-None IT">OJT-None IT</option>
                                  <option value="Student Assistant">Student Assistant</option>
                                  </select>
                                          </div>
                                        </div>
                                         <div class="control-group">
                                          <div class="controls">
                                             <select name="title" id="user_type" class="form-control" maxlength="=40" />
                                  <option value="">Title</option>
                                  <option value="Mr.">Mr.</option>
                                  <option value="Ms.">Ms.</option>
                                  <option value="Mrs.">Mrs.</option>
                                  </select>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="student" id="focusedInput" type="text" placeholder = "student ID" required>
                                          </div>
                                        </div>
                  
                  	<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="firstname" id="focusedInput" type="text" placeholder = "Firstname" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="middlename" id="focusedInput" type="text" placeholder = "Middlename" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="lastname" id="focusedInput" type="text" placeholder = "Lastname" required>
                                          </div>
                                        </div>

                                         <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="email" id="focusedInput" type="text" placeholder = "Email" required>
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
$user = $_POST['user_type'];
$title = $_POST['title'];
$email = $_POST['email'];
$student = $_POST['student'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$middle = $_POST['middlename'];
$club ="Empty";
$adviser = 2;
$img ="";


$query = mysql_query("SELECT * from staff where staff_id='$adviser'  ")or die(mysql_error());
$count = mysql_num_rows($query);

if ($count > 0){ ?>
<script>
alert('Data Already Exist');
</script>
<?php
}else{
mysql_query("INSERT into staff (admin_id,staff_id,fname,mname,lname,position,title,status,email) values('$adviser','$student','$firstname','$middle','$lastname','$user','$title','On Going','$email')")or die(mysql_error());

mysql_query("insert into activity_log (date,username,action) values(NOW(),'$user_username','Add User $username')")or die(mysql_error());
?>
<script>
window.location = "admin_user.php";
</script>
<?php
}
}
?>