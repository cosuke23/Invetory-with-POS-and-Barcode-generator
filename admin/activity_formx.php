<?php  include('header.php'); ?>
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
<style>
#print_content{

margin:0 auto;
}
</style>

<?php 
$user_query = mysql_query("SELECT * from activity_proposal where status='Accepted' group by id desc")or die(mysql_error());
$count=mysql_num_rows($user_query);
if($count>0){
while($user_row = mysql_fetch_array($user_query)){
$club = $user_row['club'];
?>
                <!--/span-->
                <div id="print_content">
                <div class="span9" id="content">

								        <div id="block_bg" class="block">
                
								<div class="block-content collapse in">
								<div class="block">Accepted Activity Form
								
										
							<!-- block -->
                        <!-- block -->
                     
                </div>

                            </div>

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
            <Input type="text" name="club" value="<?php echo $club ?>" style="width:400px;height:40px;" readonly>
  
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

                                <center>
                                     <div class="control-group">
                        <div class="controls">

<a href="javascript:Clickheretoprint()"><button  type="submit" value="Print" class="btn btn-success" /><i class="icon-check"></i>&nbsp;print</button></a>
                      
                  </div>
                  </div>	
              </center>

            <?php }else{ ?>

  <script>
alert('Accepted Proposals not found.!');
  window.location = "admin_user.php";
  </script>
<?php } ?>  
</div>
    
 
    </body>

</html>