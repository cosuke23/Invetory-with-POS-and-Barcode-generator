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
                        <h1 class="animated fadeInLeft">STOCK MANAGER</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;" >
                           View and manage JMTC office stocks.
                        </p>                                                        
              
                    <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                        
                        <li role="presentation" class="active">
                        <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-list-alt"></span> STOCK IN </a>
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
					  
					  
					//   JAVASCRIPT FOR ADD
					  
                      if(isset($_GET['add_item_name'])){
						  $itemname= $_GET['add_item_name'];
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Added Item",
                            html: true,
                           text: "<strong> Added Item Name: '. $_GET['add_item_name'].'</strong>",
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

					   
                      <!-- 1st Tab (Stock In) -->
                      <div role="tabpanel" class="tab-pane fade active in" id="tab2" aria-labelledby="tab2">                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-4" align="center">
                              <?php
                                $user_query = mysqli_query($conn,"SELECT * from products")or die(mysqli_error());
while($q_em_data = mysqli_fetch_array($user_query)){
								 
					//			  $username = $q_em_data["username"];
                                  $itemname = $q_em_data["product_name"];
                                  $itemtype = $q_em_data["product_type"];
                      //            $category = $q_em_data["category"];
                                  $itemdesc = $q_em_data["product_size"];
								  $status = $q_em_data["product_type"];
					//			  $borrowed = $q_em_data["borrowed"];
							//	  $unit = $q_em_data["unit"];
				//				  $date = $q_em_data["date"];
								
								
                                }    
							// Query for Last item added	
								 $user_query2 = mysqli_query($conn,"SELECT * from products")or die(mysqli_error());
                    while($q_em_data2 = mysqli_fetch_array($user_query2)){
								 
		            $username = $q_em_data["username"];
                                  $itemname2 = $q_em_data2["product_name"];
                                  $itemtype = $q_em_data2["product_type"];
                      //            $category = $q_em_data["category"];
                                  $itemdesc = $q_em_data2["product_size"];
                  $status = $q_em_data2["product_type"];
          //        $borrowed = $q_em_data["borrowed"];
              //    $unit = $q_em_data["unit"];
        //          $date = $q_em_data["date"];
                
								
                                }    
								// Query for Last item added	
								
								
                              if( $itemname2==""){
                                  print '<h5><b>LAST ITEM ADDED: ANG POGI NI GEREMY '+'.$itemname.';
                                } 
								else{
                               print '<h5><b>LAST ITEM ADDED:'. $itemname2.'</b> ' ;
						
   /*                               if($date==$date){
                                    print '<h5>LAST ITEM ADDED DATE: '.$date.'</b>';
								  }
                                  else{
                                    print '<h5>LAST ITEM ADDED DATE: '.$date.' - '.$date.'</b>'; 

                                } */
								}
								
								
                              ?>
                            </div>
							
							<a href="e2e_add_item.php?Item_Number=<?php echo $username; ?>&&itemname=<?php echo $itemname; ?>" style="margin-left:410px;margin-right:5px;" class="col-md-3 btn btn-success btn-outline btn-lg">
                            <span class="glyphicon glyphicon-plus"></span> &nbsp; ADD NEW ITEM &nbsp;
				
									</a><br><br>		
									<div class="col-md-4" align="center">
							</div>
							</div>
						
						
						
                        <?php
                         $user_query2 = mysqli_query($conn,"SELECT * from products where status = 'Active'")or die(mysqli_error());
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" padding-top="100px" cellspacing="0">
                          <thead> 
                          <tr>
                          <th class="text-center">ITEM NUMBER</th>
                          <th class="text-center">ITEM NAME</th>
                          <th class="text-center">UNIT</th>
                          <th class="text-center">CATEGORY</th>
                          <th class="text-center">ITEM DESCRIPTION</th>
						  <th class="text-center">STOCKS</th>
              <th class="text-center">barcode</th>
						                   
                          <th class="text-center">ACTION</th>   
						  </tr>
                          </thead>
                          <tbody>';

                         while($q_em_data2 = mysqli_fetch_array($user_query2)){
                        $code = $q_em_data2["product_id"];
                                  $itemname2 = $q_em_data2["product_name"];
                                  $itemtype = $q_em_data2["product_type"];
                      //            $category = $q_em_data["category"];
                                  $itemdesc = $q_em_data2["product_size"];
                  $qty = $q_em_data2["product_qty"];
                  $barcode = $q_em_data2["barcode"];
          //        $borrowed = $q_em_data["borrowed"];
              //    $unit = $q_em_data["unit"];
        //          $date = $q_em_data["date"];
                
                          ?>    						  
						  
						  
						  
                          <tr>
                            <td><?php echo $code; ?></td>
                          <td><?php echo $itemname2; ?></td>
                          <td><?php echo $itemdesc; ?></td>

						  <td><?php echo $status; ?></td>
						  <td><?php echo $itemtype; ?></td>
               <td><?php echo $qty; ?></td>
               <td> <img src="employee/tmp/<?php echo $barcode; ?> "></td>
						  
                          

                          <td>                          
						  <a href="e2e_add_stocks.php?Item_Number=<?php echo $username; ?>&&itemcode=<?php echo $code; ?>" class=" btn btn-outline btn-warning" data-toggle="tooltip" data-placement="top" title="Add Stocks"><span class="glyphicon glyphicon-plus-sign"></span></a>
						  <a href="e2e_item_update.php?username=<?php echo $code; ?>" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Update Info"><span class="glyphicon glyphicon-pencil"></span></a>
                          <a href="e2e_delete_item.php?Item_Number=<?php echo $code; ?>&itemname=<?php echo $itemname; ?>" class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Item"><span class="glyphicon glyphicon-trash"></span></a>                                          
						  </td>
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
