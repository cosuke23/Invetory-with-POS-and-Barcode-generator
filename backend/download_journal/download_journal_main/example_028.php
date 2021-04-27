<?php
// Assign the connection to the contant variable..
DEFINE('DB_HOST','127.0.0.1');
DEFINE('DB_USER','root');
DEFINE('DB_PASS','');
DEFINE('DB_BASE','ojtassisti');
// Create a variable to connect to the SQL..
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_BASE);


if (!$dbc) {
	print '<h1>There was an error in your code .</h1>';
}

if(isset($_GET['weekly_date']) && isset($_GET['stud_no']) && isset($_GET['semester']) && isset($_GET['acad_year_start'])) {
  
   //7 days ago
  $weekly_date=$_GET['weekly_date'];
    $stud_no=$_GET['stud_no'];
  $semester=$_GET['semester'];
  $acad_year_start=$_GET['acad_year_start'];
  
$timestring=  $weekly_date;
$datetime=new DateTime($timestring);
$datetime->modify('-6 day');
$date_2 = $datetime->format("Y-m-d");


require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 028');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, PDF_MARGIN_TOP, 10);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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
$pdf->SetFont('times', '', 10);


$pdf->AddPage('L', 'A4');
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<div>
		<img src="images/stilogi_wj.png" alt="STI LOGO" border="0" /><br>
		&nbsp;&nbsp;&nbsp;&nbsp; <label>Name of the Student Trainee:</label>
		</div>';
// --- test backward editing ---


$pdf->setPage(1, true);
$pdf->SetY(10);


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_028.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
