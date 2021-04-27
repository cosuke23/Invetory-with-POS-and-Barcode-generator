<?php include('header.php'); ?>
<?php include('session.php'); ?>
    <body>
		<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('track_sidebar.php'); ?>
		
						<div class="span9" id="content">
		                    <div class="row-fluid">
							
		                        <!-- block -->
		                        <div class="block">
		                            <div class="navbar navbar-inner block-header">
		                                <div class="muted pull-left">Add Track</div>
		                            </div>
		                            <div class="block-content collapse in">
									<a href="subjects.php"><i class="icon-arrow-left"></i> Back</a>
									    <form class="form-horizontal" method="post">
									    	<div class="control-group">
											<label class="control-label" for="inputPassword">Track</label>
											<div class="controls">
												<select name="track">
													<option></option>
													<option>ACADEMIC TRACK</option>
													<option>TECHNICAL-VOCATIONAL-LIVELIHOOD TRACK</option>
												</select>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="inputEmail">Course</label>
											<div class="controls">
											<input type="text" name="course" id="inputEmail" placeholder="Course">
											</div>
										</div>
								
										<div class="control-group">
											<label class="control-label" for="inputPassword">Description</label>
											<div class="controls">
													<textarea name="description" id="ckeditor_full"></textarea>
											</div>
										</div>
												
																		
											
										<div class="control-group">
										<div class="controls">
										
										<button name="save" type="submit" class="btn btn-info"><i class="icon-save"></i> Save</button>
										</div>
										</div>
										</form>
										
										<?php
										if (isset($_POST['save'])){
										$track = $_POST['track'];
										$course = $_POST['course'];
										$description = $_POST['description'];
									
										
										
										$query = mysql_query("select * from course_track where course = '$course' ")or die(mysql_error());
										$count = mysql_num_rows($query);

										if ($count > 0){ ?>
										<script>
										alert('Data Already Exist');
										</script>
										<?php
										}else{
										mysql_query("insert into course_track (track,course,description) values('$track','$course','$description')")or die(mysql_error());
										
										
										mysql_query("insert into activity_log (date,username,action) values(NOW(),'$user_username','Add track $course')")or die(mysql_error());
										
										
										?>
										<script>
										window.location = "track.php";
										</script>
										<?php
										}
										}
										
										?>
									
								
		                            </div>
		                        </div>
		                        <!-- /block -->
		                    </div>
		                </div>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>

</html>