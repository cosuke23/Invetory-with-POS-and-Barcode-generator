<?php
require 'connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$date_today =  date("m/d/Y");
$time_now = date("h:i A");
$username = $_COOKIE['username'];
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
ini_set('max_execution_time', 100000);
//php function codes
if(isset($_GET['event_id'])&&isset($_GET['event_name'])&&isset($_GET['event_start_date'])&&isset($_GET['event_img'])&&isset($_GET['stud_no'])){
	$event_id = $_GET['event_id'];
	$event_name = $_GET['event_name'];
  $event_start_date = date("jS \d\a\y \of\ F, Y", strtotime($_GET['event_start_date']));
	$event_img = $_GET['event_img'];
	$stud_no = $_GET['stud_no'];

	$table = "student_info";
  $columns = "*";
  $where = ["stud_no"=>$stud_no];
  $q_student = $database->select($table,$columns,$where);

  foreach ($q_student as $qstud_data) {
    $fullname = $qstud_data["fname"].'_'.$qstud_data["lname"];
  }

  $table2 = "event_manager";
  $columns2 = "*";
  $where2 = ["event_id"=>$event_id];
  $q_event = $database->select($table2,$columns2,$where2);

	$file_name = $event_name."_certificate_".$fullname;
}
require_once('tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('JULIUS, WILLISON, STEVEN');
$pdf->SetTitle($file_name);
$pdf->SetSubject('GENERATE_ID');
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
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// START OF BACKGROUND IMAGE
	$pdf->AddPage();
	$pdf->setPageMark();
	//$img_file = K_PATH_IMAGES.'certificate.jpg';
	$event_img_file = K_PATH_IMAGES.$event_img;
		$i = 0;
		$height = 10;
		$height_name = 32;
		$height_stud_no = 45;
		$height_program = 50;
		$height_barcode = 58;
		$height_img = 23.5;
		foreach($q_student AS $q_student_data){
      $full_name = $q_student_data["fname"].' '.$q_student_data["lname"];

      foreach($q_event AS $q_event_data){
        $term = "";
        $semester = $q_event_data["semester"];
        if($semester=='1st Semester'){
          $term = "1st Term";
        }
        elseif($semester=='2nd Semester') {
          $term = "2nd Term";
        }
        $acad_year_start_seminar = $q_event_data["acad_year_start_seminar"];
        $acad_year_end_seminar = $q_event_data["acad_year_end_seminar"];

  			if($i != 0) {
  				if($i % 1 == 0){
  				$pdf->AddPage();
  				$height = 10;
  				$height_name=32;
  				$height_stud_no=45;
  				$height_program=50;
  				$height_barcode=58;
  				$height_img = 23.5;
  				$pdf->SetAutoPageBreak(FALSE,PDF_MARGIN_BOTTOM);
  				}
  			}

  			$pdf->Image($event_img_file, 39, 134, 125, 50, '', '', '', true, 200, '', false, false, 0);
  			$pdf->SetFont('helvetica', 'B', 26);
  			$pdf->SetTopMargin(100);
  			$html = '<div style="text-align:center;">'.$full_name.'</div>';
  			$pdf->writeHTML($html, true, false, true, false, '');
  			$pdf->SetFont('helvetica', '', 13);
  			$pdf->writeHTMLCell(100, 0, 64, 195, '<label>Given this '.$event_start_date.'</label>');
  			$pdf->writeHTMLCell(0, 0, 34, 200, '<label>For '.$term.' Academic Year '.$acad_year_start_seminar.'-'.$acad_year_end_seminar.' at STI College Caloocan.</label>');

  	  	$height+=65;
  			$height_name+=65;
  			$height_stud_no+=65;
  			$height_program+=65;
  		  $height_barcode+=64;
  		  $height_img +=65;
  			$i++;
      }
		}


// get current vertical position

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output($file_name.'.pdf', 'I');
$pdf->IncludeJS($js);
//============================================================+
// END OF FILE
//============================================================+
