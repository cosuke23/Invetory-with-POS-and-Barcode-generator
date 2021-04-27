<?php
// Assign the connection to the contant variable..
DEFINE('DB_HOST','127.0.0.1');
DEFINE('DB_USER','root');
DEFINE('DB_PASS','');
DEFINE('DB_BASE','e2e_ojtassisti');
// Create a variable to connect to the SQL..
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_BASE);

date_default_timezone_set('Asia/Manila');

if (!$dbc) {
	print '<h1>There was an error in your code .</h1>';
}

if(isset($_GET['weekly_date']) && isset($_GET['stud_no']) && isset($_GET['semester']) && isset($_GET['acad_year_start']) && isset($_GET['week_num'])) {
  
   //7 days ago
  $weekly_date=$_GET['weekly_date'];
  $stud_no=$_GET['stud_no'];
  $semester=$_GET['semester'];
  $acad_year_start=$_GET['acad_year_start'];
  $week_num=$_GET['week_num'];
  
$timestring=  $weekly_date;
$datetime=new DateTime($timestring);
$datetime->modify('-6 day');
$date_2 = $datetime->format("Y-m-d");
}

//
$query_stud_info_NaCn = "SELECT a.lname,a.fname,a.mname,c.comp_name,d.category_description,d.category_id FROM student_info AS a INNER JOIN company_ojt_student AS b INNER JOIN company_info AS c INNER JOIN program_category_list AS d INNER JOIN student_ojt_records AS e WHERE d.category_id = e.category_id AND e.stud_no = a.stud_no AND e.stud_no = b.stud_no AND a.stud_no = b.stud_no AND e.acad_year_start = b.acad_year_start AND e.semester = b.semester AND b.comp_id = c.comp_id AND b.stud_no = '$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester'";

$result_stud_info_journal =  mysqli_query($dbc, $query_stud_info_NaCn);         
if($result_stud_info_journal->num_rows > 0 )
  {   
	while ($row_NaCn = mysqli_fetch_array($result_stud_info_journal))
	{
	  $stud__lname_row_NaCn = $row_NaCn[0];
	  $stud__fname_row_NaCn = $row_NaCn[1];
	  $stud__mname_row_NaCn = $row_NaCn[2];
	  $stud__comp_row_NaCn = $row_NaCn[3];
	  $stud__category_desc_row_NaCn = $row_NaCn[4];
	  $category_id = $row_NaCn[5];
   }
 }
	$NAME_OF_FILE =  $stud__fname_row_NaCn." ".$stud__mname_row_NaCn." ".$stud__lname_row_NaCn." - Week No.:".$week_num;	 
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Steven N. Lim');
$pdf->SetTitle($NAME_OF_FILE);
$pdf->SetSubject('My Weekly Journal');


// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, PDF_MARGIN_TOP, 5);

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
$pdf->SetFont('helvetica', '', 12);


$pdf->AddPage('L', 'A4');
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

//weekly_journal_query
$query_journal_info = "SELECT a.journal_entry FROM journal AS a INNER JOIN student_ojt_records AS b WHERE a.stud_no = b.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND b.ojt_status = 'Ongoing' AND a.date_submitted = '$weekly_date' AND a.type = 'Weekly' AND a.stud_no = '$stud_no' AND b.stud_no = '$stud_no'";

	   $result_journal_info = mysqli_query($dbc, $query_journal_info);
	  $num_rows = mysqli_num_rows($result_journal_info);
	   
		  if($result_journal_info->num_rows > 0 )
			{   
			  while ($row = mysqli_fetch_array($result_journal_info))
			  {
			  $journal_entry_weekly = $row[0];
		   }
		 }
//query for remaining dtr
$query_remaining_dtr = "SELECT SUM(input_minutes) AS total_dtr FROM dtr WHERE stud_no = '$stud_no' AND acad_year_start = '$acad_year_start' AND semester = '$semester' AND date_submitted <= '$weekly_date'";
$result_remaining_dtr = mysqli_query($dbc, $query_remaining_dtr);
if($result_remaining_dtr->num_rows > 0 )
		{   
		  while ($row_R = mysqli_fetch_array($result_remaining_dtr))
		  {
		  $total_R_DTR = $row_R[0];
		  }
		}


