<?php
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_GET['comp_id']) && isset($_GET['event_id']))
{
	$comp_id = $_GET['comp_id'];
	$event_id = $_GET['event_id'];
	
	//$limiter = "SELECT COUNT(*) as Countla FROM applicant_list_jf WHERE comp_id ='".$comp_id."' AND event_id='".$event_id."'";
	//$result2 = $database->query($limiter);
	//$row = $result2->fetch_row();
	//  
	$query = "	SELECT CONCAT(B.lname,' ',B.fname, ' ',B.mname) AS FullName , 
C.program_code AS Course,
B.stud_no AS StudNum,
D.file_name AS Resume
FROM applicant_list_jf AS A
JOIN student_info AS B
JOIN program_list AS C
JOIN resume_data AS D
WHERE  A.comp_id = ".$comp_id."
AND A.event_id = ".$event_id."
AND A.stud_no = B.stud_no
AND D.stud_no = B.stud_no
AND B.program_id = C.program_id
AND B.stud_no = D.stud_no GROUP BY A.stud_no ORDER BY B.lname";//..$row['Countla'];
				
				
/*AND B.acad_year_start = '2016'
AND B.acad_year_end = '2017'*/


	$result = $database->query($query)->fetchAll();
	
	$fordownload = " ";
    $forname = " ";
	
	$fordownload1 = array();
    $forname1 = array();
	$counter = 0;
	
	foreach($result AS $row){
        $fullname = $row["FullName"];
        $course = $row["Course"];
        $resume = $row['Resume'];
		$newfilename = $course . " - " . $fullname; 
   
		if($fordownload == " ")
		{
			$fordownload = "'".$resume."'";
			$forname = "'".$newfilename."'";
			
		}
		else
		{
			$fordownload = $fordownload . ", '".$resume."'"; 
			$forname = $forname . ", '".$newfilename."'"; 
		}
		
		
    }

	?>
		
	
		<script language="javascript" type="text/javascript">
		
			var files = [<?php echo $fordownload?>]; 
			var filesx = [<?php echo $forname?>]; 
			
			for (var i = files.length - 1; i >= 0; i--) 
			{ 
			
				var a = document.createElement("a");
				a.target = "_blank";
				a.download = filesx[i] +".pdf";
				a.href = 'asset/resume_data/' + files[i];
				a.click();
			}
		</script>
		
		
		<?php
	
	
}	
?>