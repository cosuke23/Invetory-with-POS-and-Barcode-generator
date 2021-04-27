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
                        <h1 class="animated fadeInLeft">ADD NEW ITEM</h1>
                        <p class="animated fadeInDown" style="padding-left:10px;">
                           Add new item information.
                        </p>
                    </div>
                </div>
              </div>

              <div class="col-md-12 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>ADD ITEM</h3></div>
                    <div class="panel-body">
                    <form action="e2e_add_item_process.php" method="POST" NAME = "frmOne" id="defaultForm">
                      <?php
                      $q_data = mysqli_query($conn,"SELECT max(product_id) AS user_id FROM products");
                      foreach($q_data AS $qDAta){
                      $item_id = $qDAta['user_id']+1;
                      }
                      $item_no = str_pad($item_id,4,'0',STR_PAD_LEFT);
                      $year_now = date("Y");
                      $username = "ITEM".$year_now.$item_no;

                      ?>
                      <div class="row">
                       <input type="hidden" name="username" value="<?php echo $username; ?>"/>
                        <div class="col-md-4">
                             <h5 style="padding-left:5px;">Date Buyed</h5>
                               <div class="form-group has-feedback">
                                <input type="date" name="date_buy" />
                               </div>
                          </div>

                        <div class="col-md-4">
                             <h5>OR#</h5>
                               <div class="form-group has-feedback">
                              <input type="text" class="form-control" id="mrp" name="or" value="<?php if(!empty($_POST["mrp"])) { print $_POST["mrp"]; } else { print 10.00; } ?>">
                               </div>
                          </div>
                        <div class="col-md-4">
                           <h5 style="padding-left:5px;">UNIT</h5>
                           <div class="form-group has-feedback">
                              <select class="form-control" name="unit" id="unit" required>
                <option value=""></option>
                                <option value="Box">Box</option>
                                <option value="Piece">Piece</option>
                <option value="Dozen">Dozen</option>
                <option value="Bundle">Bundle</option>
                
                              </select>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                         <div class="col-md-4">
                           <h5 style="padding-left:5px;">CATEGORY</h5>
                           <div class="form-group has-feedback">
                              <select class="form-control" name="category" id="category" required>
                <option value=""></option>
                                                <option value="Books">Books</option>
                                <option value="Gifts">GIfts</option>                
                                <option value="School Supply">School Supply</option>
                <option value="STI Supply">Papers</option>
                <option value="STI Supply">Tapes</option>
                </select>
                          </div>
              
                        </div>
                         <div class="col-md-4">
                             <h5 style="padding-left:5px;">ITEM NAME</h5>
                              <div class="form-group has-feedback">
                               <input type="text" class="form-control" id="itemname" name="sku" value="<?php if(!empty($_POST["sku"])) { print $_POST["sku"]; } else { print 'RED10MDL00009'; } ?>"> 
                              </div>
                          </div>
              
              
              <div class="row">
                         <div class="col-md-4">
                           <h5 style="padding-left:5px;">ITEM TYPE</h5>
                           <div class="form-group has-feedback">
                              <select class="form-control" name="itemtype" required>
                <option value=""></option>
                                <option value="Consumable">Consumable</option>
                                <option value="Non-Consumable">Non-Consumable</option>
                </select>
                          </div>
                        </div>
            
             </div>
             </div>
             
                         
            
            
            
                      <div class="row">
                      <div class="col-md-4">
                           <h5 style="padding-left:5px;">ITEM Model</h5>
                          <div class="form-group has-feedback">
                             <input type="text" class="form-control" id="model" name="itemdesc" value="<?php if(!empty($_POST["model"])) { print $_POST["model"]; } else { print 'MDL00009'; } ?>">  
                          </div>
                      </div>

                       <div class="col-md-4">
                           <h5 style="padding-left:5px;">CRITICAL LEVEL</h5>
                          <div class="form-group has-feedback">
                            <input type="number"  name="crit" id="crit" class="form-control" required></textarea>
                          </div>
                      </div>
                    
                         <div class="col-md-2">
                             <h5 style="padding-left:5px;">ITEM Price</h5>
                              <div class="form-group has-feedback">
                                <input type="number" onkeyup="OnChange(this.value)" name="cost" id="cost" class="form-control" maxlength="3" required />
                                 
                              </div>
                          </div>
                                                          <div class="col-md-2">
                             <h5 style="padding-left:5px;">ITEM QTY</h5>
                              <div class="form-group has-feedback">
                                <input type="number" onkeyup="OnChange(this.value)" name="qty" id="qty" class="form-control" maxlength="3" required />
                              </div>
                          </div>
                                                   <div class="col-md-2">
                             <h5 style="padding-left:5px;">Total</h5>
                              <div class="form-group has-feedback">
                                <input type="number" onkeyup="OnChange(this.value)" name="total" id="total" class="form-control" maxlength="3" required />
                              </div>
                          </div>
                      </div>
