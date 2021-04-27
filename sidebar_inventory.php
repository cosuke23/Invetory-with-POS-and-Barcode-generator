    <div class="profile-v1-pp">         
                              <div class="profile-v1-pp">         
    
  <p class="centered"><img src=<?php echo "files/student_pics/".$stud_no.".jpg"; ?> style="height:250px;" ></p>
                   <div class="panel panel-default">
          <div class="panel-body"><h5>&nbsp; Hi' <?php
          include('session.php');
          
//get student info
$user_query = mysqli_query($conn,"SELECT * from user where user_id = '$session_id'")or die(mysqli_error());
$studinfo = mysqli_fetch_array($user_query);
$studname= $studinfo['username']. ' ' .$studinfo['usr_name'];
 echo $studname ?>&nbsp;</h5></div> 
          <div class="panel-footer" align="center"><strong>Employee</strong></div>
          </div>
          </div>
      
          </div>
  <div class="nav-side-menu">
                        <label >
                          <a href="home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                          <label >
                              <label>
                          <a href="sale.php"><i class="glyphicon glyphicon-home"></i>Sale</a>
                        </label><br>
                           <label>
                          <a href="e2e_stocks.php"><i class="glyphicon glyphicon-home"></i>Stocks</a>
                        </label><br>
                        
                          <label class="active">
                          <a href="e2e_view_items.php"><i class="glyphicon glyphicon-home"></i>View Items</a>
                        </label><br>
                       
             
                  
            
            <label><a href="logout.php">
                          <i class="glyphicon fa fa-power-off"></i>Logout</a>
                        </label><br>
            
                      </div>