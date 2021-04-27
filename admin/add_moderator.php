   <div class="row-fluid">
                        <!-- block -->	
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Additional Moderator</div>
                            </div>
                            <div class="block-content collapse in">
							<?php
							$query = mysql_query("select * from clubs  where c_id = '$get_id'")or die(mysql_error());
							$row = mysql_fetch_array($query);
							?>
                                <div class="span12">
								<form method="post">
								
                    <div class="control-group">
                                          <div class="controls">
                                            <input name="un" value="<?php echo $row['c_name']; ?>" class="input focused" id="focusedInput" type="text" placeholder = "ID Number" readonly>
                                          </div>
                                        </div>
								
										<div class="control-group">
                                          <div class="controls">
                                            <input name="a_id" value="" class="input focused" id="focusedInput" type="text" placeholder = "ID Number" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input name="fn"  value=""  class="input focused" id="focusedInput" type="text" placeholder = "Firstname" required>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <div class="controls">
                                            <input  name="mn"  value="" class="input focused" id="focusedInput" type="text" placeholder = "Middlename" required>
                                          </div>
                                        </div>										
										<div class="control-group">
                                          <div class="controls">
                                            <input  name="ln"  value="" class="input focused" id="focusedInput" type="text" placeholder = "Lastname" required>
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
                            if (isset($_POST['update'])) {
                               
                                $club = $_POST['un'];
                                $adviser = $_POST['a_id'];
                                $fname = $_POST['fn'];
                                $middle = $_POST['mn'];
                                $lastname = $_POST['ln'];
                                $query = mysql_query("SELECT adviser_id,club,count(club) as cnt where adviser_id='$adviser' and club='$club'  ")or die(mysql_error());
$count = mysql_num_rows($query);

if ($count > 0){ ?>
<script>
alert('Data Already Exist');
window.location = "add_mod.php";
</script>
<?php
}else{
                                
                                                          $query = mysql_query("SELECT * from clubs where c_id = '$get_id'") or die(mysql_error());
                                    while ($row = mysql_fetch_array($query)) {
                                        $img = $row['c_img'];
                                        $data = $row['data'];
                                        $mem = $row['c_members'];
                                        $link = $row['c_link'];
                                        $c_adviser = $row['c_adviser'];


                                    }
mysql_query("INSERT into club_advisers (adviser_id,fname,mname,lname,password,club) values('$adviser','$fname','$middle','$lastname','$lastname','$club')")or die(mysql_error());
mysql_query("UPDATE clubs set c_adviser = '$c_adviser & $middle $lastname $lastname'  where c_id = '$get_id' ")or die(mysql_error());
								}
								?>
 
								<script>

								</script>

                       <?php     }  ?>
	