<!--<div class="my-form">


            <p class="text-box">

  &nbsp Others

    
  <a class="add-box" href="#">Add More</a>

             &nbsp GRAND </td><td>      &#8369<input class="input focused"  style="width:130px;" onkeyup="OnChange(this.value)"  name="grandtotal" id="focusedInput" type="text" placeholder = "Grand"   readonly>
                       


            </p>
       <br>

    </div> -->

                      <br>
                       <div class="row">
                          <div class="col-md-4"></div>
                          <div class="col-md-4">
                               <button type="submit" class="btn btn-info btn-block"  name="btn_add_item_info" id="btn_add_item_info">

                                <span class="glyphicon glyphicon-floppy-saved"></span> &nbsp;SAVE
                               </button>
                           </div>
                            <div class="col-md-4">
                             <a href="e2e_stocks.php"><button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-chevron-left"> &nbsp;BACK</span></button></a>
                           </div>
                          </div>
                     </form>

                  </div>
                </div>
              </div>
            </div><!-- end: content -->

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li class="ripple">
                      <a href="e2e_home.php"><i class="glyphicon glyphicon-home"></i>&nbsp; Home</a>
                      <a href="*"><i class="glyphicon fa fa-user"></i>&nbsp; My Profile</a>
                      <a href="*"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Transactions</a>
                      <a href="*"><i class="glyphicon fa fa-group"></i>&nbsp; User Account</a>
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
<script src="asset/js/plugins/nouislider.min.js"></script>
<script src="asset/js/plugins/jquery.validate.min.js"></script>

<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="asset/js/export.js"></script>
<script type="text/javascript" src="asset/js/dataTables.tableTools.js"></script>

<!-- custom -->
   <script type="text/javascript" language="Javascript">
    jQuery(document).ready(function($){
    $('.my-form .add-box').click(function(){
        var n = $('.text-box').length + 1;
        if( 2 < n ) {
            alert('Stop it!');
            return false;
        }


        var box_html = $('<p class="text-box">&nbsp Others <input name="date8' + n + '" id="focusedInput1'+ n +'" style="width:130px;" type="date" value="" required><input class="input focused"  name="particulars8' + n + '" id="focusedInput2'+ n +'" type="text" style="width:80px;" placeholder = "Particulars"><input class="input focused" style="width:80px;" name="reff8' + n + '" id="focusedInput3'+ n +'" type="text" placeholder = "OR#/REFF"><input class="input focused" style="width:50px;"  onkeyup="OnChange(this.value)" name="cost8' + n + '" id="focusedInput4'+ n +'" type="number" placeholder = "Cost" required><input class="input focused" onkeyup="OnChange(this.value)" style="width:40px;"  name="unit8' + n + '" id="focusedInput5'+ n +'" type="number" placeholder = "Unit" required><input class="input focused" style="width:50px;" name="hotel8' + n + '" id="focusedInput6'+ n +'" onkeyup="OnChange(this.value)" type="number" placeholder = "Hotel"><input class="input focused" style="width:50px;" name="meal8' + n + '" id="focusedInput7'+ n +'" type="number" onkeyup="OnChange(this.value)" placeholder = "Meal"><input class="input focused" style="width:50px;" name="fare8' + n + '" id="focusedInput8'+ n +'" onkeyup="OnChange(this.value)" type="number" placeholder = "Fare">&#8369  <input class="input focused" style="width:30px;"  name="total8' + n + '" id="focusedInput9'+ n +'" value="" type="text" placeholder = "Total" readonly><a href="#" class="remove-box">Remove</a></p>');  //    var box_html = $('<p class="text-box"> <input type="text" name="steps[]" value="" id="stepbox' + n + '" /> <input type="text" placeholder="Tips(Optional)" name="tips[]" value="" id="tipsbox' + n + '" /> <a href="#" class="remove-box">Remove</a></p>');
     box_html.hide();
        $('.my-form p.text-box:last').after(box_html);
        box_html.fadeIn('slow');
  
        return false;
    });

  
    $('.my-form').on('click', '.remove-box', function(){
        $(this).parent().css( 'background-color', '#FF6C6C' );
        $(this).parent().fadeOut("slow", function() {
            $(this).remove();
            
            $('.box-number').each(function(index){
                $(this).text( index + 1 );
            });
        });
        return false;
    });
  
}); 
  var t1=0; var cost=0; var qty=0; 
  qty = document.frmOne.qty.value;
  cost = document.frmOne.cost.value;
  t1 = document.frmOne.total.value;
    function OnChange(value){
    
    qty = document.frmOne.qty.value;
    cost = document.frmOne.cost.value;

    
            t1=cost * qty ;    
            
    document.frmOne.total.value = t1 ;

   







           var grandtotal=0;


    grandtotal = t1;    

        
    document.frmOne.grandtotal.value = grandtotal;

    }
</script>

<SCRIPT language=Javascript>
        <!--
        function isNumberKey(evt)
        {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;

         return true;
        }
        //-->
    </SCRIPT>
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
               itemname: {
                    message: 'Item name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Item name is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 1,
                            max: 32,
                            message: 'Item name must be more than 1 and less than 32 letters'
                        },
                 regexp: {
                            regexp: /^[a-z],[1-9]
                            message: 'Item name can only consist of letters'
                        }
                    }
                },

                itemtype: {
                    message: 'Item type is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Item tyoe is required and can\'t be empty'
                        },
                    }
                },
                category: {
                    message: 'Category is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Category is required and can\'t be empty'
                        },
                    }
                },
        
        
                      itemdesc: {
                          validators: {
                              notEmpty: {
                                  message: 'Item description is required and can\'t be empty'
                              },
                              stringLength: {
                            min: 10,
                            max: 250,
                            message: 'Item description must be more than 10 and less than 250 characters long'
                        },

                          }
                      },
            
            

                  }
          
          
        })
});

</script>
<!-- end: Javascript -->
</body>
</html>
