<?php
	require 'assets/connection/mysqli_dbconnection.php';

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
                          $query_stud_add_check_list_1 = "INSERT INTO student_checklist
                          (stud_no,deliverable_id,date_submitted,semester,acad_year_start,acad_year_end,remarks, category_id) VALUES
                          ('10000133157','$i','0000-00-00','Summer','2016','2017','Not yet completed', '7')";
                          $result_stud_reg = mysqli_query($dbc,$query_stud_add_check_list_1);
                          $i++;
                      }
					  if($result2==true)
					  {
						echo "ok";
					  }
					  else
					  {
						echo "error";
					  }
?>