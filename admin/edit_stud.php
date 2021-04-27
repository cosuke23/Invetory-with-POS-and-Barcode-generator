   <div class="row-fluid">
   
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Edit student</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                  <?php

                $query = mysql_query("SELECT * from schedule where id = '$get_id'")or die(mysql_error());
                $row = mysql_fetch_array($query);
                ?>
								<form method="POST">
									 <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="student" id="focusedInput" type="text" value="<?php echo $row['student_id'] ?>" placeholder = "Student ID" required>
                                          </div>
                                        </div>
                  
                  	<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="firstname" id="focusedInput" type="text" value="<?php echo $row['fname'] ?>" placeholder = "Firstname" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="middlename" id="focusedInput" type="text" value="<?php echo $row['mname'] ?>" placeholder = "Middlename" required>
                                          </div>
                                        </div>
										        <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="club" id="focusedInput" type="text" value="<?php echo $row['club'] ?>" placeholder = "Middlename" required>
                                          </div>
                                        </div>
                    
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="lastname" id="focusedInput" type="text" value="<?php echo $row['lname'] ?>" placeholder = "Lastname" required>
                                          </div>
                                        </div>
                                                <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="status" id="focusedInput" type="text" value="<?php echo $row['status'] ?>" placeholder = "Middlename" required>
                                          </div>
                                        </div>
                            <div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="img" id="focusedInput" type="hidden" value="<?php echo $row['img'] ?>" placeholder = "Middlename" required>
                                          </div>
                                        </div>
                    

                                                            <div class="control-group">
                                          <div class="controls">
                                            <label>Gender</label>
<?php 
$gender=$row['gender'];
if($gender=="male"){
echo ' <input type="radio" name="gender" value="male"  checked/>Male &nbsp <input type="radio"  name="gender" value="female" />Female';
 }else{
 echo '<input type="radio" name="gender" value="male" />Male &nbsp <input type="radio"  name="gender" value="female" checked/>Female';
}
 ?>
  </div>
                                        </div>

                                                            <div class="control-group">
                                          <div class="controls">
                                            <label>Birthday</label>
                                            <input class="input focused" name="birthday" value="<?php echo $row['birthday'] ?>" id="focusedInput" type="date"  required>
                                          </div>
                                        </div>

                                              <div class="control-group">
                                          <div class="controls">
                          <label>Year</label>
                          <select name="year" >
                            <option><?php echo $row['year'] ?></option>
                            <option>Grade 11</option>
                            <option>Grade 12</option>
                          </select>
                                          </div>
                                        </div>

                                                                                      <div class="control-group">
                                          <div class="controls">
                          <label>Strand</label>
                          <select name="strand">
                            <option><?php echo $row['strand'] ?></option>
                            <option> ABM </option>
                            <option> STEM </option>
                            <option> HUMSS </option>
                            <option> GAS </option>
                            <option> ICT </option>
                            <option> HE </option>
                            <option> IA </option>
                            


                          </select>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <div class="controls">
                          <label>section</label>
                          <select name="section">
                            <option><?php echo $row['section'] ?></option>
                            <option>101</option>
                            <option>102</option>
                            <option>103</option>
                            <option>104</option>
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
$club =$_POST['club'];
$student = $_POST['student'];
$img =$_POST['img'];
  $status=$_POST['status'];


mysql_query("UPDATE students  set student_id='$student' , fname='$name', mname='$mname',  lname='$lname',  birthday='$birthday',  gender='$gender',  strand='$strand',   section='$section',   year='$year',  club='$club', status='$status', img='$img' where student_id=$get_id ") or die (mysql_error());

mysql_query("insert into activity_log (date,username,action) values(NOW(),'$user_username','Edit Student $student $name $lname')")or die(mysql_error());
?>
      <script>alert('student successfully updated!')</script>

<?php

}
?>