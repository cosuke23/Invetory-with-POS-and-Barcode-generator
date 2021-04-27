   <div class="row-fluid">
                        <!-- block -->
                        <a href="add_mod.php<?php echo '?id='.$get_id; ?>" class="btn btn-info"><i class="icon-plus-sign icon-large"></i> Add Another Moderator to a Club</a>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Edit Club</div>
                            </div>
                            <div class="block-content collapse in">
							<?php
							$query = mysql_query("SELECT * from club_advisers  where id = '$get_id'")or die(mysql_error());
							$row = mysql_fetch_array($query);
							?>
                                <div class="span12">
								<form method="post">
								
                    <div class="control-group">
                                          <div class="controls">
                                            <input name="un1" value="<?php echo $row['c_name']; ?>" class="input focused" id="focusedInput" type="text" placeholder = "ID Number" readonly>
                                          </div>
                                        </div>
								
										<div class="control-group">
                                          <div class="controls">
                                            <input name="un" value="<?php echo $row['c_adviser']; ?>" class="input focused" id="focusedInput" type="text" placeholder = "ID Number" required>
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
                               
                                $un = $_POST['un'];
                      

								mysql_query("UPDATE clubs set c_adviser = '$un'  where adviser_id = '$get_id' ")or die(mysql_error());

								?>
 
								<script>

								</script>

                       <?php     }  ?>
	