//total DTR of program
$query_TDTR = "SELECT ojt_hours FROM program_category_list WHERE category_id = '$category_id'";

	   $result_TDTR = mysqli_query($dbc, $query_TDTR);
		  if($result_TDTR->num_rows > 0 )
			{   
			  while ($row_TDTR = mysqli_fetch_array($result_TDTR))
			  {
			  $TDTR = $row_TDTR[0];
			  $TOTAL_TDTR_min  = $TDTR *60;
		   }
		 }
//final display of TOTAL REMAINING DTR
$F_RDTR = $TOTAL_TDTR_min - $total_R_DTR;
$F_RDTR_hr = intval($F_RDTR/60);
$F_RDTR_min = intval($F_RDTR%60);
if($F_RDTR==0){
	$FF_RDTR = "- - -";
}elseif($F_RDTR_min==0){
	$FF_RDTR = $F_RDTR_hr. "hr(s)";
}
	else{
	$FF_RDTR = $F_RDTR_hr. " hour(s)"." and ".$F_RDTR_min. " minute(s)";
}
//query for total dtr
$query_total_dtr = "SELECT SUM(input_minutes) AS total_dtr FROM dtr WHERE stud_no = '$stud_no' AND acad_year_start = '$acad_year_start' AND semester = '$semester' AND date_submitted <= '$weekly_date'";
$result_total_dtr = mysqli_query($dbc, $query_total_dtr);
if($result_total_dtr->num_rows > 0 )
		{   
		  while ($row_TR = mysqli_fetch_array($result_total_dtr))
		  {
		  $total_W_DTR = $row_TR[0];	
		  }
		}
//final displaying of TOTAL WORKING OF HOURS
$I_total_W_DTR = intval($total_W_DTR /60);
$I_total_W_DTR_min = intval($total_W_DTR %60);
if($total_W_DTR==$TOTAL_TDTR_min){
	$F_W_total_DTR = "Completed";
	$ta_DTR = "center";
}elseif($I_total_W_DTR_min==0){
	$F_W_total_DTR = $I_total_W_DTR . " Hour(s)";
	$ta_DTR = "left";
}else{
	$F_W_total_DTR = $I_total_W_DTR . " Hour(s)". " and ".$I_total_W_DTR_min ." Minutes";
	$ta_DTR = "left";
}

//journal_mon_query
$query_journal_info = "SELECT a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,SUM(b.input_minutes) AS input_minutes,DATE_FORMAT(a.date_submitted, '%b/%d/%Y') AS date_submitted_2 FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Mon' AND a.type ='Daily'";

$result_journal_info = mysqli_query($dbc, $query_journal_info);
$num_rows = mysqli_num_rows($result_journal_info);

	  if($result_journal_info->num_rows > 0 )
		{   
		  while ($row = mysqli_fetch_array($result_journal_info))
		  {
		  $journal_entry = $row[0];
		  $date_day = $row[1];
		  $date_submitted_from_tbl = $row[2];
		  $skills_and_knowledge_used = $row[3];
		  $type = $row[4];
		  $input_hours1 = $row[5];
		  $date_submitted_2 = $row[6];

		  if($date_day =="Mon" && $type="Daily")
		  {	
			 $M = "Mon";
			 $M_date_submitted_from_tbl = $date_submitted_2 ;
			 $M_journal_entry = $journal_entry;
			 $M_input_hours1 =  intval($input_hours1/60);
			 $M_input_hours_min1 =  intval($input_hours1%60);
			 $M_skills_and_knowledge_used = $skills_and_knowledge_used;
			 $M_journal_entry_weekly = $journal_entry_weekly;
			 $fs_M = 10;
			 $ta_M = "justify";
			 $fs_WH_M = 12;
		  }	
		  else{
		 $M = "Mon";
		 $M_date_submitted_from_tbl = "- - -";
		 $M_journal_entry = "- - -";
		 $M_input_hours1 = "- - -";
		 $M_input_hours_min1 =  0;		 
		 $M_skills_and_knowledge_used = "- - -";
		 $M_journal_entry_weekly = $journal_entry_weekly;
		 $input_hours1 = 0;
		 $fs_M = 17;
		 $ta_M = "center";
		 $fs_WH_M = 17;
		}	
	   }
	 }
	
