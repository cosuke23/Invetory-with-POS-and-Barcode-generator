   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add student</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form method="POST">
									 <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="student" id="focusedInput" type="text" placeholder = "Student ID" required>
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
                                            <label>Gender</label>

 <input type="radio" name="gender" value="Male"  />Male &nbsp <input type="radio"  name="gender" value="Female" />Female
  </div>
                                        </div>

                                                            <div class="control-group">
                                          <div class="controls">
                                            <label>Birthday</label>
                                            <input class="input focused" name="birthday" id="focusedInput" type="date"  required>
                                          </div>
                                        </div>

                                              <div class="control-group">
                                          <div class="controls">
                          <label>Year</label>
                          <select name="year">
                            <option></option>
                            <option>Grade 11</option>
                            <option>Grade 12</option>
                          </select>
                                          </div>
                                        </div>

                                                                                      <div class="control-group">
                                          <div class="controls">
                          <label>Strand</label>
                          <select name="strand">
                                <?php
                                            $res=mysql_query("SELECT * from strands") or die(mysql_error());
                                           while($row=mysql_fetch_array($res)){ ?>
                            <option></option>
                            <option> <?php echo $row['strand']; ?> </option>
                        
                            
<?php } ?>

                          </select>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <div class="controls">
                                            <label>section</label>
                          <select name="section">
                                            <?php
                                            $res=mysql_query("SELECT * from section") or die(mysql_error());
                                           while($row=mysql_fetch_array($res)){ ?>
                          
                            <option></option>
                            <option><?php echo $row['section']; ?></option>
                       <?php } ?>
                          </select>
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
$name = $_POST['firstname'];
$lname = $_POST['lastname'];
$mname = $_POST['middlename'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$section = $_POST['section'];
$strand = $_POST['strand'];
$year = $_POST['year'];
$club ="Empty";
$student = $_POST['student'];
if($gender=='Male'){
$img ='Male.png';
$aimg='http://192.168.43.29/subok/profiles/Male.png';
}else{
$img ='Female.png';
$aimg='http://192.168.43.29/subok/profiles/Female.png';
 }
  $status="Choose";

$query = mysql_query("SELECT * from students where student_id = '$student'   ")or die(mysql_error());
$count = mysql_num_rows($query);

if ($count > 0){ ?>
<script>
alert('Data Already Exist');
</script>
<?php
}else{

mysql_query("insert into students (student_id,fname,mname,lname,password,birthday,gender,strand, section, year,club,status,img,a_img)
                      values('".$student."','".$name."', '".$mname."', '".$lname."', '".$mname."', '".$birthday."', '".$gender."','".$section."', '".$strand."', '".$year."', '".$club."', '".$status."', '".$img."', '".$aimg."') ") or die (mysql_error());

mysql_query("insert into activity_log (date,username,action) values(NOW(),'$user_username','Add User $username')")or die(mysql_error());
?>
      <script>alert('student successfully added!')</script>
<script>
window.location = "add_student.php";
</script>
<?php
}
}
?>