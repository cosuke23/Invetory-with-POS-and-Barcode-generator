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
if(isset($_POST['btn_gen_data_all'])){
	 $acad_year_start = $_POST['acad_year_start'];
	 $semester = $_POST['semester'];
	 $acad_year_end = $acad_year_start+1;
	 //count all student from sy and sem
	 $file_name = $semester." ".$acad_year_start."-".$acad_year_end;
	 $table_all = "student_info";
	 $columns_all = "*";
	 $where_all = ["AND"=>["acad_year_start"=>$acad_year_start,"semester"=>$semester,"count_id"=>0,"stud_dp[!]"=>"DEFAULT.jpg"]];
	 $q_all = $database->count($table_all,$columns_all,$where_all);

	 if($q_all == ""){
	 	 header("location: /e2e_JWS/e2e_grad_id.php?error_id4=4");
	 }
}
require_once('tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('STEVEN N. LIM');
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
	$img_file = K_PATH_IMAGES.'gradb2b.png'; 
	$q_si = $database->query("SELECT * FROM student_info WHERE acad_year_start= '$acad_year_start' AND semester = '$semester' AND count_id = 0 AND stud_dp != 'DEFAULT.jpg' ORDER BY lname");
		$i = 0;
		$height = 10;
		$height_name = 32;
		$height_stud_no = 45;
		$height_program = 50;
		$height_barcode = 58;
		$height_img = 23.5;
		foreach($q_si AS $qData){
		
			$stud_no = $qData['stud_no'];
			$lname = ucwords(strtolower($qData['lname']));
            $fname = ucwords(strtolower($qData['fname']));
            $mname = ucwords(strtolower($qData['mname']));
			$stud_dp = $qData['stud_dp'];
			$program_id = $qData['program_id'];
	        //$img_file2 = K_PATH_IMAGES.'DEFAULT.jpg';
			$table_program_code = "program_list";
			$column_pc = "*";
			$where_pc = ["program_id"=>$program_id];
			$q_pc = $database->select($table_program_code,$column_pc,$where_pc);
			foreach($q_pc AS $q_pc_data){
			$program_code = $q_pc_data['program_code'];
			
			if($i != 0) {
				if($i % 4 == 0){
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
			$pdf->Image($img_file, 5, $height, 200, 60, '', '', '', true, 200, '', false, false, 0);
			$pdf->writeHTMLCell(100, 0, 36, $height_name, '<label style="color:white;">'.$fname.' '.$mname.'<br>'.$lname.'</label>');
			$pdf->writeHTMLCell(100, 0, 35, $height_stud_no, '<label>'.$stud_no.'</label>');
			$pdf->writeHTMLCell(100, 0, 36, $height_program, '<label>'.$program_code.'</label>');
			//$pdf->Image($img_file2, 7.5, $height_img, 25, 27.5, '', '', '', true, 200, '', false, false, 0);
			$pdf->writeHTMLCell(100, 0, 6, $height_img, '<img src="student_image/'.$stud_dp.'" style="height:80px;width:78px;border:1px solid #021a40;"/>');
			$pdf->write1DBarcode($stud_no, 'C128', '45', $height_barcode, '', 10, 0.45, '', 'N');
			
			//update of stud ID coount
			$table_id = "student_info";
			$columns_id = ["count_id[+]"=>1];
			$where_id = ["stud_no"=>$stud_no];
			$q_update = $database->update($table_id,$columns_id,$where_id);

	  		}//end of foreach for program code
	  		$height+=65;
			$height_name+=65;
			$height_stud_no+=65;
			$height_program+=65;
		    $height_barcode+=64; 
		    $height_img +=65;
			$i++;
		}//end of foreach for student info

		$action = "|| SY : ".$acad_year_start." - ".$acad_year_end." || SEM : ".$semester;
			$tbl = "audit_trail";
			$columns = ["date_at"=>$date_today,"time"=>$time_now,"username"=>$username,"action"=>"Generate and print ID: ".$action."","module"=>"Batch Printing of Graduating ID Module"];
			$q_data = $database->insert($tbl,$columns);	
$html = '<div></div>';
$pdf->writeHTML($html, true, false, true, false, '');
// get current vertical position

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output($file_name.'.pdf', 'I');
$pdf->IncludeJS($js);
//============================================================+
// END OF FILE
//============================================================+
