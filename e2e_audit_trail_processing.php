<?php


// DB table to use
$table = 'audit_trail';

// Table's primary key
$primaryKey = 'at_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
  array( 'db' => '`a`.`profileData`', 
                    'dt' => 0 ,
                    'field' => 'profileData',
                    'formatter' => function($profileData) {
                        $decoded = base64_decode($profileData);
                        $x = finfo_open();
                        $type = finfo_buffer($x, $profileData, FILEINFO_MIME_TYPE);
                        return '<img src="data:'.$type.';base64,'.$profileData.'" style="height:40px;width:50px;">' ;
                         }
                 ),
    array( 'db' => '`b`.`username`', 'dt' => 1, 'field' => 'username' ),
    array( 'db' => '`a`.`lname`', 'dt' => 2, 'field' => 'lname' ),
    array( 'db' => '`a`.`fname`', 'dt' => 3, 'field' => 'fname' ),
    array( 'db' => '`a`.`mname`', 'dt' => 4, 'field' => 'mname' ),
    array( 'db' => '`b`.`date_at`', 'dt' => 5, 'field' => 'date_at' ),
    array( 'db' => '`b`.`time`', 'dt' => 6, 'field' => 'time' ),
    array( 'db' => '`b`.`module`', 'dt' => 7, 'field' => 'module' ),
    array( 'db' => '`b`.`action`', 'dt' => 8, 'field' => 'action' ),
);


// SQL server connection information
//require('asset/connection/mysqli_dbconnection.php');
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_JWS',
    'host' => '127.0.0.1'
);

/* * 2 2 * * 2 2 * 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2
 * If you rust want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `user_info` AS `a` JOIN `audit_trail` AS `b` ON (`a`.`username` = `b`.`username`)";
$extraWhere = "`a`.`username` = `b`.`username`";        

echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);