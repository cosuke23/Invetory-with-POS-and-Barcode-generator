 <?php

// Start the session..

session_start();



// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

if(isset($_POST['btn-DNA']))

	{

		$stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no_records']));

		$category_id = mysqli_real_escape_string($dbc, trim($_POST['category_id']));

		$ojt_status =  mysqli_real_escape_string($dbc, trim($_POST['ojt_status']));

		//$enrollment_status =  mysqli_real_escape_string($dbc, trim($_POST['enrollment_status']));

		//$section_records =  mysqli_real_escape_string($dbc, trim($_POST['section_records']));

		$acad_year_start_rd =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));

		$acad_year_end_rd =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_end']));

		$semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));

		

				//DNA student/s

		if($ojt_status=="DNA")

		{

			$query_dna_records = "UPDATE student_ojt_records SET ojt_status='$ojt_status' WHERE stud_no='$stud_no' AND category_id = '$category_id' AND semester='$semester' AND acad_year_start='$acad_year_start_rd'";

			$result_dna_records = mysqli_query($dbc, $query_dna_records);

			

			$query_dna_comp_stud = "UPDATE company_ojt_student SET status='$ojt_status' WHERE stud_no='$stud_no' AND semester='$semester' AND acad_year_start='$acad_year_start_rd' AND acad_year_end='$acad_year_end_rd'";

			$result_dna_comp_stud = mysqli_query($dbc, $query_dna_comp_stud);

			

			//$query_insert_dna = "INSERT INTO dna_stud_handler VALUES('$stud_no', '$category_id')";

			//$result_insert_dna = mysqli_query($dbc, $query_insert_dna);

			

			if($result_dna_records && $result_dna_comp_stud) //&& $result_insert_dna)

			{

				$msg = "Successfully update the records.";

				header("Location: adviser_update_student_records.php?acad_year_start_rd=$acad_year_start_rd&semester_rd=$semester&stud_no_records=$stud_no&message=$msg");

				echo "DNA";

			}

			else

			{

				echo "query_DNA failed to execute.";

			}

		}

		else if($ojt_status=="Incomplete")

		{

			$query_inc_records = "UPDATE student_ojt_records SET ojt_status='$ojt_status' WHERE stud_no='$stud_no' AND category_id = '$category_id' AND semester='$semester' AND acad_year_start='$acad_year_start_rd'";

			$result_inc_records = mysqli_query($dbc, $query_inc_records);

			

			$query_inc_comp_stud = "UPDATE company_ojt_student SET status='$ojt_status' WHERE stud_no='$stud_no' AND semester='$semester' AND acad_year_start='$acad_year_start_rd' AND acad_year_end='$acad_year_end_rd'";

			$result_inc_comp_stud = mysqli_query($dbc, $query_inc_comp_stud);

			

			if($result_inc_records && $result_inc_comp_stud)

			{

				$msg = "Successfully update the record(s).";

				header("Location: adviser_update_student_records.php?acad_year_start_rd=$acad_year_start_rd&semester_rd=$semester&stud_no_records=$stud_no&message=$msg");

				echo "Incomplete";

			}

			else

			{

				echo "query_Incomplete failed to execute.";

			}

		}else{

			header("Location: adviser_update_student_records.php?acad_year_start_rd=$acad_year_start_rd&semester_rd=$semester&stud_no_records=$stud_no");

		}

		

	}

?>

