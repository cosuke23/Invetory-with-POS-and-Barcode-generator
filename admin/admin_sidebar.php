     <div class="span3" id="sidebar">

      
                    




                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li class="active"> <a href=""><i class="icon-chevron-right"></i><i class="icon-home"></i>&nbsp;Category</a> </li>
 </li>
      <li class="dropdown" >
                            <a href="../home.php"></i><i class="icon-home"></i>Home</a>
  </li>
                        <li class="dropdown-submenu" >
                     <a tabindex="-1" href="#"><i class="icon-wrench"></i>Maintenance</a>
    <ul class="dropdown-menu">
        <?php
        $status="creator";
$query = mysql_query("SELECT * from admin where position='$status' and id='$session_id'  ")or die(mysql_error());
                    $counta = mysql_num_rows($query);
                    if($counta>0){
            ?>
    <li>
                            <a href="system.php"><i class="icon-user"></i> Admin</a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="admin_user.php"><i class="icon-user"></i> Moderator</a>
                        </li>
                        <li>
                            <a href="edit_shs.php"><i class="icon-user"></i> Schedules</a>
                        </li>
                     
                       
                  
    </ul>
  </li>
            <li class="dropdown" >
             
  </li>
      <li class="dropdown" >
                            <a href="add_announcement.php"></i><i class="icon-wrench"></i>Announcement</a>
  </li>

                    <li class="dropdown" >
                            <a href="calendar_of_events.php"></i><i class="icon-calendar"></i>Calendar of Events</a>
  </li>
               <li class="dropdown" >
                            <a href="../e2e_view_items.php"></i><i class="icon-calendar"></i>e2e Inventory</a>
 
                   
    



      

                 
                     
                      
        



                    </ul>

                </div>

       