  <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
            
<p class="centered"><img src="files/student_pics/<?php echo $stud_no;?>.jpg" style="width:200px;height:250px;" ></p>
              	  <h5 class="centered"><?php echo $stud_no; ?></h5>
                  <h5 class="centered"><?php echo $studname; ?></h5>
				  <h6 class="centered" style="color:#ffffff"><?php echo $title; ?></h6>
              	  	
                  <li class="mt">
                      <a class="active" href="home.php">
                          <i class="fa fa-home"></i>
                          <span>Home</span>
                      </a>
                  </li>
                  <?php
                  if($stud_no=='1'){
                    ?>
				         
                  <?php
                }
                else{?>
                  <li class="sub-menu">
                      <a href="change_picture.php">
                          <i class="fa fa-user"></i>
                          <span>Change Profile</span>
                      </a>
                  </li>
                <?php
              }?> 
			
             <?php
             error_reporting(0);
             require('db.php');
     $user_query = mysqli_query($conn,"SELECT * from user where user_id = '$session_id'")or die(mysqli_error());
$user_row = mysqli_fetch_array($user_query);

$admin = $user_row['user_id'];
if($stud_no==1){
?>
<li class="sub-menu">
                      <a href="admin/calendar_of_events.php">
                          <i class="fa fa-calendar"></i>
                          <span>Event Calendar</span>
                      </a>
                  </li>
<?php 
      }
      ?>  
               
                            

				  <li class="sub-menu">
                      <a href="logout.php">
                          <i class="fa fa-gear"></i>
                          <span>Logout</span>
                      </a>
                  </li>

              </ul>
			  
              <!-- sidebar menu end-->
          </div>
      </aside>