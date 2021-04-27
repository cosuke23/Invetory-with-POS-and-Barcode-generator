<?php
include('db.php');
include('session.php');
				
		
	?> 
<html>
<head>
	  <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JMCT</title>

        <!-- CSS -->
  
        
        <link rel="stylesheet" href="assets/css/media-queries.css">
        <link rel="shortcut icon" href="tmp/logo.png">
<!--Take a look -->
                <link rel="stylesheet" type="text/css" href="cssi/default.css" />
        <link rel="stylesheet" type="text/css" href="cssi/component.css" />
        <script src="jsi/modernizr.custom.js"></script>

  
<script language="javascript">
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,widtd=900, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("print_content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<html><head><title>JMCT Receipt</title>'); 
   docprint.document.write('</head><body onLoad="self.print()" style="widtd: 900px; font-size:16px; font-family:arial;">');          
   docprint.document.write(content_vlue);          
   docprint.document.write('</body></html>'); 
   docprint.document.close(); 
   docprint.focus(); 
}
</script>
<style>
#print_content{
width:450px;
margin:0 auto;
}
</style>
<br>
<div id="print_content">
<img src="tmp/logo.png" width="155" height="100" style="float:left;">
<p style=" font-family:Georgia; font-size:20px;"><strong>&nbsp&nbsp JMCT</strong></p>
<p style=" font-family:Georgia; font-size:11px;">&nbsp&nbsp "ADDRESS HERE"</p>
<p style=" font-family:Georgia; font-size:11px;">&nbsp&nbsp "EMAIL"</p>
<p style=" font-family:Georgia; font-size:11px;">&nbsp&nbsp Contact: <a href="#">0927-625-7573</a>/<a href="#">0948-408-5910</a>/<a href="#">871-9674</a></p>
<p style=" font-family:Georgia; font-size:23px;">Prepared by:<?php echo $studname; ?></p>
<br><br>


<table cellpadding="5" cellspacing="0" id="resultTable" border="1" width="100%">
		                          <thead>
                          <tr>
                          <th class="text-center">Date buyed</th>
                          <th class="text-center">Buyer</th>
                          <th class="text-center">Product Name</th>
                          <th class="text-center">Price</th>
						  <th class="text-center">Quantity</th>
						  <th class="text-center">Total</th>                      

						  
						  </tr>
                          </thead>
	<?php
	   

                                $buyer=$_GET['buyer'];
                              
        $user_query = mysqli_query($conn,"SELECT * from sale where  buyer='$buyer' ")or die(mysqli_error());
								 print '<div class="panel-body">
                          <div class="responsive-table">
                          
                          <tbody>';

while($item_data = mysqli_fetch_array($user_query)){
                          $date_buyed = $item_data['date_buyed'];
                          $buyer = $item_data['buyer'];
                          $product = $item_data['product'];
						  $price = $item_data['product_price'];
              $qty=$item_data['product_qty'];
						  $total = $item_data['product_total'];
              $person = $item_data['prepared_by'];

              //$stock=5;
                          ?>    						  
						  
                          <tr>
                          <td><?php echo $date_buyed; ?></td>
                          <td><?php echo $buyer; ?></td>
                          <td><?php echo $product; ?></td>
                        
                          <td><?php echo $price; ?></td>
                          <td><?php echo $qty; ?></td>
                         
						  <td><?php echo number_format($total); ?></td>
                          </tr>
						
                          <?php
                          }
                          print '</tbody>
                          </table>
                          ';


                        ?>
                        <br />
                        <?php
                         $buyer=$_GET['buyer'];
        $grand_query = mysqli_query($conn,"SELECT sum(product_total) as grand from sale where  buyer='$buyer'  ")or die(mysqli_error());
        $grand_data = mysqli_fetch_array($grand_query);
        $grand=$grand_data['grand'];
      
      ?>
                        <center>
                        <p>Total Price</p>
                         ₱<?php echo number_format($grand); ?>
                        </center>
                        </div>
                          </div>
</div><br><br>
<div >
<a href="sale.php">
	<center><input type="button" value="Back" style="width:100px; height:100px;"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a href="javascript:Clickheretoprint()"><input type="button" value="Print" style="width:100px; height:100px;"></a></center>
</div>