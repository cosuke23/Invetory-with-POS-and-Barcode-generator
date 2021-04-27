<?php

require 'pdfcrowd.php';

require 'asset/connection/mysqli_dbconnection.php'; 

if(isset($_POST['downloadjournal']))

{

    $URL = mysqli_real_escape_string($dbc, trim($_POST['URL']));



try

{   

    // create an API client instance

    $client = new Pdfcrowd("limsteven1994", "75fec50cfd85a5b095e1b8375ef82026");



    // convert a web page and store the generated PDF into a $pdf variable

    $pdf = $client->convertFile('C:\xampp\htdocs\OJTassisti-v20\weekly_journal.php');



    // set HTTP response headers

    header("Content-Type: application/pdf");

    header("Cache-Control: max-age=0");

    header("Accept-Ranges: none");

    header("Content-Disposition: attachment; filename=\"journal.pdf\"");



    // send the generated PDF 

    echo $pdf;

}

catch(PdfcrowdException $why)

{

    echo "Pdfcrowd Error: " . $why;

}

}

?>