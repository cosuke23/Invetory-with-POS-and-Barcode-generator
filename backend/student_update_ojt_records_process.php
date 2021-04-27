<?php
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
// Set the auto increment..
function generateId($con, $id, $table_name) {
    $query = "SELECT $id FROM $table_name";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if($num <= 0)
	{
        $id = 1;
        return $id;
    }
	else
	{
        $query1 = "SELECT MAX($id) FROM $table_name";
        $result1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_array($result1, MYSQLI_NUM);
        $id = $row1[0] + 1;
        return $id;
    }
}
if(isset($_POST['btn_ojt_records_update']))
	{
		$stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
		$year_level =  mysqli_real_escape_string($dbc, trim($_POST['year_level']));
		$category_id =  mysqli_real_escape_string($dbc, trim($_POST['category_id']));
		$ojt_status =  mysqli_real_escape_string($dbc, trim($_POST['ojt_status']));
		$enrollment_status =  mysqli_real_escape_string($dbc, trim($_POST['enrollment_status']));
		$semester_ay = mysqli_real_escape_string($dbc, $_POST['semester_ay']);
		$explode_semester_ay = explode('|',$semester_ay);
		$semester= $explode_semester_ay[0];
		$acad_year_start = $explode_semester_ay[1];
		$acad_year_end = $acad_year_start + 1;
		  
		  
		$query_stud_rec = "SELECT stud_no FROM student_ojt_records WHERE stud_no='$stud_no' and ojt_status='Ongoing'";
		$result_stud_rec = mysqli_query($dbc,$query_stud_rec);
		if(mysqli_num_rows($result_stud_rec)>0)
		{
			header("Location: Student_information.php?registered2=2&stud_no=$stud_no");
			exit;
			
        }
		
		
			$query_stud_records_status = "INSERT INTO student_ojt_records (stud_no,year_level,acad_year_start,acad_year_end,semester,category_id,section_id,ojt_status,enrollment_status) 
			VAlUES('$stud_no', '$year_level', '$acad_year_start', '$acad_year_end', '$semester', '$category_id', 1, '$ojt_status', '$enrollment_status')";
			$result_stud_records_status = mysqli_query($dbc,$query_stud_records_status);
			
			//-----resume data----//
			$query_stud_add_resume = "UPDATE student_resume_data set resume_status='1' WHERE stud_no = '$stud_no'";
			$result_stud_add_resume = mysqli_query($dbc,$query_stud_add_resume);
			
			$comp_ojt_stud_id = generateId($dbc, 'comp_ojt_stud_id','company_ojt_student');
			$query_company_ojt_student = "INSERT INTO company_ojt_student(stud_no,comp_id,status,ojt_start_date,comp_ojt_stud_id,acad_year_start,acad_year_end,semester) VALUES('$stud_no','0','Pending','0000-00-00','$comp_ojt_stud_id','$acad_year_start','$acad_year_end','$semester')";       
			$result_company_ojt_student = mysqli_query($dbc,$query_company_ojt_student);
			//$result_stud_reg = mysqli_query($dbc,$query_stud_reg);
			
			//$result_stud_add_ojt_rec = mysqli_query($dbc,$query_stud_add_ojt_rec);
			
			$query44 = "SELECT COUNT(*) FROM student_deliverables";
			$result2 =  mysqli_query($dbc, $query44);         
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
                    $query_stud_add_check_list_1 = "INSERT INTO student_checklist(stud_no,deliverable_id,date_submitted,semester,acad_year_start,acad_year_end,remarks,category_id) VALUES('$stud_no','$i','1970-01-01','$semester','$acad_year_start','$acad_year_end','Not yet completed', '$category_id')";
                    $result_stud_reg = mysqli_query($dbc,$query_stud_add_check_list_1);
                    $i++;
                }
                if($result_stud_reg && $result_stud_records_status)
                {
                    echo "Added";
                    if(isset($_GET['rb']))
					{
						if($_GET['rb']==1)
						{
							header("Location: Student_information.php?registered2=2&stud_no=$stud_no");
							exit;
						}
						else
						{
							header("Location: blank.php");
							exit;
						}
					}
					else
					{
						header("Location: blank.php");
						exit;
					}
                }
                else    
                {
                    echo "query error failed please try again.."; 
                }
	}
?>
