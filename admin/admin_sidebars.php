     <div class="span3" id="sidebar">
<?php
$que=mysql_query("SELECT * from maintenance")or die (mysql_error());
$count=mysql_fetch_array($que);
if($count==0){
 ?>
       <form action="system_triger.php" method="post">
  <a data-toggle="modal" href="#Election" id="delete"  class="btn btn-danger" name=""><i class="icon-group icon-large"></i> Start System Maintence</a>
                        
                          <?php include('maintenance_modal.php'); ?>
                      
                       </form>
                       <?php }else { ?>
                        <form action="system_triger.php" method="post">
  <a data-toggle="modal" href="#stop_now" id="stop"  class="btn btn-success" name=""><i class="icon-group icon-large"></i> Stop System Maintence</a>
                        
                          <?php include('modal_delete.php'); ?>
                      
                       </form>
                       <?php } ?>

 <?php
if(isset($_POST['subpic'])){
  

   move_uploaded_file($_FILES['ppic']['tmp_name'],"../images/".$_FILES['ppic']['name']);
              

     mysql_query("UPDATE android SET file = '".$_FILES['ppic']['name']."' ")or die(mysql_error());      
      
}
?>      
   <?php
$query = mysql_query("SELECT * from activity_proposal where status='Pending'  ")or die(mysql_error());
                    $count = mysql_num_rows($query);
            ?>

<form action="" method="post" enctype="multipart/form-data">
                       Upload APK<input type="file" name="ppic">
                       <input type="Submit" name="subpic">
</form>
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li class="active"> <a href=""><i class="icon-chevron-right"></i><i class="icon-home"></i>&nbsp;Category</a> </li>

                        <li class="dropdown-submenu" >
                     <a tabindex="-1" href="#"><i class="icon-wrench"></i>Maintenance</a>
    <ul class="dropdown-menu">
                         <li>
                            <a href="system.php"><i class="icon-user"></i> Admin</a>
                        </li>
                        <li>
                            <a href="admin_user.php"><i class="icon-user"></i> Moderator</a>
                        </li>
                        <li>
                            <a href="club.php"><i class="icon-user"></i> Club</a>
                        </li>
                                                <li>
                            <a href="add_student.php"><i class="icon-user"></i> Student</a>
                        </li>
                                              <li>
                            <a href="strand.php"><i class="icon-user"></i> SHS strands</a>
                        </li>
                                              <li>
                            <a href="section.php"><i class="icon-user"></i> Section</a>
                        </li>
                  
    </ul>
  </li>
            <li class="dropdown" >
             
  </li>
      <li class="dropdown" >
                            <a href="add_announcement.php"></i><i class="icon-wrench"></i>System Announcement</a>
  </li>

                    <li class="dropdown" >
                            <a href="calendar_of_events.php"></i><i class="icon-calendar"></i>Calendar of Events</a>
  </li>

                   
                    <li class="dropdown-submenu" >
                 <span class="label label-primary pull-right"><?php echo $count ?> </span>
                            <a href="activity_form.php"></i><i class="icon-file"></i>Activity Proposals</a>
   <ul class="dropdown-menu">
    <li>
                            <a href="activity_formx.php"><i class="icon-file"></i>Accepted</a>
                        </li>
                        <li>
                                           <span class="label label-primary pull-right"><?php echo $count ?> </span>
                            <a href="activity_forms.php"><i class="icon-file"></i> Pending</a>
                        </li> 
   </ul>
  </li>
                      <li class="dropdown" >
                            <a href="liquid.php"></i><i class="icon-file"></i>Liquidation Forms</a>
  </li>


                    <li class="dropdown" >
                            <a href="activity_log.php"><i class="icon-download"></i> Activity log</a>
  
  </li>

                 
                     
                      
        



                    </ul>

                </div>

       