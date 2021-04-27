<?php
date_default_timezone_set('Asia/Manila');
// require the sql connection..
require 'assets/connection/mysqli_dbconnection.php';

// Set the auto increment..
function generateId($con, $id, $table_name) {
    $query = "SELECT $id FROM $table_name";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if($num <= 0) {
        $id = 1;
        return $id;
    } else {
        $query1 = "SELECT MAX($id) FROM $table_name";
        $result1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_array($result1, MYSQLI_NUM);
        $id = $row1[0] + 1;
        return $id;
    }
}
//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_reg2']))
{
    $stud_no =  mysqli_real_escape_string($dbc, trim($_POST['stud_no']));
	$pass = crypt($stud_no, '$2a$12$xyYidadDvFewdFQZFIcDDs');
    $lname =  mysqli_real_escape_string($dbc, trim($_POST['lname']));
    $fname =  mysqli_real_escape_string($dbc, trim($_POST['fname']));
    $mname =  mysqli_real_escape_string($dbc, trim($_POST['mname']));
    $gender =  mysqli_real_escape_string($dbc, trim($_POST['gender']));
    $bday =  mysqli_real_escape_string($dbc, trim($_POST['bday']));
    $program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

    $email =  mysqli_real_escape_string($dbc, trim($_POST['email']));
    $mobile_no =  mysqli_real_escape_string($dbc, trim($_POST['mobile_no']));
    $tel_no =  mysqli_real_escape_string($dbc, trim($_POST['tel_no']));
    $address =  mysqli_real_escape_string($dbc, trim($_POST['address']));
    $facebook =  mysqli_real_escape_string($dbc, trim($_POST['facebook']));
    $bday2 = date('Y-m-d', strtotime(str_replace('-', '/', $bday)));

    $enrollment_status =  mysqli_real_escape_string($dbc, trim($_POST['enrollment_status']));
     $acad_year_start =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_start']));
     $acad_year_end =  mysqli_real_escape_string($dbc, trim($_POST['acad_year_end']));

     $year_level =  mysqli_real_escape_string($dbc, trim($_POST['year_level']));
     $semester =  mysqli_real_escape_string($dbc, trim($_POST['semester']));
     $category_id =  mysqli_real_escape_string($dbc, trim($_POST['category_id']));
     $ojt_status =  mysqli_real_escape_string($dbc, trim($_POST['ojt_status']));
	 

     $comp_ojt_stud_id = generateId($dbc,'comp_ojt_stud_id','company_ojt_student');
	 
	 
	 $query_v="SELECT * FROM student_info WHERE stud_no='$stud_no'";
	 $result_v = mysqli_query($dbc, $query_v);
	 if(mysqli_num_rows($result_v)>0)
	 {
		header("Location: login.php");
	 }
	 else
		{		  
			/*default_image*/
			$flname = "../files/default_img.jpg";
			$nw_pic = (file_get_contents($flname));
			$file_typex= basename($flname);
			$type = pathinfo($file_typex,PATHINFO_EXTENSION);

			$image = imagecreatefromstring($nw_pic);

			//NOTE: Resize all incoming images to reduce file size on database.
			// Content type pag iooutopu
			//header('Content-Type: image/jpeg');

			// Get new sizes
			list($width, $height) = getimagesize($flname);
			$newwidth = 300;
			$newheight = 300;

			// // Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = $image;
			// // Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			// // Output
			if(!empty($nw_pic))
			{
				ob_start();
				imagejpeg($thumb);
				$image_final = ob_get_contents();
				ob_end_clean();
				$filename = "../files/student_pics/".$stud_no.".jpg";
				file_put_contents($filename, $image_final);
				chmod($filename, 0666);
			}
			else
			{
				echo "ERROR: img is empty.";
			}
			
			
			/*INSERT INFO*/
            $query_stud_reg = "INSERT INTO student_info(stud_no,lname,fname,mname,gender,bday,program_id,email,mobile_no,tel_no,address,facebook,password) VALUES('$stud_no','$lname','$fname','$mname','$gender','$bday2','$program_id','$email','$mobile_no','$tel_no','$address','$facebook','$pass')";

            $query_stud_add_ojt_rec = "INSERT INTO student_ojt_records(stud_no,year_level,acad_year_start,acad_year_end,semester,category_id,section_id,ojt_status,enrollment_status) VALUES('$stud_no','$year_level','$acad_year_start','$acad_year_end','$semester','$category_id','1','$ojt_status','$enrollment_status')";
            
            $query_stud_add_resume = "INSERT INTO student_resume_data(stud_no, resume_status) VALUES('$stud_no', '0')";
            $query_company_ojt_student = "INSERT INTO company_ojt_student(stud_no,comp_id,status,ojt_start_date,comp_ojt_stud_id,acad_year_start,acad_year_end,semester) VALUES('$stud_no','0','Pending','1970-01-01','$comp_ojt_stud_id','$acad_year_start','$acad_year_end','$semester')";
				  
				$result_stud_add_resume = mysqli_query($dbc,$query_stud_add_resume);
                $result_company_ojt_student = mysqli_query($dbc,$query_company_ojt_student);
                $result_stud_reg = mysqli_query($dbc,$query_stud_reg);
                $result_stud_add_ojt_rec = mysqli_query($dbc,$query_stud_add_ojt_rec);

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
                    $query_stud_add_check_list_1 = "INSERT INTO student_checklist(stud_no,deliverable_id,date_submitted,semester,acad_year_start,acad_year_end,remarks, category_id) VALUES('$stud_no','$i','1970-01-01','$semester','$acad_year_start','$acad_year_end','Not yet completed', '$category_id')";
                    $result_stud_reg = mysqli_query($dbc,$query_stud_add_check_list_1);
                    $i++;
                }
				if($result_stud_add_resume==true)
                {
					if($result_company_ojt_student==true)
					{
						if($result_stud_reg==true)
						{
							if($result_stud_add_ojt_rec==true)
							{
								header("Location: login.php?success=1");
								exit;
							}
							else
							{
								echo "result_stud_add_ojt_rec";
								echo "<br>" . mysqli_error($dbc);
							}
						}
						else
						{
							echo "result_stud_reg";
							echo "<br>" . mysqli_error($dbc);
						}
					}
					else
					{
						echo "result_company_ojt_student";
						echo "<br>" . mysqli_error($dbc);
					}
				}
				else
				{
					echo "result_stud_add_resume.";
					echo "<br>" . mysqli_error($dbc);
				}
	}
}
?>