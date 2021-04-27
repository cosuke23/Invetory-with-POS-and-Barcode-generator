      <!-- end: Header -->
<?php 
include('head.php');
?>


      <div class="container-fluid mimin-wrapper">

          <!-- start:Left Menu -->
             <div id="left-menu">
              <div class="sub-left-menu scroll">

                        <div class="profile-v1-pp">         
                              <div class="profile-v1-pp">         
                     <p class="centered"><img src=<?php echo "files/student_pics/".$stud_no.".jpg"; ?> style="height:300px;" ></p>
          <div class="panel panel-default">
          <div class="panel-body"><h5>&nbsp; Hi' <?php echo $studname ?>&nbsp;</h5></div> 
          <div class="panel-footer" align="center"><strong>Administrator</strong></div>
          </div>
          </div>
      
          </div>
  <div class="nav-side-menu">
                        <label >
                          <a href="home.php"><i class="glyphicon glyphicon-home"></i>Home</a>
                        </label><br>
                          <label >
                          <a href="e2e_consume.php"><i class="glyphicon glyphicon-home"></i>Consumable</a>
                        </label><br>
                          <label >
                          <a href="e2e_stocks.php"><i class="glyphicon glyphicon-home"></i>Stocks</a>
                        </label><br>
                          <label class="active">
                          <a href="e2e_borrow.php"><i class="glyphicon glyphicon-home"></i>Non-Consumable</a>
                        </label><br>
                          <label >
                          <a href="e2e_view_items.php"><i class="glyphicon glyphicon-home"></i>View Items</a>
                        </label><br>
                        <label><a href="my_account.php">
                          <i class="glyphicon fa fa-user"></i>My Profile</a>
                        </label><br>
             
                  
            
            <label><a href="logout.php">
                          <i class="glyphicon fa fa-power-off"></i>Logout</a>
                        </label><br>
            
                      </div>
              </div>
            </div>
          <!-- end: Left Menu -->
		  
          <div class="container-fluid mimin-wrapper">
          <!-- start: Content -->

            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">NON-CONSUMABLE MANAGER</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;" >
                           Borrowing and Returning Items in e2e office.
                        </p>                                                        
              
                    <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
                        <li role="presentation" class="active">
                        <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true"><span class="glyphicon glyphicon-list-alt"></span> NON-CONSUMABLE STOCKS</a>
                      </li>
                        <li role="presentation">
                        <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> BORROW </a>
                      </li>
						<li role="presentation">
                        <a href="#tab3" id="tabs3" role="tab" data-toggle="tab" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> RETURN </a>
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
                      <div role="tabpanel" class="tab-pane fade in active" id="tab1" aria-labelledby="tab1">                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-4" align="center">
                              <?php
                                $table_em  ="item_info";
                                $columns_em = "*";
                                $where_em1 = ["status"=>"With Stocks"] and ["itemtype"=>"Consumable"];
                                $q_em = $database->select($table_em,$columns_em,$where_em1);
                                foreach($q_em AS $q_em_data){
								 
								  $username = $q_em_data["username"];
                                  $itemname = $q_em_data["itemname"];
                                  $itemtype = $q_em_data["itemtype"];
                                  $category = $q_em_data["category"];
                                  $itemdesc = $q_em_data["itemdesc"];
								  $status = $q_em_data["status"];
								  $date = $q_em_data["date"];
								
								
                                }    
								
								
                                if($q_em==null){
                                  print '<h5><b>LAST ITEM ADDED: ANG POGI NI GEREMY ';
                                } 
								else{
                                  print '<h5><b>LAST ITEM ADDED: '.$itemname.'';
								  

                                  if($date==$date)
                                    print '<h5>LAST ITEM ADDED DATE: '.$date.'</b>';
                                  else
                                    print '<h5>LAST ITEM ADDED DATE: '.$date.' - '.$date.'</b>';

                                }

                              ?>
                            </div>
                          </div>
                        </div>
                        <?php
                          $table = "item_info";
                          $columns = "*";
						  $where_em2 = ["itemtype"=>"Non-Consumable"];
                          $q_item_info =$database->select($table,$columns,$where_em2);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="text-center">ITEM NUMBER</th>
                          <th class="text-center">ITEM NAME</th>
                          <th class="text-center">UNIT</th>
						  <th class="text-center">CATEGORY</th>
                          <th class="text-center">ITEM DESCRIPTION</th>
						  <th class="text-center">STOCKS</th>
						  <th class="text-center">BORROWED</th>
						
						  <th class="text-center">ITEM TYPE</th> 
							  						  
						  </tr>
                          </thead>
                          <tbody>';

                          foreach($q_item_info as $item_data){
                          $username = $item_data['username'];
                          $itemname = $item_data['itemname'];
                          $unit = $item_data['unit'];
                          $category = $item_data['category'];
                          $itemdesc = $item_data['itemdesc'];
                          $stocks = $item_data['stocks'];
						  $borrowed = $item_data['borrowed'];
						  
						  $itemtype = $item_data['itemtype'];
						  $item_data['date'];
						  $status = $item_data['status'];
                          ?>   						  
						  
                          <tr>
                          <td><?php echo $username; ?></td>
                          <td><?php echo $itemname; ?></td>
                          <td><?php echo $unit; ?></td>
                          <td><?php echo $category; ?></td>
                          <td><?php echo $itemdesc; ?></td>
						  <td><?php echo $stocks; ?></td>
						  <td><?php echo $borrowed; ?></td>
						  
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

                      <!-- 2nd Tab (Borrow) -->
                      <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-4" align="center">
                              <?php
                                $table_em  ="item_info";
                                $columns_em = "*";
                                $where_em3 = ["itemtype"=>"Non-Consumable"];
                                $q_em = $database->select($table_em,$columns_em,$where_em3);
                                foreach($q_em AS $q_em_data){
								 
								  $username = $q_em_data["username"];
                                  $itemname = $q_em_data["itemname"];
                                  $itemtype = $q_em_data["itemtype"];
                                  $category = $q_em_data["category"];
								  $itemtype = $q_em_data["itemtype"];
                                  $itemdesc = $q_em_data["itemdesc"];
								  $status = $q_em_data["status"];
								  $borrowed = $q_em_data["borrowed"];
								 
								  $date = $q_em_data["date"];
								
								
                                }    
								
								
                                if($q_em==null){
                                  print '<h5><b>LAST ITEM ADDED: ANG POGI NI GEREMY ';
                                } 
								else{
                                  print '<h5><b>LAST ITEM ADDED: '.$itemname.'';
								  

                                  if($date==$date)
                                    print '<h5>LAST ITEM ADDED DATE: '.$date.'</b>';
                                  else
                                    print '<h5>LAST ITEM ADDED DATE: '.$date.' - '.$date.'</b>';

                                }

                              ?>
                            </div>
                          </div>
                        </div>
					<!-- //////////////////////////////////////////Table  of Items ThAT CAN BE borrowed //////////////////////////////////////////////////////////////////-->	
                         <?php
                          $table = "item_info";
                          $columns = "*";
						  $where_em2 = ["itemtype"=>"Non-Consumable"];
                          $q_item_info =$database->select($table,$columns,$where_em2);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="text-center">ITEM NUMBER</th>
                          <th class="text-center">ITEM NAME</th>
                          <th class="text-center">UNIT</th>
						  <th class="text-center">CATEGORY</th>
                          <th class="text-center">ITEM DESCRIPTION</th>
						  <th class="text-center">STOCKS</th>
						  <th class="text-center">BORROWED</th>
						
						  <th class="text-center">ITEM TYPE</th>  
						<th class="text-center">ACTION</th>  						  
						  </tr>
                          </thead>
                          <tbody>';

                          foreach($q_item_info as $item_data){
                          $item_id = $item_data['item_id'];
                          $itemname = $item_data['itemname'];
                          $unit = $item_data['unit'];
                          $category = $item_data['category'];
                          $itemdesc = $item_data['itemdesc'];
                          $stocks = $item_data['stocks'];
						  $borrowed = $item_data['borrowed'];
						  
						  $itemtype = $item_data['itemtype'];
						  $item_data['date'];
						  $status = $item_data['status'];
                          ?>   						  
						  <?php 
						   if ($stocks > 0)
						   {
							   ?>
                          <td><?php echo $item_id; ?></td>
                          <td><?php echo $itemname; ?></td>
                          <td><?php echo $unit; ?></td>
                          <td><?php echo $category; ?></td>
                          <td><?php echo $itemdesc; ?></td>
						  <td><?php echo $stocks; ?></td>
						  <td><?php echo $borrowed; ?></td>
						  <td><?php echo $itemtype; ?></td>
                          
						   
                          <td>                          
						  &nbsp;&nbsp;&nbsp;&nbsp;<a href="e2e_borrow_stocks.php?Item_Number=<?php echo $item_id; ?>&&itemname=<?php echo $itemname; ?>" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Borrow Item"><span class="glyphicon glyphicon-refresh"></span></a>
						  
						  <?php 
						   } 
						   ?>
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

				
				<!-- 3rd Tab (Return) -->	
				
					<!--////////////////////////////////////////////////////////Table for Borrow Table////////////////////////////////////////////////////////////////// -->	  
                     
                    
						<div role="tabpanel" class="tab-pane fade" id="tab3" aria-labelledby="tab1">                        
						<div class="panel-heading"><h3>List of Borrowers</h3></div>                        
							<div class="row">
                          <div class="col-md-12">
                            <div class="col-md-4" align="center">
                              <?php
                                $table_em  ="item_info";
                                $columns_em = "*";
                                $where_em4 = ["status"=>"With Stocks"];
                                $q_em = $database->select($table_em,$columns_em,$where_em4);
                                foreach($q_em AS $q_em_data){
								 
								  $username = $q_em_data["username"];
                                  $itemname = $q_em_data["itemname"];
                                  $itemtype = $q_em_data["itemtype"];
                                  $category = $q_em_data["category"];
                                  $itemdesc = $q_em_data["itemdesc"];
								  $status = $q_em_data["status"];
								  $date = $q_em_data["date"];
								
								
                                }    
								
								
                                if($q_em==null){
                                  print '<h5><b>LAST ITEM ADDED: ANG POGI NI GEREMY ';
                                } 
								else{
                                  print '<h5><b>LAST ITEM ADDED: '.$itemname.'';
								  

                                  if($date==$date)
                                    print '<h5>LAST ITEM ADDED DATE: '.$date.'</b>';
                                  else
                                    print '<h5>LAST ITEM ADDED DATE: '.$date.' - '.$date.'</b>';

                                }

                              ?>
                            </div>
                          </div>
                        </div>
                        <?php
                          $table = "borrow";
                          $columns = "*";
						  $where_brw = ["borrow_qty[!]" => 0  ];
              
                          $q_borrow =$database->select($table,$columns,$where_brw,["ORDER" => "return_date"]);
                          print '<div class="panel-body">
                          <div class="responsive-table">
                          <table id="datatables2"  class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
                          <thead>
                          <tr>
                          <th class="text-center">DEPARTMENT</th>
                          <th class="text-center">ITEM NUMBER</th>
                          <th class="text-center">ITEM NAME</th>
                          <th class="text-center">ITEM TYPE</th>
                          <th class="text-center">BORROWER</th>
						  <th class="text-center">DATE OF BORROW</th>
						  <th class="text-center">BORROWED QUANTITY</th>
						  <th class="text-center">RETURNEE</th>
						  <th class="text-center">DATE OF RETURNs</th>
						  <th class="text-center">ACTION</th>      

						  
						  </tr>
                          </thead>
                          <tbody>';

                          foreach($q_borrow as $item_data){
                 
                          $borrow_id = $item_data['department'];
                          $item_id = $item_data['item_id'];
                          $itemname = $item_data['itemname'];
                          $itemtype = $item_data['itemtype'];
						  $borrower = $item_data['borrower'];
						  $borrow_date = $item_data['borrow_date'];
						  $borrow_qty = $item_data['borrow_qty'];
						  $returnee = $item_data['returnee'];
						  $return_date = $item_data['date_return'];
                          ?>    						  
					<!--////////////////////////////////////////////////////////Table for Return Table////////////////////////////////////////////////////////////////// -->	  
                          <tr>
                      <?php 
                      $date_now =  date("Y-m-d");
                      if($return_date<=$date_now){
                        ?>
                          <td style="color:red"><?php echo $borrow_id; ?></td>
                          <td style="color:red"><?php echo $item_id; ?></td>
                          <td style="color:red"><?php echo $itemname; ?></td>
                          <td style="color:red"><?php echo $itemtype; ?></td>
                          <td style="color:red"><?php echo $borrower; ?></td>
              <td style="color:red"><?php echo $borrow_date; ?></td>
              <td style="color:red"><?php echo $borrow_qty; ?></td>
              <td style="color:red"><?php echo $returnee; ?></td>
              <td style="color:red"><?php echo $return_date; ?></td>

                          <?php
                        }else{
                          ?>

                           <td><?php echo $borrow_id; ?></td>
                          <td><?php echo $item_id; ?></td>
                          <td><?php echo $itemname; ?></td>
                          <td><?php echo $itemtype; ?></td>
                          <td><?php echo $borrower; ?></td>
              <td><?php echo $borrow_date; ?></td>
              <td><?php echo $borrow_qty; ?></td>
              <td><?php echo $returnee; ?></td>
              <td><?php echo $return_date; ?></td>
 <?php
                        }
                          ?>
						  

						<td>                          
						  &nbsp;&nbsp;&nbsp;&nbsp;<a href="e2e_return_stocks.php?Item_Number=<?php echo $item_id; ?>&&itemname=<?php echo $itemname; ?>&&borrowid=<?php echo $borrow_id; ?>" class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Return Item"><span class="glyphicon glyphicon-refresh"></span></a>
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


                    </form>
            
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
