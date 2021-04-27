   <div class="row-fluid">
                       <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Edit Moderator</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								
								<form method="post">
                
                  <div class="control-group">
                                          <div class="controls">
                                          <select name='admin' value="<?php echo $row['id']; ?>">
                                          <?php
                $query = mysql_query("SELECT * from admin ")or die(mysql_error());
                while($row = mysql_fetch_array($query)){
                ?>
                                            <option class="input focused" value="<?php echo $row['id']; ?>"   required><?php echo $row['id']; ?>
                                            <?php
                                          }
                                            ?>
                                            </select>
                                          </div>
                                        </div>

                                         <div class="control-group">
                                          <div class="controls">
                                           <select name="monday">
                                            <option value="No-Schedule">No-Schedule</option>
                                            <option value="Monday">Monday</option>
                                          </select>
                                          <br/>
                  Time-In <input class="input focused"   name="m-in" id="focusedInput" type="time" style="width: 80px"  >
                 Time-Out <input class="input focused"   name="m-o" id="focusedInput" type="time" style="width: 80px"  >
                                          </div>
                                        </div>

                                        <div class="control-group">
                                          <div class="controls">
                                            <select name="tuesday">
                                            <option value="No-Schedule">No-Schedule</option>
                                            <option value="Tuesday">Tuesday</option>
                                          </select>
                                          <br/>
                  Time-In <input class="input focused"   name="t-in" id="focusedInput" type="time" style="width: 80px"  >
                 Time-Out <input class="input focused"   name="t-o" id="focusedInput" type="time" style="width: 80px"  >
                                          </div>
                                        </div>

								   <div class="control-group">
                                          <div class="controls">
                                            <select name="wednesday">
                                            <option value="No-Schedule">No-Schedule</option>
                                            <option value="Wednesday">Wednesday</option>
                                          </select>
                                          <br/>
                 Time-In <input class="input focused"   name="w-in" id="focusedInput" type="time" style="width: 80px"  >
                 Time-Out <input class="input focused"   name="w-o" id="focusedInput" type="time" style="width: 80px"  >
                                          </div>
                                        </div>
										
										     <div class="control-group">
                                          <div class="controls">
                                           <select name="thursday">
                                            <option value="No-Schedule">No-Schedule</option>
                                            <option value="Thursday">Thursday</option>
                                          </select>
                                          <br/>
                 Time-In <input class="input focused"   name="th-in" id="focusedInput" type="time" style="width: 80px"  >
                 Time-Out <input class="input focused"   name="th-o" id="focusedInput" type="time" style="width: 80px" >
                                          </div>
                                        </div>
										
										  <div class="control-group">
                                          <div class="controls">
                                           <select name="friday">
                                            <option value="No-Schedule">No-Schedule</option>
                                            <option value="Friday">Friday</option>
                                          </select>
                                          <br/>
                 Time-In <input class="input focused"   name="f-in" id="focusedInput" type="time" style="width: 80px" >
                 Time-Out <input class="input focused"   name="f-o" id="focusedInput" type="time" style="width: 80px"  >
                                          </div>
                                        </div>

                                          <div class="control-group">
                                          <div class="controls">
                                           <select name="saturday">
                                            <option value="No-Schedule">No-Schedule</option>
                                            <option value="Saturday">Saturday</option>
                                          </select>
                                          <br/>
                 Time-In <input class="input focused"   name="s-in" id="focusedInput" type="time" style="width: 80px" >
                 Time-Out <input class="input focused"   name="s-o" id="focusedInput" type="time" style="width: 80px" >
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

$admin = $_POST['admin'];
$monday = $_POST['monday'];
$mi = $_POST['m-in'];
$mo = $_POST['m-o'];
$tuesday = $_POST['tuesday'];
$ti = $_POST['t-in'];
$to = $_POST['t-o'];
$wednesday = $_POST['wednesday'];
$wi = $_POST['w-in'];
$wo = $_POST['w-o'];
$thursday = $_POST['thursday'];
$thi = $_POST['th-in'];
$tho = $_POST['th-o'];
$friday = $_POST['friday'];
$fi = $_POST['f-in'];
$fo = $_POST['f-o'];
$saturday = $_POST['saturday'];
$si = $_POST['s-in'];
$si = $_POST['s-o'];
$query = mysql_query("SELECT * from schedule where stud_no='$admin'   ")or die(mysql_error());
$count = mysql_num_rows($query);

if ($count > 0){ ?>
<script>
alert('Data Already Exist');
</script>
<?php
}else{
if($monday!='No-Schedule'){
mysql_query("INSERT INTO `schedule`( `stud_no`, `day`, `start_time`, `end_time`) VALUES ('$admin','$monday','$mi','$mo') ")or die(mysql_error());
}
if($tuesday!='No-Schedule'){
mysql_query("INSERT INTO `schedule`( `stud_no`, `day`, `start_time`, `end_time`) VALUES ('$admin','$tuesday','$ti','$to') ")or die(mysql_error());
}
if($wednesday!='No-Schedule'){
mysql_query("INSERT INTO `schedule`( `stud_no`, `day`, `start_time`, `end_time`) VALUES ('$admin','$wednesday','$wi','$wo') ")or die(mysql_error());
}
if($thursday!='No-Schedule'){
mysql_query("INSERT INTO `schedule`( `stud_no`, `day`, `start_time`, `end_time`) VALUES ('$admin','$thursday','$thi','$tho') ")or die(mysql_error());
}
if($friday!='No-Schedule'){
mysql_query("INSERT INTO `schedule`( `stud_no`, `day`, `start_time`, `end_time`) VALUES ('$admin','$friday','$fi','$fo') ")or die(mysql_error());
}
if($saturday!='No-Schedule'){
mysql_query("INSERT INTO `schedule`( `stud_no`, `day`, `start_time`, `end_time`) VALUES ('$admin','$saturday','$si','$mo') ")or die(mysql_error());
}
}
?>
<script>
  window.location = "admin_user.php"; 
</script>
<?php
}
?>