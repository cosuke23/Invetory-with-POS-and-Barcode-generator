<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
    if (isset($_POST['btn_student_chk_stud']))
    {
        $student_number = mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
        
        $query_stud_info = "SELECT stud_no FROM student_ojt_records WHERE stud_no='$student_number' and ojt_status='Ongoing'";
        $result_stud_info = mysqli_query($dbc,$query_stud_info);
		if(mysqli_num_rows($result_stud_info)>0)
		{
			header("Location: check_student_number.php?stud_no=$student_number&error=1");
			exit;
			
        }
		 $query_stud_fin = "SELECT stud_no FROM student_ojt_records WHERE stud_no='$student_number' and ojt_status='Finished'";
         $result_stud_fin = mysqli_query($dbc,$query_stud_fin);
		if(mysqli_num_rows($result_stud_fin)>0)
		{
			header("Location: student_ojt_records.php?stud_no=$student_number&rb=1");
			exit;
			
        }
       else
        {
			$query_official_stud = "SELECT stud_no FROM official_student_list WHERE stud_no='$student_number' AND status='Approved'";
			$result_official_stud = mysqli_query($dbc, $query_official_stud);
			if(mysqli_num_rows($result_official_stud)>0)
			{
				header("Location: student_official_list.php?stud_no=$student_number&rb=1");
				exit;
			}
			else
			{
				header("Location: check_student_number.php?stud_no=$student_number&error2=1");
				exit;
			}
        }
    }
?>