<?php
// DB table to use
$table = 'applicant_list_jf';
$comp_id = $_COOKIE["cid"];
// Table's primary key
$primaryKey = 'aljf_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
  array( 'db' => '`a`.`stud_dp`', 
                    'dt' => 0 ,
                    'field' => 'stud_dp',
                    'formatter' => function($stud_dp) {
                        return '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;">' ;
                    }
                 ),
    array( 'db' => '`a`.`stud_no`', 'dt' => 1, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`', 
                      'dt' => 2, 
                      'field' => 'lname',
                       'formatter' => function($lname,$row) {
                        $fname = $row[11];
                        $mname = $row[12];
                        return  $lname.", ".$fname." ".$mname;
                    } 
          ),
    array( 'db' => '`b`.`program_code`', 'dt' => 3, 'field' => 'program_code' ),
    array( 'db' => '`a`.`contact_no`', 'dt' => 4, 'field' => 'contact_no' ),
    array( 'db' => '`c`.`remarks`', 'dt' => 5, 'field' => 'remarks' ),
    array( 'db' => '`c`.`others`', 'dt' => 6, 'field' => 'others' ),
    array( 'db' => '`d`.`event_name`', 'dt' => 7, 'field' => 'event_name' ),
    array( 'db' => '`d`.`semester`', 
                    'dt' => 8, 
                    'field' => 'semester',
                    'formatter' => function($semester,$row) {
                        $acad_year_start_seminar = $row[9];
                        $acad_year_end_seminar = $row[10];
                        return $semester." <br> ".$acad_year_start_seminar." - ".$acad_year_end_seminar;
                    } 
          ),
    //Row DATAS
    array( 'db' => '`d`.`acad_year_start_seminar`', 'dt' => 9, 'field' => 'acad_year_start_seminar' ),
    array( 'db' => '`d`.`acad_year_end_seminar`', 'dt' => 10, 'field' => 'acad_year_end_seminar' ),
    array( 'db' => '`a`.`fname`', 'dt' => 11, 'field' => 'fname' ),
    array( 'db' => '`a`.`mname`', 'dt' => 12, 'field' => 'mname' ),
    
);


// SQL server connection information
//require('asset/connection/mysqli_dbconnection.php');
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_JWS',
    'host' => '127.0.0.1'
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `student_info` AS `a` JOIN `program_list` AS `b` JOIN  `applicant_list_jf` AS `c` JOIN `event_manager` AS `d` ON  (`a`.`program_id` = `b`.`program_id` AND `a`.`stud_no` = `c`.`stud_no` AND `c`.`event_id` = `d`.`event_id`)";
$extraWhere = "`c`.`comp_id` = '".$comp_id."'";     

echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);