//journal_tues_query
$query_journal_info = "SELECT a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,SUM(b.input_minutes) AS input_minutes,DATE_FORMAT(a.date_submitted, '%b/%d/%Y') AS date_submitted_2 FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date'AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Tue' AND a.type ='Daily'";

$result_journal_info = mysqli_query($dbc, $query_journal_info);
$num_rows = mysqli_num_rows($result_journal_info);

	  if($result_journal_info->num_rows > 0 )
		{   
		  while ($row = mysqli_fetch_array($result_journal_info))
		  {
		  $journal_entry = $row[0];
		  $date_day = $row[1];
		  $date_submitted_from_tbl = $row[2];
		  $skills_and_knowledge_used = $row[3];
		  $type = $row[4];
		  $input_hours2 = $row[5];
		  $date_submitted_2 = $row[6];
		  if($date_day =="Tue" && $type="Daily")
		  {	
			 $T = "Tue";
			 $T_date_submitted_from_tbl = $date_submitted_2 ;
			 $T_journal_entry = $journal_entry;
			 $T_input_hours2 =  intval($input_hours2/60);
			 $T_input_hours_min2 =  intval($input_hours2%60);
			 $T_skills_and_knowledge_used = $skills_and_knowledge_used;
			 $fs_T = 10;
			 $ta_T = "justify";
			 $fs_WH_T = 12;
		  }	
		  else{
		 $T = "Tue";
		 $T_date_submitted_from_tbl = "- - -";
		 $T_journal_entry = "- - -";
		 $T_input_hours2 = "- - -";
		 $T_input_hours_min2 = 0;
		 $T_skills_and_knowledge_used = "- - -";
		 $input_hours2 = 0;
		 $fs_T = 17;
		 $ta_T = "center";
		 $fs_WH_T = 17;
		}	
	   }
	 }
	
//journal_wed_query
$query_journal_info = "SELECT a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,SUM(b.input_minutes) AS input_minutes,DATE_FORMAT(a.date_submitted, '%b/%d/%Y') AS date_submitted_2 FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Wed' AND a.type ='Daily'";

$result_journal_info = mysqli_query($dbc, $query_journal_info);
$num_rows = mysqli_num_rows($result_journal_info);

	  if($result_journal_info->num_rows > 0 )
		{   
		  while ($row = mysqli_fetch_array($result_journal_info))
		  {
		  $journal_entry = $row[0];
		  $date_day = $row[1];
		  $date_submitted_from_tbl = $row[2];
		  $skills_and_knowledge_used = $row[3];
		  $type = $row[4];
		  $input_hours3 = $row[5];
		  $date_submitted_2 = $row[6];

		  if($date_day =="Wed" && $type="Daily")
		  {	
			 $W = "Wed";
			 $W_date_submitted_from_tbl = $date_submitted_2 ;
			 $W_journal_entry = $journal_entry;
			 $W_input_hours3 =  intval($input_hours3/60);
			 $W_input_hours_min3 =  intval($input_hours3%60);
			 $W_skills_and_knowledge_used = $skills_and_knowledge_used;
			 $fs_W = 10;
			 $ta_W = "justify";
			 $fs_WH_W = 12;
		  }	
		  else{
		 $W = "Wed";
		 $W_date_submitted_from_tbl = "- - -";
		 $W_journal_entry = "- - -";
		 $W_input_hours3 = "- - -";
		 $W_input_hours_min3 = 0;
		 $W_skills_and_knowledge_used = "- - -";
		 $input_hours3 = 0;
		 $fs_W = 17;
		 $ta_W = "center";
		  $fs_WH_W = 17;
		}	
	   }
	 }
	
