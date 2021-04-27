      	 <div id="view<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
          	   <div class="container-fluid">
            <div class="row-fluid">

                          
<script type="text/javascript">
function validateForm()
{
var x=document.forms["frmOne"].value;

var con = confirm("Are You Sure? you want to accept this Activity?");
if (con ==false)
{
return false;
}
}
</script>
<script type="text/javascript">
function validateForms()
{
var x=document.forms["frmtwo"].value;

var con = confirm("Are You Sure? you want to Declined this Activity?");
if (con ==false)
{
return false;
}
}
</script>

<?php 
       $statuz="main";
$query = mysql_query("SELECT * from admin where checks='$status' and id='$session_id'  ")or die(mysql_error());
                    $counta = mysql_num_rows($query);
                    if($counta>0){
            $status="OnGoing";
            }else{
              $status="Pending";
            }
$user_query = mysql_query("SELECT * from activity_proposal where status='$status' group by id desc")or die(mysql_error());

$count=mysql_num_rows($user_query);
if($count>0){
while($user_row = mysql_fetch_array($user_query)){
$club = $user_row['club'];

$id = $user_row['id'];
?>
                <!--/span-->
                  <form action="accepted.php?id=<?php echo $id ?>" NAME = "frmOne" onsubmit="return validateForm()" class="" method="post">
                    
              <!-- block -->
                        <!-- block -->
                     
            <font face="Arial" size="5px"   color="Black">ACTIVITY PROPOSAL FORM</font>
                <?php 

?>
            <font face="Arial" size="2px" color="Black">REQUESTING SHS CLUB/ SHS CLASS</font>
            <Input type="text" name="club" value="<?php echo $club ?>" style="width:820px;height:40px;" readonly>
            <Input type="text" name="id" value="<?php echo $user_row['id'] ?>" style="width:500px;height:0px;" readonly>  
  
            <font face="Arial" size="2px" color="Black">PERSON-IN-CHARGE FOR THE ACTIVITY</font>
            <Input type="text" name="adviser" value="<?php echo $user_row['adviser'] ?>" style="width:500px;height:40px;" readonly>
              <font face="Arial" size="2px" color="Black">TITLE OF THE ACTIVITY</font>
    <input type="Text" name="title" style="width:420px;height:40px;" value="<?php echo $user_row['title'] ?>" readonly>
                <font face="Arial" size="4px" color="Black">Proposed Budget</font>
    <input type="text" name="budget" style="width:140px;height:40px;" value="P <?php echo   number_format($user_row['budget']); ?>.00" readonly>
              <font face="Arial" size="2px" color="Black">RATIONALE OF THE ACTIVITY</font>
        <input type="text" name="rationale" style="width:757px;height:50px;" value="<?php echo $user_row['rationale'] ?>" readonly>
              <font face="Arial" size="2px" color="Black">OBJECTIVES OF THE ACTIVITY</font>
        <input type="text" name="objective" style="width:770px;height:40px;" value="<?php echo $user_row['objective'] ?>" readonly>
              <font face="Arial" size="2px" color="Black">TYPE OF ACTIVITY</font>
        <input type="text" name="activity" style="width:770px;height:40px;" value="<?php echo $user_row['activity_type'] ?>" readonly>
              <font face="Arial" size="2px" color="Black">DATE OF THE ACTIVITY</font>
  <input type="date" name="date_start" value="<?php echo $user_row['date_start'] ?>" readonly>
              <font face="Arial" size="2px" color="Black">To</font>
  <input type="date" name="date_end" value="<?php echo $user_row['date_end'] ?>" readonly>
              <font face="Arial" size="2px" color="Black">Venue</font>
        <input type="text" name="objective" style="width:270px;height:40px;" value="<?php echo $user_row['venue'] ?>" readonly>
<input  name="trans" type="hidden" value="<?php  echo   $trans=mt_rand(1000000,9999999); ?>"   readonly> 
            <font face="Arial" size="2px" color="Black">&nbspREACH OF ACTIVITY</font></div>
        <input type="text" name="objective" style="width:795px;height:90px;" value="<?php echo $user_row['activity_reach'] ?>" readonly>
                                
                                <?php } ?>
                                <div class="span15">
                <hr>
                                <center>
                                     <div class="control-group">
                        <div class="controls">

<button name="Upload" type="submit" value="Upload" class="btn btn-success" /><i class="icon-check"></i>&nbsp;Accept</button>  
 </form>
<form action="declined.php?id=<?php echo $id ?>" NAME = "frmtwo" onsubmit="return validateForms()" class="" method="post"> 
<button name="Declined" type="submit" value="Declined" class="btn btn-danger" /><i class="icon-trash"></i>&nbsp;Declined</button>
                      </form>
                  </div>
                  </div>  
              </center>
              </div>
                                              


                      
                  
<?php }else{ ?>

  <script>
alert('No Pending Forms.!');
  window.location = "admin_user.php";
  </script>

<?php } ?>
              
                        <script>
      jQuery(document).ready(function($){
        $("#add_downloadble").submit(function(e){
          e.preventDefault();
          var formData = $(this).serialize();
          $.ajax({
            type: "POST",
            url: "accepted.php",
            data: formData,
            success: function(html){
              $.jGrowl("Proposed activity Accepted", { header: 'Activity Saved' });
              window.location = 'activity_formx.php';
            }

          });
        });
      });
      </script>
 
          </div>
          </div>
          </div>