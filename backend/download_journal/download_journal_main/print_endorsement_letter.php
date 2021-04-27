<?php

DEFINE('DB_HOST','127.0.0.1');
DEFINE('DB_USER','root');
DEFINE('DB_PASS','');
DEFINE('DB_BASE','e2e_ojtassisti');


//DEFINE('DB_HOST','127.0.0.1');
//DEFINE('DB_USER','root');
//DEFINE('DB_PASS','');
//DEFINE('DB_BASE','ojtassisti');

$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_BASE);
date_default_timezone_set('Asia/Manila');
$date_today = date("F d, Y");
if (!$dbc) {
	print '<h1>There was an error in your code .</h1>';
}
if(isset($_POST['btn_print'])){
	//adviser info
	$adviser_id = $_POST['adviser_id'];
	$query2 = "SELECT * from adviser_info WHERE adviser_id = '$adviser_id'";
	$result2 = mysqli_query($dbc,$query2);
		if(mysqli_num_rows($result2)>0)
		{
			$row2 = mysqli_fetch_assoc($result2);
			$fname2 = $row2["fname"];
			$lname2 =  $row2["lname"];
			$contact_no = $row2["mobile_no"];
			$email = $row2["email"];
			$program_id = $row2["program_id"];
			//get program code
				$q_program_code = "select program_code from program_list where program_id ='$program_id'";
				$q_program_code_res = mysqli_query($dbc,$q_program_code);
				$get_program_code = mysqli_fetch_assoc($q_program_code_res);
				$program_code = $get_program_code['program_code'];
		}
		
	
	//get info for endorsement
		$cmp_representative = $_POST['cmp_representative'];
		$cmp_rep_position = $_POST['cmp_rep_position'];
		$cmp_name = $_POST['cmp_name'];
		$cmp_address = $_POST['cmp_address'];
		$stud_name = $_POST['stud_name'];
		$ojt_hours = $_POST['ojt_hours'];
		$program_head=$_POST['program_head'];
		$program_head_position = $_POST['program_head_position'];
}

require_once('tcpdf_include.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('STEVEN N.LIM');
$pdf->SetTitle('ENDORSEMENT LETTER');
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, PDF_MARGIN_TOP, 100);

// set auto page breaks
$pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
// set font
$pdf->SetFont('Helvetica', 10, 11);
$pdf->AddPage('P', 'A4');
// create some HTML content
$pdf->writeHTMLCell(100, 0, 10, 47, '<label>'.$date_today.'</label>');
$pdf->writeHTMLCell(100, 0, 10, 61, '<b><label>'.$cmp_representative.'</label></b>');
$pdf->writeHTMLCell(100, 0, 10, 66, '<label>'.$cmp_rep_position.'</label>');
$pdf->writeHTMLCell(100, 0, 10, 71, '<label>'.$cmp_name.'</label>');
$pdf->writeHTMLCell(65, 0, 10, 76, '<label>'.$cmp_address.'<label>');

$pdf->writeHTMLCell(100, 0, 10, 95, '<label>Dear '.$cmp_representative.',</label>');
$pdf->writeHTMLCell(185, 0, 10, 105, '<p style="text-align:justify;">STI, in its dedication to further enhance the development of our students, requires them to undergo the
On-the-Job Training (OJT) Program. This program aims to help our students develop competency in their
chosen field by arming them with the basic experience, knowledge, attitude essential to aid their
transition from being a student to being part of the workforce.</p>');

$pdf->writeHTMLCell(185, 0, 10, 130, '<p style="text-align:justify;">With this, we request your good office to be our partner in achieving this goal by agreeing to be the Host
Company for <span style="text-decoration:underline"><b>'.$stud_name.'</b></span>, <span style="text-decoration:underline"><b>'.$program_code.'</b></span> student, for a total of <span style="text-decoration:underline"><b>'.$ojt_hours.'</b></span>  hours.</p>');


$pdf->writeHTMLCell(185, 0, 10, 145, '<p style="text-align:justify;">We believe that the experiences and learnings he/she will receive from your office will greatly complement the knowledge, skills and attitude that he/she has acquired from our school.</p>');

$pdf->writeHTMLCell(200, 0, 10, 160, '<p>Should you have any questions, kindly contact me at <span><b>'.$contact_no.'</b></span> and/or</p>');


$pdf->writeHTMLCell(200, 0, 10, 165, '<p><b>'.$email.'</p>');

$pdf->writeHTMLCell(100, 0, 10, 180, '<label>Thank you.</label>');

$pdf->writeHTMLCell(100, 0, 10, 195, '<label>Respectfully yours,</label>');

$pdf->writeHTMLCell(100, 0, 10, 210, '<label>____________________________</label>');
$pdf->writeHTMLCell(100, 0, 10, 215, '<label>'.$fname2.' '.$lname2.'</label>');
$pdf->writeHTMLCell(100, 0, 10, 220, '<label>OJT Adviser</label>');

$pdf->writeHTMLCell(100, 0, 10, 235, '<label>Noted by:</label>');

$pdf->writeHTMLCell(100, 0, 10, 250, '<label>____________________________</label>');
$pdf->writeHTMLCell(100, 0, 10, 255, '<label>'.$program_head.'</label>');
$pdf->writeHTMLCell(100, 0, 10, 260, '<label>'.$program_head_position.'</label>');
$html = '<label></label>';
// --- test backward editing ---
$pdf->setPage(1, true);
$pdf->SetY(10);


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('endorsement_letter_'.$stud_name.'_'.$program_code.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