//journal_Thu_query
$query_journal_info = "SELECT a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,SUM(b.input_minutes) AS input_minutes,DATE_FORMAT(a.date_submitted, '%b/%d/%Y') AS date_submitted_2 FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Thu' AND a.type ='Daily'";

$result_journal_info = mysqli_query($dbc, $query_journal_info);
$num_rows = mysqli_num_rows($result_journal_info);

	  if($result_journal_info->num_rows > 0 )
		{   
		  while ($row = mysqli_fetch_array($result_journal_info))
		  {
		  $journal_entry = $row[0];
		  $date_day = $row[1];
		  $date_submitted_from_tbl = $row[2];
		  $skills_and_knowledge_used = $row[3];
		  $type = $row[4];
		  $input_hours4 = $row[5];
		  $date_submitted_2 = $row[6];
	if($date_day =="Thu" && $type="Daily")
		  {	
			 $th = "Thu";
			 $th_date_submitted_from_tbl = $date_submitted_2 ;
			 $th_journal_entry = $journal_entry;
			 $th_input_hours4 =  intval($input_hours4/60);
			 $th_input_hours_min4 =  intval($input_hours4%60);
			 $th_skills_and_knowledge_used = $skills_and_knowledge_used;
			 $fs_th = 10;
			 $ta_th = "justify";
			 $fs_WH_th = 12;
		  }
		  else{
		 $th = "Thu";
		 $th_date_submitted_from_tbl = "- - -";
		 $th_journal_entry = "- - -";
		 $th_input_hours4 = "- - -";
		 $th_input_hours_min4 = 0;
		 $th_skills_and_knowledge_used = "- - -";
		 $input_hours4 = 0;
		 $fs_th = 17;
		 $ta_th = "center";
		 $fs_WH_th = 17;
		}		
	   }
	 }
	
		  
//journal_Fri_query
$query_journal_info = "SELECT a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,SUM(b.input_minutes) AS input_minutes,DATE_FORMAT(a.date_submitted, '%b/%d/%Y') AS date_submitted_2 FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Fri' AND a.type ='Daily'";

$result_journal_info = mysqli_query($dbc, $query_journal_info);
$num_rows = mysqli_num_rows($result_journal_info);

	  if($result_journal_info->num_rows > 0 )
		{   
		  while ($row = mysqli_fetch_array($result_journal_info))
		  {
		  $journal_entry = $row[0];
		  $date_day = $row[1];
		  $date_submitted_from_tbl = $row[2];
		  $skills_and_knowledge_used = $row[3];
		  $type = $row[4];
		  $input_hours5 = $row[5];
		  $date_submitted_2 = $row[6];

		 if($date_day =="Fri" && $type="Daily")
		  {	
			 $F = "Fri";
			 $F_date_submitted_from_tbl = $date_submitted_2 ;
			 $F_journal_entry = $journal_entry;
			 $F_input_hours5 =  intval($input_hours5/60);
			 $F_input_hours_min5 =  intval($input_hours5%60);
			 $F_skills_and_knowledge_used = $skills_and_knowledge_used;
			 $fs_F = 10;
			 $ta_F = "justify";
			 $fs_WH_F = 12;
		  }	
		  else{
		 $F = "Fri";
		 $F_date_submitted_from_tbl = "- - -";
		 $F_journal_entry = "- - -";
		 $F_input_hours5 = "- - -";
		 $F_input_hours_min5 = 0;
		 $F_skills_and_knowledge_used = "- - -";
		 $input_hours5 = 0;
		 $fs_F = 17;
		 $ta_F = "center";
		 $fs_WH_F = 17;
		}	
	   }
	 }
	
