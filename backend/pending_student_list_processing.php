<?php

if(isset($_GET['program_id'])){
$program_id = $_GET['program_id'];
}
// DB table to use
$table = 'student_info';

// Table's primary key
$primaryKey = 'stud_no';

$columns = array(
   array( 'db' => '`a`.`stud_no`', 
                    'dt' => 0 ,
                    'field' => 'stud_no',
                    'formatter' => function($stud_no) {        
                        return '<img src="../files/student_pics/'.$stud_no.'.jpg" style="height:50px;width:60px;">' ;
                    }
                 ),
	array( 'db' => '`a`.`stud_no`', 'dt' => 1, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`',
					'dt' => 2, 
					'field' =>'lname',
					'formatter' => function($lname,$row) {  
						$fname = $row[10];
					    $mname = $row[11];
                        return $lname.", ".$fname." ".$mname;
                    }
		),
	array( 'db' => '`b`.`program_code`', 'dt' => 3, 'field' =>'program_code' ),
	array( 'db' => '`c`.`acad_year_start`', 
					'dt' => 4, 
					'field' =>'acad_year_start',
					'formatter' => function($acad_year_start,$row) {  
						$acad_year_end = $row[12];
                        return $acad_year_start." - ".$acad_year_end;
                    }
		),
	array( 'db' => '`c`.`semester`', 'dt' => 5, 'field' =>'semester' ),
	array( 'db' => '`d`.`category_description`', 'dt' => 6, 'field' =>'category_description' ),
	array( 'db' => '`c`.`ojt_status`', 'dt' => 7, 'field' =>'ojt_status' ),
	array( 'db' => '`c`.`enrollment_status`', 'dt' => 8, 'field' =>'enrollment_status' ),
	array( 'db' => '`a`.`stud_no`', 
                    'dt' => 9 ,
                    'field' => 'stud_no',
                    'formatter' => function($stud_no,$row) {
					 $acad_year_start_rd = $row[4];
					 $semester_rd = $row[5];
                        return '<a href="enrolled_student.php?stud_no_records='.$stud_no.'&acad_year_start_rd='.$acad_year_start_rd.'&semester_rd='.$semester_rd.'">
                                  <button type="submit" class="btn btn-outline btn-primary btn-block btn-sm">
                                  <span class="fa fa-mail-forward"></span> &nbsp;Enroll  &nbsp;</button>
                                  </a>' ;
                    }
                 ),
	//concat data
	array( 'db' => '`a`.`fname`', 'dt' => 10, 'field' =>'fname' ),
	array( 'db' => '`a`.`mname`', 'dt' => 11, 'field' =>'mname' ),
	array( 'db' => '`c`.`acad_year_end`', 'dt' => 12, 'field' =>'acad_year_end' ),
	
);


//SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_ojtassisti',
    'host' => 'localhost'
);

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `student_info` AS `a` JOIN `program_list` AS `b` JOIN student_ojt_records AS `c` JOIN program_category_list AS `d` ON (`a`.`program_id` = `b`.`program_id` AND `a`.`stud_no` = `c`.`stud_no` AND `c`.`category_id` = `d`.`category_id`)";     
$extraWhere = "`a`.`program_id` = '".$program_id."' AND `c`.`enrollment_status` = 'Not Enrolled'";
echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);