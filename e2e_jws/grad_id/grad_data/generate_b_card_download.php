<?php
require 'connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
// create new PDF document
// Extend the TCPDF class to create custom Header and Footer

//php function codes
if(isset($_GET['stud_no'])){
  $stud_no = $_GET['stud_no'];
  $table = "student_info";
  $columns = "*";
  $where = ["stud_no"=>$stud_no];
  $q1 = $database->select($table,$columns,$where);
  foreach($q1 AS $q1_data){
    $stud_no = $q1_data['stud_no'];
    $lname = ucwords(strtolower($q1_data['lname']));
    $mname = ucwords(strtolower($q1_data['mname']));
    $fname = ucwords(strtolower($q1_data['fname']));
    $email = $q1_data['email'];
    $contact_no = $q1_data['contact_no'];
    $stud_dp = $q1_data['stud_dp'];
    $program_id = $q1_data['program_id'];
    $decoded_img_stud_dp = base64_decode($stud_dp);

    $File_name = $lname.", ".$fname." ".$mname."_".$stud_no;
        $f = finfo_open();
        $stud_dp_type = finfo_buffer($f, $decoded_img_stud_dp, FILEINFO_MIME_TYPE);

    $table_program_code = "program_list";
    $column_pc = "*";
    $where_pc = ["program_id"=>$program_id];
    $q_pc = $database->select($table_program_code,$column_pc,$where_pc);
    foreach($q_pc AS $q_pc_data){
      $program_code = $q_pc_data['program_code'];
    }
  }
  $table_id = "student_info";
  $columns_id = ["count_b_card[+]"=>1];
  $where_id = ["stud_no"=>$stud_no];
  $q_update = $database->update($table_id,$columns_id,$where_id);

  $tbl = "audit_trail";
  $columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Download Business Card : ".$stud_no."","module"=>"Business Card Module"];
  $q_data = $database->insert($tbl,$columns);
}
//end of php functions codes
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
    // $theme_id = 0;


        $img_file = K_PATH_IMAGES.'puzzle_theme.png';
   

    $this->Image($img_file, 9, 31, 192, 58, '', '', '', true, 100, '', false, false, 0);
    $this->Image($img_file, 9, 90, 192, 58, '', '', '', true, 100, '', false, false, 0);
    $this->Image($img_file, 9, 149, 192, 58, '', '', '', true, 100, '', false, false, 0);
    $this->Image($img_file, 9, 208, 192, 58, '', '', '', true, 100, '', false, false, 0);


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
$pdf->SetMargins(0,0,0,0);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->SetFont('helvetica', '', 10);
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
// print 1st column
$pdf->SetFont('helvetica', 'B', 12);
$pdf->writeHTMLCell(100, 0, 20, 36, '<label>'.$stud_no.'</label>');

$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(56, 0, 20, 44, '<label>'.$fname.' '.$mname.' '.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 20, 55, '<label>'.$contact_no.'</label>');
$pdf->writeHTMLCell(56, 0, 20, 63, '<label>'.$email.'</label>');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->writeHTMLCell(100, 0, 117, 36, '<label>'.$stud_no.'</label>');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(56, 0, 117, 44, '<label>'.$fname.' '.$mname.' '.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 117, 55, '<label>'.$contact_no.'</label>');
$pdf->writeHTMLCell(56, 0, 117, 63, '<label>'.$email.'</label>');
// end of 1st column

// print 2nd column
$pdf->SetFont('helvetica', 'B', 12);
$pdf->writeHTMLCell(100, 0, 20, 95, '<label>'.$stud_no.'</label>');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(56, 0, 20, 103, '<label>'.$fname.' '.$mname.' '.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 20, 114, '<label>'.$contact_no.'</label>');
$pdf->writeHTMLCell(56, 0, 20, 122, '<label>'.$email.'</label>');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->writeHTMLCell(100, 0, 117, 95, '<label>'.$stud_no.'</label>');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(56, 0, 117, 103, '<label>'.$fname.' '.$mname.' '.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 117, 114, '<label>'.$contact_no.'</label>');
$pdf->writeHTMLCell(56, 0, 117, 122, '<label>'.$email.'</label>');
// end of 2nd column

// print 3rd column
$pdf->SetFont('helvetica', 'B', 12);
$pdf->writeHTMLCell(100, 0, 20, 154, '<label>'.$stud_no.'</label>');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(56, 0, 20, 162, '<label>'.$fname.' '.$mname.' '.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 20, 173, '<label>'.$contact_no.'</label>');
$pdf->writeHTMLCell(56, 0, 20, 181, '<label>'.$email.'</label>');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->writeHTMLCell(100, 0, 117, 154, '<label>'.$stud_no.'</label>');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(56, 0, 117, 162, '<label>'.$fname.' '.$mname.' '.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 117, 173, '<label>'.$contact_no.'</label>');
$pdf->writeHTMLCell(56, 0, 117, 181, '<label>'.$email.'</label>');
// end of 3rd column

// print 4th column
$pdf->SetFont('helvetica', 'B', 12);
$pdf->writeHTMLCell(100, 0, 20, 213, '<label>'.$stud_no.'</label>');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(56, 0, 20, 221, '<label>'.$fname.' '.$mname.' '.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 20, 232, '<label>'.$contact_no.'</label>');
$pdf->writeHTMLCell(56, 0, 20, 240, '<label>'.$email.'</label>');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->writeHTMLCell(100, 0, 117, 213, '<label>'.$stud_no.'</label>');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(56, 0, 117, 221, '<label>'.$fname.' '.$mname.' '.$lname.'</label>');
$pdf->writeHTMLCell(100, 0, 117, 232, '<label>'.$contact_no.'</label>');
$pdf->writeHTMLCell(56, 0, 117, 240, '<label>'.$email.'</label>');
// end of 4th column

// $pdf->writeHTMLCell(100, 0, 6, 23, '<img src="data:'.$stud_dp_type.';base64,'.$stud_dp.'" style="height:80px;width:78px;border:1px solid #021a40;"/>');
$pdf->SetY(30);
// -----------------------------------------------------------------------------
$pdf->SetFont('helvetica', '', 12);
// $pdf->write1DBarcode('10000131632', 'C128', '45', '58', '', 10, 0.45, '', 'N');
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// create some HTML content
$html = '<div>

    </div>';

$pdf->writeHTML($html, true, false, true, false, '');
//Close and output PDF document

$pdf->Output($File_name.'.pdf', 'D');
$pdf->IncludeJS($js);


//============================================================+
// END OF FILE
//============================================================+
