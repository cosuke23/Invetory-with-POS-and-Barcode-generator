\<?php  include('header.php'); ?>
<?php  include('session.php'); ?>
    <body>
		<?php include('navbar.php') ?>
        <div class="container-fluid">
            <div class="row-fluid">
					<?php include('admin_sidebar.php'); ?>
                                      <script language="javascript">
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,widtd=900, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("print_content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<html><head><title>MSC0</title>'); 
   docprint.document.write('</head><body onLoad="self.print()" style="widtd: 900px; font-size:16px; font-family:arial;">');          
   docprint.document.write(content_vlue);          
   docprint.document.write('</body></html>'); 
     docprint.document.close(); 
   docprint.focus(); 
}
</script>
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
<style>
#print_content{

margin:0 auto;
}
</style>

<?php 
       $statuz="main";
$query = mysql_query("SELECT * from admin where checks='$status' and id='$session_id'  ")or die(mysql_error());
                    $counta = mysql_num_rows($query);
                    if($counta>0){
            $status="OnGoing";
            }else{
              $status="Pending";
            }
                        $act_id=$_GET['id'];
$user_query = mysql_query("SELECT * from activity_proposal where status='$status' and id='$act_id' group by id desc")or die(mysql_error());

$count=mysql_num_rows($user_query);
if($count>0){
while($user_row = mysql_fetch_array($user_query)){
$club = $user_row['club'];

$id = $user_row['id'];
?>
                <!--/span-->
                <div id="print_content">
                <div class="span9" id="content">

								        <div id="block_bg" class="block">
                
								<div class="block-content collapse in">
									<div id="print_content">
								  <form action="accepted.php?id=<?php echo $id ?>" NAME = "frmOne" onsubmit="return validateForm()" class="" method="post">
										
							<!-- block -->
                        <!-- block -->
                     <a href="budget_view.php"><i class="icon-arrow-left"></i> Back</a>

                </div>

                            </div>
                            <center>
                              <?php
                              $status="main";
$query = mysql_query("SELECT * from admin where checks='$status' and id='$session_id'  ")or die(mysql_error());
                    $count = mysql_num_rows($query);
                    if($count>0){
                               ?>
                           Date Start <Input type="date" name="date_start"  required> Date End <Input type="date" name="date_end" required>   
                           <?php }else { ?>


                           <?php } ?>
                            </center>
<div id="main">

            <br>
            <font face="Arial" size="5px"   color="Black">ACTIVITY PROPOSAL FORM</font>
          </div>
              <div id="main1">
                <?php 

?>
            <font face="Arial" size="2px" color="Black">REQUESTING SHS CLUB/ SHS CLASS</font>
</div>
    <div id="main2">
            <Input type="text" name="club" value="<?php echo $club ?>" style="width:820px;height:40px;" readonly>
            <Input type="text" name="id" value="<?php echo $user_row['id'] ?>" style="width:500px;height:0px;" readonly>  
  
</div>
    <div id="main3">
            <font face="Arial" size="2px" color="Black">PERSON-IN-CHARGE FOR THE ACTIVITY</font>
</div>
<div id="main4">
            <Input type="text" name="adviser" value="<?php echo $user_row['adviser'] ?>" style="width:500px;height:40px;" readonly>
</div>
<div id="main5">
              <font face="Arial" size="2px" color="Black">TITLE OF THE ACTIVITY</font>
</div>
<div id="main6">
    <input type="Text" name="title" style="width:420px;height:40px;" value="<?php echo $user_row['title'] ?>" readonly>
</div>
<div id="main5">
                <font face="Arial" size="4px" color="Black">Proposed Budget</font>
  </div>
  <div id="mains">
    <input type="text" name="budget" style="width:140px;height:40px;" value="P <?php echo   number_format($user_row['budget']); ?>.00" readonly>
  </div>
<div id="main7">
              <font face="Arial" size="2px" color="Black">RATIONALE OF THE ACTIVITY</font>
              
</div>
<div id="main8">
        <input type="text" name="rationale" style="width:757px;height:50px;" value="<?php echo $user_row['rationale'] ?>" readonly>
                   
</div>
<div id="main9">
              <font face="Arial" size="2px" color="Black">OBJECTIVES OF THE ACTIVITY</font>
</div>
<div id="main10">
        <input type="text" name="objective" style="width:770px;height:40px;" value="<?php echo $user_row['objective'] ?>" readonly>
                    
            </div>        
<div id="main11">
              <font face="Arial" size="2px" color="Black">TYPE OF ACTIVITY</font>
</div>
<div id="main12">
        <input type="text" name="activity" style="width:770px;height:40px;" value="<?php echo $user_row['activity_type'] ?>" readonly>
    </div>
<div id="main13">
              <font face="Arial" size="2px" color="Black">DATE OF THE ACTIVITY</font>
</div>
<div id="main14">
  <input type="date" name="date_start" value="<?php echo $user_row['date_start'] ?>" readonly>
</div>
<div id="main14s">
              <font face="Arial" size="2px" color="Black">To</font>
</div>
<div id="main14">
  <input type="date" name="date_end" value="<?php echo $user_row['date_end'] ?>" readonly>
</div>
<div id="main15">
              <font face="Arial" size="2px" color="Black">Venue</font>
</div>
<div id="main16">
        <input type="text" name="objective" style="width:270px;height:40px;" value="<?php echo $user_row['venue'] ?>" readonly>
</div>
<input  name="trans" type="hidden" value="<?php  echo   $trans=mt_rand(1000000,9999999); ?>"   readonly> 
<div id="main17">
            <font face="Arial" size="2px" color="Black">&nbspREACH OF ACTIVITY</font></div>
<div id="main18">
        <input type="text" name="objective" style="width:795px;height:90px;" value="<?php echo $user_row['activity_reach'] ?>" readonly>
    </div>

						  
										</div>
                                </div>	
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
 
    </body>

</html>