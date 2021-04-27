<?php
 
// DB table to use
$table = 'official_student_list';
 
// Table's primary key
$primaryKey = 'sol_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => '`a`.`stud_no`', 'dt' => 0, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`', 'dt' => 1, 'field' =>'lname' ),
    array( 'db' => '`a`.`fname`', 'dt' => 2, 'field' =>'fname' ),
    array( 'db' => '`a`.`mname`', 'dt' => 3, 'field' =>'mname' ),
    array( 'db' => '`a`.`program_code`', 'dt' => 4, 'field' =>'program_code' ),
    array( 'db' => '`a`.`status`', 'dt' => 5, 'field' =>'status' )

);
 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_ojtassisti',
    'host' => 'localhost'
);
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
//require( 'ssp.class.php' );
 require('ssp.customized.class.php' );
 $joinQuery = "FROM `official_student_list` AS `a`";  
 $extraWhere = "`a`.`status` = 'Approved'";
echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);