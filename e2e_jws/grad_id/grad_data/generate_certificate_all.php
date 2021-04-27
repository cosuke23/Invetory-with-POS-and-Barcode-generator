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
if(isset($_GET['event_id'])&&isset($_GET['event_name'])&&isset($_GET['event_img'])&&isset($_GET['program_id'])){
	$event_id = $_GET['event_id'];
	$event_name = $_GET['event_name'];
	$event_img = $_GET['event_img'];

	$program_id = $_GET['program_id'];
	$table = "program_list";
    $columns = "*";
   	$where = ["program_id"=>$program_id];
   	$q_program = $database->select($table,$columns,$where);

	foreach ($q_program AS $q_program_data) {
		$program_code = $q_program_data["program_code"];
	}

	// echo $event_id . "<br>";
	// echo $event_name . "<br>";
	 
	 $file_name = $event_name."_certificate_all_".$program_code;
	 $q_all = $database->query("select a.stud_no as 'Student No.',c.lname as 'Last Name',c.fname as 'First Name',d.program_code as 'Course',DATE_FORMAT(str_to_date(c.bday, '%m/%d/%Y'),'%M %d, %Y') as 'BDAY', from_unixtime(a.s1_timein, '%h:%i %AM') AS 'TIME-IN1',a.s1_status AS 'T1 STATUS', from_unixtime(b.s2_timein, '%h:%i %AM') AS 'TIME-IN2',b.s2_status AS 'T2 STATUS',b.date_attended AS 'EVENT DATE', b.acad_year_start AS 'YS', b.acad_year_end AS 'YE', b.semester AS 'SEM'
FROM
seminar_attended AS a
INNER JOIN seminar_attended_2 AS b ON a.stud_no = b.stud_no AND a.acad_year_start = b.acad_year_start AND a.acad_year_end = b.acad_year_end
INNER JOIN student_info AS c ON a.stud_no = c.stud_no
INNER JOIN program_list AS d ON c.program_id='".$program_id."' AND d.program_id = '".$program_id."'

where a.event_id='".$event_id."' and b.event_id='".$event_id."'

order by c.lname desc, c.fname")->fetchAll();

// print_r($q_all);	

	 if($q_all == ""){
	 	 header("location: /e2e_JWS/e2e_event_manager.php?error_id4=4");
	 }
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
	// $q_si = $database->query("SELECT * FROM student_info WHERE acad_year_start= '$acad_year_start' AND semester = '$semester' AND count_id = 0 AND stud_dp != 'DEFAULT.jpg' ORDER BY lname");
		$i = 0;
		$height = 10;
		$height_name = 32;
		$height_stud_no = 45;
		$height_program = 50;
		$height_barcode = 58;
		$height_img = 23.5;
		foreach($q_all AS $qData){
		
			$stud_no = $qData[0];
			$lname = ucwords(strtolower($qData["Last Name"]));
            $fname = ucwords(strtolower($qData["First Name"]));
            $semester = ucwords(strtolower($qData["SEM"]));
            $term = '';
            if($semester == '2nd Semester'){
            	$term = "2nd Term";
            }
            elseif($semester == '1st Semester'){
            	$term = "1st Term";
            }
            $event_date = date("jS \d\a\y \of\ F, Y", strtotime($qData["EVENT DATE"]));
            $ys = ucwords(strtolower($qData["YS"]));
            $ye = ucwords(strtolower($qData["YE"]));
			
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
			//$pdf->Image($img_file, 5, $height, 200, 265, '', '', '', true, 200, '', false, false, 0);
			$pdf->Image($event_img_file, 39, 134, 125, 50, '', '', '', true, 200, '', false, false, 0);
			$pdf->SetFont('helvetica', 'B', 26);			
			$pdf->SetTopMargin(100);
			$html = '<div style="text-align:center;">'.$fname.' '.$lname.'</div>';
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->SetFont('helvetica', '', 13);
			$pdf->writeHTMLCell(100, 0, 64, 195, '<label>Given this '.$event_date.'</label>');
			$pdf->writeHTMLCell(0, 0, 34, 200, '<label>For '.$term.' Academic Year '.$ys.'-'.$ye.' at STI College Caloocan.</label>');
							  	
	  		$height+=65;
			$height_name+=65;
			$height_stud_no+=65;
			$height_program+=65;
		    $height_barcode+=64; 
		    $height_img +=65;
			$i++;
		}
		

// get current vertical position

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output($file_name.'.pdf', 'I');
$pdf->IncludeJS($js);
//============================================================+
// END OF FILE
//============================================================+
