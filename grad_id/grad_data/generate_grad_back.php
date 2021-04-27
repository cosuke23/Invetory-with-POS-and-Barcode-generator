<?php
require 'connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
//php function codes
if(isset($_POST['btn_gen_back'])){
	 $back_cover = $_POST['back_cover'];
}
require_once('tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('STEVEN N. LIM');
$pdf->SetTitle('GENERATING GRADUATING ID CARD WITH BARCODE');
$pdf->SetSubject('GENERATE ID');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetMargins(5,5,5,5);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('times', '', 12);
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
$pdf->write1DBarcode('10000131576', 'C128', '45', '58', '', 10, 0.45, '', 'N');
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// START OF BACKGROUND IMAGE
	$pdf->AddPage();
	$pdf->setPageMark();
	$img_file = K_PATH_IMAGES.'grad_back_only.png';
	$i = 0;
	$height = 10;
	$width = 4;
	while($i < $back_cover){
			if($i != 0) {
				if($i % 8 == 0){
				$pdf->AddPage();
				$width = 4;
				$height = -55;
				$pdf->SetAutoPageBreak(FALSE,PDF_MARGIN_BOTTOM);
				}
			}
			if($i != 0) {
				if($i % 2 == 0){
					$height+=65;
					$width -=102;
					$width = 4;
				}
			}		
			$pdf->Image($img_file, $width, $height, 100, 60, '', '', '', true, 200, '', false, false, 0);
			$height-=65;
			$width+=102;
	  		$height+=65;
			$i++;
	}

$tbl = "audit_trail";
$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Generate Back ID","module"=>"Print Back ID Module"];
$q_data = $database->insert($tbl,$columns);		
$html = '<div></div>';
$pdf->writeHTML($html, true, false, true, false, '');
// get current vertical position

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('GRAD.pdf', 'I');
$pdf->IncludeJS($js);
//============================================================+
// END OF FILE
//============================================================+
