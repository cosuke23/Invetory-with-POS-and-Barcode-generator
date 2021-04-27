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
            </div>w
          <!-- end: Left Menu -->
          <div class="container-fluid mimin-wrapper">
          <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h1 class="animated fadeInLeft">STOCK MANAGER</h1>
                    </div>
                </div>
              </div>
              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Update Item</h3></div>
                    <br>
                    <form id="defaultForm" method="post" action="e2e_item_update_process.php" enctype="multipart/form-data">
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

                      if(isset($_GET['username'])) {

                        $username=$_GET['username'];

                        //echo $event_id;

                    
                      $user_query2 = mysqli_query($conn,"SELECT * from products where product_id='$username'")or die(mysqli_error());

                       while($q_em_data2 = mysqli_fetch_array($user_query2)){

                         $code = $q_em_data2["product_id"];
                                  $itemname = $q_em_data2["product_name"];
                                  $itemtype = $q_em_data2["product_type"];
                                $category = $q_em_data2["product_name"];
                                  $itemdesc = $q_em_data2["product_size"];
                                  $stocks = $q_em_data2["product_qty"];
                  $qty = $q_em_data2["product_qty"];
						  

                        }
                      }

                      ?>

                      <div class="panel-body" style="padding-bottom:30px;">
                         <input name="username" type="hidden" value ="<?php echo $code ?>"/>

                      <div class="row">
                        <div class="col-md-4">
                             <h5 style="padding-left:5px;">ITEM NUMBER</h5>
                               <div class="form-group has-feedback">
                                <h4><?php echo $username; ?></h4>
                               </div>
                          </div>
						
                        <div class="col-md-4">
                            <h5 style="padding-left:5px;">ITEM NAME</h5>
                            <div class="form-group has-feedback">
                               <input type="text" name="itemname" class="form-control" placeholder="Item name" value ="<?php echo $itemname ?>"/>
                            </div>
                        </div>
						
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">ITEM QUANTITY</h5>
                          <div class="form-group has-feedback">
                            <input type="text" name="qty" value="<?php echo $stocks; ?>">
       
                              </div>
 
                        </div>
                      </div>
					  
                      <div class="row">
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">Unit</h5>

                          <div class="form-group has-feedback">
                                   <?php
                   $comstart1="";
                   $comstart2="";
				   $comstart3="";
				   $comstart4="";
                   $comend="-->";
                   if($itemdesc=="Box")
                   {
                  $comstart1="<!--";
                   }
                   else if($itemdesc=="Piece")
                   {
                  $comstart2="<!--";
                   }
				   else if($itemdesc=="Dozen")
                   {
                  $comstart3="<!--";
                   }
				   else if($itemdesc=="Bundle")
                   {
                  $comstart4="<!--";
                   }
                   ?>
                   <select class="form-control" name="unit" id="unit" class="form-control" placeholder="">
                                    <option><?php echo $itemdesc; ?></option>
                                    <?php echo $comstart1;?><option value="Box">Box</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Piece">Piece</option><?php echo $comend;?>
                                    <?php echo $comstart3;?><option value="Dozen">Dozen</option><?php echo $comend;?>
									<?php echo $comstart4;?><option value="Bundle">Bundle</option><?php echo $comend;?>
									</select>
                              </div>
                        </div>
                        <div class="col-md-4">
                          <h5 style="padding-left:5px;">CATEGORY</h5>
                          <div class="form-group has-feedback">
                                   <?php
                   $comstart1="";
                   $comstart2="";
                   $comstart3="";
				   $comstart4="";
				   $comstart5="";
				   $comstart6="";
                   $comend="-->";
                   if($category=="Tarpaulin")
                   {
                  $comstart1="<!--";
                   }
                   else if($category=="Books")
                   {
                  $comstart2="<!--";
                   }
                   else if($category=="Cable Wires")
                   {
                  $comstart3="<!--";
                   }
				   else if($category=="Gifts")
                   {
                  $comstart4="<!--";
                   }
				   else if($category=="School Supply")
                   {
                  $comstart5="<!--";
                   }
				   else if($category=="STI Supply")
                   {
                  $comstart6="<!--";
                   }
                   ?>
                   <select class="form-control" name="category" class="form-control" placeholder="">
                                    <option><?php echo $category; ?></option>
                                    <?php echo $comstart1;?><option value="Tarpaulin">Tarpaulin</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Books">Books</option><?php echo $comend;?>
                                    <?php echo $comstart3;?><option value="Cable Wires">Cable Wires</option><?php echo $comend;?>
                                    <?php echo $comstart4;?><option value="Gifts">Gifts</option><?php echo $comend;?>
                                    <?php echo $comstart5;?><option value="School Supply">School Supply</option><?php echo $comend;?>
                                    <?php echo $comstart6;?><option value="STI Supply">STI Supply</option><?php echo $comend;?>
                                    </select>
                              </div>
                        </div>
						
						
						
							<div class="col-md-4">
                          <h5 style="padding-left:5px;">ITEM TYPE</h5>
                          <div class="form-group has-feedback">
                                   <?php
                   $comstart1="";
                   $comstart2="";
                   $comend="-->";
                   if($itemtype=="Consumable")
                   {
                  $comstart1="<!--";
                   }
                   else if($itemtype=="Non-Consumable")
                   {
                  $comstart2="<!--";
                   }
                   ?>
                   <select class="form-control" name="itemtype" class="form-control" placeholder="">
                                    <option><?php echo $itemtype; ?></option>
                                    <?php echo $comstart1;?><option value="Consumable">Consumable</option><?php echo $comend;?>
                                    <?php echo $comstart2;?><option value="Non-Consumable">Non-Consumable</option><?php echo $comend;?>
                                    </select>
                              </div>
                        </div>
                      </div>

                      <div class="row">
                            <div class="col-md-12">
                              <h5 style="padding-left:5px;">ITEM DESCRIPTION</h5>
                              <div class="form-group has-feedback">
                                  <textarea rows ="2" name="itemdesc" id="itemdesc" class="form-control" placeholder="(Optional) Item Description"><?php echo $itemdesc; ?> </textarea>
                              </div>
                            </div>
				
                      </div>

                          <div class="row">

                      <div class="row"><br><br>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-info btn-block" name="btn-update" id="btn-update"><span class="glyphicon glyphicon-pencil"></span> &nbsp;UPDATE</button>
                        </div>
                        <div class="col-md-4">
                            <a href="e2e_stocks.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                        </div>
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
                      <a href="*"><i class="glyphicon fa fa-user"></i>&nbsp; User Account</a>0
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
 var table = $('#datatables').DataTable();

$('#btn-updatezz').click(function(){
    swal({
  title: "Currently Under Development!",
  text: ":((",
  type: "warning",
  showCancelButton: false,
  closeOnConfirm: true,
  animation: "slide-from-bottom",
  inputPlaceholder: "---"
},
function(inputValue){
  var regex = /^[0-9]+$/;
  /*if (inputValue === false) return false;
  if (inputValue === "") {
    swal.showInputError("You need to write something!");
    return false;
  }
  if (!inputValue.match(regex)) {
    swal.showInputError("Student Number only consist of numbers!");
    return false;
  }
  if (inputValue.length !== 11) {
    swal.showInputError("Student Number must be 11 numbers!");
    return false;
  }
  else{
    swal("Nice!", "You wrote: " + inputValue, "success");
    }
*/    });
  });

 });
<!-- end: Javascript -->

</script>
</body>
</html>
