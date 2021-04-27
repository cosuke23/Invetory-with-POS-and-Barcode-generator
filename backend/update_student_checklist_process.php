<?php
// Start the session..
date_default_timezone_set('Asia/Manila');
session_start();
//header("Location: update_student_records.php");
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
//Show all possible problems..
if(!isset($_COOKIE["uid"])) {
  header ("Location: login.php");
  exit;
}
$username = $_COOKIE["uid"];
$usertype = $_COOKIE["ut"];
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
if($usertype==1)
{
  $query2 = "SELECT * from admin_info WHERE admin_id = '$username'";
  $result2 = mysqli_query($dbc,$query2);
    if(mysqli_num_rows($result2)>0)
    {
      $row2 = mysqli_fetch_assoc($result2);
      $fname2 = $row2["fname"];
      $title2 = $row2["title"];
    }
}
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_stud_chklist']))
	{
		$stud_no_chklist =  mysqli_real_escape_string($dbc, trim($_POST['stud_no_chklist']));
		$deliverable_id =  mysqli_real_escape_string($dbc, trim($_POST['deliverable_id']));
		$date_submitted =  mysqli_real_escape_string($dbc, trim($_POST['date_submitted']));
		$remarks =  mysqli_real_escape_string($dbc, trim($_POST['remarks']));
		$deliverable_name =  mysqli_real_escape_string($dbc, trim($_POST['deliverable_name']));
		$acad_year_start =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));
		$semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));
		$acad_year_end = $acad_year_start + 1;
		$date_submitted2 = date('Y-m-d', strtotime(str_replace('-', '/', $date_submitted)));
		$comp_id =  mysqli_real_escape_string($dbc, trim($_POST['comp_id']));
		$note =  mysqli_real_escape_string($dbc, trim($_POST['note']));
		$date_note =  mysqli_real_escape_string($dbc, trim($_POST['date_note_picker']));
		$date_note2 = date('Y-m-d', strtotime(str_replace('-', '/', $date_note)));
		$rmks_id = mysqli_real_escape_string($dbc, trim($_POST['rmks_id']));
		$category_id = mysqli_real_escape_string($dbc,$_POST['category_id']);
		if($remarks == 'On process')
		{
			$query_remarks_moa = "SELECT rmks_id FROM moa_remarks WHERE stud_no = '$stud_no_chklist' AND acad_year_start = '$acad_year_start' AND semester = '$semester'";
 			 $result_remarks_moa =  mysqli_query($dbc, $query_remarks_moa);         
          if($result_remarks_moa->num_rows > 0 )
            {   
              while ($row2 = mysqli_fetch_array($result_remarks_moa))
              {
                  $remarks_id = $row2[0];                         
              }
           }else{
           	$remarks_id = "haha";
           }
			if($rmks_id == $remarks_id)
			{
			//Update query for student_ojt_records
			$query_student_update_chklist = "UPDATE student_checklist SET date_submitted = '$date_submitted2', remarks = '$remarks',checker='$title2.$fname2'  WHERE stud_no = '$stud_no_chklist' AND deliverable_id = '$deliverable_id' AND acad_year_start = '$acad_year_start' AND semester = '$semester' AND category_id = '$category_id'";
			
			$query_update_moa_remarks = "UPDATE moa_remarks SET comp_id = '$comp_id', note= '$note',date_note = '$date_note2' WHERE stud_no = '$rmks_id'";
			$result_update_moa_remarks = mysqli_query($dbc,$query_update_moa_remarks);
			$result_update_student_checklist = mysqli_query($dbc,$query_student_update_chklist);
			if($result_update_student_checklist && $result_update_moa_remarks)
				{
					echo "update student checklist success with update remarks";
					header("Location: OJT_student_checklist.php?acad_year_start_rd=$acad_year_start&semester_rd=$semester&stud_no_records=$stud_no_chklist&success=1&deliverable_name=$deliverable_name&category_id=$category_id");
				}
			else	
				{
					echo "query error failed please try again.."; 
				}	
			}else{
				//Update query for student_ojt_records
			$query_student_update_chklist = "UPDATE student_checklist SET date_submitted = '$date_submitted2', remarks = '$remarks',checker='$title2.$fname2'  WHERE stud_no = '$stud_no_chklist' AND deliverable_id = '$deliverable_id' and acad_year_start = '$acad_year_start' and semester = '$semester' AND category_id = '$category_id'";
			
			$query_insert_moa_remarks = "INSERT INTO moa_remarks(stud_no,comp_id,acad_year_start,acad_year_end,semester,note,date_note) VALUES('$stud_no_chklist','$comp_id','$acad_year_start','$acad_year_end','$semester','$note','$date_note2')";
			$result_insert_moa_remarks = mysqli_query($dbc,$query_insert_moa_remarks);
			$result_update_student_checklist = mysqli_query($dbc,$query_student_update_chklist);
			if($result_update_student_checklist && $result_insert_moa_remarks)
				{
					echo "update student checklist success with added moa remarks";
					header("Location: OJT_student_checklist.php?acad_year_start_rd=$acad_year_start&semester_rd=$semester&stud_no_records=$stud_no_chklist&category_id=$category_id&success=1&deliverable_name=$deliverable_name");
				}
			else	
			{
				echo "query error failed please try again.."; 
				}	
			}
			
		}
		else
		{
			//Update query for student_ojt_records
			$query_student_update_chklist = "UPDATE student_checklist SET date_submitted = '$date_submitted2', remarks = '$remarks',checker='$title2.$fname2'  WHERE stud_no = '$stud_no_chklist' AND deliverable_id = '$deliverable_id' and acad_year_start = '$acad_year_start' and semester = '$semester' AND category_id = '$category_id'";
			
			$result_update_student_checklist = mysqli_query($dbc,$query_student_update_chklist);
	
			
		if($result_update_student_checklist)
				{
					echo "update student checklist success";
					header("Location: OJT_student_checklist.php?acad_year_start_rd=$acad_year_start&semester_rd=$semester&stud_no_records=$stud_no_chklist&category_id=$category_id&success=1&deliverable_name=$deliverable_name");
				}
			else	
			{
				echo "query error failed please try again.."; 
			}
		}	
	}
?>