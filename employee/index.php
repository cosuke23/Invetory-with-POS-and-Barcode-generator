<?php 
require_once "function.php";
include('templates/header.php');?>
<form name="datetime"  method="post">
    <section class="showcase">
      <div class="container">
        <div class="pb-2 mt-4 mb-2 border-bottom">
          <h2>Generate QR Codes using PHP</h2>
        </div>
        <div class="row align-items-center">  
          <div class="form-group col-md-3">
            <label for="inputEmail4">MRP</label>
            <input type="text" class="form-control" id="mrp" name="mrp" value="<?php if(!empty($_POST["mrp"])) { print $_POST["mrp"]; } else { print 10.00; } ?>">  
          </div>
          <div class="form-group col-md-3">
            <label for="inputEmail4">SKU</label>
            <input type="text" class="form-control" id="sku" name="sku" value="<?php if(!empty($_POST["sku"])) { print $_POST["sku"]; } else { print 'RED10MDL00009'; } ?>">  
          </div>
          <div class="form-group col-md-3">
            <label for="inputEmail4">Model</label>
            <input type="text" class="form-control" id="model" name="model" value="<?php if(!empty($_POST["model"])) { print $_POST["model"]; } else { print 'MDL00009'; } ?>">  
          </div>
          <div class="col">
                <button type="submit" class="btn btn-primary mt-3 float-left">Generate</button>
            </div>
        </div>
        
        <div class="row align-items-center">  
          <div class="form-group col-md-6">
            <label for="inputEmail4">
                <strong>Output: </strong> 
                <hr>
              <?php
                // generate QR Codes
                if(!empty($_POST['mrp'])) {
                    $barcode = generateBarcode($data = array('mrp'=>$_POST['mrp'], 'sku'=>$_POST['sku'], 'model'=>$_POST['model']), 'tmp');
                    echo '<img src="tmp/'.basename($barcode).'" />';
                }
              ?>
            </label>
          </div>
        </div>
    </div>
    </section>
</form>
<?php include('templates/footer.php');?>