//journal_Sat_query
$query_journal_info = "SELECT a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,SUM(b.input_minutes) AS input_minutes,DATE_FORMAT(a.date_submitted, '%b/%d/%Y') AS date_submitted_2 FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date' AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Sat' AND a.type ='Daily'";
$result_journal_info = mysqli_query($dbc, $query_journal_info);
$num_rows = mysqli_num_rows($result_journal_info);

	  if($result_journal_info->num_rows > 0 )
		{   
		  while ($row = mysqli_fetch_array($result_journal_info))
		  {
		  $journal_entry = $row[0];
		  $date_day = $row[1];
		  $date_submitted_from_tbl = $row[2];
		  $skills_and_knowledge_used = $row[3];
		  $type = $row[4];
		  $input_hours6 = $row[5];
		  $date_submitted_2 = $row[6];

		  if($date_day =="Sat" && $type="Daily")
		  {	
			 $Sa = "Sat";
			 $Sa_date_submitted_from_tbl = $date_submitted_2 ;
			 $Sa_journal_entry = $journal_entry;
			 $Sa_input_hours6 =  intval($input_hours6/60);
			 $Sa_input_hours_min6 =  intval($input_hours6%60);
			 $Sa_skills_and_knowledge_used = $skills_and_knowledge_used;
			 $fs_Sa = 10;
			 $ta_Sa = "justify";
			 $fs_WH_Sa = 12;
		  }	
			  else{
			 $Sa = "Sat";
			 $Sa_date_submitted_from_tbl = "- - -";
			 $Sa_journal_entry = "- - -";
			 $Sa_input_hours6 = "- - -";
			 $Sa_input_hours_min6 = 0;
			 $Sa_skills_and_knowledge_used = "- - -";
			 $input_hours6 = 0;
			 $fs_Sa = 17;
			 $ta_Sa = "center";
			 $fs_WH_Sa = 17;
			}	
	   }
	 }
	
