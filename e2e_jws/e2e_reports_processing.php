<?php


// DB table to use
$table = 'seminar_attended';

// Table's primary key
$primaryKey = 'sa_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => '`a`.`stud_no`', 'dt' => 0, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`', 'dt' => 1, 'field' => 'lname' ),
    array( 'db' => '`a`.`fname`', 'dt' => 2, 'field' => 'fname' ),
    array( 'db' => '`a`.`mname`', 'dt' => 3, 'field' => 'mname' ),
    array( 'db' => '`b`.`program_code`', 'dt' => 4, 'field' => 'program_code' ),
    array( 'db' => '`a`.`semester`', 
            'dt' => 5,
            'field' => 'semester',
            'formatter' => function($semester) {
                        if($semester == "2nd Semester"){
                          $F_semester = "2nd sem";
                        }elseif($semester == "1st Semester"){
                          $F_semester = "1st sem";
                        }elseif($semester == "Summer"){
                          $F_semester = "Summer";
                        }
                        return  $F_semester;
                    }
          ),
    array( 'db' => '`a`.`acad_year_start`', 'dt' => 6, 'field' => 'acad_year_start' ),
    array( 'db' => '`a`.`acad_year_end`', 'dt' => 7, 'field' => 'acad_year_end' ),
    array( 'db' => '`sa1`.`s1_status`', 'dt' => 8, 'field' => 's1_status' ),
    array( 'db' => '`sa2`.`s2_status`', 'dt' => 9, 'field' => 's2_status' ),
    array( 'db' => '`sa1`.`batch_id`', 'dt' => 10, 'field' => 'batch_id' ),
    

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


  $joinQuery = "FROM `student_info` AS `a` JOIN `program_list` AS `b`  JOIN `event_manager` AS `em` JOIN `seminar_attended` AS `sa1` JOIN `seminar_attended_2` AS `sa2` ON (`a`.`program_id` = `b`.`program_id` AND `em`.`event_id` = `sa1`.`event_id` AND `a`.`stud_no` = `sa1`.`stud_no` AND `em`.`event_id` = `sa2`.`event_id` AND `a`.`stud_no` = `sa2`.`stud_no` AND `sa1`.`stud_no` = `sa2`.`stud_no` AND `sa1`.`batch_id` = `sa2`.`batch_id` AND `sa1`.`event_id`  = `sa2`.`event_id`) ";     
$extraWhere = "";
echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);