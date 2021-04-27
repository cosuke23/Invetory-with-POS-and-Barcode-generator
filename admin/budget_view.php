<?php include('header.php'); ?>
<?php include('session.php'); ?>
    <body>
		<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('admin_sidebar.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">

                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Content</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
									<form action="delete_content.php" method="post">
  									<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
									
									<thead>
										        <tr>

												 <th>Title</th>
												 <th>club</th>
                         <th>Adviser</th>
                         <th>budget</th>
                         <th></th>
                                   
												</tr>
												
										</thead>
										<tbody>
											
             	
<?php 
       $statuz="main";
$query = mysql_query("SELECT * from admin where checks='$status' and id='$session_id'  ")or die(mysql_error());
                    $counta = mysql_num_rows($query);
                    if($counta>0){
            $status="OnGoing";
            }else{
              $status="Pending";
            }

$user_query = mysql_query("SELECT * from activity_proposal where status='$status'  group by id desc")or die(mysql_error());

$count=mysql_num_rows($user_query);
if($count>0){
while($user_row = mysql_fetch_array($user_query)){
$club = $user_row['club'];
$id = $user_row['id'];
$title = $user_row['title'];

$id = $user_row['id'];
?>
                         
                                         <td><?php echo $title; ?></td>
                                         <td><?php echo $club; ?></td>
                                         <td><?php echo $user_row['adviser']; ?></td>
                                         <td>&#8369  <?php echo number_format($user_row['budget']); ?></td>
               <td width="30"><a href="activity_forms.php?id=<?php echo $id ?>" id="delete"  class="btn btn-success" name="">Show</a>
                  
                  </td>
    
                                     
                               
                                </tr>
                         <?php } }?>
						   
                              
										</tbody>
									</table>
									</form>

                                </div>
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