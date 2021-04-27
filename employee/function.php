
<?php
function generateBarcode($data, $folder) {

    // include QR Codes Lib
    require ('vendor/autoload.php');

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = $folder.'/';

    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $timestamp = time();
    $filenames = $PNG_TEMP_DIR.$timestamp.'.png';
    $filename = $timestamp.'.png';
    $MRP = $data["mrp"];
    $SKU = $data["sku"];
    $MODEL = $data["model"];

    $productData = "098{$MRP}10{$SKU}55{$MODEL}";
    $barcode = new \Com\Tecnick\Barcode\Barcode();
    $bobj = $barcode->getBarcodeObj('C128B', "{$productData}", 450, 70, 'black', array(0, 0, 0, 0));
    
    $imageData = $bobj->getPngData();
    
    file_put_contents($filenames, $imageData);

    return $filename;
}
?>
