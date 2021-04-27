<!DOCTYPE html>
<?php include('header.php'); ?>
<?php include('session.php'); ?>

    <?php include('navbar.php') ?>
<html>
<head>

      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          <div class="box box-success">
           
          
            <!-- /.chat -->
<?php 
      $id=$_SESSION['id'];
  $sqlad = mysql_query("SELECT * FROM admin Where id='$id'")or die (mysql_error());

   



  while($rowad= mysql_fetch_array($sqlad)){ 
           
       $fname= $rowad["fname"];
       $mname=$rowad["mname"];
       $lname=$rowad["lname"];
       $club=$rowad["club"];
     
              $user=$rowad["user"];
                            $id=$rowad["id"];
      
    
      

    }
  



?>
<center>
<div id="contactform">
<div id="formleft">
<form id="submitform" action="edit.php" method="post" enctype="multipart/form-data" name="submitform" >
  
<input name="id" type="hidden" class="ed" id="brnu" value="<?php echo $id;?>" />
<h3><b>Edit Your Profile</b></h3>
<br>
Username <br />
<input name="user" type="text" class="ed" id="U_Name" value="<?php echo $user;?>" required/>*
<br>
Lastname <br />
<input name="lname" type="text" class="ed" id="Last_Name" value="<?php echo $lname;?>"  pattern="[A-Za-z]{2,}" required/>*
<br>
Firstname <br />
<input name="fname" type="text" class="ed" id="First_Name" value="<?php echo $fname;?>"  pattern="[A-Za-z]{2,}" required/>*

<br>
Middlename <br />
<input name="mname" type="text" class="ed" id="Middle_Name" value="<?php echo $mname;?>"  pattern="[A-Za-z]{2,}" required/>*
<br>

<br>
club <br />
<input name="club" type="text" class="ed" id="year" value="<?php echo $club;?>"  pattern="[A-Za-z]{2,}" readonly/>*
<br>

<br>




<input type="submit" name="doRegister" value="save" id="doRegister" />
</form>

<form id="submitform" action="edit.php" method="post" enctype="multipart/form-data" name="submitform" >


<br><br><br>

Change Password<br>
Old Password<br />
<input name="oPword" type="password" class="ed" id="oPword"  />*
<br>

New Password<br />
<input name="nPword" type="password" class="ed" id="nPword" minlength="4" />*
<br>
<input type="submit" name="doUpdateP" value="save" id="doRegister" />
</form>

    </div>
  <div id="error">

  </div>
<div class="clear"></div>
</div>
</center>
      

          </div>
          <!-- /.box (chat box) -->

          <!-- TO DO List -->
        
</body>
</html>
