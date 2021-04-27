<?php

function checkStud($stud_no,$tochange) {
                      $con = mysqli_connect('localhost','root','','e2e_ojtassisti');
					  $result = mysqli_query($con,'SELECT `stud_no` FROM `student_report` WHERE `stud_no` = ' . $stud_no);
					  $query = mysqli_fetch_array($result, MYSQLI_ASSOC);
					  return ($query ? "<font color='RED'><B>".$tochange ."</B></font>" : $tochange);
}
		 
// DB table to use
$table = 'student_info';

$primaryKey = 'stud_no';
 
$columns =  array(
            array( 'db' => 'stud_no', 
                    'dt' => 0 ,
                    'formatter' => function($stud_no) { 
                        return '<img src="../files/student_pics/' . $stud_no. '.jpg" style="height:50px;width:60px;">' ;
						
						
						
						
	
                    }
                 ),
            array( 'db' => 'stud_no', 'dt' => 1,
			 'formatter' => function($stud_no) { 
					return checkStud($stud_no,$stud_no);
                    }),
            array( 'db' => 'lname', 'dt' => 2,
			 'formatter' => function($lname,$row) { 
					$stud_no = $row[0];
					return checkStud($stud_no,$lname);
                    }),
            array( 'db' => 'fname', 'dt' => 3 ,
			 'formatter' => function($fname,$row) { 
					$stud_no = $row[0];
					return checkStud($stud_no,$fname);
                    }),
            array( 'db' => 'mname', 'dt' => 4 ,
			 'formatter' => function($mname,$row) { 
					$stud_no = $row[0];
					return checkStud($stud_no,$mname);
                    }),
            array( 'db' => 'stud_no', 
                    'dt' => 5 ,
                    'formatter' => function($stud_no) {
                       $edit = '<a href="update_Student_information.php?stud_no='.$stud_no.'">
                                  <button type="submit" class=" btn btn-outline btn-primary" data-toggle="tooltip" title= "Update Info">
                                  <span class="glyphicon glyphicon-pencil"></span></button>
                                  </a>';
                      $ojt_records = '<a href="student_ojt_details.php?stud_no='.$stud_no.'">
                                  <button type="submit" class="btn btn-outline btn-info" data-toggle="tooltip" title= "OJT Records">
                                  <span class="fa fa-file-text"></span></button>
                                  </a>';
                      $more = '<a href="view_Student_information.php?stud_no='.$stud_no.'">
                                  <button type="submit" class="btn btn-outline btn-warning" data-toggle="tooltip" title= "More">
                                  <span class="glyphicon glyphicon-info-sign"></span></button>
                                  </a>';
                        return $edit.$ojt_records.$more;
                    }
                 ),
            );
            
// SQL server connection information
$sql_details = array(
     'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_ojtassisti',
    'host' => 'localhost'
);

 
require( 'ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);