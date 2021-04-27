<?php  include('header.php'); ?>
<?php include('session.php'); ?>
    <body id="class_div">
    <?php include('navbar.php') ?>
        <div class="container-fluid">
            <div class="row-fluid">
          <?php include('admin_sidebar.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">


  <script language="javascript">
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,widtd=900, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("print_content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<html><head><title>Liquidation Form</title>'); 
   docprint.document.write('</head><body onLoad="self.print()" style="widtd: 900px; font-size:16px; font-family:arial;">');          
   docprint.document.write(content_vlue);          
   docprint.document.write('</body></html>'); 
   docprint.document.close(); 
   docprint.focus(); 
}
</script>
<style>
#print_content{
  background: white;
width:750px;
margin:0 auto;
}
</style>             <!-- breadcrumb --> 
             <!-- end breadcrumb -->
           
                        <!-- block --><div id="print_content">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="count_class" class="muted pull-left">Liquidation Form

                </div>
                </div>
  
  
 
<br>

<img src="../images/sti.png" width="" height="100" style="float:left;">
<p style=" font-family:Georgia; font-size:20px;"><strong>STI COLLEGE OF KALOOKAN INC </strong></p>
<p style=" font-family:Georgia; font-size:11px;"><strong>School Liquidation Report Form (SLRF)</strong>             
</p>
<br><br>
<p style=" font-family:Georgia; font-size:11px; float:right "> [  ]Cash Advance &nbsp&nbsp&nbsp&nbsp&nbsp [  ]CATA</p>
<br><br>

  <tr>


            <td><p style=" font-family:Georgia; font-size:10px;"> <strong>TO FILLED UP BY REQUESTING UNIT</strong></p></td>

    </tr>

  </table>
