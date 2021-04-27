<?php 
include('head.php');
?>
      <div class="container-fluid mimin-wrapper">

          <!-- start:Left Menu -->
             <div id="left-menu">
              <div class="sub-left-menu scroll">

                          <div class="profile-v1-pp">         
                              <div class="profile-v1-pp">         
                      <?php
                
                       echo '<img src="../files/student_pics/'.$stud_no.'.jpg;"style="height:100%;" class="img-responsive">';
                       ?> 
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
                          <label class="active">
                          <a href="e2e_stocks.php"><i class="glyphicon glyphicon-home"></i>Stocks</a>
                        </label><br>
                          <label >
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
                        <h1 class="animated fadeInLeft">RETURN MANAGER</h1>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Return Item</h3></div>
                    <br>
                    <form id="defaultForm" method="post" action="e2e_return_stocks_process.php" enctype="multipart/form-data">
                     <?php

                      if(isset($_GET['update_item_success'])&&isset($_GET['username'])){
                        $username=$_GET['username'];
                        echo '<script language = javascript>
                        swal({
                           title: "Successfully Updated Item!",
                            html: true,
                           text: "<strong> Updated Item with ID: '. $_GET['username'].'</strong>",
                           type: "success",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_item_update.php?Item_Number='.$username.'";
                           }
                         });
                     </script>';
                      }
                      if(isset($_GET['update_item_failed'])&&isset($_GET['username'])){
                        $username=$_GET['username'];
                        echo '<script language = javascript>
                        swal({
                           title: "Item Update Unsuccessful!",
                            html: true,
                           text: "<strong> Unsuccessful Update of Item with ID: '. $_GET['username'].'</strong>",
                           type: "warning",
                           showCancelButton: false,

                           confirmButtonText: "OK",
                           closeOnConfirm: false,
                           closeOnCancel: false
                         },
                         function(isConfirm){
                           if (isConfirm) {
                             window.location.href="e2e_item_update.php?Item_Number='.$username.'";
                           }
                         });
                     </script>';
                      }

                      if(isset($_GET['Item_Number'] )) {

                        $username=$_GET['Item_Number'];
						$borrow_id=$_GET['borrowid'];

                        //echo $event_id;

                    	$table = "item_info";
                        $columns = "*";
                        $where = ["item_id" => $username];
                        $q_item_info =$database->select($table,$columns,$where);

                        foreach($q_item_info as $item_data){

                          $username         =   $item_data['username'];
                          $itemname         =   $item_data['itemname'];
                          $itemtype   		=   $item_data['itemtype'];
                          $category     	=   $item_data['category'];
                          $itemdesc         =   $item_data['itemdesc'];
                          $status     		=   $item_data['status'];
						  $stocks			=	$item_data['stocks'];
                          $date			    =   $item_data['date'];
						  

$borrow_id=$_GET['Item_Number'];
						$table1 = "borrow";
                        $columns1 = "*";
                        $where1 = ["item_id" => $borrow_id];
                        $q_borrow =$database->select($table1,$columns1,$where1);

                        foreach($q_borrow as $item_data1){

                          $borrow_id        =   $item_data1['borrow_id'];
                          $itemname         =   $item_data1['itemname'];
                          $itemtype   		=   $item_data1['itemtype'];
                          $category     	=   $item_data1['category'];
						  $borrower			=   $item_data1['borrower'];
                          $borrow_date		=   $item_data1['borrow_date'];
						  $returnee			=   $item_data1['returnee'];
						  $borrowed			=   $item_data1['borrow_qty'];
              $remarks     =   $item_data1['remarks'];
              $department     =   $item_data1['department'];
						

						}

                        }
                      }

                      ?>

                      <div class="panel-body" style="padding-bottom:30px;">
                         <input name="username" type="hidden" value ="<?php echo $username ?>"/>
						  <input name="borrow_id" type="hidden" value ="<?php echo $borrow_id ?>"/>

                      <div class="row">
                        <div class="col-md-4">
                             <h5 style="padding-left:5px;">DEPARTMENT</h5>
                               <div class="form-group has-feedback">
                                <h4><?php echo $department; ?>(<?php echo $remarks; ?>)</h4>
                               </div>
                          </div>
						
                        <div class="col-md-4">
                            <h5 style="padding-left:5px;">ITEM NAME</h5>
                            <div class="form-group has-feedback">
                               <h4><?php echo $itemname; ?></h4>
                            </div>
                        </div>
						
                        
					  
                      <div class="row">
                        <div class="col-md-4">
                          <h5 style="padding-left:20px;">ITEM TYPE</h5>
                          <div class="form-group has-feedback">
                              <h4 style="padding-left:15px;"><?php echo $itemtype; ?></h4>
                          </div>
                        </div>
						
                        <div class="col-md-4">
                          <h5 style="padding-left:10px;">CATEGORY</h5>
                          <div class="form-group has-feedback">
						  <h4 style="padding-left:5px;"><?php echo $category; ?></h4>
                          </div>
                        </div>
						
						 <div class="col-md-4">
                          <h5 style="padding-left:10px;">BORROWER</h5>
                          <div class="form-group has-feedback">
						  <h4 style="padding-left:5px;"><?php echo $borrower; ?></h4>
                          </div>
                        </div>

						<div class="col-md-4">
                          <h5 style="padding-left:10px;">DATE OF BORROW</h5>
                          <div class="form-group has-feedback">
						  <h4 style="padding-left:5px;"><?php echo $borrow_date; ?></h4>
                          </div>
                        </div>
						
						<div class="row">
                        <div class="col-md-4">
							<h5 style="padding-left:20px;">CURRENT STOCKS</h5>
							<div class="form-group has-feedback">
							<h3 style="text-align:center"><?php echo $stocks; ?></h3>
							<input type="hidden" name="currentborrowstock" id="currentborrowstock" class="form-control" value ="<?php echo $stocks; ?>"/>
							</div>
                        </div>
						
						<div class="col-md-4">
						<h5 style="padding-left:20px;">BORROWED QUANTITY</h5>
							<div class="form-group has-feedback">
							<h3 style="text-align:center"><?php echo $borrowed; ?></h3>
							<input type="hidden" name="borrowedqty" id="borrowedqty" class="form-control" value ="<?php echo $borrowed; ?>"/>
							</div>
                        </div>

							<div class="col-md-3">
                        	<h5 style="padding-left:10px;">RETURN QUANTITY</h5>
							
							<div class="form-group has-feedback">
                            <input type="text" name="returnqtystocks" id="returnqtystocks" class="form-control" maxlength="3" required />
							</div>
						</div>
                        
						</div>
						
						<div class="row">
						<div class="col-md-4">
                        </div>
						
						<div class="col-md-4">
                        </div>

						<div class="col-md-3">
							<h5 style="padding-left:10px;">RETURNEE</h5>
							<div class="form-group has-feedback">
                            <input type="text" name="returnee" id="returnee	" class="form-control" maxlength="23" required />
							</div>
						</div>
                        
						</div>
					    

                       <div class="row"><br><br>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-info btn-block" name="btn-return" id="btn-return"><span class="glyphicon glyphicon-pencil"></span> &nbsp;RETURN</button>
                        </div>
                        <div class="col-md-4">
                            <a href="e2e_borrow.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                        </div>
                      </div>
					  
                </div>
              </form>
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
                      <a href="*"><i class="glyphicon fa fa-building-o"></i>&nbsp; Company Records</a>
                      <a href="*"><i class="glyphicon fa fa-thumbs-o-up"></i>&nbsp; OJT Endorsement</a>
                      <a href="*"><i class="glyphicon fa fa-user-secret"></i>&nbsp; Check Attire</a>
                      <a href="*"><i class="glyphicon fa fa-smile-o"></i>&nbsp; Graduating ID Card</a>
                      <a href="e2e_business_card.php"><i class="glyphicon icons icon-credit-card"></i>&nbsp; Business Card</a>
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

<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<script src="asset/js/sweetalert-dev.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is invalid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                borrowstocks: {
                    validators: {
                        notEmpty: {
                            message: 'Adding stocks field is required and can\'t be empty'
                        },
                  regexp: {
                                  regexp: /[0-9]/,
                                  message: 'Adding stocks can only consist of numbers'
                              },
                  stringLength: {
                                  min: 1,
                                  max: 3,
                                  message: 'Adding stocks must be 11 numbers'
                              }
                          }
                      },

                  }
        })
}); 
 
 
 
 
 
 
 
 
 
</script>
<!-- end: Javascript -->
</body>
</html>
