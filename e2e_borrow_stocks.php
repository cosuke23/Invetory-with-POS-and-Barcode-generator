<?php 
include('head.php');
?>


      <!-- end: Header -->

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
                        <h1 class="animated fadeInLeft">BORROW MANAGER</h1>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Borrow Item</h3></div>
                    <br>
                    <form id="defaultForm" method="post" action="e2e_borrow_stocks_process.php" enctype="multipart/form-data">
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

                      if(isset($_GET['Item_Number'])) {

                        $item_id=$_GET['Item_Number'];
						

                        //echo $event_id;

                    	$table = "item_info";
                        $columns = "*";
                        $where = ["item_id" => $item_id];
                        $q_item_info =$database->select($table,$columns,$where);

                        foreach($q_item_info as $item_data){

                          $item_id          =   $item_data['item_id'];
                          $itemname         =   $item_data['itemname'];
                          $itemtype   		=   $item_data['itemtype'];
                          $category     	=   $item_data['category'];
                          $itemdesc         =   $item_data['itemdesc'];
                          $status     		=   $item_data['status'];
						  $stocks			=	$item_data['stocks'];
                          $date			    =   $item_data['date'];

                        }
                      }

                      ?>

                      <div class="panel-body" style="padding-bottom:30px;">
                         <input name="item_id" type="hidden" value ="<?php echo $item_id ?>"/>

                      <div class="row">
                        <div class="col-md-4">
                             <h5 style="padding-left:5px;">ITEM NUMBER</h5>
                               <div class="form-group has-feedback">
                                <h4><?php echo $item_id; ?></h4>
                               </div>
                          </div>
						
                        <div class="col-md-4">
                            <h5 style="padding-left:5px;">ITEM NAME</h5>
                            <div class="form-group has-feedback">
                               <h4><?php echo $itemname; ?></h4>
							<input type="hidden" name="itemname" id="itemname" class="form-control" value ="<?php echo $itemname; ?>"/>
                            </div>
                        </div>
						
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">ITEM STATUS</h5>
                          <div class="form-group has-feedback">
								<h4><?php echo $status; ?></h4>
                        </div>
                      </div>
					  
                      <div class="row">
                        <div class="col-md-4">
                          <h5 style="padding-left:20px;">ITEM TYPE</h5>
                          <div class="form-group has-feedback">
                              <h4 style="padding-left:15px;"><?php echo $itemtype; ?></h4>
							<input type="hidden" name="itemtype" id="itemtype" class="form-control" value ="<?php echo $itemtype; ?>"/>
                          </div>
                        </div>
						
                        <div class="col-md-4">
                          <h5 style="padding-left:10px;">CATEGORY</h5>
                          <div class="form-group has-feedback">
						  <h4 style="padding-left:5px;"><?php echo $category; ?></h4>
						<input type="hidden" name="category" id="category" class="form-control" value ="<?php echo $category; ?>"/>
                          </div>
                        </div>
						
						<div class="col-md-4">
                            <h5 style="padding-left:0px;"> ITEM DESCRIPTION</h5>
                            <div class="form-group has-feedback">
							<h4 style="padding-left:0px;"><?php echo $itemdesc; ?></h4>   
                            </div>
                        </div>
                      </div>
                        <div class="row">
                        <div class="col-md-4">
                          <h5 style="padding-left:20px;">DEPARTMENT</h5>
                          <div class="form-group has-feedback">
                                 <select class="form-control" name="department" style="width:50%;" required>
                <option value=""></option>
                <option value="MAINTENANCE">MAINTENANCE</option>
                                <option value="E2E DEPARTMENT">E2E DEPARTMENT</option>
                                <option value="PROWARE">PROWARE</option>
                                <option value="I.T-DEPARTMENT">I.T-DEPARTMENT</option>
                                <option value="FRONTLINE">FRONTLINE</option>
                                <option value="FACULTY">FACULTY</option>
                                <option value="REGISTRAR">REGISTRAR</option>
                                <option value="CASHIER">CASHIER</option>
                                <option value="LIBRARY">LIBRARY</option>
                                <option value="ACCOUNTING">ACCOUNTING</option>
                </select>
                          </div>
                        </div>
            
                        <div class="col-md-4">
                          <h5 style="padding-left:10px;">REMARKS</h5>
                          <div class="form-group has-feedback">
              <input type="text" name="remarks" id="remarks" class="form-control" style="width:50%;"/>
                          </div>
                        </div>
            
            <div class="col-md-4">
                            <h5 style="padding-left:0px;">DATE TO RETURN</h5>
                            <div class="form-group has-feedback">
              <input type="date" name="date_return" id="date_return" class="form-control" style="width:50%;"/>   
                            </div>
                        </div>
                      </div>

					  
					  	<div class="row">
                        <div class="col-md-4">
							<h5 style="padding-left:20px;">CURRENT STOCKS</h5>
							<div class="form-group has-feedback">
							<h3 style="text-align:center"><?php echo $stocks; ?></h3>
							<input type="hidden" name="currenborrowtstock" id="currentborrowstock" class="form-control" value ="<?php echo $stocks; ?>"/>
							</div>
                        </div>
                        
						<div class="col-md-4">
                        	<h5 style="padding-left:10px;">BORROWED QTY</h5>
							<div class="form-group has-feedback">
                            <input type="text" name="borrowstocks" id="borrowstocks" class="form-control" maxlength="3" style="width:50%;"/>
							</div>
						</div>
						
						<div class="col-md-4">
                        	<h5 style="padding-left:10px;">BORROWED BY</h5>
							<div class="form-group has-feedback">
                            <input type="text" name="borrower" id="borrower" class="form-control" maxlength="10" style="width:50%;"/>
							</div>
						</div>
						
                        
						<div class="col-md-4">
                        </div>
						
                      </div>

                      <div class="row"><br><br>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-info btn-block" name="btn-borrow" id="btn-borrow"><span class="glyphicon glyphicon-pencil"></span> &nbsp;BORROW</button>
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







               

                          
						
                          <?php
                          
                          print '</tbody>
                          </table>
                          </div>
                          </div>';
                        ?>
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
                borrower: {
                    validators: {
                        notEmpty: {
                            message: 'Adding Name field is required and can\'t be empty'
                        },
                  regexp: {
                                  regexp: /[a-z]/,
                                  message: 'Adding Name can only consist of letters'
                              },
                  stringLength: {
                                  min: 1,
                                  max: 10,
                                  message: 'Adding Name must be 10 letters above'
                              }
                          }
                      },
                borrower: {
                    validators: {
                        notEmpty: {
                            message: 'Adding Name field is required and can\'t be empty'
                        },
                  regexp: {
                                  regexp: /[a-z]/,
                                  message: 'Adding Name can only consist of letters'
                              },
                  stringLength: {
                                  min: 1,
                                  max: 10,
                                  message: 'Adding Name must be 10 letters'
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