<?php
include('db.php');
$querys=mysql_query("SELECT  * from liquid ");
                                    while($rows=mysql_fetch_array($querys)) { 
                                      $time=$rows['date_now'];
                                    }
                                      
    $result=mysql_query("SELECT  * from club_advisers left join liquid on club_advisers.id=liquid.adviser_id  where  liquid.date_now= '$time' ");
    while($row = mysql_fetch_array($result))
      {
        
        
        echo '<p style=" font-family:Consolas; font-size:15px;">Liquidation Report of:'.$row['fname'].' '.$row['lname'].' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
        echo '<p style=" font-family:Consolas; font-size:15px;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong> Project Title:'.$row['project_title'].' </strong> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
        
      //  echo 'Delivery Type: '.$row['delivery_type'].'<br>';
      
      
  ?> 
<table cellpadding="5" cellspacing="0" id="resultTable" border="1" width="100%">
    <tr>


            <td> <strong>Particulars</strong></td>
                       <td> <strong> Date</strong></td>
                      <td> <strong>  OR#/REFF#</strong></td>
                      
                     <td> <strong>   Cost</strong></td>
                     <td> <strong>   Unit</strong></td>
                     <td> <strong>   Hotel</strong></td>
                      
                     <td> <strong>   Meal</strong></td>
                     <td> <strong>   Fare</strong></td>
                     <td> <strong>   Total</strong></td>

    </tr>
  <?php

     
$query=mysql_query("SELECT  * from supplies where date_now = '$time' ");
                                    while($row=mysql_fetch_array($query)) { 
        
                  ?>
                                    <tr>

                                        <td> <?php echo $row['particulars']; ?> </td>                                      
                                        <td> <?php echo $row['date']; ?> </td>
                                        <td> <?php echo $row['reff']; ?> </td>
                                        <td> <?php echo $row['count']; ?>.00 </td>
                                        <td> <?php echo $row['unit_cost']; ?> </td>
                                        <td> <?php echo $row['hotel']; ?>.00 </td>
                                        <td> <?php echo $row['meal']; ?>.00 </td>
                                        <td> <?php echo $row['fare']; ?>.00 </td>
                                        <td> <?php echo number_format($row['total']); ?>.00 </td>
                                     
                                    </tr>
                                    <?php } ?>    
                  
  <?php

     
$query=mysql_query("SELECT  * from prizes where date_now = '$time' ");
                                    while($row=mysql_fetch_array($query)) { 
        
                  ?>
                                    <tr>

                                        <td> <?php echo $row['particulars']; ?> </td>                                      
                                        <td> <?php echo $row['date']; ?> </td>
                                        <td> <?php echo $row['reff']; ?> </td>
                                        <td> <?php echo $row['count']; ?>.00 </td>
                                        <td> <?php echo $row['unit_cost']; ?> </td>
                                        <td> <?php echo $row['hotel']; ?>.00 </td>
                                        <td> <?php echo $row['meal']; ?>.00 </td>
                                        <td> <?php echo $row['fare']; ?>.00 </td>
                                        <td> <?php echo number_format($row['total']); ?>.00 </td>
                                     
                                    </tr>
                                    <?php } ?>    
                    <?php

     
$query=mysql_query("SELECT  * from makeup where date_now = '$time' ");
                                    while($row=mysql_fetch_array($query)) { 
        
                  ?>
                                    <tr>

                                        <td> <?php echo $row['particular']; ?> </td>                                      
                                        <td> <?php echo $row['date']; ?> </td>
                                        <td> <?php echo $row['reff']; ?> </td>
                                        <td> <?php echo $row['count']; ?>.00 </td>
                                        <td> <?php echo $row['unit_cost']; ?> </td>
                                        <td> <?php echo $row['hotel']; ?>.00 </td>
                                        <td> <?php echo $row['meal']; ?>.00 </td>
                                        <td> <?php echo $row['fare']; ?>.00 </td>
                                        <td> <?php echo number_format($row['total']); ?>.00 </td>
                                     
                                    </tr>
                                    <?php } ?>

                                                 <?php
     
$query=mysql_query("SELECT  * from cloth where  date_now = '$time' ");
                                    while($row=mysql_fetch_array($query)) { 
        
                  ?>
                                    <tr>

                                        <td> <?php echo $row['particular']; ?> </td>                                      
                                        <td> <?php echo $row['date']; ?> </td>
                                        <td> <?php echo $row['reff']; ?> </td>
                                        <td> <?php echo $row['count']; ?>.00 </td>
                                        <td> <?php echo $row['unit_cost']; ?> </td>
                                        <td> <?php echo $row['hotel']; ?>.00 </td>
                                        <td> <?php echo $row['meal']; ?>.00 </td>
                                        <td> <?php echo $row['fare']; ?>.00 </td>
                                        <td> <?php echo number_format($row['total']); ?>.00 </td>
                                     
                                    </tr>
                                    <?php } ?>    
                               <?php
$query=mysql_query("SELECT  * from design_materials where date_now = '$time' ");
                                    while($row=mysql_fetch_array($query)) { 
        
                  ?>
                                    <tr>

                                        <td> <?php echo $row['particular']; ?> </td>                                      
                                        <td> <?php echo $row['date']; ?> </td>
                                        <td> <?php echo $row['reff']; ?> </td>
                                        <td> <?php echo $row['count']; ?>.00 </td>
                                        <td> <?php echo $row['unit_cost']; ?> </td>
                                        <td> <?php echo $row['hotel']; ?>.00 </td>
                                        <td> <?php echo $row['meal']; ?>.00 </td>
                                        <td> <?php echo $row['fare']; ?>.00 </td>
                                        <td> <?php echo number_format($row['total']); ?>.00 </td>
                                     
                                    </tr>
                                    <?php } ?>
             <?php
$query=mysql_query("SELECT  * from food where  date_now = '$time' ");
                                    while($row=mysql_fetch_array($query)) { 
        
                  ?>
                                    <tr>

                                        <td> <?php echo $row['particular']; ?> </td>                                      
                                        <td> <?php echo $row['date']; ?> </td>
                                        <td> <?php echo $row['reff']; ?> </td>
                                        <td> <?php echo $row['count']; ?>.00 </td>
                                        <td> <?php echo $row['unit_cost']; ?> </td>
                                        <td> <?php echo $row['hotel']; ?>.00 </td>
                                        <td> <?php echo $row['meal']; ?>.00 </td>
                                        <td> <?php echo $row['fare']; ?>.00 </td>
                                        <td> <?php echo number_format($row['total']); ?>.00 </td>
                                     
                                    </tr>
                                    <?php } ?>
                        
                                                 <?php
     
$query=mysql_query("SELECT  * from other where date_now = '$time' ");
                                    while($row=mysql_fetch_array($query)) { 
        
                  ?>
                                    <tr>

                                        <td> <?php echo $row['particular']; ?> </td>                                      
                                        <td> <?php echo $row['date']; ?> </td>
                                        <td> <?php echo $row['reff']; ?> </td>
                                        <td> <?php echo $row['count']; ?>.00 </td>
                                        <td> <?php echo $row['unit_cost']; ?> </td>
                                        <td> <?php echo $row['hotel']; ?>.00 </td>
                                        <td> <?php echo $row['meal']; ?>.00 </td>
                                        <td> <?php echo $row['fare']; ?>.00 </td>
                                        <td> <?php echo $row['total']; ?>.00 </td>
                                     
                                    </tr>
                                    <?php } ?>




<?php

$querys=mysql_query("SELECT  * from liquid where  date_now = '$time'  ");
while($rows=mysql_fetch_array($querys)) {
  
 ?>
  <td> Grand Total : <?php  echo number_format($rows['project_cost']); ?>.00 </td>
   <td> Cash Advanced Received : <?php echo number_format($rows['cash_given']); ?>.00 </td>
 <td> Amount Overspent(Saved) : <?php echo number_format($rows['amount_saved']); ?>.00 </td>
                                     <?php } ?>

  <?php
  }
  ?>
  
                               
</table>
</body>
  </div>
<br><br>
 </div>
                 
                  <div class="span4">
                      

          
                  <div class="pull-left">

                <script>
                $("#checkAll").click(function () {
                  $('input:checkbox').not(this).prop('checked', this.checked);
                });
                </script>         
              </div>
              </div>
                  
                                </div>

    

                <hr>
                  <center>
                  <div class="control-group">
                        <div class="controls">

<a href="javascript:Clickheretoprint()"><button  type="submit" value="Print" class="btn btn-success" /><i class="icon-check"></i>&nbsp;print</button></a>
                      
                  </div>
                  </div>

                  </center>
             
                   </form>    
             
              <?php/*  include('teacher_right_sidebar.php')  */?>
  
    <?php include('script.php'); ?>
    </body>
</html>