//journal_Sun_query
$query_journal_info = "SELECT a.journal_entry,DATE_FORMAT(a.date_submitted, '%a') AS date_day,a.date_submitted,a.skills_and_knowledge_used,a.type,b.input_minutes,DATE_FORMAT(a.date_submitted, '%b/%d/%Y') AS date_submitted_2 FROM journal AS a INNER JOIN dtr AS b WHERE a.date_submitted >= '$date_2' AND  a.date_submitted <= '$weekly_date'  AND a.date_submitted = b.date_submitted AND b.stud_no = a.stud_no AND a.acad_year_start = b.acad_year_start AND a.semester = b.semester AND a.stud_no='$stud_no' AND b.acad_year_start = '$acad_year_start' AND b.semester = '$semester' AND a.day = 'Sun' AND a.type ='Daily'";
$result_journal_info = mysqli_query($dbc, $query_journal_info);
$num_rows = mysqli_num_rows($result_journal_info);

	  if($result_journal_info->num_rows > 0 )
		{   
		  while ($row = mysqli_fetch_array($result_journal_info))
		  {
		  $journal_entry = $row[0];
		  $date_day = $row[1];
		  $date_submitted_from_tbl = $row[2];
		  $skills_and_knowledge_used = $row[3];
		  $type = $row[4];
		  $input_hours7 = $row[5];
		  $date_submitted_2 = $row[6];

		  if($date_day =="Sun" && $type="Daily")
		  {	
			 $Su = "Sun";
			 $Su_date_submitted_from_tbl = $date_submitted_from_tbl ;
			 $Su_journal_entry = $journal_entry;
			 $Su_input_hours7 =  intval($input_hours7/60);
			 $Su_input_hours_min7 =  intval($input_hours7%60);
			 $Su_skills_and_knowledge_used = $skills_and_knowledge_used;
			 $fs_Su = 10;
			 $ta_Su = "justify";
			 $fs_WH_Su = 12;
		  }		
	   }
	 }
	else{
		 $Su = "Sun";
		 $Su_date_submitted_from_tbl = "- - -";
		 $Su_journal_entry = "- - -";
		 $Su_input_hours7 = "- - -";
		 $Su_input_hours_min7 =  0;
		 $Su_skills_and_knowledge_used = "- - -";
		 $fs_Su = 17;
		 $ta_Su = "center";
		 $fs_WH_Su = 17;
		 
		 $input_hours7 = 0;	 
		}
		//monday to sunday Final hours and mins
		if($M_input_hours1=="- - -"){
			$M_input_hours1_F = 0;
		}elseif($M_input_hours1!="- - -"){
			$M_input_hours1_F = $M_input_hours1;
		}if($T_input_hours2=="- - -"){
			$T_input_hours2_F = 0;
		}elseif($T_input_hours2!="- - -"){
			$T_input_hours2_F = $T_input_hours2;
		}if($W_input_hours3=="- - -"){
			$W_input_hours3_F = 0;
		}elseif($W_input_hours3!="- - -"){
			$W_input_hours3_F = $W_input_hours3;
		}if($th_input_hours4=="- - -"){
			$th_input_hours4_F = 0;
		}elseif($th_input_hours4!="- - -"){
			$th_input_hours4_F = $th_input_hours4;
		}if($F_input_hours5=="- - -"){
			$F_input_hours5_F = 0;
		}elseif($F_input_hours5!="- - -"){
			$F_input_hours5_F = $F_input_hours5;
		}if($Sa_input_hours6=="- - -"){
			$Sa_input_hours6_F = 0;
		}elseif($Sa_input_hours6!="- - -"){
			$Sa_input_hours6_F = $Sa_input_hours6;
		}if($Su_input_hours7=="- - -"){
			$Su_input_hours7_F = 0;
		}elseif($Su_input_hours7!="- - -"){
			$Su_input_hours7_F = $Su_input_hours7;
		}
		//final display of dtr
		if($M_input_hours1=="- - -"){
			$M_dtr_F1 = $M_input_hours1; 
		} 
		elseif($M_input_hours_min1!=0){
			$M_dtr_F1 = $M_input_hours1." hr(s) and ".$M_input_hours_min1." Min(s)"; 
		}else{
			$M_dtr_F1 = $M_input_hours1. " hr(s)";
		}
		if($T_input_hours2=="- - -"){
			$T_dtr_F2 = $T_input_hours2; 
		} 
		elseif($T_input_hours_min2!=0){
			$T_dtr_F2 = $T_input_hours2." hr(s) and ".$T_input_hours_min2." Min(s)"; 
		}else{
			$T_dtr_F2 = $T_input_hours2. " hr(s)";
		}
		if($W_input_hours3=="- - -"){
			$W_dtr_F3 = $W_input_hours3; 
		}elseif($W_input_hours_min3!=0){
			$W_dtr_F3 = $W_input_hours3." hr(s) and ".$W_input_hours_min3." Min(s)"; 
		}else{
			$W_dtr_F3 = $W_input_hours3. " hr(s)";
		}
		if($th_input_hours4=="- - -"){
			$th_dtr_F4 = $th_input_hours4; 
		}elseif($th_input_hours_min4!=0){
			$th_dtr_F4 = $th_input_hours4." hr(s) and ".$th_input_hours_min4." Min(s)"; 
		}else{
			$th_dtr_F4 = $th_input_hours4. " hr(s)";
		}
		if($F_input_hours5=="- - -"){
			$F_dtr_F5 = $F_input_hours5; 
		} 
		elseif($F_input_hours_min5!=0){
			$F_dtr_F5 = $F_input_hours5." hr(s) and ".$F_input_hours_min5." Min(s)"; 
		}else{
			$F_dtr_F5 = $F_input_hours5. " hr(s)";
		}
		if($Sa_input_hours6=="- - -"){
			$Sa_dtr_F6 = $Sa_input_hours6; 
		}elseif($Sa_input_hours_min6!=0){
			$Sa_dtr_F6 = $Sa_input_hours6." hr(s) and ".$Sa_input_hours_min6." Min(s)"; 
		}else{
			$Sa_dtr_F6 = $Sa_input_hours6. " hr(s)";
		}
		if($Su_input_hours7=="- - -"){
			$Su_dtr_F7 = $Su_input_hours7; 
		}elseif($Su_input_hours_min7!=0){
			$Su_dtr_F7 = $Su_input_hours7." hr(s) and ".$Su_input_hours_min7." Min(s)"; 
		}else{
			$Su_dtr_F7 = $Su_input_hours7. " hr(s)";
		}
		
		//final total dtr
