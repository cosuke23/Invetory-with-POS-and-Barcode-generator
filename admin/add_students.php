<?php

include('dbcon.php');
      
if(isset($_POST['btn-signup'])){
               $club = $_POST['club']; 
               $class_id = $_POST['class_id'];  
      $user_query = mysql_query("select * from club_advisers where adviser_id = '$class_id'")or die(mysql_error());
$user_row = mysql_fetch_array($user_query);
$fname = $user_row['fname'];
$lname = $user_row['lname'];

$check=mysql_query("SELECT * FROM clubs where c_name='$club'")or die(mysql_error());
$check_count=mysql_num_rows($check);

	if($check_count<1){

    mysql_query("CREATE TABLE IF NOT EXISTS  ".$club." (id int(11) NOT NULL AUTO_INCREMENT,student_id varchar(250) NOT NULL,fname varchar(250) NOT NULL,mname varchar(250) NOT NULL
    ,lname varchar(250) NOT NULL,birthday varchar(250) NOT NULL,gender varchar(250) NOT NULL,section varchar(250) NOT NULL,strand varchar(250) NOT NULL,year varchar(250) NOT NULL
    ,club varchar(250) NOT NULL,PRIMARY KEY(id))");
    
			
        $c_img='msco.png';
        $data='';
        mysql_query("insert into clubs (c_name,c_img,data,c_adviser)
                      values('".$club."','".$c_img."', '".$data."', '".$fname." ".$lname."') ") or die (mysql_error());
        mysql_query("update club_advisers set club = '$club'   where adviser_id = '$class_id' ")or die(mysql_error());
		?>
        <script>alert('successfully registered ');</script>
        <?php
	}
	else
	{
		?>
        <script>alert('Club organization Already Registered...');</script>
        <?php
	}
}

?> 
<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Club</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form id="add_student" method="post">
								
								        <div class="control-group">
                                   <label>Adviser</label>
                                          <div class="controls">
                                            <select  name="class_id" class="" required>
                                             	<option></option>
											<?php
                      
											$cys_query = mysql_query("SELECT * from club_advisers where club='Empty' order by adviser_id  ");
											while($cys_row = mysql_fetch_array($cys_query)){
											
											?>
											<option value="<?php echo $cys_row['adviser_id']; ?>"><?php echo $cys_row['fname']; ?> <?php echo $cys_row['mname']; ?> <?php echo $cys_row['lname']; ?></option>
											<?php } ?>
                                            </select>
                                          </div>
                                        </div>
                    <div class="control-group">
                                          <div class="controls">
                                            <input name="club" class="input focused" id="focusedInput" type="text" placeholder = "Club Name" required>
                                          </div>
                                        </div>								
									
<?php
  function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
    $str = null;
    
    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ) {
      $str .= $chars[ rand( 0, $size - 1 ) ];
    }
    
    return $str;
  }
?>

                    <div class="control-group">
                                          <div class="controls">
                                            <input  name="code" class="input focused" id="focusedInput" type="hidden" value='<?php echo rand_string( 6 ); ?>' readonly>
                                          </div>
                                        </div>
								
										<tr>
<td><button type="submit" name="btn-signup" class="btn btn-info"><i class="icon-plus-sign icon-large"></i></button></td>
</tr>

                                </form>
								</div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
	