<?php 
include('head.php');
?>



      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">

          <!-- start:Left Menu -->
            <div id="left-menu">
              <div class="sub-left-menu scroll">

                    
					
                    <?php 
                    include('sidebar_inventory.php');
                    ?>
              </div>
            </div>
          <!-- end: Left Menu -->
		  
          <div class="container-fluid mimin-wrapper">
          <!-- start: Content -->

            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">VIEW ITEMS</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;" >
                           View the available stocks in JMTC.
                        </p>                                                        
              
                    <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                        <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-list-alt"></span> AVAILABLE STOCKS</a>
                      </li>
                         
                    </ul>  
                      </div><!-- col-md-12 -->
                </div><!-- panel-body -->
              </div><!-- panel box-shadow-none -->                                      
                                

								
								
				<!-- Javascript -->
				
                      <?php
                      if(isset($_GET['delete_item'])&&isset($_GET['username'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Deleted Item!",
                            html: true,
                           text: "<strong> Deleted Item with ID:'. $_GET['username'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_stocks.php";
                           }
                         });
                     </script>';
                      }

                      if(isset($_GET['delete_cancelled'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Deleted Item Cancelled!",
                            html: true,
                           text: "<strong> Deletion of Item is Cancelled.</strong>",
                           type: "success",
                           showCancelButton: false,
                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_stocks.php";
                           }
                         });
                     </script>';
                      }
					  
					  
					  /* JAVASCRIPT FOR ADD
					  
                      if(isset($_GET['add_event'])&&isset($_GET['event_name'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Added Event!",
                            html: true,
                           text: "<strong> Added Event Name: '. $_GET['event_name'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_event_manager.php";
                           }
                         });
                     </script>';
                      }
					  
					  */
					  

                      if(isset($_GET['change_batch'])&&isset($_GET['active_date'])&&isset($_GET['active_batch'])){
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Updated Item!",
                            html: true,
                           text: "<strong> Event Date: '. $_GET['active_date'] .' - Batch Active: '. $_GET['active_batch'] .'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_stocks.php";
                           }
                         });
                     </script>';
                      }
					  
					 
                      ?>

				
					<!-- End Javascript -->				  
					  
					  
					  
					  
                      <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-body">
                      <div class="col-md-12">
                       <div id="tabsDemo4Content" class="tab-content tab-content-v3">
                       
                      <!-- First Tab (Available Stocks) -->
                      <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-4" align="center">
                            <form method="post" action="pos.php" name="form1">
<label>Delivery Date

</label>
<input type="Date" name="from" id="email" />
 to 
 <label>Delivery Date

</label>
<input type="Date" name="to" id="email" />
<input type="hidden" name="display" value="show"  />
<input type="submit" name="button" value="view sale" />
</form>
                            </div>
                          </div>
                        </div>
                        <?php
                        if (isset($_POST['btn'])) {
                                $from=$_POST['from'];
                                $to=$_POST['to'];
        $user_query = mysqli_query($conn,"SELECT * from products where date_buyed>='$from' and date_buyed<='$to' ")or die(mysqli_error());
      }
                          print '<div class="panel-body">
                          <div class="responsive-table">
                           <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="text-center">ITEM NUMBER</th>
                          <th class="text-center">ITEM NAME</th>
                          <th class="text-center">Date buyed</th>
                          <th class="text-center">Critical level</th>
                          <th class="text-center">Price</th>
						  <th class="text-center">Stock</th>
						  <th class="text-center">Total</th>
						  <th class="text-center">STATUS</th>                        

						  
						  </tr>
                          </thead>
                          <tbody>';

while($item_data = mysqli_fetch_array($user_query)){
                          $username = $item_data['product_id'];
                          $itemname = $item_data['product_name'];
                          $itemtype = $item_data['product_type'];
						  $stock = $item_data['product_qty'];
              $date_buyed=$item_data['date_buyed'];
						  $product_price = $item_data['product_price'];
              $total=$product_price*$stock;
              //$stock=5;
              $crit=$item_data['crit_level'];
                          ?>    						  
						  
                          <tr>
                          <td><?php echo $username; ?></td>
                          <td><?php echo $itemname; ?></td>
                          <td><?php echo $date_buyed; ?></td>
                        
                          <td><?php echo $crit; ?></td>
                          <td><?php echo $product_price; ?></td>
                            <?php 
                          if($stock<=$crit){
                          ?>
                          <td style="color:red"><?php echo $stock; ?></td>
                          <?php 
                        }else{
                          ?>
                          <td style="color:green"><?php echo $stock; ?></td>

                        <?php 
                         }
                          ?>
						  <td><?php echo number_format($total); ?></td>
						  <td><?php echo $itemtype; ?></td>
                          </tr>
						
                          <?php
                          }
                          print '</tbody>
                          </table>
                          </div>
                          </div>';
                        ?>
                      </div>
					  
                  </div>

                  </div>
                </div>
              </div>
              </div>
              </div>




            </div><!-- end: content -->
            </div>

      </div>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="e2e_home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                      <a href="e2e_student_records.php"><i class="glyphicon glyphicon-tasks"></i>&nbsp; Student Records</a>
                      <a href="e2e_company_records.php"><i class="glyphicon fa fa-building-o"></i>&nbsp; Company Records</a>
                      <a href="*"><i class="glyphicon fa fa-thumbs-o-up"></i>&nbsp; OJT Endorsement</a>
                      <a href="*"><i class="glyphicon fa fa-user-secret"></i>&nbsp; Check Attire</a>
                      <a href="*"><i class="glyphicon fa fa-smile-o"></i>&nbsp; Graduating ID Card</a>
                      <a href="*"><i class="glyphicon icons icon-credit-card"></i>&nbsp; Business Card</a>
                      <a href="e2e_event_manager.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Event Manager</a>
                      <a href="*"><i class="glyphicon fa fa-user"></i>&nbsp; User Account</a>
                    </li>
                </ul>
            </div>
        </div>
      </div>
      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle" style="background-color:#0d47a1;">
        <span class="fa fa-bars" style="color:yellow;"></span>
      </button>
       <!-- end: Mobile -->

<!-- start: Javascript -->
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/jquery.ui.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>

<!-- plugins -->
<script src="asset/js/plugins/moment.min.js"></script>
<script src="asset/js/plugins/jquery.datatables.min.js"></script>
<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>

<script src="asset/js/plugins/jquery.knob.js"></script>
<script src="asset/js/plugins/ion.rangeSlider.min.js"></script>
<script src="asset/js/plugins/bootstrap-material-datetimepicker.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>
<script src="asset/js/plugins/jquery.mask.min.js"></script>
<script src="asset/js/plugins/select2.full.min.js"></script>
<script src="asset/js/plugins/nouislider.min.js"></script>
<script src="asset/js/plugins/jquery.validate.min.js"></script>

<<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script src="asset/js/jquery.confirm.min.js"></script>
<script src="asset/js/jquery.confirm.js"></script>
<script src="asset/js/sweetalert-dev.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
 var js_event_dates = document.getElementById('event_dates');
 var table = $('#datatables').DataTable();
 var table = $('#datatables1').DataTable();
 var table = $('#datatables2').DataTable();
 });
</script>
<!-- end: Javascript -->
</body>
</html>