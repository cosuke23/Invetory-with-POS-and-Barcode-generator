<?php

include('dbcon.php');
        $id=$_GET['id'];
  error_reporting(0);

if(isset($_POST['btn-signup'])){
               $club = $_POST['strand'];  


        $c_img='sample.png';
        $data='';
        mysql_query("UPDATE section set section ='$club' where id='$id' ") or die (mysql_error());

		?>
        <script>alert('section edited ');</script>
     
        <?php
	
}

?> 
<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Strand</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
 <?php $user_query = mysql_query("SELECT * from section where id='$id'")or die(mysql_error());
$rows = mysql_fetch_array($user_query);
$check_count=mysql_num_rows($user_query); ?>
								<form id="add_student" method="post">
								
                    <div class="control-group">
                                          <div class="controls">
                                            <input name="strand" class="input focused" id="focusedInput" type="text" value="<?php echo $rows['section']; ?>"  required>
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
					
	