$total_input_of_hours = $input_hours7 + $input_hours6 + $input_hours5 +  $input_hours4
						+ $input_hours3 + $input_hours2 + $input_hours1;
						
			$final_dtr_H = intval($total_input_of_hours/60);
			$final_dtr_M = intval($total_input_of_hours%60);
			//Final display of total DTR
			if($final_dtr_M==0){	
				$FF_dtr = $final_dtr_H. " Hour(s)";
			}else{
				$FF_dtr = $final_dtr_H. " Hour(s) and ". $final_dtr_M. " Minute(s)";
			}
// create some HTML content
$html = '<img src="images/stilogi_wj.png" alt="STI LOGO" border="0" /><br>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<table border="0" cellpadding="2">
			<tr>
				<td><label style="font-size:14px;"><b>Name of the Student Trainee: </b>'.$stud__lname_row_NaCn.', '.$stud__fname_row_NaCn.' '.$stud__mname_row_NaCn.'</label></td>
				<td><label style="font-size:14px;"><b>Name of Company:</b> '.$stud__comp_row_NaCn.'</label></td>
			</tr>
			<tr>
				<td><label style="font-size:14px;"><b>Program Category:</b> '.$stud__category_desc_row_NaCn.'</label></td>
				<td><label style="font-size:14px;"><b>Week No:</b>&nbsp;'.$week_num.'</label></td>
			</tr>
			<tr>
				<td colspan="2"><label style="text-align:center;"><b>ON THE JOB TRAINING / PRACTICUM JOURNAL</b></label></td>
			</tr>
		</table>	  
		<br>
		<div style="height:100px; overflow:auto;">
		<table border="1" cellpadding="4">
		<tr style="background-color:#a3a375;">
		<th style="width:5%;text-align:center;">DAY</th>
		<th style="width:10%;text-align:center;">DATE</th>
		<th style="width:35%;text-align:center;">NATURE OF ACTIVITY</th>
		<th style="font-size:10px;width:7%;text-align:center;">NO. OF <br>WORKING HOURS</th>
		<th style="width:23%;text-align:center;font-size:12px;">SKILLS AND <br> KNOWLEDGE USED</th>
		<th style="width:20%;font-size:9px;text-align:center;">EVALUATION OF WEEK`S EXPERIENCES THAT WERE BENEFICIAL TO YOUR PRE-PROFESSIONAL DEVELOPMENT</th>
	</tr>
	<tr>
		<td style="height:40px;">'.$M.'</td>
		<td style="text-align:'.$ta_Su.';">'.$M_date_submitted_from_tbl.'</td>
		<td style="font-size:'.$fs_M.'px;text-align:'.$ta_M.';">'.$M_journal_entry.'</td>
		<td style="text-align:center;font-size:'.$fs_WH_M.'px;">'.$M_dtr_F1.'</td>
		<td style="font-size:'.$fs_M.'px;text-align:'.$ta_M.';">'.$M_skills_and_knowledge_used.'</td>
		<td rowspan="15" style="font-size:12px;text-align:justify;">'.$M_journal_entry_weekly.'</td>
	</tr>
	<tr>
		<td style="height:40px;">'.$T.'</td>
		<td style="text-align:'.$ta_Su.';">'.$T_date_submitted_from_tbl.'</td>
		<td style="font-size:'.$fs_T.'px;text-align:'.$ta_T.';">'.$T_journal_entry.'</td>
		<td style="text-align:center;font-size:'.$fs_WH_T.'px;">'.$T_dtr_F2.'</td>
		<td style="font-size:'.$fs_T.'px;text-align:'.$ta_T.';">'.$T_skills_and_knowledge_used.'</td>
		<td style="font-size:10px;"></td>
	</tr>
	<tr>
		<td style="height:40px;">'.$W.'</td>
		<td style="text-align:'.$ta_Su.';">'.$W_date_submitted_from_tbl.'</td>
		<td style="font-size:'.$fs_W.'px;text-align:'.$ta_W.';">'.$W_journal_entry.'</td>
		<td style="text-align:center;font-size:'.$fs_WH_W.'px;">'.$W_dtr_F3.'</td>
		<td style="font-size:'.$fs_W.'px;text-align:'.$ta_W.';">'.$W_skills_and_knowledge_used.'</td>
		<td style="font-size:10px;"></td>
	</tr>
	<tr>
		<td style="height:40px;">'.$th.'</td>
		<td style="text-align:'.$ta_Su.';">'.$th_date_submitted_from_tbl.'</td>
		<td style="font-size:'.$fs_th.'px;text-align:'.$ta_th.';">'.$th_journal_entry.'</td>
		<td style="text-align:center;font-size:'.$fs_WH_th.'px;">'.$th_dtr_F4.'</td>
		<td style="font-size:'.$fs_th.'px;text-align:'.$ta_th.';">'.$th_skills_and_knowledge_used.'</td>
		<td style="font-size:10px;"></td>
	</tr>
	<tr >
		<td style="height:40px;">'.$F.'</td>
		<td style="text-align:'.$ta_Su.';">'.$F_date_submitted_from_tbl.'</td>
		<td style="font-size:'.$fs_F.'px;text-align:'.$ta_F.';">'.$F_journal_entry.'</td>
		<td style="text-align:center;font-size:'.$fs_WH_F.'px;">'.$F_dtr_F5.'</td>
		<td style="font-size:'.$fs_F.'px;text-align:'.$ta_F.';">'.$F_skills_and_knowledge_used.'</td>
		<td style="font-size:10px;"></td>
	</tr>
	<tr>
		<td style="height:40px;">'.$Sa.'</td>
		<td style="text-align:'.$ta_Su.';">'.$Sa_date_submitted_from_tbl.'</td>
		<td style="font-size:'.$fs_Sa.'px;text-align:'.$ta_Sa.';">'.$Sa_journal_entry.'</td>
		<td style="text-align:center;font-size:'.$fs_WH_Sa.'px;">'.$Sa_dtr_F6.'</td>
		<td style="font-size:'.$fs_Sa.'px;text-align:'.$ta_Sa.';">'.$Sa_skills_and_knowledge_used.'</td>
		<td style="font-size:10px;"></td>
	</tr>
	<tr>
		<td style="height:40px;">'.$Su.'</td>
		<td style="text-align:'.$ta_Su.';">'.$Su_date_submitted_from_tbl.'</td>
		<td style="font-size:'.$fs_Su.'px;text-align:'.$ta_Su.';">'.$Su_journal_entry.'</td>
		<td style="text-align:center;font-size:'.$fs_WH_Su.'px;">'.$Su_dtr_F7.'</td>
		<td style="font-size:'.$fs_Su.'px;text-align:'.$ta_Su.';">'.$Su_skills_and_knowledge_used.'</td>
		<td style="font-size:10px;"></td>
	</tr>
</table></div>
<table border="0" cellpadding="6">
	<tr>
		<td style="font-size:12px"><b>Remaining No. of Working Hour(s):</b></td>
		<td style="font-size:12px"><b>Total No. of Working Hour(s)</b></td>
		<td style="font-size:12px"><b>Total No. of Working Hour(s) for week '.$week_num.'</b></td>		
		<td style="text-align:left;font-size:13px;"><b>Certified By:</b></td>
	</tr>
	<tr>
		<td style="text-align:'.$ta_DTR.'px;">'.$FF_RDTR.'</td>
		<td>'.$F_W_total_DTR.'</td>
		<td>'.$FF_dtr.'</td>
		<td><b>_____________________________</b></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td><b style="text-align:center;">OJT SUPERVISOR</b></td>
	</tr>
</table>
';
// --- test backward editing ---


$pdf->setPage(1, true);
$pdf->SetY(1,true);


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($NAME_OF_FILE.'.pdf', 'I');
$pdf->IncludeJS($js);

//============================================================+
// END OF FILE
//============================================================+
?>