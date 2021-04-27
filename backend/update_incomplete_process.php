<?php

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



if(isset($_POST['btn_inc']))

{

	$ojt_status = mysqli_real_escape_string($dbc, trim($_POST['ojt_status']));

	$stud_no = mysqli_real_escape_string($dbc, trim($_POST['stud_no']));

	$semester = mysqli_real_escape_string($dbc, trim($_POST['semester']));

	$acad_year_start = mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));

	$acad_year_end = mysqli_real_escape_string($dbc, trim($_POST['acad_year_end']));

	$category_id = mysqli_real_escape_string($dbc, trim($_POST['category_id']));

	$lname = mysqli_real_escape_string($dbc, trim($_POST['lname']));

	$fname = mysqli_real_escape_string($dbc, trim($_POST['fname']));

	$mname = mysqli_real_escape_string($dbc, trim($_POST['mname']));

	$remarks = mysqli_real_escape_string($dbc, trim($_POST['remarks']));

	//------------------------------------------------------------------------------------------------------------//

	//----------------------------------OJT_STATUS = CONTINUE----------------------------------------------------//

	//----------------------------------------------------------------------------------------------------------//

	if($ojt_status == "Continue")

	{

		//------INSERT INTO student_checklist------//

		$query_count = "SELECT COUNT(*) FROM student_deliverables";

                   $result2 =  mysqli_query($dbc, $query_count);         

                        if($result2->num_rows > 0 )

                        {   

                            while ($row = mysqli_fetch_array($result2))

                            {

                              $count_deliverables_id = $row[0];

                            }

                        }

                  $i = 1;

                  while($i<= $count_deliverables_id)

                    {

                        $inc_checklist = "INSERT INTO student_checklist

                          (stud_no,deliverable_id,date_submitted,semester,acad_year_start,acad_year_end,remarks) VALUES

                          ('$stud_no','$i','0000-00-00','$semester','$acad_year_start','$acad_year_end','Not yet completed')";

                        $result_checklist = mysqli_query($dbc,$inc_checklist);

                        $i++;

                    }

					  

		//------SELECT student_ojt_records---//

		$inc_select_ojt_records = "SELECT year_level, section_id, ojt_status, enrollment_status FROM student_ojt_records WHERE stud_no='$stud_no' AND semester='$semester' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND category_id='$category_id'";

		$result_select_ojt_records = mysqli_query($dbc, $inc_select_ojt_records);

		if(mysqli_num_rows($result_select_ojt_records)>0)

		{

			$row = mysqli_fetch_assoc($result_select_ojt_records);

			$year_level = $row['year_level'];

			$section_id = $row['section_id'];

			$ojt_status2 = $row['ojt_status'];

			$enrollment_status = $row['enrollment_status'];

		}

		//------SELECT company_ojt_student-------//

		$inc_select_comp_ojt_stud = "SELECT comp_id, ojt_start_date, comp_ojt_stud_id FROM company_ojt_student WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_select_comp_ojt_stud = mysqli_query($dbc, $inc_select_comp_ojt_stud);

		if(mysqli_num_rows($result_select_comp_ojt_stud)>0)

		{

			$row2 = mysqli_fetch_assoc($result_select_comp_ojt_stud);

			$comp_id = $row2['comp_id'];

			$ojt_start_date = $row2['ojt_start_date'];

			$comp_ojt_stud_id = $row2['comp_ojt_stud_id'];

		}

		

		//------INSERT INTO incomplete_student---//

		$inc_ojt_records = "INSERT INTO incomplete_student_records(stud_no, year_level, acad_year_start, acad_year_end, semester, category_id, section_id, ojt_status, enrollment_status, comp_id, ojt_start_date, comp_ojt_stud_id, remarks) VALUES('$stud_no', '$year_level', '$acad_year_start', '$acad_year_end', '$semester', '$category_id', '$section_id', '$ojt_status2', '$enrollment_status', '$comp_id', '$ojt_start_date', '$comp_ojt_stud_id', '$remarks')";

		$result_ojt_records = mysqli_query($dbc, $inc_ojt_records);

		

		//------UPDATE student_ojt_records-----//

		$inc_update_ojt = "UPDATE student_ojt_records SET ojt_status='Ongoing' WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_update_ojt = mysqli_query($dbc, $inc_update_ojt);

		//------UPDATE company_ojt_student----//

		$inc_update_comp_ojt = "UPDATE company_ojt_student SET comp_id='0', status='Pending' WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_update_comp_ojt = mysqli_query($dbc, $inc_update_comp_ojt);

		

		if($result_checklist==true && $result_select_ojt_records==true && $result_ojt_records==true && $result_select_comp_ojt_stud==true && $result_update_ojt==true && $result_update_comp_ojt)

		{

			$info = $stud_no." ".$lname.", ".$fname." ".$mname;

			header("Location: student_master_list.php?sn=$info");

			exit;

		}

	}

	//------------------------------------------------------------------------------------------------------------//

	//----------------------------------OJT_STATUS = REPEAT------------------------------------------------------//

	//----------------------------------------------------------------------------------------------------------//

	else if($ojt_status == "Repeat")

	{

		//------DELETE student_checklist------------//

		$query_delete = "DELETE FROM student_checklist WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_delete=mysqli_query($dbc, $query_delete);

		//------INSERT INTO student_checklist------//

		$query_count = "SELECT COUNT(*) FROM student_deliverables";

                   $result2 =  mysqli_query($dbc, $query_count);         

                        if($result2->num_rows > 0 )

                        {   

                            while ($row = mysqli_fetch_array($result2))

                            {

                              $count_deliverables_id = $row[0];

                            }

                        }

                  $i = 1;

                  while($i<= $count_deliverables_id)

                    {

                        $inc_checklist = "INSERT INTO student_checklist

                          (stud_no,deliverable_id,date_submitted,semester,acad_year_start,acad_year_end,remarks) VALUES

                          ('$stud_no','$i','0000-00-00','$semester','$acad_year_start','$acad_year_end','Not yet completed')";

                        $result_checklist = mysqli_query($dbc,$inc_checklist);

                        $i++;

                    }

					  

		//------SELECT student_ojt_records---//

		$inc_select_ojt_records = "SELECT year_level, section_id, ojt_status, enrollment_status FROM student_ojt_records WHERE stud_no='$stud_no' AND semester='$semester' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND category_id='$category_id'";

		$result_select_ojt_records = mysqli_query($dbc, $inc_select_ojt_records);

		if(mysqli_num_rows($result_select_ojt_records)>0)

		{

			$row = mysqli_fetch_assoc($result_select_ojt_records);

			$year_level = $row['year_level'];

			$section_id = $row['section_id'];

			$ojt_status2 = $row['ojt_status'];

			$enrollment_status = $row['enrollment_status'];

		}

		//------SELECT company_ojt_student-------//

		$inc_select_comp_ojt_stud = "SELECT comp_id, ojt_start_date, comp_ojt_stud_id FROM company_ojt_student WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_select_comp_ojt_stud = mysqli_query($dbc, $inc_select_comp_ojt_stud);

		if(mysqli_num_rows($result_select_comp_ojt_stud)>0)

		{

			$row2 = mysqli_fetch_assoc($result_select_comp_ojt_stud);

			$comp_id = $row2['comp_id'];

			$ojt_start_date = $row2['ojt_start_date'];

			$comp_ojt_stud_id = $row2['comp_ojt_stud_id'];

		}

		

		//------INSERT INTO incomplete_student---//

		$inc_ojt_records = "INSERT INTO incomplete_student_records(stud_no, year_level, acad_year_start, acad_year_end, semester, category_id, section_id, ojt_status, enrollment_status, comp_id, ojt_start_date, comp_ojt_stud_id, remarks) VALUES('$stud_no', '$year_level', '$acad_year_start', '$acad_year_end', '$semester', '$category_id', '$section_id', '$ojt_status2', '$enrollment_status', '$comp_id', '$ojt_start_date', '$comp_ojt_stud_id', '$remarks')";

		$result_ojt_records = mysqli_query($dbc, $inc_ojt_records);

		

		//------UPDATE student_ojt_records-----//

		$inc_update_ojt = "UPDATE student_ojt_records SET ojt_status='Ongoing' WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_update_ojt = mysqli_query($dbc, $inc_update_ojt);

		

		//------UPDATE company_ojt_student----//

		$inc_update_comp_ojt = "UPDATE company_ojt_student SET comp_id='0', status='Pending' WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_update_comp_ojt = mysqli_query($dbc, $inc_update_comp_ojt);

		//------DELETE dtr-------------------//

		$inc_delete_dtr = "DELETE FROM dtr WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_delete_dtr = mysqli_query($dbc, $inc_delete_dtr);

		//------DELETE journal-------------------//

		$inc_delete_journal = "DELETE FROM journal WHERE stud_no='$stud_no' AND acad_year_start='$acad_year_start' AND acad_year_end='$acad_year_end' AND semester='$semester'";

		$result_delete_journal = mysqli_query($dbc, $inc_delete_journal);

		

		if($result_checklist==true && $result_select_ojt_records==true && $result_ojt_records==true && $result_select_comp_ojt_stud==true && $result_update_comp_ojt==true && $result_update_ojt==true &&$result_delete_dtr==true && $result_delete_journal==true && $result_delete==true)

		{

			$info = $stud_no." ".$lname.", ".$fname." ".$mname;

			header("Location: student_master_list.php?sn=$info");

			exit;

		}

	}

}

?>