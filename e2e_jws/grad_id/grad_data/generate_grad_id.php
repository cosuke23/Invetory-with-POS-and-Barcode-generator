<?php
require 'connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
//php function codes
if(isset($_POST['btn_gen_data'])){
	$stud_no = $_POST['stud_no'];
	$table_csn = "student_info";
	$columns_csn = "*";
	$where_csn = ["stud_no"=>$stud_no];
	$q1_csn = $database->count($table_csn,$columns_csn,$where_csn);
	if($q1_csn == ""){
	  header("location: /e2e_JWS/e2e_grad_id.php?error_id=1&stud_no=$stud_no");
	  exit;
	}elseif($q1_csn != ""){

		$q_check_dp = $database->query("SELECT stud_dp FROM student_info where stud_no = '$stud_no'");
		foreach($q_check_dp AS $dp_data){
			$stud_dp = $dp_data["stud_dp"];
		}
		if($stud_dp == 'DEFAULT.jpg'){
			header("location: /e2e_JWS/e2e_grad_id.php?error_id_dp=1&stud_no=$stud_no");
	 		 exit;
		}else{
	$table = "student_info";
	$columns = "*";
	$where = ["stud_no"=>$stud_no];
	$q1 = $database->select($table,$columns,$where);
		foreach($q1 AS $q1_data){
		$stud_no = $q1_data['stud_no'];
		$lname = ucwords(strtolower($q1_data['lname']));
        $fname = ucwords(strtolower($q1_data['fname']));
        $mname = ucwords(strtolower($q1_data['mname']));
		$stud_dp = $q1_data['stud_dp'];
		$program_id = $q1_data['program_id'];
		
   
		$table_program_code = "program_list";
		$column_pc = "*";
		$where_pc = ["program_id"=>$program_id];
		$q_pc = $database->select($table_program_code,$column_pc,$where_pc);
		foreach($q_pc AS $q_pc_data){
			$program_code = $q_pc_data['program_code'];
	  }
	 }
	$table_id = "student_info";
	$columns_id = ["count_id[+]"=>1];
	$where_id = ["stud_no"=>$stud_no];
	$q_update = $database->update($table_id,$columns_id,$where_id);

	$tbl = "audit_trail";
$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Generate and print ID: ".$stud_no."","module"=>"Print Graduating ID Module"];
$q_data = $database->insert($tbl,$columns);	
    }
 }	
}
//start of function
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'gradb2b.png';
		$this->Image($img_file, 5, 10, 200, 60, '', '', '', true, 100, '', false, false, 0);
		//$img_file2 = K_PATH_IMAGES.'gradb2b.png';
		//$this->Image($img_file2, 5, 75, 200, 60, '', '', '', true, 100, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
$pdf->SetAutoPageBreak(TRUE, 0);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// -----------QUERY FIELD---------------------
//--------------END OF QUERY FIELD------------
// set a barcode on the page footer
$pdf->setBarcode(date('Y-m-d H:i:s'));
// add a page
$pdf->AddPage();
// print back

$pdf->writeHTMLCell(100, 0, 36, 32, '<label style="color:white;">'.$fname.' '.$mname.'<br>'.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 35, 45, '<label>'.$stud_no.'</label>');
$pdf->writeHTMLCell(100, 0, 36, 50, '<label>'.$program_code.'</label>');
$pdf->writeHTMLCell(100, 0, 6, 23, '<img src="student_image/'.$stud_dp.'" style="height:80px;width:78px;border:1px solid #021a40;"/>');
$pdf->SetY(30);
// -----------------------------------------------------------------------------
$pdf->SetFont('Courier', '', 10);
$pdf->write1DBarcode($stud_no, 'C128', '45', '58', '', 10, 0.45, '', 'N');
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// create some HTML content
$html = '<div style="background-image: url(images/gradb2b.png)"></div>';

$pdf->writeHTML($html, true, false, true, false, '');
//Close and output PDF document

$pdf->Output('haha.pdf', 'I');
$pdf->IncludeJS($js);


//============================================================+
// END OF FILE
//============================================================+
